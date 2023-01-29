<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
    public $timestamps  = false;

    protected $table = 'report';
    protected $primaryKey = 'id_review';
 
    protected $fillable = [
        'id_review','id_user', 'motive', 'date','status'
    ];

    public function reported()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function review()
    {
        return $this->belongsTo(Review::class, 'id_review');
    }
}
