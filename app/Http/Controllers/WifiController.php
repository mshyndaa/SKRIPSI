<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ms_item;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;
use UniFi_API\Client as UnifiClient;

class WifiController extends Controller {

    public function getWifiDevices($id,$name) {
                
        $companyid = DB::connection('mysql1')->table('ms_item')
                ->join('ms_floor', 'ms_item.location', 'ms_floor.id')
                ->where('ms_item.id', $id)
                ->value('ms_floor.company_id');
         
         $user=env('WIFI_USER_'.$companyid);
         $pass=env('WIFI_PASS_'.$companyid);
         $url=env('WIFI_URL_'.$companyid);
         $controller=env('WIFI_CONTROLLER_'.$companyid);
         //dd($user);
         //env('OAUTH_CLIENT_ID')
        $unifi_connection = new UnifiClient($user, $pass, $url, "", $controller);
        $name=$str = str_replace(';', '/', $name);
        
        $WifiData=array();
        $Upload=0;
        $Download=0;
      //  $set_debug_mode = $unifi_connection->set_debug("false");
        $loginresults = $unifi_connection->login();
        $data = $unifi_connection->list_devices();
      //  print_r($data[133]->name);
        for($i=0;$i<count($data);$i++){
            //dd($data[$i]->name);
            if(isset($data[$i]->name)){
                if(((string)$data[$i]->name)==$name){
        //        echo "ada\r\n";
               // $WifiData=$data[$i]->uplink;
                $WifiData = (array) $data[$i]->uplink;
                $Upload=$WifiData['tx_bytes']/(1024*1024);
                $Download=$WifiData['rx_bytes']/(1024*1024);
                break;
                }
          
            }
        }
        
 $array = array();
        $array[0]['upload'] = number_format($Upload,2);
        $array[0]['download'] = number_format($Download,2);
        
        return json_encode($array);
        /**
         * provide feedback in json format
         */
      
    }
    public function getAllWifiDevices($id) {
           //     dd($id);
        $companyid = DB::connection('mysql1')->table('ms_floor')
                ->where('ms_floor.id', $id)
                ->value('ms_floor.company_id');
               // ->toSql();
       //  dd($companyid);
         $user=env('WIFI_USER_'.$companyid);
         $pass=env('WIFI_PASS_'.$companyid);
         $url=env('WIFI_URL_'.$companyid);
         $controller=env('WIFI_CONTROLLER_'.$companyid);
         //dd($user);
         //env('OAUTH_CLIENT_ID')
        $unifi_connection = new UnifiClient($user, $pass, $url, "", $controller);
     //   $name=$str = str_replace(';', '/', $name);
        
        $WifiData=array();
        $Upload=0;
        $Download=0;
      //  $set_debug_mode = $unifi_connection->set_debug("false");
        $loginresults = $unifi_connection->login();
        $data = $unifi_connection->list_devices();
      //  print_r($data[133]->name);
        //print_r(count($data));
        $totalWifiData=count($data)-1;
        $WifiData = (array) $data[$totalWifiData];
        $Upload=$WifiData['tx_bytes']/(1024*1024);
        $Download=$WifiData['rx_bytes']/(1024*1024);

        /*for($i=0;$i<count($data);$i++){
            //dd($data[$i]->name);
            if(isset($data[$i]->name)){
                if(((string)$data[$i]->name)==$name){
        //        echo "ada\r\n";
               // $WifiData=$data[$i]->uplink;
                $WifiData = (array) $data[$i]->uplink;
                $Upload=$WifiData['tx_bytes']/(1024*1024);
                $Download=$WifiData['rx_bytes']/(1024*1024);
                break;
                }
          
            }
        }*/
        
 $array = array();
        $array[0]['upload'] = number_format($Upload,2);
        $array[0]['download'] = number_format($Download,2);
        
        return json_encode($array);
        /**
         * provide feedback in json format
         */
      
    }
}

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

