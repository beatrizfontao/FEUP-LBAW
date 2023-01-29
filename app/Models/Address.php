<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    public $timestamps  = false;

    protected $table = 'address';
    protected $primaryKey = 'id_address';

    /*
    public function customers()
    {
        return $this->belongsToMany(Customer::class, 'customer_address', 'id_user', 'id_address');
    }
    */
    
    protected $fillable = [
        'zipcode', 'street', 'city', 'door_number', 'country'
    ];

    public function addresses()
    {
        return $this->belongsToMany(Address::class,'customer_address','id_address','id_user');
    }
}
