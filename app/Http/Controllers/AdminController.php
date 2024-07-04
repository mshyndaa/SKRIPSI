<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AdminController extends Controller
{
    public function viewAdminLogin()
    {
        if (Session::get('admin.id') != null) {
            return view('../admin/Listadmin');
        } else {
            return view('../admin/login');
        }
    }

    public function verifyLogin(Request $request)
    {
        $username = $request->input('username', '0');
        $password = $request->input('password', '0');
        $remember = $request->input('remember', false);

        $users = DB::connection('mysql1')
            ->table('admin')
            ->where('admin.username', '=', $username)
            ->get();

        if (count($users) > 0) {
            foreach ($users as $user) {
                $id = $user->id_users;
                $username = $user->username;
                $email = $user->email;
                $passwordDb = $user->password;

                if (Hash::check($password, $passwordDb)) {
                    $request->session()->put('admin', [
                        'id' => $id, 'name' => '', 'username' => $username, 'email' => $email
                    ]);

                    return redirect('/admin');
                } else {
                    Session::flash('message', 'Username or Password is incorrect! Please check your credentials again.');
                    return redirect()->back();
                }
            }
        } else {
            return redirect()->back()->withErrors([
                'email' => 'Username atau Password Salah !!!',
            ]);
        }
    }
}
