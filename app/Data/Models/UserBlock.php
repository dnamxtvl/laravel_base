<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBlock extends Model
{
    use HasFactory;

    protected $table = 'users_block';
    protected $fillable = [
        'user_id',
        'block_user_id'
    ];
}
