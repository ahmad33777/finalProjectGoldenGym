<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;



    protected $hidden = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function subscriber()
    {
        return $this->belongsTo(subscriber::class);
    }

     
}