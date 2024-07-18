<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ms_item;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class MapsController extends Controller {
  public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Session::get('user.id') == null) {
                return Redirect::to('/')->send();
            } else {
                return $next($request);
            }
        });
    }

    public function home(){
      session()->forget('devicetype');
          $data = DB::connection('mysql1')->table('users')
            ->join('user_akses', 'user_akses.user_id', 'users.id_users')
            ->join('ms_company', 'ms_company.id', 'user_akses.company_id')
            ->where('users.id_users',Session::get('user.id'))          
            ->select('ms_company.*')
            ->orderby('ms_company.id', 'ASC')
            ->get();
          return view('../staff/home', ['Data' => $data]);
    }
    
    public function getMap($id){
         $data = DB::connection('mysql1')->table('ms_floor')
            ->where('company_id',$id)
            ->get();
         echo $data;
    }

    public function getNextMap(Request $request){
        $id=$request->id;
        $limit=$request->floorOnPage;
        $offset=$request->pageNo;
       
        $data = DB::connection('mysql1')->table('ms_floor')
                ->where('company_id',$id)
                ->offset(($offset-1)*$limit)
                ->limit($limit)
                ->get();    
         echo $data; 
    }
    

    public function indexByFloor($id) {
        if(Session::has('devicetype'))
            $valueDevice = Session::get('devicetype');
        else
            $valueDevice ='classNone';
            $data = DB::connection('mysql1')
                ->table('ms_item')
                ->where('location',$id)
                ->get();
            $companyprofile =  DB::connection('mysql1')
                ->table('ms_floor')
                ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                ->where('ms_floor.id', $id)
                ->select('ms_company.*')
                ->get();
            $compname= $companyprofile[0]->sitename; 
            $compid= $companyprofile[0]->id;
            $floor = DB::connection('mysql1')
                ->table('ms_floor')
                ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                ->where('ms_floor.company_id', $compid)->select('ms_floor.*')
                ->orderby('ms_floor.sequence_number', 'ASC')
                ->get();
            $no=1;
            foreach ($floor as $index) {
                if ((int)$index->id==$id){
                    break;
                }
                $no++;
            }
            $jumlahlantai=count($floor);
            $pagesurface=ceil($no/4);
            if ($compid == 1) {
                $unificountconnect = DB::connection('mysql2')
                    ->select("select * from unifi_list_event_src where msg like '%has connected%'");
                $unificountdisconnect = DB::connection('mysql2')
                    ->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
                $unifi = count($unificountdisconnect) - count($unificountconnect);
                $unifiSumDownload=0;//$unifiSumDownload[0]->total;
                $unifiSumdUpload=0;//$unifiSumdUpload[0]->total;
                $unifi = count($unificountdisconnect) - count($unificountconnect);
                $pc_data = DB::connection('mysql1')->table('ms_item')
                    ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                    ->select('ms_floor.*')     
                    ->where('ms_floor.company_id', '1')
                    ->where('ms_item.type', 'pc')
                    ->get(); 
                $wifi_data = DB::connection('mysql1')->table('ms_item')
                    ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                    ->select('ms_floor.*')     
                    ->where('ms_floor.company_id', '1')
                    ->where('ms_item.type', 'wifi')
                    ->get();
                $pc = 0;
            } else if ($compid == 2) {
                    $unificountconnect = DB::connection('mysql2')
                        ->select("select * from unifi_list_event_kk_src where msg like '%has connected%'");
                    $unificountdisconnect = DB::connection('mysql2')
                        ->select("select * from unifi_list_event_kk_src where msg like '%has connected%' or msg like '%disconnected from%'");
                    $unifiSumDownload=0;
                    $unifiSumdUpload=0;
                    $unifi = count($unificountdisconnect) - count($unificountconnect);
                    $pc = 0;
                    $pcdata = DB::connection('mysql2')->table('people_counting_kk_traffics_src')
                        ->select('ctvalue')
                        ->get();
                        foreach ($pcdata as $list) {
                            $pc = $pc + $list->ctvalue;
                        }                
                        $pc_data = DB::connection('mysql1')
                            ->table('ms_item')
                            ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                            ->select('ms_floor.*')     
                            ->where('ms_floor.company_id', '2')
                            ->where('ms_item.type', 'pc')
                            ->get(); 
                        $wifi_data = DB::connection('mysql1')
                            ->table('ms_item')
                            ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                            ->select('ms_floor.*')     
                            ->where('ms_floor.company_id', '2')
                            ->where('ms_item.type', 'wifi')
                            ->get();
            } else if ($compid == 3) {
                $pc = 0;
                $pc_data = DB::connection('mysql1')
                    ->table('ms_item')
                    ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                    ->select('ms_floor.*')     
                    ->where('ms_floor.company_id', '3')
                    ->where('ms_item.type', 'pc')
                    ->get();
                $pcdata = DB::connection('mysql2')->table('people_counting_pbm_traffics_src')
                        ->select('ctvalue')
                        ->get();
                foreach ($pcdata as $list) {
                    $pc = $pc + $list->ctvalue;
                }
                $pc_data = DB::connection('mysql1')->table('ms_item')
                    ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                    ->select('ms_floor.*')     
                    ->where('ms_floor.company_id', '3')
                    ->where('ms_item.type', 'pc')
                    ->get();
                $wifi_data = DB::connection('mysql1')->table('ms_item')
                    ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                    ->select('ms_floor.*')     
                    ->where('ms_floor.company_id', '3')
                    ->where('ms_item.type', 'wifi')
                    ->get();
            } else {
                $unifi = 0;
                $pc = 0;
            }
    $data2 = DB::connection('mysql1')->table('ms_floor')
                    ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                    ->where('ms_company.id', $compid)
                    ->where('ms_floor.sequence_number', '1')
                    ->select('ms_floor.id')
                    ->get();
            $FloorID = $id;
            return view('../staff/Maps',['typedevice'=>$valueDevice,'wifidata'=>count($wifi_data),'pcdata'=>count($pc_data),'unifi'=>$unifi,'PeopleCounting'=>$pc,'floor'=>$floor,'compname'=>$compname,'FloorID'=>$FloorID, 'pagesurface'=>$pagesurface]);
        
        }


    public function changefloor($id) {
        $data = DB::connection('mysql1')->table('ms_floor')
                ->join('ms_company', 'ms_floor.company_id', 'ms_company.id')
                ->where('ms_floor.id', $id)
                ->select('ms_floor.maps_img', 'ms_floor.id', 'ms_floor.name', 'ms_company.sitename')
                ->get();
        echo $data;
    }

    public function floor($id) {
        $arrTotalDataDevice=array();
        $data = DB::connection('mysql1')->table('ms_item')
                ->where('location', $id)
                ->orderBy('id','asc')
                ->get();
        $i=0;  
        echo $data;
    }
 public function floorUser($id) {
        $arrTotalDataDevice=array();
        $data = DB::connection('mysql1')->table('ms_item')
                ->where('location', $id)
                ->orderBy('id','asc')
                ->get();
        $i=0;
        foreach ($data as $index) {
            $arrDataDevice =array();
            $arrDataDevice['id']=$index->id;
            $arrDataDevice['name']=$index->name;
            $arrDataDevice['isalive']=$index->isalive;
            $arrTotalDataDevice[$i]=$arrDataDevice;
            $i++;

            
        }
        $sessionName="sessionDevice_".$id;
        if(Session::has($sessionName)){
            $value = Session::get($sessionName);;
            session([$sessionName => '']);
             $value = Session::get($sessionName);
        }
      Session::put($sessionName, $arrTotalDataDevice);
      $value = Session::get($sessionName);
        echo $data;
    }

    public function save(Request $request) {
        $location = (isset($request['location'])) ? $request['location'] : '';
        $typeppoint = (isset($request['typeppoint'])) ? $request['typeppoint'] : '';
        $x = (isset($request['x'])) ? $request['x'] : '';
        $y = (isset($request['y'])) ? $request['y'] : '';
        $name = (isset($request['name'])) ? $request['name'] : '';
        $link = (isset($request['link'])) ? $request['link'] : '';
        $idlink = (isset($request['idlink'])) ? $request['idlink'] : '';
        $idn = (isset($request['idn'])) ? $request['idn'] : '';
        $company = (isset($request['company'])) ? $request['company'] : '';

        if ($x != null) {
            DB::connection('mysql1')->table('ms_item')->updateOrInsert([
                '_id' => $idn,
                'link' => $link,
                'zm_id' => $idlink,
                'x_axis' => $x,
                'y_axis' => $y,
                'name' => $name,
                'location' => $location,
                'type' => $typeppoint
            ]);
        }
    
        return response()->json(['message' => 'Lokasi '.$typeppoint.' berhasil disimpan!']);
    }
    public function update(Request $request) {
        $location = (isset($request['location'])) ? $request['location'] : '';
        $typeppoint = (isset($request['typeppoint'])) ? $request['typeppoint'] : '';
        $x = (isset($request['x'])) ? $request['x'] : '';
        $y = (isset($request['y'])) ? $request['y'] : '';
        $name = (isset($request['name'])) ? $request['name'] : '';
        $link = (isset($request['link'])) ? $request['link'] : '';
        $idlink = (isset($request['idlink'])) ? $request['idlink'] : '';
        $idn = (isset($request['idn'])) ? $request['idn'] : '';
        $id = (isset($request['deleteid'])) ? $request['deleteid'] : '';
        if ($x != null) {
            $post = new ms_item();
            $post->exists = true;
            $post->id = $id; //already exists in database.
            $post->_id = $idn;
            $post->link = trim($link);
            $post->zm_id = trim($idlink);
            $post->x_axis = $x;
            $post->y_axis = $y;
            $post->name = trim($name);
            $post->save();
        }
        return response()->json(['message' => 'Update Device berhasil disimpan!']);
    }
    public function deleteData($id) {
        DB::connection('mysql1')->table('ms_item')->where('id', $id)->delete();
        return response()->json(['message' => 'Delete Lokasi berhasil !']);
    }
    public function deleteDataAjax(Request $request){
        $id = (isset($request['deleteid'])) ? $request['deleteid'] : '';
        DB::connection('mysql1')->table('ms_item')->where('id', $id)->delete();
        return response()->json(['message' => 'Delete Lokasi berhasil !']);
    }
    public function delete($id) {
        DB::connection('mysql1')->table('ms_item')->where('id', $id)->delete();
        return 'true';
    }


    public function wifidatadetail($id) {
        $name = DB::connection('mysql1')->table('ms_item')
                ->where('id', $id)
                ->value('name');
         $ip_addr = DB::connection('mysql1')->table('ms_item')
                ->where('id', $id)
                ->value('link');
        $companyid = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                ->where('ms_item.id', $id)
                ->value('ms_floor.company_id');
        if ($companyid == '1') {
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' and ap_name = '" . $name . "'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'  and ap_name = '" . $name . "' or msg like '%disconnected from%' and ap_name = '" . $name . "'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
             $unifiSumDownload = 0;
            $unifiSumUpload = 0;
        } else if ($companyid == '2') {
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%' and ap_name = '" . $name . "'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%'  and ap_name = '" . $name . "' or msg like '%disconnected from%' and ap_name = '" . $name . "'");
            $unifiSumDownload = 0;
            $unifiSumUpload = 0;
            $unifi = count($unificountdisconnect) - count($unificountconnect);
        } else if ($companyid == '3') {
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' and ap_name = '" . $name . "'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'  and ap_name = '" . $name . "' or msg like '%disconnected from%' and ap_name = '" . $name . "'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $unifiSumDownload = 0;
            $unifiSumUpload = 0;
        } else {
            $unifi = 0;
            $unifiSumDownload=0;
            $unifiSumUpload=0;
        }

        $array = array();
        $array[0]['Count'] = $unifi;
        $array[0]['Name'] = $name;
        $array[0]['Ip'] = $ip_addr;
        $array[0]['WifiUpload'] = 0;
        $array[0]['WifiDownload'] = 0;
        return json_encode($array);
    }

    public function pcclick($id) {
        $idsource = DB::connection('mysql1')->table('ms_item')
                ->where('id', $id)
                ->value('_id');
        $company_id = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                ->where('ms_item.id', $id)
                ->value('ms_floor.company_id');
        if ($company_id == 1) {
            $pc = 0;
        } else if ($company_id == 2) {
            $pc = 0;
            $pcdata = DB::connection('mysql2')->table('people_counting_kk_traffics_src')
                    ->join('people_counting_kk_ctsources_src', 'people_counting_kk_traffics_src.CtSourceId', 'people_counting_kk_ctsources_src.CtSourceId')
                    ->join('people_counting_kk_tblcameralineindoor_src', 'people_counting_kk_ctsources_src.CtSourceId', 'people_counting_kk_tblcameralineindoor_src.CtSourceId')
                    ->join('people_counting_kk_tbldoor_src', 'people_counting_kk_tblcameralineindoor_src.Doorid', 'people_counting_kk_tbldoor_src.Doorid')
                    ->where('people_counting_kk_tbldoor_src.doorid', $idsource)
                    ->select('people_counting_kk_traffics_src.ctvalue')
                    ->get();
            foreach ($pcdata as $list) {
                $pc = $pc + $list->ctvalue;
            }
        } else if ($company_id == 3) {
            $pc = 0;
            $pcdata = DB::connection('mysql2')->table('people_counting_pbm_traffics_src')
                    ->join('people_counting_pbm_ctsources_src', 'people_counting_pbm_traffics_src.CtSourceId', 'people_counting_pbm_ctsources_src.CtSourceId')
                    ->join('people_counting_pbm_tblcameralineindoor_src', 'people_counting_pbm_ctsources_src.CtSourceId', 'people_counting_pbm_tblcameralineindoor_src.CtSourceId')
                    ->join('people_counting_pbm_tbldoor_src', 'people_counting_pbm_tblcameralineindoor_src.Doorid', 'people_counting_pbm_tbldoor_src.Doorid')
                    ->where('people_counting_pbm_tbldoor_src.doorid', $idsource)
                    ->select('people_counting_pbm_traffics_src.ctvalue')
                    ->get();
            foreach ($pcdata as $list) {
                $pc = $pc + $list->ctvalue;
            }
        } else {
            $pc = 0;
        }
        $pcdata = [];
        $pcdata[0]['Name'] = DB::connection('mysql1')->table('ms_item')
                ->where('id', $id)
                ->value('name');
        $pcdata[0]['Count'] = $pc;
        return json_decode(json_encode($pcdata));
    }
    public function HeatData($id) {
        $addedIndex=0;
        $deletedIndex=0;
        $deletedDevice=array();
        $changedIndex=0;
        $changedDevice=array();
        $sessionName="sessionDevice_".$id;
        $valueDevice=0;
        $indexDevice=0;
       if(Session::has($sessionName)){ 
         $valueDevice = Session::get($sessionName);
         for($i = 0;$i < count($valueDevice);$i++){
             $array=$valueDevice[$i];
         }
               $indexDevice=count($valueDevice);
      
       }
           
         $arrTotalChangeDataDevice=array();
        $arrTotalDataDevice=array();
        $data = DB::connection('mysql1')->table('ms_item')
                ->where('location', $id)
                ->orderBy('id','asc')
                ->get();
        $i=0;
        foreach ($data as $index) {
            if($indexDevice>0){
            for($i = 0;$i < $indexDevice;$i++){
                $isexist=1;
             $array=$valueDevice[$i];
             if($index->id==$array['id']){
                 $isexist=0;
                 
                 if($index->isalive!=$array['isalive'] && $index->isalive==0){
                     $arrchangeDataDevice =array();
                     $arrchangeDataDevice['ip']=$index->link;
                     $arrchangeDataDevice['name']=$index->name;
                $changedDevice[$changedIndex]=$arrchangeDataDevice;
                $changedIndex++;
                 }
                 break;
             }
            }
            
         }
         foreach ($data as $index) {
            $arrDataDevice =array();
            $arrDataDevice['id']=$index->id;
            $arrDataDevice['name']=$index->name;
            $arrDataDevice['isalive']=$index->isalive;
            $arrDataDevice['type']=$index->type;
            $arrTotalDataDevice[$i]=$arrDataDevice;
            $i++;

            
        }
        if(Session::has($sessionName)){
            $value = Session::get($sessionName);
            session(['sessionDevice' => '']);
             $value = Session::get($sessionName);
        }
      Session::put($sessionName, $arrTotalDataDevice);
                 }
        $data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                ->where('ms_floor.id', $id)
              
                ->select('ms_item.*', 'ms_floor.maps_img', 'ms_floor.name as floorname', 'ms_floor.company_id')
                ->get();
        $newdata = array();
        foreach ($data as $key => $list) {
            $newdata[$key]['x_axis'] = $list->x_axis;
            $newdata[$key]['id'] = $list->id;
            $newdata[$key]['y_axis'] = $list->y_axis;
            $newdata[$key]['maps_img'] = $list->maps_img;
            $newdata[$key]['name'] = $list->name;
            $newdata[$key]['link'] = $list->link;
            $newdata[$key]['isalive'] = $list->isalive;
            $newdata[$key]['tipe'] = $list->type;
            $name = $list->name;
            if ($list->company_id == '1' || $list->company_id = 1) {
                $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' and ap_name = '" . $name . "'");
                $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'  and ap_name = '" . $name . "' or msg like '%disconnected from%' and ap_name = '" . $name . "'");
                $unifi = count($unificountdisconnect) - count($unificountconnect);
            } else if ($list->company_id == '2' || $list->company_id = 2) {
                $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%' and ap_name = '" . $name . "'");
                $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%'  and ap_name = '" . $name . "' or msg like '%disconnected from%' and ap_name = '" . $name . "'");
                $unifi = count($unificountdisconnect) - count($unificountconnect);
            } else if ($list->company_id == '3' || $list->company_id = 3) {
                $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' and ap_name = '" . $name . "'");
                $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'  and ap_name = '" . $name . "' or msg like '%disconnected from%' and ap_name = '" . $name . "'");
                $unifi = count($unificountdisconnect) - count($unificountconnect);
            } else {
                $unifi = 0;
            }
            $newdata[$key]['count'] = $unifi;
        }
        return json_decode(json_encode($newdata));
    }
    public function selectDeviceType($device){
        Session::put("devicetype", $device);
        return response()->json(['data'=>'0']);
    }
    public function floorcondition($id) {
        $addedDevice=array();
        $addedIndex=0;
        $deletedIndex=0;
        $deletedDevice=array();
        $changedIndex=0;
        $changedDevice=array();
        $sessionName="sessionDevice_".$id;
        $valueDevice=0;
       if(Session::has($sessionName)){ 
         $valueDevice = Session::get($sessionName);
         for($i = 0;$i < count($valueDevice);$i++){
             $array=$valueDevice[$i];
         } 
       }
         $arrTotalChangeDataDevice=array();
        $arrTotalDataDevice=array();
        $data = DB::connection('mysql1')->table('ms_item')
                ->where('location', $id)
                ->orderBy('id','asc')
                ->get();
        $i=0;
        $indexDevice=count($valueDevice);
        foreach ($data as $index) {
            if(count($valueDevice)>0){
            for($i = 0;$i < count($valueDevice);$i++){
                $isexist=1;
             $array=$valueDevice[$i];
             if($index->id==$array['id']){
                 $isexist=0;
                 
                 if($index->isalive!=$array['isalive'] && $index->isalive==0){
                     $arrchangeDataDevice =array();
                     $arrchangeDataDevice['ip']=$index->link;
                     $arrchangeDataDevice['name']=$index->name;
                $changedDevice[$changedIndex]=$arrchangeDataDevice;
                $changedIndex++;
                 }
                 break;
             }
            }
            
         }
         foreach ($data as $index) {
            $arrDataDevice =array();
            $arrDataDevice['id']=$index->id;
            $arrDataDevice['name']=$index->name;
            $arrDataDevice['isalive']=$index->isalive;
            $arrDataDevice['type']=$index->type;
            $arrTotalDataDevice[$i]=$arrDataDevice;
            $i++;

            
        }
        if(Session::has($sessionName)){
            $value = Session::get($sessionName);
            session(['sessionDevice' => '']);
             $value = Session::get($sessionName);
        }
      Session::put($sessionName, $arrTotalDataDevice);
                 }
            $i++;
return response()->json(['data'=>$data,'chgDeviceStatus'=>$changedDevice]);


            
        }
        
         public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->forget('devicetype');

        return redirect('/');
    }

}
