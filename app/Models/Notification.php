<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'notifications';


    protected $fillable = [
        'title',
        'message',
    ];

    protected $hidden = [
        'id',
        'updated_at',
        'deleted_at',
    ];

}