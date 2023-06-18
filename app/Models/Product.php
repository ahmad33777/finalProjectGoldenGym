<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'image',
        'base_price',
        'discount',
        'quantity',
        'description',
        'production_date',
        'expiry_date',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
        'pivot'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function subscribers()
    {
        return $this->belongsToMany(Subscriber::class);
    }
}