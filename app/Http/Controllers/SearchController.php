<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class SearchController extends Controller
{
    public function search(Request $request){
         $products = Product::whereRaw("tsvectors @@ plainto_tsquery('" . $request->search . "')")->paginate(9);
        return view('pages.products', ['products' => $products]); 
    }
}