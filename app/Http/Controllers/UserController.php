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
        if (Session::get('user.id') != null) {
            return redirect('home');
        } else {
            return view('../staff/Login');
        }
    }

    public function verifyLoginStaff(Request $request)
    {
        $username = $request->input('username', '0');
        $password = $request->input('password', '0');
        $remember = $request->input('remember', false);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $users = DB::connection('mysql1')
                ->table('users')
                ->where('users.username', '=', $username)
                ->get();

            foreach ($users as $user) {
                $id = $user->id_users;
                $username = $user->username;
                $email = $user->email;

                $request->session()->put('user', [
                    'id' => $id, 'name' => '', 'username' => $username, 'email' => $email
                ]);

                return redirect('/home');
            }
        } else {
            Session::flash('message', 'Username or Password is incorrect. Please check your credentials again.');
            return redirect()->back();
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['user', 'devicetype']);
        return redirect('/');
    }
}
