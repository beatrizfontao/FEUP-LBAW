<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\OrderStatus;


class UserController extends Controller
{
    //
    public function show($id)
    {
        $user = User::find($id);
        $this->authorize('show', $user);
        return view('pages.profile', ['user' => $user]);
    }

    public function show_addresses($id)
    {
        $user = User::find($id);
        $this->authorize('show', $user);
        return view('pages.addresses', ['addresses' => $user->addresses($id), 'user' => $user]);
    }

    public function show_past_orders($id)
    {
        $user = User::find($id);
        $stages = OrderStatus::all()->take(10);
        $this->authorize('show', $user);
        //$id_finished = $stages->where('name', "Finished")->get("id_order_status");
        return view('pages.orders', ['orders' => $user->orders($id)->where('id_order_status', 3), 'stages' => $stages, 'user' => $user]);
    }

    public function show_current_orders($id)
    {
        $user = User::find($id);
        $stages = OrderStatus::all()->take(10);
        $this->authorize('show', $user);
        //$id_finished = $stages->where('name', "Finished")->get("id_order_status");
        return view('pages.orders', ['orders' => $user->orders($id)->where('id_order_status', '<>', 3), 'stages' => $stages, 'user' => $user]);
    }

    public function show_edit($id)
    {
        $user = User::find($id);
        $this->authorize('show', $user);
        if (!Auth::check())
            return back()->withErrors([
                'user' => 'You can not edit this profile.'
            ]);
        $user = User::find($id);
        return view("pages.edit_profile", ['user' => $user]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'string|max:255|nullable',
            'email' => 'email|max:255|unique:users|nullable',
            'date_of_birth' => 'date|nullable',
            'password' => 'string|min:6|confirmed|nullable',
        ]);
    }

    public function edit($id, Request $request)
    {
       
        $validation = $this->validator($request->all());
        if ($validation->fails()) {
            return redirect()->back()->withErrors($validation);
        } else {
            if (!Auth::check()) {
                return back()->withErrors([
                    'user' => 'You are not logged in'
                ]);
            }
            $user = User::find($id);

            $input = $request->all();

            $name = $input["name"];
            $email = $input["email"];
            $gender = $input["gender"];
            $date_of_birth = $input["date_of_birth"];
            $password = $input["password"];

            if (isset($input['photo'])) {
                $image = $request->file('photo');
                $filename = $image->getClientOriginalName();

                if (isset($user->photo)) {
                    Storage::delete('public/users/' . $user->photo);
                }
                $image->storeAs('/public/users/', $filename);

                $user->photo =  $filename;
            }

            if (isset($name))
                $user->name = $name;
            if (isset($email))
                $user->email = $email;
            if (isset($gender))
                $user->gender = $gender;
            if (isset($date_of_birth))
                $user->date_of_birth = $date_of_birth;
            if (isset($password))
                $user->password = bcrypt($password);

            $user->save();
            return view("pages.profile", ['user' => $user]);
        }
    }

public function delete_user($id)
    {
        $user = User::find($id);
        Review::where('id_user', $id)
            ->update(['id_user' => 0]);
        $user->delete();
        return redirect('/');
    }

public function recover_show(){
    return view("pages.recovery");
    }
}
