<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ShoppingCart extends Model
{
    use HasFactory;
    public $timestamps  = false;

    protected $table = 'shopping_cart';
    protected $primaryKey = 'id_shopping_cart';

    protected $fillable = [
        'total-price', 'product_quantity', 'id_shopping_cart'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,'add_to_shopping_cart','id_shopping_cart','id_product');
    
    }

    public function cart_not_empty($id){
        $purchases = DB::table('add_to_shopping_cart')->where('id_shopping_cart', 0)->get();
        if(empty($prev_cart)){
          ShoppingCart::find(0)['product_quantity'] = 50;
          return;
        }
        else{
          $first_cart = ShoppingCart::find(0);
          $cart = ShoppingCart::find($id);
    
          $cart['total_price'] = $first_cart['total_price'];
          $cart['product_quantity'] = $first_cart['product_quantity'];
          $first_cart['total_price'] = 0;
          $first_cart['product_quantity'] = 0;
    
          foreach($purchases as $purchase){
            $purchase['id_shopping_cart'] = $id;
          }
    
          return;
        }
      }
}
