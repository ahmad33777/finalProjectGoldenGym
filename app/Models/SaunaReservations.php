<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaunaReservations extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sauna_reservations';
    protected $fillable = [
        'subscriber_id',
        'booking_date',
        'start_time',
        'end_time',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
      ];

}