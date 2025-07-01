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
        'isActive',
        'arrangement',
        'counter',
        'createdBy',
    ];

    protected $cast = [
        'startDate' => 'datetime',
        'endDate' => 'datetime',
        'counter' => 'integer',
        'isActive' => 'boolean',
    ];

    // protected static function booted()
    // {
    //     static::addGlobalScope('active', function (Builder $builder) {
    //         $builder->where('isActive', true);
    //     });
    // }
    
    public function programme()
    {
        return $this->belongsTo(Programme::class, 'programme_id');
    }
}
