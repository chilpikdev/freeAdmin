<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DeveloperContoller extends Controller
{
    /**
     * REGISTER PAGE
     */
    public function registerPage()
    {
        if (auth('web')->user())
            return "developer profile";
            // return redirect(route('developer.cabinet'));
        else
            return view("pages.users.developer.register");
    }

    /**
     * REGISTER PROCESSING
     */
    public function registerProcess(Request $request)
    {
        $data = $request->validate([
            'developer' => 'required|max:255',
            'name' => 'required|max:255',
            'surename' => 'required|max:255',
            'position' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'phone_number' => 'required|unique:users|integer',
            'password' => 'required|min:8|confirmed'
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $role = Role::where('name', 'developer')->first();
        // $user->assignRole('developer');

        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_type' => 'App\Models\User',
            'model_id' => $user->id,
        ]);

        $credentials = $request->only('email', 'password');

        if (auth('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return "developer profile";
            // return redirect(route("pages.users.developer.profile"));
        }

        return back();
    }
}
