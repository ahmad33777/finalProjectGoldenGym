<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainerComplaint extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'trainer_complaints';



    protected $fillable = [
        'message',
    ];


    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
      ];






}