<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserFormRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::role('user')->get();

        return view("admin.pages.user.user.index")->with(["data" => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.pages.user.user.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserFormRequest $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'patronymic' => 'required|max:255',
            'login' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'images.*' => 'mimes:jpg,bmp,png,svg',
            'password' => 'required|min:6|confirmed',
        ]);

        $images = [];

        if ($request->has('images')) {
            foreach($request->images as $value) {
                $fileName = $this->random_string(15).'.'.$value->getClientOriginalExtension();
                $destinationPath = public_path().'/images/users/user' ;
                $value->move($destinationPath,$fileName);
                $images[] = 'images/users/user/'.$fileName;
            }
        }

        $data["images"] = (count($images) > 0) ? json_encode($images) : null;
        $data["password"] = bcrypt($request->password);

        $user = User::create($data);
        $user->assignRole('user');

        return redirect(route("admin.users.index"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::findOrFail($id);

        return view("admin.pages.user.user.create")->with(["data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, string $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'patronymic' => 'required|max:255',
            'images.*' => 'mimes:jpg,bmp,png,svg',
        ]);

        if ($user->login != $request->login) {
            $request->validate([
                'login' => 'unique:users',
            ]);

            $data['login'] = $request->login;
        }

        if ($user->email != $request->email) {
            $request->validate([
                'email' => 'unique:users',
            ]);

            $data['email'] = $request->email;
        }

        if (!empty($request->password)) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);

            $data["password"] = bcrypt($request->password);
        }

        $images = ($user->images) ? json_decode($user->images) : [];

        if ($request->has('images')) {
            foreach($request->images as $value) {
                $fileName = $this->random_string(15).'.'.$value->getClientOriginalExtension();
                $destinationPath = public_path().'/images/users/user' ;
                $value->move($destinationPath,$fileName);
                $images[] = 'images/users/user/'.$fileName;
            }
        }

        $data["images"] = (count($images) > 0) ? json_encode($images) : null;

        $user->update($data);

        return redirect(route("admin.users.index"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if (auth('admin')->user()->id != $id) {
            if (!empty($user->images)) {
                foreach(json_decode($user->images) as $value) {
                    $file_path = public_path($value);

                    if (File::exists($file_path)) {
                        File::delete($file_path);
                    }
                }
            }

            if (count($user->roles) > 0)
            {
                foreach($user->roles as $value)
                {
                    $user->removeRole($value->name);
                }
            }

            $user->delete();
        }

        return back();
    }
}
