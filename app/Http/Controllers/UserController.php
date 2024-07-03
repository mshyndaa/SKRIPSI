<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;


class UserController extends Controller
        {
    public function viewLogin()
    {
       if (Session::get('user.id') != null){ 
            return redirect('home');
        }else{
             return view('../staff/Login');
        }
    }

    public function verifyLoginStaff(Request $request)
    {
        $username = (isset($request['username'])) ? $request['username'] : '0';
        $password = (isset($request['password'])) ? $request['password'] : '0';
        $remember = (isset($request['remember'])) ? $request['remember'] : false;
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $name = '';
            $uname = '';
            $id = '';
            $email = '';
            $phone = '';
            $office = '';
            $users = DB::connection('mysql1')
                ->table('users')    
                ->where('users.username', '=', $username)
                ->get();
            $row = 0;
            foreach ($users as $key => $user) {
                $id = $user->id_users;
                $uname = $user->username;
                $email = $user->email;
                $request->session()->put('user', [
                    'id' => $id, 'name' => $name, 'username' => $username, 'email' => $email
                ]);

                return redirect('/home');
            }
        } else {
            Session::flash('message', 'Username or Password is incorrect Please check your credentials again.');
            return redirect::back();
        }
    }
    
    public function logout(Request $request)
    {
        $request->session()->forget('user');
        $request->session()->forget('devicetype');

        return redirect('/');
    }
}