<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index() {
        return view('admin.pages.auth.login');
    }

    public function login(Request $request) {
        $data = $request->validate([
            "email" => ["required", "email", "string"],
            "password" => ["required"]
        ]);

        if (auth("admin")->attempt($data, $request->remember) || auth("admin")->viaRemember()) {
            $request->session()->regenerate();

            return redirect(route("admin.dashboard"));
        }

        return back()->withErrors([
            "email" => "The credentials you entered did not match our records.",
        ])->onlyInput("email");
    }

    /**
     * User logout
     */
    public function logout(Request $request) {
        auth("admin")->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(route("admin.login"));
    }
}
