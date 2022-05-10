<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $payer_id
 * @property string $payee_id
 * @property float $value
 */

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transactions';
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
