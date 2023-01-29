<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    public $timestamps  = false;

    protected $primaryKey = 'id_order';

    protected $attributes = [
        'id_order_status' => 1,
    ];

    protected $fillable = [
        'id_order','id_address','payment_method','corfirmation','id_user', 'date', 'id_order_status'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function products($id)
    {
        return $this->belongsToMany('App\Models\Product', 'add_to_order', 'id_order', 'id_product')->where('add_to_order.id_order', $id)->get();
    }

    public function brand()
    {
        return $this->belongsTo(Category::class, 'id_brand');
    }

    public function order_status()
    {
        return $this->belongsTo(OrderStatus::class, 'id_order_status');
    }

}