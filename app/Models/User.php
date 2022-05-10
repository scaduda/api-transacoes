<?php

namespace App\Models;

use App\Enums\TypeUserEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property float $balance
 * @property TypeUserEnum $type
 */

class User extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'users';
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
    ];

    protected $casts = [
        'type' => TypeUserEnum::class
    ];


}
