<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSnowflakeId;

class ProductStock extends Model
{
    use HasSnowflakeId;

    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_stocks';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'quantity',
        'product_id'
    ];

    protected $casts = [
        'product_id' => 'string'
    ];

    protected function product()
    {
        return $this->belongsTo(Product::class);
    }
}
