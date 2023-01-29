<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public $timestamps  = false;

    protected $table = 'review';
    protected $primaryKey = 'id_review';
    
    protected $fillable = [
        'rating', 'title', 'text', 'date','id_user', 'id_product'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }

    public function reports()
    {
        return $this->belongsToMany(User::class)->withPivot('motive','date','status');
    }
}
