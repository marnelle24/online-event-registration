<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Promotion extends Model
{
    protected $fillable = [
        'programme_id',
        'programCode',
        'title',
        'description',
        'startDate',
        'endDate',
        'price',
        'isGroup',
        'minGroup',
        'maxGroup',
        'isActive',
        'arrangement',
        'counter',
        'createdBy',
    ];

    protected $casts = [
        'startDate' => 'datetime',
        'endDate' => 'datetime',
        'counter' => 'integer',
        'minGroup' => 'integer',
        'maxGroup' => 'integer',
        'arrangement' => 'integer',
        'isActive' => 'boolean',
        'isGroup' => 'boolean',
    ];

    public function programme()
    {
        return $this->belongsTo(Programme::class, 'programme_id');
    }
}
