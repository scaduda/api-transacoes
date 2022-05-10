<?php

namespace App\Models;

use App\Enums\TypeUserEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property TypeUserEnum $type
 * @property string $register
 * @property string $email
 * @property string $password
 * @property float $balance
 * @property string $fantasy_name

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
