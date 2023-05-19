<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class BrokerController extends Controller
{
    /**
     * REGISTER PAGE
     */
    public function registerPage()
    {
        if (auth('web')->user()) {
            if (auth('web')->user()->hasRole('individual broker')) {
                return "individual broker profile";
            }
            elseif(auth('web')->user()->hasRole('business broker')) {
                return "business broker profile";
            }
        } else {
            return view("pages.users.broker.register");
        }
    }

    /**
     * REGISTER PROCESSING FOR INDIVIDUAL
     */
    public function registerIndividProcess(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'surename' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'phone_number' => 'required|unique:users|integer',
            'password' => 'required|min:8|confirmed'
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $role = Role::where('name', 'individual broker')->first();

        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_type' => 'App\Models\User',
            'model_id' => $user->id,
        ]);

        $credentials = $request->only('email', 'password');

        if (auth('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return "individual broker profile";
        }

        return back();
    }

    /**
     * REGISTER PROCESSING FOR BUSINESS
     */
    public function registerBusinessProcess(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'surename' => 'required|max:255',
            'agency_name' => 'required|max:255',
            'position' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'phone_number' => 'required|unique:users|integer',
            'password' => 'required|min:8|confirmed'
        ]);

        $data['password'] = bcrypt($data['password']);

        $user = User::create($data);
        $role = Role::where('name', 'business broker')->first();

        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_type' => 'App\Models\User',
            'model_id' => $user->id,
        ]);

        $credentials = $request->only('email', 'password');

        if (auth('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return "business broker profile";
        }

        return back();
    }
}
