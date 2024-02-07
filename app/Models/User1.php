<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User1 extends Model
{
    use HasFactory;

    protected $table = 'users1';

    protected $fillable = [
        'name',
        'email',
        'join_date',
        'status',
    ];
}
