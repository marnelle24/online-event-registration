<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Programme extends Model
{
    protected $casts = [
        'settings' => 'array',
        'extraFields' => 'array'
    ]; 

    protected $fillable = [
        'ministry_id',
        'type',
        'programmeCode',
        'title',
        'startDate',
        'endDate',
        'startTime',
        'endTime',
        'activeUntil',
        'customDate',
        'address',
        'city',
        'state',
        'postalCode',
        'country',
        'latLong',
        'price',
        'adminFee',
        'thumb',
        'a3_poster',
        'excerpt',
        'description',
        'contactNumber',
        'contactPerson',
        'contactEmail',
        'chequeCode',
        'limit',
        'settings',
        'extraFields',
        'searchable',
        'publishable',
        'private_only',
        'externalUrl',
        'soft_delete',
        'status',
        'created_at',
        'updated_at',
    ];

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('soft_delete', false);
            $builder->where('status', 'published');
            $builder->where('publishable', true);
            $builder->where('searchable', true);
            $builder->where('private_only', false);
        });
    }

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_programme', 'programme_id', 'category_id');
    }
}
