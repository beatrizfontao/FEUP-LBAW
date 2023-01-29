<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ShoppingCart;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'date_of_birth' => 'required|date',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'photo' => $data['photo'],
            'password' => bcrypt($data['password']),
            'id_shopping_cart' => $data['id_shopping_cart']
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        $validation = $this->validator($data);
        if ($validation->fails()) {
            return redirect('/register')->back()->withErrors($validation);
        } else {

            if (isset($data['photo'])) {
                $image = $request->file('photo');
                $filename = $image->getClientOriginalName();

                $image->storeAs('/public/users/', $filename);

                $data['photo'] = $filename;
            }
            else{
                $data['photo'] = '';
            }

            $cart = ShoppingCart::create();

            $data['id_shopping_cart'] = $cart->id_shopping_cart;
            $id = $cart->id_shopping_cart;

            $purchases = DB::table('add_to_shopping_cart')->where('id_shopping_cart', 0)->get();
            if(empty($purchases)){
              ShoppingCart::find(0)['product_quantity'] = 50;
            }
            else{
              $first_cart = ShoppingCart::find(0);
              $cart = ShoppingCart::find($id);

              DB::table('shopping_cart')
              ->where('id_shopping_cart', $id)
              ->update(['product_quantity' => $first_cart->product_quantity, 'total_price'=>$first_cart->total_price]);

              DB::table('shopping_cart')
              ->where('id_shopping_cart', 0)
              ->update(['product_quantity' => 0, 'total_price'=>0]);

              DB::table('add_to_shopping_cart')
              ->where('id_shopping_cart', 0)
              ->update(['id_shopping_cart' => $id]);
            }

            $user = $this->create($data);

            Auth::login($user);

            return view('pages.profile', ['user'=>$user]);
        }
    }
}
