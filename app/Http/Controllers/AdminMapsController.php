<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ms_item;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class AdminMapsController extends Controller {
  public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Session::get('admin.id') == null) {
                return Redirect::to('/admin')->send();
            } else {
                return $next($request);
            }
        });
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

    public function ms_itemcompany($id) {
        if ($id == 1) {
            $hibobcount = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $pc = 0;
        } else if ($id == 2) {
            $hibobcount = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%' or msg like '%disconnected from%'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $pc = 0;
            $pcdata = DB::connection('mysql2')->table('people_counting_kk_traffics_src')
                    ->select('ctvalue')
                    ->whereRaw('LEFT(cttime, 10) = LEFT(NOW(), 10)')
                    ->get();
            foreach ($pcdata as $list) {
                $pc = $pc + $list->ctvalue;
            }
        } else if ($id == 3) {
            $hibobcount = DB::connection('mysql2')->table('hibob_pbm_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $pc = 0;
            $pcdata = DB::connection('mysql2')->table('people_counting_pbm_traffics_src')
                    ->select('ctvalue')
                    ->whereRaw('LEFT(cttime, 10) = LEFT(NOW(), 10)')
                    ->get();
            foreach ($pcdata as $list) {
                $pc = $pc + $list->ctvalue;
            }
        } else {
            $hibobcount = [];
            $unifi = 0;
            $pc = 0;
        }
         $cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', $id)
                ->where('ms_item.type', 'cctv')
                ->get();
             $pc_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', $id)
                ->where('ms_item.type', 'pc')
                ->get();
             $wifi_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', $id)
                ->where('ms_item.type', 'wifi')
                ->get();
             $hibob_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', $id)
                ->where('ms_item.type', 'hibob')
                ->get();
        $floor = DB::connection('mysql1')->table('ms_floor')
                ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                ->where('ms_company.id', $id)
                ->select('ms_floor.*')
                ->orderby('ms_floor.sequence_number', 'ASC')
                ->get();
        $compname = DB::connection('mysql1')->table('ms_company')
                ->where('ms_company.id', $id)
                ->value('sitename');
        $data2 = DB::connection('mysql1')->table('ms_floor')
                ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                ->where('ms_company.id', $id)
                ->where('ms_floor.sequence_number', '1')
                ->select('ms_floor.id')
                ->get();
        $FloorID = 0;
        foreach ($data2 as $index) {
            $FloorID = $index->id;
        }
        return view('../admin/Maps', ['hibob'=>count($hibobcount),'hibobdata'=>count($hibob_data),'wifidata'=>count($wifi_data),'pcdata'=>count($pc_data),'cctv'=>count($cctv_data), 'unifi' => $unifi, 'PeopleCounting' => $pc, 'floor' => $floor, 'compname' => $compname, 'FloorID' => $FloorID, 'CompID' => $id]);
    }

    public function changefloor($id) {
        $data = DB::connection('mysql1')->table('ms_floor')
                ->join('ms_company', 'ms_floor.company_id', 'ms_company.id')
                ->where('ms_floor.id', $id)
            //    ->where('ms_company.id', '1')
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
       //dd();
       
        echo $data;
    }
 public function floorUser($id) {
        $arrTotalDataDevice=array();
        $data = DB::connection('mysql1')->table('ms_item')
                ->where('location', $id)
                ->orderBy('id','asc')
                ->get();
        $i=0;
       //dd();
        foreach ($data as $index) {
            $arrDataDevice =array();
            $arrDataDevice['id']=$index->id;
            $arrDataDevice['name']=$index->name;
            $arrDataDevice['isalive']=$index->isalive;
            
          //  echo "test<br>";
            //print_r($arrDataDevice);
            $arrTotalDataDevice[$i]=$arrDataDevice;
            // echo "test2<br>";
          //  print_r($arrTotalDataDevice);
            $i++;

            
        }
        $sessionName="sessionDevice_".$id;
        if(Session::has($sessionName)){
            $value = Session::get($sessionName);;
          //  print_r($value);
            //echo "true";
            session([$sessionName => '']);
             $value = Session::get($sessionName);
              //echo "truea";
            //print_r($value);
    //$devices[$key] = $subArr;  
//}

            //Session::put('product', $product);
        }
     //print_r($arrTotalDataDevice);
     //  print_r($arrTotalDataDevice);
      Session::put($sessionName, $arrTotalDataDevice);
      $value = Session::get($sessionName);
           //print_r($value);
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
        
             //DB::connection('mysql1')->table('students')->updateOrInsert(['age'=>40],['name'=>'Arbaaz Khanna', 'email'=>'arbaaz@gmail.com', 'address'=>'testing', 'age'=>'35']);
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
        
//dd();


        if ($x != null) {
        
             //DB::connection('mysql1')->table('students')->updateOrInsert(['age'=>40],['name'=>'Arbaaz Khanna', 'email'=>'arbaaz@gmail.com', 'address'=>'testing', 'age'=>'35']);
           /* DB::connection('mysql1')->table('ms_item')->update([
                '_id' => $idn,
                'link' => trim($link),
                'zm_id' => trim($idlink),
                'x_axis' => $x,
                'y_axis' => $y,
                'name' => trim($name),
                'id'=> $id
            ]);*/
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
        return response()->json(['message' => 'Delete Device berhasil !']);
    }
    public function deleteDataAjax(Request $request){
        $id = (isset($request['deleteid'])) ? $request['deleteid'] : '';
       // echo "a".$id."b";
        DB::connection('mysql1')->table('ms_item')->where('id', $id)->delete();
        return response()->json(['message' => 'Delete Device berhasil !']);
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
             $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_src where  ap_name = '" . $name . "'"); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_src where  ap_name = '" . $name . "'"); //where  DATE(last_update) = CURDATE()
        } else if ($companyid == '2') {
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%' and ap_name = '" . $name . "'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%'  and ap_name = '" . $name . "' or msg like '%disconnected from%' and ap_name = '" . $name . "'");
            $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_kk_src where  ap_name = '" . $name . "'"); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_kk_src where  ap_name = '" . $name . "'"); //where  DATE(last_update) = CURDATE()
            $unifi = count($unificountdisconnect) - count($unificountconnect);
        } else if ($companyid == '3') {
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' and ap_name = '" . $name . "'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'  and ap_name = '" . $name . "' or msg like '%disconnected from%' and ap_name = '" . $name . "'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_src where  ap_name = '" . $name . "'"); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_src where  ap_name = '" . $name . "'"); //where  DATE(last_update) = CURDATE()
        } else {
            $unifi = 0;
            $unifiSumDownload=0;
            $unifiSumUpload=0;
        }

        $array = array();
        $array[0]['Count'] = $unifi;
        $array[0]['Name'] = $name;
        $array[0]['Ip'] = $ip_addr;
        $array[0]['WifiUpload'] = $unifiSumUpload[0]->total;
        $array[0]['WifiDownload'] = $unifiSumDownload[0]->total;
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
                    ->whereRaw('LEFT(cttime, 10) = LEFT(NOW(), 10)')
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
                    ->whereRaw('LEFT(cttime, 10) = LEFT(NOW(), 10)')
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

    public function cctv($id) {
        $old = DB::connection('mysql1')->table('cctv')->value('cctv_id_new');
        if ($id != $old) {
            return 'Change';
        } else {
            return 'None';
        }
    }
    public function HeatData($id) {
        $data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                ->where('ms_floor.id', $id)
              
                ->select('ms_item.*', 'ms_floor.maps_img', 'ms_floor.name as floorname', 'ms_floor.company_id')
                ->get();
        $newdata = array();
        foreach ($data as $key => $list) {
            $newdata[$key]['x_axis'] = $list->x_axis;
            $newdata[$key]['y_axis'] = $list->y_axis;
            $newdata[$key]['maps_img'] = $list->maps_img;
            $newdata[$key]['name'] = $list->name;
            $newdata[$key]['link'] = $list->link;
            
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
    public function floorcondition($id) {
        $addedDevice=array();
        $addedIndex=0;
        $deletedIndex=0;
        $deletedDevice=array();
        $changedIndex=0;
        $changedDevice=array();
        $sessionName="sessionDevice_".$id;
       if(Session::has($sessionName)){ 
         $valueDevice = Session::get($sessionName);
         for($i = 0;$i < count($valueDevice);$i++){
             //echo "test";
             $array=$valueDevice[$i];
        //    print_r($array);
         } 
       }
         $arrTotalChangeDataDevice=array();
        $arrTotalDataDevice=array();
        $data = DB::connection('mysql1')->table('ms_item')
                ->where('location', $id)
                ->orderBy('id','asc')
                ->get();
        $i=0;
       //dd();
        $indexDevice=count($valueDevice);
        
        //add item
        foreach ($data as $index) {
            if(count($valueDevice)>0){
            for($i = 0;$i < count($valueDevice);$i++){
                $isexist=1;
            // echo "test";
             $array=$valueDevice[$i];
           //  print_r($array['id']);
             if($index->id==$array['id']){
                 $isexist=0;
                 
                 if($index->isalive!=$array['isalive'] && $index->isalive==0){
                     $arrchangeDataDevice =array();
                     $arrchangeDataDevice['ip']=$index->link;
                     $arrchangeDataDevice['name']=$index->name;
                $changedDevice[$changedIndex]=$arrchangeDataDevice;
                //$changedDevice[$changedIndex]['ip']=$index->link;
                //$indexDevice++;
                $changedIndex++;
                 }
                 
                 //check isalive condition to 
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
            
          //  echo "test<br>";
            //print_r($arrDataDevice);
            $arrTotalDataDevice[$i]=$arrDataDevice;
            // echo "test2<br>";
          //  print_r($arrTotalDataDevice);
            $i++;

            
        }
        if(Session::has($sessionName)){
            $value = Session::get($sessionName);
          //  print_r($value);
            //echo "true";
            session(['sessionDevice' => '']);
             $value = Session::get($sessionName);
              //echo "truea";
            //print_r($value);
    //$devices[$key] = $subArr;  
//}

            //Session::put('product', $product);
        }
     //print_r($arrTotalDataDevice);
     //  print_r($arrTotalDataDevice);
      Session::put($sessionName, $arrTotalDataDevice);
         //print_r($changedDevice);
                 }
        //foreach ($data as $index) {
        
        //remove it
        
             
          
            
          //  echo "test<br>";
            //print_r($arrDataDevice);
           // $arrTotalDataDevice[$i]=$arrDataDevice;
            // echo "test2<br>";
         // print_r($valueDevice);
            $i++;
return response()->json(['data'=>$data,'chgDeviceStatus'=>$changedDevice]);


            
        }
        
         public function adminlogout(Request $request)
    {
           //  dd("test");
        $request->session()->forget('admin');

        return redirect('/admin');
    }

    public function backdashboard(){
        return redirect('/admin');
    }
    public function useredit(){
       return view('../admin/Listuser');
    }
}
