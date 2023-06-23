<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    protected $table = 'categories';

    use HasFactory;
    use SoftDeletes;
    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}