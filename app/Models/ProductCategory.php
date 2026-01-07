<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSnowflakeId;

class ProductCategory extends Model
{
    use HasSnowflakeId;

    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    protected function product()
    {
        return $this->hasMany(Product::class);
    }
}
