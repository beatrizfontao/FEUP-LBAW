<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\WishList;


class WishListController extends Controller
{
  public function list(){
    $user = Auth::user();
    $this->authorize('showwishlist', $user);
    $wish_list = WishList::find(Auth::user()->id_wish_list);
    return view('pages.wish_list', ['wish_list' => $wish_list]);
  }
}
