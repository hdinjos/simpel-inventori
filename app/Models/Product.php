<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSnowflakeId;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasSnowflakeId, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code',
        'name',
        'description',
        'product_category_id',
        'unit_id',
    ];

    protected $casts = [
        'product_category_id' => 'string',
        'unit_id' => 'string',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    /**
     * Get the type associated with the productCategory.
     */
    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    /**
     * Get the type associated with the unit.
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the type associated with the productStock.
     */
    public function stock()
    {
        return $this->hasOne(ProductStock::class);
    }

    /**
     * Get the type associated with the productStock.
     */
    public function packageItems()
    {
        return $this->hasOne(PackageItem::class);
    }
}
