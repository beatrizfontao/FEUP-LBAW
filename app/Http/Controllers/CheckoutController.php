<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


use App\Models\Order;
use App\Models\User;
use App\Models\Address;
use App\Models\ShoppingCart;
use App\Models\Product;
use App\Models\Notification;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function show()
    {
        $this->authorize('show',Auth::user());
        if(!Auth::check()){
            return redirect('/register');
        }
        return view("pages.checkout");
    }

    protected function create_adress(array $input) {
        return Address::create([
            'zipcode' => $input["zip"],
            'street' => $input["address"],
            'city' => $input["city"],
            'door_number' => $input["door"],
            'country' => $input["country"]
        ]);
    }

    protected function create(array $input) {
        $add = $this->create_adress($input);
        $add->addresses()->attach(Auth::User()->id_user);
        return Order::create([
        'id_address' => $add->id_address,
        'payment_method' => $input["cardname"] . ' ' . $input["cardnumber"] . ' ' . $input["expmonth"] . ' ' . $input["expyear"] . ' ' . $input["cvv"],
        'corfirmation' => 1,
        'date' => date("Y/m/d"),
        'id_user' => Auth::User()->id_user
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:86',
            'country' => 'required|string|max:57',
            'door' => 'required|integer|max_digits:6',
            'zip' => 'required|integer|digits:7',
            'cardname' => 'required|string|max:255',
            'cardnumber' => 'required|integer|digits:16',
            'expmonth' => 'required|string|between:3,9',
            'expyear' => 'required|integer|digits:4|min:2022',
            'cvv' => 'required|integer|digits:3'
        ]);
    }
    
    
   public function info(Request $request)
   {
        $input = $request->all();
        $check = $this->validator($input);
        
        if ($check->fails()) {
            return redirect()->back()->withErrors($check);
        } 
        $order = $this->create($input);
        $cart = DB::table('add_to_shopping_cart')->where('id_shopping_cart', Auth::User()->id_shopping_cart)->get();
        $notification = Notification::create([
            'message' => 'Your payment information has been successfully accepted', 
            'pending' => 'Payment accepted', 
            'id_shopping_cart' => NULL,
            'id_order' => $order["id_order"],
            'id_wish_list' => NULL
        ]);
        foreach ($cart as $temp){
            $product = Product::find($temp->id_product);
            ProductController::remove_sc($product);
            $product->orders()->attach($order->id_order);
        }
        return view("pages.verify", ['input' => $input]);
   }

}
?>