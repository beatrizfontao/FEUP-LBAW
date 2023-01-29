<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use App\Models\Category;
use App\Models\Brand;
use App\Models\WishList;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
  public function show($id)
  {
    $checkbuy = NULL;
    $product = Product::find($id);
    $productcount = 0;
    $wishlist = NULL;
    $buyprod = NULL;
    $reviews = $product->reviews()->get();
    if (Auth::check()) {
      $productcount = $this->count_prod($id);
      $wishlist = $product->wishLists->contains(Auth::user()->id_wish_list);
      $buyprod = $product->orders->intersect(Auth::user()->orders((Auth::user()->id_user))); 
      $checkbuy =  $buyprod->count();   
    }
    return view('pages.product', ['product' => $product, 'productcount' => $productcount, 'wishlist' => $wishlist, 'reviews' => $reviews, 'buyprod' => $buyprod,'checkbuy' => $checkbuy]);
  }

  public function list()
  {
    $products = Product::whereRaw('id_product>0')->paginate(9);
    return view('pages.products', ['products' => $products]);
  }

  public function brand_list($brand)
  {
    $products = Product::where('id_brand',$brand)->get();
    $brand_obj = Brand::find($brand);
    return view('pages.brand', ['products' => $products, 'brand'=> $brand_obj->name]);
  }


  public function category_list($category)
  {
    $products = Product::where('id_category',$category)->get();
    $category_obj = Category::find($category);
    return view('pages.category', ['products' => $products, 'category'=> $category_obj->name]);
  }

  public function add_wishlist(Request $request)
  {
    $id = $request->id;
    $product = Product::find($id);
    if (Auth::check())
      $product->wishLists()->attach(Auth::user()->id_wish_list);
    return $product;
  }

  public function remove_wishlist(Request $request)
  {
    $id = $request->id;
    $product = Product::find($id);
    if (Auth::check())
      $product->wishLists()->detach(Auth::user()->id_wish_list);
    return $product;
  }

  public static function count_prod($id)
  {
    if (Auth::check())
      $prodcount = DB::table('add_to_shopping_cart')
        ->where('id_product', '=', $id)
        ->where('id_shopping_cart', '=', Auth::user()->id_shopping_cart)
        ->count();
    else
      $prodcount = DB::table('add_to_shopping_cart')
        ->where('id_product', '=', $id)
        ->where('id_shopping_cart', '=', 0)
        ->count();
    return $prodcount;
  }

  public function buy(Request $request)
  {
    $id = $request->id;
    $product = Product::find($id);
    if (Auth::check())
      $product->shoppingCarts()->attach(Auth::user()->id_shopping_cart);
    else
      $product->shoppingCarts()->attach(0);
    return $product;
  }

  public function remove(Request $request)
  {
    $id = $request->id;
    $product = Product::find($id);
    DB::delete(
      'DELETE FROM lbaw2213.add_to_shopping_cart
                  WHERE ctid IN (
                  SELECT ctid
                  FROM lbaw2213.add_to_shopping_cart
                  WHERE id_product = ?  AND id_shopping_cart = ?
                  LIMIT 1)',
      array($id, Auth::user()->id_shopping_cart)
    );
    return $product;
  }

  public static function remove_sc(Product $request)
  {
    $id = $request->id_product;
    $product = Product::find($id);
    return DB::delete(
      'DELETE FROM lbaw2213.add_to_shopping_cart
                  WHERE ctid IN (
                  SELECT ctid
                  FROM lbaw2213.add_to_shopping_cart
                  WHERE id_product = ?  AND id_shopping_cart = ?
                  LIMIT 1)',
      array($id, Auth::user()->id_shopping_cart)
    );
  }

  public function show_edit($id)
  {
    $product = Product::find($id);
    $categories = Category::all();
    $brands = Brand::all();
    return view('pages.edit_product', ['product' => $product, 'categories' => $categories, 'brands' => $brands]);
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator_edit(array $data)
  {
    return Validator::make($data, [
      'id_product' => 'integer',
      'name' => 'string|max:255|nullable',
      'price' => 'nullable',
      'stock' => 'integer|nullable',
      'description' => 'string|nullable',
      'category' => 'integer|nullable',
      'brand' => 'integer|nullable',
      'photo' => 'nullable'
    ]);
  }

  public function edit(Request $request, $id)
  {
    $product = Product::find($id);

    $data = $request->all();
    $validation = $this->validator_edit($data);
    if ($validation->fails()) {
      return redirect('/product/'. $id .'/edit')->back()->withErrors($validation);
    } else {
      $name = $data["name"];
      $price = $data["price"];
      $description = $data["description"];
      $stock = $data["stock"];
      $id_category = $data["category"];
      $id_brand = $data["brand"];

      if (isset($data['photo'])) {
        $image = $request->file('photo');
        $filename = $image->getClientOriginalName();

        if (isset($product->photo)) {
            Storage::delete('public/products/' . $product->photo);
        }
        $image->storeAs('/public/products/', $filename);

        $product->photo =  $filename;
      }

      if (isset($name))
        $product->name = $name;
      if (isset($price)){
        $shoppingcart = DB::table('add_to_shopping_cart')
                        ->Where('id_product',"$id")
                        ->pluck('id_shopping_cart');
        foreach($shoppingcart as $cart){
          $notification = Notification::create([
            'message' => 'Please check your shooping cart for price updates', 
            'pending' => 'An item in your shopping cart changed price', 
            'id_shopping_cart' => "$cart",
            'id_order' => NULL,
            'id_wish_list' => NULL
          ]);
        }
        $wishlist = DB::table('add_to_wish_list')
                        ->Where('id_product',"$id")
                        ->pluck('id_wish_list');
        foreach($wishlist as $wish){
          $notification = Notification::create([
            'message' => 'Please check your wishlist for price updates', 
            'pending' => 'An item in your wishlist changed price', 
            'id_shopping_cart' => NULL,
            'id_order' => NULL,
            'id_wish_list' => "$wish"
          ]);
        }
        $product->price = $price;
      }
      if (isset($stock))
        $product->stock = $stock;
      if (isset($description))
        $product->description = $description;
      if (isset($id_category))
        $product->id_category = $id_category;
      if (isset($id_brand))
        $product->id_brand = $id_brand;

      $product->save();
      return redirect('/product/' . $id);
    }
  }

  public function show_add(Request $request)
  {
    $this->authorize('management',Auth::user());
    $categories = Category::all();
    $brands = Brand::all();
    return view("pages.add_product", ['categories' => $categories, 'brands' => $brands]);
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator_add(array $data)
  {
    return Validator::make($data, [
      'id_product' => 'integer',
      'name' => 'string|max:255|required',
      'price' => 'required',
      'stock' => 'integer|required',
      'description' => 'string|required',
      'category' => 'integer|required',
      'brand' => 'integer|required',
      'photo' => 'required'
    ]);
  }

  /**
   * Create a new product instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\Models\Product
   */
  protected function create(array $data)
  {
    return Product::create([
      'name' => $data['name'],
      'description' => $data['description'],
      'price' => $data['price'],
      'stock' => $data['stock'],
      'id_category' => $data['category'],
      'id_brand' => $data['brand'],
      'photo' => $data['photo']
    ]);
  }

  public function add(Request $request)
  {

    $data = $request->all();

    $validation = $this->validator_add($data);
    if ($validation->fails()) {
      return redirect('/product/add')->back()->withErrors($validation);
    } else {
    $image = $request->file('photo');
    $filename = $image->getClientOriginalName();

    $image->storeAs('/public/products/', $filename);

    $data['photo'] = $filename;

    $product = $this->create($data);
    return redirect()->intended('/product/' . $product->id_product);
    }
  }

  public function delete_product($id)
  {
    $product = Product::find($id);

    DB::table('add_to_shopping_cart')->where('id_product', $id)->delete();

    DB::table('add_to_wish_list')->where('id_product', $id)->delete();

    DB::table('add_to_order')->where('id_product', $id)->delete();

    $product->delete();

    return redirect('/');
  }
}
