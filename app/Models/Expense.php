<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'expenses';



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
