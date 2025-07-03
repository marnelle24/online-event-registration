<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $fillable = [
        'programme_id',
        'programCode',
        'promocode',
        'startDate',
        'endDate',
        'price',
        'maxUses',
        'usedCount',
        'isActive',
        'createdBy',
        'remarks'
    ];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'programme_id');
    }


}
