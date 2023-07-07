<?php

namespace App\Models;

use App\Models\Check;
use App\Models\Leave;
use App\Models\Latetime;
use App\Models\Overtime;
use App\Models\schedule;
use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Trainer extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;
    use HasApiTokens;


    public static function rouleStore()
    {
        return [
            'name' => ['required', 'string', 'min:5'],
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|min:10|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|nullable',
            'age' => 'required|min:16|numeric|nullable',
            'marital_status' => 'nullable|in:أعزب,مطلق,متزوج,أرمل',
            'schedule' => 'required|not_in:0',
        ]
        ;
    }
    
    protected $table = 'trainers';

    protected $fillable = [
        'name',
        'email',
        'phone',
    ];


    protected $hidden = [
        'password',
        'remember_token',
        'updated_at',
        'deleted_at',
        'image',
        'email_verified_at',
        'created_at'
    ];

    public function check()
    {
        return $this->hasMany(Check::class);
    }

    public function attendance()
    {
        return $this->hasMany(TrainerAttendance::class);
    }



    public function schedules()
    {
        return $this->belongsToMany(schedule::class, 'schedule_trainers', 'trainer_id', 'schedule_id');
    }


    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

}