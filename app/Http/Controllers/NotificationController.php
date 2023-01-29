<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public static function notifications()
    {
        $user = Auth::User();
        $id_order = DB::table('orders')->select('id_order')->where('id_user', $user["id_user"])->get();
        $id=[];
        foreach($id_order as $order)
            array_push($id, $order->id_order);
        $id_shopping_cart = $user["id_shopping_cart"];
        $id_wish_list = $user["id_wish_list"];
        $message = DB::table('notification')
                        ->WhereIn('id_order', $id)
                        ->orWhere('id_shopping_cart', $id_shopping_cart)
                        ->orWhere('id_wish_list', $id_wish_list)
                        ->get();
        return $message;
    }
}
