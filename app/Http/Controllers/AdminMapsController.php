<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ms_item;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class AdminMapsController extends Controller {
    public function __construct(){
        $this->middleware(function ($request, $next) {
            if (Session::get('admin.id') == null) {
                return Redirect::to('/admin')->send();
            } else {
                return $next($request);
            }
        });
    }


    public function ms_itemcompany($id) {
        if ($id == 1) {
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $pc = 0;
        } else if ($id == 2) {
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
            $unifi = 0;
            $pc = 0;
        }
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
        return view('../admin/Maps', ['wifidata'=>count($wifi_data),'pcdata'=>count($pc_data),'unifi' => $unifi, 'PeopleCounting' => $pc, 'floor' => $floor, 'compname' => $compname, 'FloorID' => $FloorID, 'CompID' => $id]);
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
        \Log::info('Deleting item with ID: ' . $id);
        DB::connection('mysql1')->table('ms_item')->where('id', $id)->delete();
        return response()->json(['message' => 'Delete Device berhasil !']);
    }
    
    public function deleteDataAjax(Request $request){
        $id = (isset($request['deleteid'])) ? $request['deleteid'] : '';
        \Log::info('Deleting item with ID: ' . $id);
        DB::connection('mysql1')->table('ms_item')->where('id', $id)->delete();
        return response()->json(['message' => 'Delete Device berhasil !']);
    }
    
    public function delete($id) {
        \Log::info('Deleting item with ID: ' . $id);
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
             $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_src where  ap_name = '" . $name . "'"); 
            $unifiSumUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_src where  ap_name = '" . $name . "'"); 
        } else if ($companyid == '2') {
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%' and ap_name = '" . $name . "'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%'  and ap_name = '" . $name . "' or msg like '%disconnected from%' and ap_name = '" . $name . "'");
            $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_kk_src where  ap_name = '" . $name . "'"); 
            $unifiSumUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_kk_src where  ap_name = '" . $name . "'"); 
            $unifi = count($unificountdisconnect) - count($unificountconnect);
        } else if ($companyid == '3') {
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' and ap_name = '" . $name . "'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'  and ap_name = '" . $name . "' or msg like '%disconnected from%' and ap_name = '" . $name . "'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_src where  ap_name = '" . $name . "'"); 
            $unifiSumUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_src where  ap_name = '" . $name . "'");
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
    public function adminlogout(Request $request){
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
