<?php

namespace App\Models;

use App\Traits\HasSnowflakeId;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\StockOpnameStatus;

class StockOpname extends Model
{
    use HasSnowflakeId, SoftDeletes, Searchable;

    public $incrementing = false;
    protected $keyType = 'int';


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'stock_opname';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'status',
        'note'
    ];

    protected $casts = [
        'status' => StockOpnameStatus::class,
        'user_id' => 'string'
    ];

    protected $hidden = [
        'deleted_at'
    ];
}
