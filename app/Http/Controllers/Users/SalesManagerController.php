<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class SalesManagerController extends Controller
{
    /**
     * REGISTER PAGE
     */
    public function registerPage()
    {
        if (auth('web')->user())
            return "sales manager profile";
        else
            return view("pages.users.manager.register");
    }

    /**
     * REGISTER PROCESSING
     */
    public function registerProcess(Request $request)
    {
        $data = $request->validate([
            'developer_name' => 'required|max:255',
            'name' => 'required|max:255',
            'surename' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'phone_number' => 'required|unique:users|integer',
            'password' => 'required|min:8|confirmed'
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $role = Role::where('name', 'sales manager')->first();
        // $user->assignRole('developer');

        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_type' => 'App\Models\User',
            'model_id' => $user->id,
        ]);

        $credentials = $request->only('email', 'password');

        if (auth('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return "sales manager profile";
            // return redirect(route("pages.users.developer.profile"));
        }

        return back();
    }
}
