<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Notification extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'notifications';
    protected $visible = [
        'id',
        'email',
        'title',
        'message',
        'send',
        'created_at'

    ];
    protected $fillable = [
        'email',
        'title',
        'message',
        'send',
    ];

}
