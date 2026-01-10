<?php

namespace App\Models;

use App\Traits\HasSnowflakeId;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageItem extends Model
{
    use HasSnowflakeId, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'package_items';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'quantity',
        'package_id',
        'product_id',
    ];

    protected $casts = [
        "package_id" => 'string',
        "product_id" => 'string'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function product()
    {
        return  $this->belongsTo(Product::class);
    }
}
