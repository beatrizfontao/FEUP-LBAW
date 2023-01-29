<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class ManagementController extends Controller
{
    public function show()
    {
        $this->authorize('management',Auth::user());
        return view("pages.management");
    }

    public function show_search_users()
    {
        return view("pages.search_user");
    }

    public function show_search(Request $request)
    {
        $this->authorize('management',Auth::user());
        $input = $request->all();
        $option = $input["option"];
        $search = $input["id"];
        
        if($option == 1){
            $customer = User::find($search);
            if($customer == NULL){
                return view("pages.search_user");
            }
        }
        elseif($option == 2){
            $customer = DB::table('users')->where('email', $search)->get()->first();
            if($customer == NULL){
                return view("pages.search_user");
            }
        }
        return view("pages.profile", ['user' => $customer]);
    }

    public function edit_admin(Request $request)
    {
        $this->authorize('management',Auth::user());
        $input = $request->all();

        $customer = user::find($input["id"]);

        $name = $input["name"];
        $email = $input["email"];
        $gender = $input["gender"];
        $date_of_birth = $input["date_of_birth"];
        $password = $input["password"];


        if(isset($name))
            $customer->name = $name;
        if(isset($email))
            $customer->email = $email;
        if(isset($gender))
            $customer->gender = $gender;
        if(isset($date_of_birth))
            $customer->date_of_birth = $date_of_birth;
        if(isset($password))
            $customer->password = bcrypt($password);

        $customer->save();
        return redirect('/management');
    }

    public function show_create_user()
    {
        return view("pages.create_profile");
    }
    
    protected function create(array $data)
    {   
        $this->authorize('management',Auth::user());
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'photo' => $data['photo'],
            'password' => bcrypt($data['password']),
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $this->authorize('management',Auth::user());
        if (isset($data['photo'])) {
            $image = $request->file('photo');
            $filename = $image->getClientOriginalName();

            $image->storeAs('/public/users/', $filename);

            $data['photo'] = $filename;
        }
        else{
            $data['photo'] = '';
        }
        $customer = DB::table('users')->where('email', $data['email'])->get()->first();
        if($customer != NULL){
            return view("pages.management");
        }

        $user = $this->create($data);
        
        return view('pages.profile', ['user' => $user]);
    }
}