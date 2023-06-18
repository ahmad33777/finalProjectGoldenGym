<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Subscriber extends Authenticatable
{
    use HasFactory;
    use SoftDeletes;
    use HasApiTokens;

    protected $table = 'subscribers';


    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Product::class, 'orders', 'subscriber_id', 'product_id')
            ->where('orders.deleted_at', null);
        ;
    }

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
        'email_verified_at',
        'fcm_token',
    ];


    public function products()
    {
        return $this->hasMany(Sale::class);
    }
}