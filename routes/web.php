<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\MapsController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMapsController;
use App\Http\Controllers\PostAjaxController;
use App\Http\Controllers\DataTableAjaxCRUDController;
use App\Http\Controllers\UserController;


//Routing Web : Staff
Route::get('/', [UserController::class, 'viewLogin'])->name('viewLogin');
Route::post('verifyLoginStaff', [UserController::class, 'verifyLoginStaff'])->name('verifyLoginStaff');

Route::get('/home', [MapsController::class, 'home']);
Route::get('/indexbyfloor/{id}', [MapsController::class, 'indexByFloor']);

Route::post('logout', [UserController::class, 'logout'])->name('logout');



//Routing Web : Admin
Route::get('/admin', [AdminController::class, 'viewAdminLogin'])->name('viewAdminLogin');
Route::post('verifyLogin', [AdminController::class, 'verifyLogin'])->name('verifyLogin');

Route::get('/dashboard', [AdminController::class, 'dashboard']);
Route::get('adminlogout', [AdminMapsController::class, 'adminlogout'])->name('adminlogout');
Route::post('backdashboard', [AdminController::class, 'dashboard']);


Route::get('/floor/{id}', [MapsController::class, 'floor']);
Route::get('/floorUser/{id}', [MapsController::class, 'floorUser']);
Route::get('/changefloor/{id}', [MapsController::class, 'changefloor']);


Route::get('/selectDeviceType/{id}', [MapsController::class, 'selectDeviceType']);
Route::get('/wifidatadetail/{nama}', [MapsController::class, 'wifidatadetail']);
Route::get('/cctvchange/{id}', [MapsController::class, 'cctvclick']);
Route::get('/livecctv/{id}', [MapsController::class, 'livecctv']);
Route::get('/pcclick/{id}', [MapsController::class, 'pcclick']);
Route::get('/cctv/{id}', [MapsController::class, 'cctv']);
Route::get('/heatmap', [MapsController::class, 'HeatMap']);
Route::get('/heatdata/{id}', [MapsController::class, 'HeatData']);

Route::post('backhome', [MapsController::class, 'home']);
Route::get('/getMap/{id}', [MapsController::class, 'getMap']);

Route::get('/getNextMap/{id}/{pageNo}/{floorOnPage}', [MapsController::class, 'getNextMap']);
Route::get('/floorcondition/{id}', [MapsController::class, 'floorcondition']);
Route::get('register', [RegisterController::class, 'viewRegister'])->name('viewRegister');
Route::get('test', [RegisterController::class, 'test'])->name('test');
Route::post('register/action', [RegisterController::class, 'ActionRegister'])->name('ActionRegister');


// admin
Route::get('/ms_item', [AdminMapsController::class, 'ms_item']);
Route::get('/ms_item/{id}', [AdminMapsController::class, 'ms_itemcompany']);
Route::post('/save', [AdminMapsController::class, 'save']);
Route::post('/update', [AdminMapsController::class, 'update']);
Route::post('/deleted', [AdminMapsController::class, 'deleteData']);
Route::post('/deletedata', [AdminMapsController::class, 'deleteDataAjax']);
Route::get('/deletedata/{id}', [AdminMapsController::class, 'delete']);

Route::get('/changeadminfloor/{id}', [AdminMapsController::class, 'changefloor']);
Route::get('/flooradmin/{id}', [AdminMapsController::class, 'floor']);
Route::get('/wifiadmindatadetail/{nama}', [AdminMapsController::class, 'wifidatadetail']);
Route::get('/pcadminclick/{id}', [AdminMapsController::class, 'pcclick']);

Route::get('/user/', [AdminMapsController::class, 'useredit']);

Route::resource('ajaxposts', PostAjaxController::class);

//Route::get('/{id}', [MapsController::class, 'indexbycompany']);
Route::get('ajax-crud-user-datatable', [DataTableAjaxCRUDController::class, 'indexuser']);
Route::post('edit-user', [DataTableAjaxCRUDController::class, 'edituser']);
Route::post('edit-mall', [DataTableAjaxCRUDController::class, 'editmall']);
Route::post('store-user', [DataTableAjaxCRUDController::class, 'storeuser']);
Route::post('delete-company', [DataTableAjaxCRUDController::class, 'destroy']);

Route::get('ajax-crud-datatable', [DataTableAjaxCRUDController::class, 'index']);
Route::post('store-company', [DataTableAjaxCRUDController::class, 'store']);
Route::post('edit-company', [DataTableAjaxCRUDController::class, 'edit']);
Route::post('delete-user', [DataTableAjaxCRUDController::class, 'destroyUser']);
/*end*/

