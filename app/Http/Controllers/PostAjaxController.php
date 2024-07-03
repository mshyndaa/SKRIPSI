<?php
         
namespace App\Http\Controllers;
          
use App\Models\Admin;
use Illuminate\Http\Request;
use DataTables;
        
class PostAjaxController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
         $post = "";
       // if ($request->ajax()) {
            $post = Admin::latest()->get();
          //  dd($post);
            return Datatables::of($post)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
   
                           $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editPost">Edit</a>';
   
                           $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deletePost">Delete</a>';
    
                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        //}
      
        return view('postAjax',compact('post'));
    }
     
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Admin::updateOrCreate(['id_users' => $request->id_users],
                ['username' => $request->username, 'password' => $request->password]);        
   
        return response()->json(['success'=>'Data Admin Sukses Disimpan.']);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Admin::find($id);
        return response()->json($post);
    }
  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::find($id)->delete();
     
        return response()->json(['success'=>'Data Admin Telah Terhapus.']);
    }
}