<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    public $timestamps  = false;

    protected $table = 'notification';
    protected $primaryKey = 'id_notification';

    protected $fillable = [
        'message', 'pending', 'id_shopping_cart', 'id_order', 'id_wish_list'
    ];

    public function shoppingCart()
    {
        return $this->belongsTo(ShoppingCart::class, 'id_shopping_cart');
    }

    public function wishList()
    {
        return $this->belongsTo(WishList::class, 'id_wish_list');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order');
    }
}
