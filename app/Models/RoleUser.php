<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
{
    use HasFactory;
    protected $table = 'role_user';
    protected $fillable = [
        'compId',
        'role_id',
        'user_id'
    ];
}
