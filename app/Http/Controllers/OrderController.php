<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderStatus;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
  public function show($id, $id_order)
  {
    $this->authorize('show',Auth::user());
    $user = User::find($id);
    $order = Order::find($id_order);
    $stages = OrderStatus::all()->take(10);
    $status = OrderStatus::find($order->id_order_status);
    $products = $order->products($id_order);
    return view('pages.order', ['order' => $order, 'stages' => $stages, 'status' => $status, 'products' => $products, 'user' => $user]);
  }

  public function change_status($id, Request $request)
  {
    $id = $request->route("id");
    $new_status = $request->post()['id_order_status'];
    $order = Order::findOrFail($id);

    $order->id_order_status = $new_status;
    $order->save();
    
    return response()->json(['id_order_status' => $order->id_order_status], 200);
    /*
    $input = $request->all();
    $order = Order::find($id);
    $order->id_order_status = $input["id_order_status"];
    $order->save();
    return $order;
    
    $input = $request->data;
    $order = Order::find($id);
    $order->id_order_status = $input["id_order_status"];
    $order->save();
    return $order;
    */
  }
}
