<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'usuarios';
    protected $visible = [
        'id',
        'name',
        'fantasy_name',
        'type',
        'register',
        'email',
        'password',
        'balance',
        'created_at',
    ];
    protected $fillable = [
        'name',
        'fantasy_name',
        'type',
        'register',
        'email',
        'password',
        'balance',
        'saldo',
    ];

}
