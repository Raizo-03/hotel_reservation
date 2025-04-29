<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Admin.login'); // You must create this login page
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = DB::table('admins')
                    ->where('username', $request->username)
                    ->first();

        if ($admin && $request->password === $admin->password) {
            Session::put('admin_logged_in', true);
            Session::put('admin_username', $admin->username);
            return redirect()->route('admin.dashboard');
        } else {
            return back()->withErrors(['login_error' => 'Invalid username or password'])->withInput();
        }
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect()->route('admin.login');
    }
}
