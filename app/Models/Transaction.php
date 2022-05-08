<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transacoes';
    protected $visible = [
        'id',
        'type',
        'payer_id',
        'payee_id',
        'value',
        'comment',
        'created_at',
    ];
    protected $fillable = [
        'type',
        'payer_id',
        'payee_id',
        'value',
        'comment',
    ];
}
