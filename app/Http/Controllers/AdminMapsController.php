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
    public function home(){
       /// if(Session::has('sessionuser')){
       //  if(Auth::check()){
          //   dd(Auth::check());
            //return view('dashboard');
      
          $data = DB::connection('mysql1')->table('users')
                  ->join('user_akses', 'user_akses.user_id', 'users.user_id')
                   ->join('ms_company', 'ms_company.id', 'user_akses.company_id')
                ->where('ms_company.id', '1')
                ->select('ms_company.*')
                ->orderby('ms_company.id', 'ASC')
                ->get();
              
          return view('HomeUser', ['Data' => $data]);
           // }
            //return redirect("/");
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
    public function test(){
         $data = DB::connection('mysql1')->table('ms_item')
                ->where('location', '1')
                ->get();
        //$hibobcount=[];
        $hibobcount = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
        $hibobcountHK = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', 'HK')->distinct()->get();
        $hibobcountGS = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', 'SG')->distinct()->get();
        $hibobcountOthers = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', '!=', 'SG')->where('hibob_gc_getuserinoutbytime_src.posisi_staff', '!=', 'HK')->distinct()->get();
        $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
        $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
        // $unificountconnect = DB::connection('mysql2')->table('unifi_list_event_sr')->where('msg','like','%has connecrted%')->get();
        $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
        $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
        $unifi = count($unificountdisconnect) - count($unificountconnect);
        $floor = DB::connection('mysql1')->table('ms_floor')
                ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                ->where('ms_company.id', '1')
                ->select('ms_floor.*')
                ->orderby('ms_floor.sequence_number', 'ASC')
                ->get();

        $compname = DB::connection('mysql1')->table('ms_company')
                ->where('ms_company.id', '1')
                ->value('sitename');
        $cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '1')
                ->where('ms_item.type', 'cctv')
                ->get();
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
             $hibob_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '1')
                ->where('ms_item.type', 'hibob')
                ->get();
       //  dump($compname);
        return view('DivMaps', ['Data' => $data, 'hibob' => count($hibobcount),'hibobdata'=>count($hibob_data),'wifidata'=>count($wifi_data),'pcdata'=>count($pc_data),'cctv'=>count($cctv_data), 'unifi' => $unifi, 'floor' => $floor, 'compname' => $compname, 'hibobcountHK' => count($hibobcountHK), 'hibobcountGS' => count($hibobcountGS), 'hibobcountOthers' => count($hibobcountOthers), 'wifiDownload' => $unifiSumDownload[0]->total, 'wifiUpload' => $unifiSumdUpload[0]->total]);
    }
    
    public function displayfloor(){
        
        return view('FloorMaps');
        
    }
    public function index() {
        $data = DB::connection('mysql1')->table('ms_item')
                ->where('location', '1')
                ->get();
        //$hibobcount=[];
        $hibobcount = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
        $hibobcountHK = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', 'HK')->distinct()->get();
        $hibobcountGS = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', 'SG')->distinct()->get();
        $hibobcountOthers = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', '!=', 'SG')->where('hibob_gc_getuserinoutbytime_src.posisi_staff', '!=', 'HK')->distinct()->get();
        $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
        $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_kk_src "); //where  DATE(last_update) = CURDATE()
        // $unificountconnect = DB::connection('mysql2')->table('unifi_list_event_sr')->where('msg','like','%has connecrted%')->get();
        $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
        $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
        $unifi = count($unificountdisconnect) - count($unificountconnect);
        $floor = DB::connection('mysql1')->table('ms_floor')
                ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                ->where('ms_company.id', '1')
                ->select('ms_floor.*')
                ->orderby('ms_floor.sequence_number', 'ASC')
                ->get();
  $cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '1')
                ->where('ms_item.type', 'cctv')
                ->get();
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
             $hibob_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '1')
                ->where('ms_item.type', 'hibob')
                ->get();
        $compname = DB::connection('mysql1')->table('ms_company')
                ->where('ms_company.id', '1')
                ->value('sitename');
        //       dump($compname);
        return view('Maps', ['Data' => $data, 'hibob' => count($hibobcount), 'unifi' => $unifi, 'floor' => $floor, 'compname' => $compname, 'hibobcountHK' => count($hibobcountHK), 'hibobcountGS' => count($hibobcountGS), 'hibobcountOthers' => count($hibobcountOthers), 'wifiDownload' => $unifiSumDownload[0]->total, 'wifiUpload' => $unifiSumdUpload[0]->total]);
    }

    public function indexbycompany($id) {
         
        if ($id == 1) {
       //     $hibobcount = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $hibobcount = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $hibobcountHK = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', 'HK')->distinct()->get();
            $hibobcountGS = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', 'SG')->distinct()->get();
            $hibobcountOthers = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', '!=', 'SG')->where('hibob_gc_getuserinoutbytime_src.posisi_staff', '!=', 'HK')->distinct()->get();
          /* $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_kk_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_kk_src ");   */
             $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
          $unifiSumDownload=$unifiSumDownload[0]->total;
          $unifiSumdUpload=$unifiSumdUpload[0]->total;
          // if(!empty($unificountdisconnect) && !empty($unificountconnect))
                $unifi = count($unificountdisconnect) - count($unificountconnect);
             /*$cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_item.id')    
                ->where('ms_floor.company_id', '1')
                     ->distinct()->get()
                ; */
             $cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '1')
                ->where('ms_item.type', 'cctv')
                ->get();
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
             $hibob_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '1')
                ->where('ms_item.type', 'hibob')
                ->get();
           // else 
         //       $unifi=0;
            $floor = DB::connection('mysql1')->table('ms_floor')
                    ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                    ->where('ms_company.id', '1')
                    ->select('ms_floor.*')
                    ->orderby('ms_floor.sequence_number', 'ASC')
                    ->get();

            $compname = DB::connection('mysql1')->table('ms_company')
                    ->where('ms_company.id', '1')
                    ->value('sitename');
            $pc = 0;
        } else if ($id == 2) {
         //   $hibobcount = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%' or msg like '%disconnected from%'");
          /* $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_kk_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_kk_src "); */
          $hibobcount = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $hibobcountHK = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->where('hibob_kk_getuserinoutbytime_src.posisi_staff', 'HK')->distinct()->get();
            $hibobcountGS = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->where('hibob_kk_getuserinoutbytime_src.posisi_staff', 'SG')->distinct()->get();
            $hibobcountOthers = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->where('hibob_kk_getuserinoutbytime_src.posisi_staff', '!=', 'SG')->where('hibob_kk_getuserinoutbytime_src.posisi_staff', '!=', 'HK')->distinct()->get();
            //$unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
           // $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
            $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_kk_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_kk_src "); //where  DATE(last_update) = CURDATE()
          $unifiSumDownload=$unifiSumDownload[0]->total;
          $unifiSumdUpload=$unifiSumdUpload[0]->total;
           // if(!empty($unificountdisconnect) && !empty($unificountconnect))
                $unifi = count($unificountdisconnect) - count($unificountconnect);
         //   else 
         //       $unifi=0;
            $pc = 0;
            $pcdata = DB::connection('mysql2')->table('people_counting_kk_traffics_src')
                    ->select('ctvalue')
                    ->whereRaw('LEFT(cttime, 10) = LEFT(NOW(), 10)')
                    ->get();
            foreach ($pcdata as $list) {
                $pc = $pc + $list->ctvalue;
            }
            $cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '2')
                ->where('ms_item.type', 'cctv')
                ->get();
           $pc_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '2')
                ->where('ms_item.type', 'pc')
                ->get(); 
             $wifi_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '2')
                ->where('ms_item.type', 'wifi')
                ->get();
             $hibob_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '2')
                ->where('ms_item.type', 'hibob')
                ->get();
        } else if ($id == 3) {
           $hibobcount = DB::connection('mysql2')->table('hibob_pbm_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $hibobcountHK = DB::connection('mysql2')->table('hibob_pbm_getuserinoutbytime_src')->select("nama_staff")->where('hibob_pbm_getuserinoutbytime_src.posisi_staff', 'HK')->distinct()->get();
            $hibobcountGS = DB::connection('mysql2')->table('hibob_pbm_getuserinoutbytime_src')->select("nama_staff")->where('hibob_pbm_getuserinoutbytime_src.posisi_staff', 'SG')->distinct()->get();
            $hibobcountOthers = DB::connection('mysql2')->table('hibob_pbm_getuserinoutbytime_src')->select("nama_staff")->where('hibob_pbm_getuserinoutbytime_src.posisi_staff', '!=', 'SG')->where('hibob_pbm_getuserinoutbytime_src.posisi_staff', '!=', 'HK')->distinct()->get();
        
               $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
          $unifiSumDownload=$unifiSumDownload[0]->total;
          $unifiSumdUpload=$unifiSumdUpload[0]->total;
           $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $pc = 0;
            $pc_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '3')
                ->where('ms_item.type', 'pc')
                ->get();
            $pcdata = DB::connection('mysql2')->table('people_counting_pbm_traffics_src')
                    ->select('ctvalue')
                    ->whereRaw('LEFT(cttime, 10) = LEFT(NOW(), 10)')
                    ->get();
            foreach ($pcdata as $list) {
                $pc = $pc + $list->ctvalue;
            }
            $cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '3')
                ->where('ms_item.type', 'cctv')
                ->get();
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
             $hibob_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '3')
                ->where('ms_item.type', 'hibob')
                ->get();
        } else {
            $hibobcount = [];
            $unifi = 0;
            $pc = 0;
        }

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
        //return view('EmptyMaps', ['Data' => $data, 'hibob' => count($hibobcount), 'unifi' => $unifi, 'floor' => $floor, 'compname' => $compname, 'hibobcountHK' => count($hibobcountHK), 'hibobcountGS' => count($hibobcountGS), 'hibobcountOthers' => count($hibobcountOthers), 'wifiDownload' => $unifiSumDownload[0]->total, 'wifiUpload' => $unifiSumdUpload[0]->total]);
        return view('EmptyMaps',['hibob'=>count($hibobcount),'hibobdata'=>count($hibob_data),'wifidata'=>count($wifi_data),'pcdata'=>count($pc_data),'cctv'=>count($cctv_data),'unifi'=>$unifi,'PeopleCounting'=>$pc,'floor'=>$floor,'compname'=>$compname,'FloorID'=>$FloorID, 'hibobcountHK' => count($hibobcountHK), 'hibobcountGS' => count($hibobcountGS), 'hibobcountOthers' => count($hibobcountOthers),'wifiDownload' => $unifiSumDownload, 'wifiUpload' => $unifiSumdUpload]);
    
    }

    public function indexByFloor($id) {
        $data = DB::connection('mysql1')->table('ms_item')
                ->where('location',$id)
                ->get();
        $companyprofile =  DB::connection('mysql1')->table('ms_floor')
                ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                ->where('ms_floor.id', $id)
                ->select('ms_company.*')
                ->get();
      //  dd($companyprofile);
          $compname= $companyprofile[0]->sitename; 
          $compid= $companyprofile[0]->id;
         $floor = DB::connection('mysql1')->table('ms_floor')
                ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                ->where('ms_floor.company_id', $compid)
                ->select('ms_floor.*')
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
       //     $hibobcount = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $hibobcount = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $hibobcountHK = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', 'HK')->distinct()->get();
            $hibobcountGS = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', 'SG')->distinct()->get();
            $hibobcountOthers = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->where('hibob_gc_getuserinoutbytime_src.posisi_staff', '!=', 'SG')->where('hibob_gc_getuserinoutbytime_src.posisi_staff', '!=', 'HK')->distinct()->get();
          /* $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_kk_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_kk_src ");   */
             $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
          $unifiSumDownload=$unifiSumDownload[0]->total;
          $unifiSumdUpload=$unifiSumdUpload[0]->total;
          // if(!empty($unificountdisconnect) && !empty($unificountconnect))
                $unifi = count($unificountdisconnect) - count($unificountconnect);
             /*$cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_item.id')    
                ->where('ms_floor.company_id', '1')
                     ->distinct()->get()
                ; */
             $cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '1')
                ->where('ms_item.type', 'cctv')
                ->get();
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
             $hibob_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '1')
                ->where('ms_item.type', 'hibob')
                ->get();
           // else 
         //       $unifi=0;
           
            $pc = 0;
        } else if ($compid == 2) {
         //   $hibobcount = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_kk_src where msg like '%has connected%' or msg like '%disconnected from%'");
          /* $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_kk_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_kk_src "); */
          $hibobcount = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $hibobcountHK = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->where('hibob_kk_getuserinoutbytime_src.posisi_staff', 'HK')->distinct()->get();
            $hibobcountGS = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->where('hibob_kk_getuserinoutbytime_src.posisi_staff', 'SG')->distinct()->get();
            $hibobcountOthers = DB::connection('mysql2')->table('hibob_kk_getuserinoutbytime_src')->select("nama_staff")->where('hibob_kk_getuserinoutbytime_src.posisi_staff', '!=', 'SG')->where('hibob_kk_getuserinoutbytime_src.posisi_staff', '!=', 'HK')->distinct()->get();
            //$unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
           // $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
            $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_kk_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_kk_src "); //where  DATE(last_update) = CURDATE()
          $unifiSumDownload=$unifiSumDownload[0]->total;
          $unifiSumdUpload=$unifiSumdUpload[0]->total;
           // if(!empty($unificountdisconnect) && !empty($unificountconnect))
                $unifi = count($unificountdisconnect) - count($unificountconnect);
         //   else 
         //       $unifi=0;
            $pc = 0;
            $pcdata = DB::connection('mysql2')->table('people_counting_kk_traffics_src')
                    ->select('ctvalue')
                    ->whereRaw('LEFT(cttime, 10) = LEFT(NOW(), 10)')
                    ->get();
            foreach ($pcdata as $list) {
                $pc = $pc + $list->ctvalue;
            }
            $cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '2')
                ->where('ms_item.type', 'cctv')
                ->get();
           $pc_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '2')
                ->where('ms_item.type', 'pc')
                ->get(); 
             $wifi_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '2')
                ->where('ms_item.type', 'wifi')
                ->get();
             $hibob_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '2')
                ->where('ms_item.type', 'hibob')
                ->get();
        } else if ($compid == 3) {
           $hibobcount = DB::connection('mysql2')->table('hibob_pbm_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
            $hibobcountHK = DB::connection('mysql2')->table('hibob_pbm_getuserinoutbytime_src')->select("nama_staff")->where('hibob_pbm_getuserinoutbytime_src.posisi_staff', 'HK')->distinct()->get();
            $hibobcountGS = DB::connection('mysql2')->table('hibob_pbm_getuserinoutbytime_src')->select("nama_staff")->where('hibob_pbm_getuserinoutbytime_src.posisi_staff', 'SG')->distinct()->get();
            $hibobcountOthers = DB::connection('mysql2')->table('hibob_pbm_getuserinoutbytime_src')->select("nama_staff")->where('hibob_pbm_getuserinoutbytime_src.posisi_staff', '!=', 'SG')->where('hibob_pbm_getuserinoutbytime_src.posisi_staff', '!=', 'HK')->distinct()->get();
        
               $unifiSumDownload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')   as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
//dump($unifiSumDownload[0]->total);
            $unifiSumdUpload = DB::connection('mysql2')->select("select FORMAT(sum(bytes)/(1024*1024),2,'de_DE')  as total from unifi_list_event_src "); //where  DATE(last_update) = CURDATE()
          $unifiSumDownload=$unifiSumDownload[0]->total;
          $unifiSumdUpload=$unifiSumdUpload[0]->total;
           $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
            $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $unifi = count($unificountdisconnect) - count($unificountconnect);
            $pc = 0;
            $pc_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '3')
                ->where('ms_item.type', 'pc')
                ->get();
            $pcdata = DB::connection('mysql2')->table('people_counting_pbm_traffics_src')
                    ->select('ctvalue')
                    ->whereRaw('LEFT(cttime, 10) = LEFT(NOW(), 10)')
                    ->get();
            foreach ($pcdata as $list) {
                $pc = $pc + $list->ctvalue;
            }
            $cctv_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '3')
                ->where('ms_item.type', 'cctv')
                ->get();
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
             $hibob_data = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                 ->select('ms_floor.*')     
                ->where('ms_floor.company_id', '3')
                ->where('ms_item.type', 'hibob')
                ->get();
        } else {
            $hibobcount = [];
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
       
        
        
        //return view('EmptyMaps', ['Data' => $data, 'hibob' => count($hibobcount), 'unifi' => $unifi, 'floor' => $floor, 'compname' => $compname, 'hibobcountHK' => count($hibobcountHK), 'hibobcountGS' => count($hibobcountGS), 'hibobcountOthers' => count($hibobcountOthers), 'wifiDownload' => $unifiSumDownload[0]->total, 'wifiUpload' => $unifiSumdUpload[0]->total]);
        return view('ViewFloorById',['hibob'=>count($hibobcount),'hibobdata'=>count($hibob_data),'wifidata'=>count($wifi_data),'pcdata'=>count($pc_data),'cctv'=>count($cctv_data),'unifi'=>$unifi,'PeopleCounting'=>$pc,'floor'=>$floor,'compname'=>$compname,'FloorID'=>$FloorID, 'hibobcountHK' => count($hibobcountHK), 'hibobcountGS' => count($hibobcountGS), 'hibobcountOthers' => count($hibobcountOthers),'wifiDownload' => $unifiSumDownload, 'wifiUpload' => $unifiSumdUpload,'pagesurface'=>$pagesurface]);
    
    }

    public function maps() {
        $data = DB::connection('mysql1')->table('ms_item')
                ->where('location', 'b2')
                ->get();

        return view('OnlyMaps', ['Data' => $data]);
    }

    public function ms_item() {
        $data = DB::connection('mysql1')->table('ms_item')
                ->where('location', 'b2')
                ->get();
        $hibobcount = DB::connection('mysql2')->table('hibob_gc_getuserinoutbytime_src')->select("nama_staff")->distinct()->get();
        $unificountconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%'");
        $unificountdisconnect = DB::connection('mysql2')->select("select * from unifi_list_event_src where msg like '%has connected%' or msg like '%disconnected from%'");
        $unifi = count($unificountdisconnect) - count($unificountconnect);
        $floor = DB::connection('mysql1')->table('ms_floor')
                ->join('ms_company', 'ms_company.id', 'ms_floor.company_id')
                ->where('ms_company.id', '1')
                ->select('ms_floor.*')
                ->orderby('ms_floor.sequence_number', 'ASC')
                ->get();
        $compname = DB::connection('mysql1')->table('ms_company')
                ->where('ms_company.id', '1')
                ->value('sitename');
        return view('Mapsms_item', ['Data' => $data, 'hibob' => count($hibobcount), 'unifi' => $unifi, 'floor' => $floor, 'compname' => $compname]);
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
        return view('MapsMasterNew', ['hibob'=>count($hibobcount),'hibobdata'=>count($hibob_data),'wifidata'=>count($wifi_data),'pcdata'=>count($pc_data),'cctv'=>count($cctv_data), 'unifi' => $unifi, 'PeopleCounting' => $pc, 'floor' => $floor, 'compname' => $compname, 'FloorID' => $FloorID, 'CompID' => $id]);
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
        
        //return view('MapsMasterNew', ['Data' => $data]);
        //return redirect('/ms_item/' . $company);
        ///return redirect()->back()->with('success', 'your message,here');  
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
        
        //return view('MapsMasterNew', ['Data' => $data]);
        //return redirect('/ms_item/' . $company);
        ///return redirect()->back()->with('success', 'your message,here');  
        return response()->json(['message' => 'Update Lokasi berhasil disimpan!']);
    }
    public function deleteData($id) {
        DB::connection('mysql1')->table('ms_item')->where('id', $id)->delete();
        return response()->json(['message' => 'Delete Lokasi berhasil !']);
    }
    public function deleteDataAjax(Request $request){
        $id = (isset($request['deleteid'])) ? $request['deleteid'] : '';
       // echo "a".$id."b";
        DB::connection('mysql1')->table('ms_item')->where('id', $id)->delete();
        return response()->json(['message' => 'Delete Lokasi berhasil !']);
    }
    public function right(Request $request) {
        $id_new = DB::connection('mysql1')->table('cctv')
                        ->join('ms_item', 'ms_item.id', 'cctv.cctv_id_new')
                        ->select('ms_item.zm_id')
                        ->first()->zm_id;

        $id_old = DB::connection('mysql1')->table('cctv')
                        ->join('ms_item', 'ms_item.id', 'cctv.cctv_id_old')
                        ->select('ms_item.zm_id')
                        ->first()->zm_id;

        $cookie_jar = tempnam("tmp", "cookie");
        //login
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://172.30.50.40/zm/api/host/login.json',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_COOKIEJAR => $cookie_jar,
            CURLOPT_POSTFIELDS => 'user=admin2&pass=Pakuwon2023%23',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'),
                )
        );
        $response = json_decode(curl_exec($curl))->access_token;
        //turn off
        curl_setopt_array($curl, array(
            // CURLOPT_URL             => 'http://192.168.0.88/PakuwonUATTenant2/entity/Pakuwon/18.200.001/StockItem?$top=50&$skip='.$skip.'&$expand=WarehouseDetails',
            CURLOPT_URL => 'http://172.30.50.40/zm/api/monitors/' . $id_old . '.json?token=' . $response,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_COOKIEFILE => $cookie_jar,
            CURLOPT_POSTFIELDS => 'Monitor[Function]=None&Monitor[Enabled]=1',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'),
                )
        );
        $data = json_decode(curl_exec($curl));
        //turn on
        curl_setopt_array($curl, array(
            // CURLOPT_URL             => 'http://192.168.0.88/PakuwonUATTenant2/entity/Pakuwon/18.200.001/StockItem?$top=50&$skip='.$skip.'&$expand=WarehouseDetails',
            CURLOPT_URL => 'http://172.30.50.40/zm/api/monitors/' . $id_new . '.json?token=' . $response,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_COOKIEFILE => $cookie_jar,
            CURLOPT_POSTFIELDS => 'Monitor[Function]=Monitor&Monitor[Enabled]=1',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'),
                )
        );
        $data = json_decode(curl_exec($curl));
        // <img src="https://yourserver/zm/cgi-bin/nph-zms?scale=50&width=640p&height=480px&mode=jpeg&maxfps=5&buffer=1000&&monitor=1&auth=b5<deleted>03&connkey=36139" />
        // $link = 'http://172.30.50.40/zm/cgi-bin/nph-zms?scale=100&mode=jpeg&maxfps=5&monitor='.$id_new;
        $link = DB::connection('mysql1')->table('ms_item')
                        ->where('zm_id', $id_new)
                        ->first()->link . '&user=admin2&pass=Pakuwon2023%23';

        $new = DB::connection('mysql1')->table('cctv')
                ->value('cctv_id_new');
        return view('Right', ['NewCCTV' => $new, 'Link' => $link]);
    }

    public function delete($id) {
        DB::connection('mysql1')->table('ms_item')->where('id', $id)->delete();
        return 'true';
    }

    public function hibobdata($id) {
        
        $name = DB::connection('mysql1')->table('ms_item')->where('id', $id)->value('name');
        $company_id = DB::connection('mysql1')->table('ms_item')->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                        ->where('ms_item.id', $id)->take(1)->value('ms_floor.company_id','ms_floor.company_name');
         $company_detail=DB::connection('mysql1')->table('ms_item')
                    ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                      ->where('ms_item.id', $id)
                    ->select('ms_item.name',"ms_floor.company_id")
                    ->get();
          $company_id=$company_detail[0]->company_id;
        $name=$company_detail[0]->name;
               
        //$company_id=
        //dd($company_id);
        if ($company_id == '1' || $company_id == 1) {
            $data = DB::connection('mysql2')->table('hibob_gc_getlateingateway_src')->where('nama_gateway', $name)->orderby('waktu_alert', 'Desc')->distinct()->take(2)->get();
        } else if ($company_id == '2' || $company_id == 2) {
            $data = DB::connection('mysql2')->table('hibob_kk_getlateingateway_src')->where('nama_gateway', $name)->orderby('waktu_alert', 'Desc')->distinct()->take(2)->get();
        } else if ($company_id == '3' || $company_id == 3) {
            $data = DB::connection('mysql2')->table('hibob_pbm_getlateingateway_src')->where('nama_gateway', $name)->orderby('waktu_alert', 'Desc')->distinct()->take(2)->get();
        } else {
            $data = [];
        }

        return $data;
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

    public function cctvclick($id) {
        $old = DB::connection('mysql1')->table('cctv')->value('cctv_id_new');
        DB::connection('mysql1')->table('cctv')->update([
            'cctv_id_new' => $id,
            'cctv_id_old' => $old
        ]);
        $zm_id = DB::connection('mysql1')->table('ms_item')->where('id', $id)->value('zm_id');
        return 'Monitor ' . $zm_id;
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

    public function HeatMap() {
        $floorid = 4;
        return view('HeatMap', ['FloorID' => $floorid]);
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
     public function dashboard()
    {
        return view('dashboard');
    }
    public function backdashboard(){
        return redirect('/admin');
    }
    public function useredit(){
       return view('dashboardUser');
    }
}
