<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;
    public $timestamps  = false;

    protected $table = 'order_status';
    protected $primaryKey = 'id_order_status';

    protected $fillable = [
        'id_order_status','name'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function get_id_finished()
    {
        return $this->where('name', "Finished")->get()["id_order_status"];
    }
}