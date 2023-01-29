<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    use HasFactory;
    public $timestamps  = false;

    protected $table = 'ban';
    protected $primaryKey = 'id_customer';

    protected $fillable = [
        'id_customer','id_admin', 'motive', 'date'
    ];


    public function banned()
    {
        return $this->belongsTo(User::class, 'id_customer');
    }

    public function review()
    {
        return $this->belongsTo(User::class, 'id_admin');
    }
}