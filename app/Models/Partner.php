<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasSnowflakeId;

class Partner extends Model
{
    use HasSnowflakeId;

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
        'active'
    ];

    /**
     * Get the type associated with the partner.
     */
    public function partnerType()
    {
        return $this->belongsTo(PartnerType::class);
    }
}
