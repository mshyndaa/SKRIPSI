<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\User;
use App\Models\UserAkses;
use Illuminate\Support\Facades\Hash;
use Datatables;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class DataTableAjaxCRUDController extends Controller {

    public function __construct() {
        $this->middleware(function ($request, $next) {
            if (Session::get('admin.id') == null) {
                return Redirect::to('/admin')->send();
            } else {
                return $next($request);
            }
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        if (request()->ajax()) {
            return datatables()->of(Admin::select('id_users', 'username', 'email', 'created_at'))
                            ->addColumn('action', '../../ajax/company-action')
                            ->rawColumns(['action'])
                            ->addIndexColumn()
                            ->make(true);
        }
        return view('admin_form');
    }

    public function indexuser() {
        if (request()->ajax()) {
            return datatables()->of(User::select('id_users', 'username', 'email', 'created_at'))
                            ->addColumn('action', '../ajax/user-action')
                            ->rawColumns(['action'])
                            ->addIndexColumn()
                            ->make(true);
        }
        return view('user_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {


        DB::connection('mysql1')->enableQueryLog();
        $id_users = $request->id;
        $password = Hash::make($request->password);
        //dd(Session::get('admin.username'));
        $company = Admin::updateOrCreate(
                        [
                            'id_users' => $id_users
                        ],
                        [
                            'username' => $request->name,
                            'email' => $request->email,
                            'password' => $password,
                            'updated_at' => NOW(),
                            'updated_by' => Session::get('admin.username')
        ]);
        //  print_r(DB::connection('mysql1')->getQueryLog());       
        //exit();
        return Response()->json($company);
    }

    public function storeuser(Request $request) {
        $company = $request->input('mall');
        // dd($colors);
        
        $id_users = $request->id;
        $password = Hash::make($request->password);
        //dd(Session::get('admin.username'));
        $post = User::find($id_users);
        if ($request->password != '') {
            $password = Hash::make($request->password);
            $post->password = $password;
        }
        if ($request->email != '') {
            $password = Hash::make($request->password);
            $post->email = $request->email;
        }
        if ($request->email != '') {
            $password = Hash::make($request->password);
            $post->email = $request->email;
        }
        if (isset($request->isactive))
            $post->active = "1";
        else
            $post->active = "0";
        $post->save();
        $res=UserAkses::where('user_id',$id_users)->delete();
        for ($i = 0; $i < count($company); $i++) {
           
            $akses = new UserAkses();
            $akses->company_id = $company[$i];
            $akses->user_id = $id_users;
            $akses->save();
        }
//$post = User::find($id_users);
        //  print_r(DB::connection('mysql1')->getQueryLog());       
        //exit();
        return Response()->json($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {



        $where = array('id_users' => $request->id);
        $company = Admin::where($where)->first();

        return Response()->json($company);
    }

    public function edituser(Request $request) {



        $where = array('id_users' => $request->id);
        $company = User::where($where)->get();

        return Response()->json($company);
    }
public function editmall(Request $request) {


//$dat
        $where = array('user_id' => $request->id);
        $company = UserAkses::where($where)->first();
         $data = DB::connection('mysql1')->table('user_akses')
                ->where('user_id', $request->id)
              
                ->select('company_id')
                ->get();
        $newdata = array();
        $dataMall="";
        foreach ($data as $key => $list) {
            if($dataMall=='')
                $dataMall=$list->company_id;
            else
                $dataMall .=";".$list->company_id;
        }
        return Response()->json($data);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        $company = Admin::where('id_users', $request->id)->delete();

        return Response()->json($company);
    }
}
