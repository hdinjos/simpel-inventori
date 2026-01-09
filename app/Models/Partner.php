<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSnowflakeId;
use Illuminate\Database\Eloquent\SoftDeletes;


class Partner extends Model
{
    use HasSnowflakeId, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'partners';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'phone',
        'address',
        'active',
        'partner_type_id'
    ];

    protected $casts = [
        'partner_type_id' => 'string'
    ];

    protected $hidden = [
        'deleted_at'
    ];

    /**
     * Get the type associated with the partner.
     */
    public function partnerType()
    {
        return $this->belongsTo(PartnerType::class);
    }
}
