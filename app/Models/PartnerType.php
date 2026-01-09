<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSnowflakeId;
use Illuminate\Database\Eloquent\SoftDeletes;


class PartnerType extends Model
{
    use HasSnowflakeId, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partner_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    protected $hidden = [
        'deleted_at'
    ];

    /**
     * Get the partner for the blog post.
     */
    public function partner()
    {
        return $this->hasMany(Partner::class);
    }
}
