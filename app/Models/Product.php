<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    public $timestamps  = false;

    protected $table = 'product';
    protected $primaryKey = 'id_product';

        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'id_category', 'id_brand', 'photo', 'price','stock'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_category');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'id_brand');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class,'id_product');
    }

    public function wishLists()
    {
        return $this->belongsToMany(ShoppingCart::class,'add_to_wish_list','id_product','id_wish_list');
    }

    public function shoppingCarts()
    {
        return $this->belongsToMany(ShoppingCart::class,'add_to_shopping_cart','id_product','id_shopping_cart');
    }
    
    public function orders()
    {
        return $this->belongsToMany(Order::class,'add_to_order','id_product','id_order');
    }
}
