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
        'user_id',
        'title',
        'message',
        'send',
        'created_at'

    ];
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'send',
    ];

}
