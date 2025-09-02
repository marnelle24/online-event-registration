<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breakout extends Model
{
    protected $fillable = [
        'programme_id',
        'programCode',
        'title',
        'description',
        'startDate',
        'endDate',
        'price',
        'location',
        'speaker_id',
        'order',
        'isActive',
        'createdBy',
    ];

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }
}
