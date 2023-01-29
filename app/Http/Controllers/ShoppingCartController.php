<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\ShoppingCart;


class ShoppingCartController extends Controller
{
  public function list()
  {
    if (!Auth::check()) {
      $shopping_cart = ShoppingCart::find(0);
    } else {
      $user = Auth::user();
      $this->authorize('showshoppingcart', $user);
      $shopping_cart = ShoppingCart::find(Auth::user()->id_shopping_cart);
    }
    return view('pages.shopping_cart', ['shopping_cart' => $shopping_cart]);
  }

}
