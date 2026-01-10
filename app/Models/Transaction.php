<?php

namespace App\Models;

use App\Traits\HasSnowflakeId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\TransactionStatus;

class Transaction extends Model
{
    use HasSnowflakeId, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'transactions';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'identifier',
        'user_id',
        'partner_id',
        'type',
        'note',
        'status'
    ];

    protected $casts = [
        'status' => TransactionStatus::class,
        'user_id' => 'string',
        'partner_id' => 'string'
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
