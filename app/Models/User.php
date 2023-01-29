<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;



class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps  = false;

    protected $table = 'users';
    protected $primaryKey = 'id_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'password', 'date_of_birth','email', 'photo', 'id_shopping_cart'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    // Relations
    public function wishList()
    {
        return $this->hasOne(WishList::class, 'id_wish_list');
    }

    public function shoppingCart()
    {
        return $this->hasOne(ShoppingCart::class, 'id_shopping_cart');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orders($id)
    {
        return $this->hasMany(Order::class, 'id_user')->where('id_user', $id)->get();
    }

    public function addresses($id)
    {
        //return $this->belongsToMany(Address::class, 'customer_address', 'id_user', 'id_address');
        return $this->belongsToMany('App\Models\Address', 'customer_address', 'id_user', 'id_address')->where('customer_address.id_user', $id)->get();
    }

    public function reports()
    {
        return $this->belongsToMany(Review::class)->withPivot('motive','date','status');
    }

    public function getProfilePicture()
    {
        if ($this->photo == '' || is_null($this->photo))
            return "nophoto.jpg";
        return $this->photo;
    }

    public function isBanned()
    {
        return $this->hasMany(Ban::class,'id_customer')->get();
    }
}