<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WishList extends Model
{
    use HasFactory;
    public $timestamps  = false;

    protected $table = 'wish_list';
    protected $primaryKey = 'id_wish_list';

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
        return $this->belongsToMany(Product::class,'add_to_wish_list','id_wish_list','id_product');
    }
    
}
