<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Programme extends Model implements HasMedia
{
    use InteractsWithMedia;

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
        'allowPreRegistration',
        'allowWalkInRegistration',
        'allowGroupRegistration',
        'groupRegistrationMin',
        'groupRegistrationMax',
        'groupRegIndividualFee',
        'allowBreakoutSession',
        'isHybridMode',
        'hybridPlatformDetails',
        'soft_delete',
        'status',
    ];

    public function getLocationAttribute()
    {
        $fullLocation = ($this->address ? $this->address.', ': '') . ($this->city ? $this->city.', ': '') . ($this->postalCode ? $this->postalCode.', ': '');
        return $fullLocation ? $fullLocation : 'TBA';
    }

    public function getProgrammeDatesAttribute()
    {
        if (!empty($this->customDate)) {
            return $this->customDate;
        }

        $startDate = \Carbon\Carbon::parse($this->startDate);
        $formattedStartDate = $startDate->format('M j');
        
        if ($this->endDate) {
            $endDate = \Carbon\Carbon::parse($this->endDate);
            
            if ($startDate->year === $endDate->year && $startDate->month !== $endDate->month && $startDate->day !== $endDate->day) {
                return $formattedStartDate . ' - ' . $endDate->format('j, Y');
            }
            if ($startDate->year === $endDate->year && $startDate->month === $endDate->month && $startDate->day === $endDate->day) {
                return $startDate->format('M j, Y');
            }
            return $formattedStartDate . ', ' . $startDate->format('Y') . ' - ' . $endDate->format('M j, Y');
        }
        
        return $startDate->format('M j, Y');
    }

    public function getProgrammeTimesAttribute()
    {
        $time = '';
        $time = \Carbon\Carbon::parse($this->startTime)->format('g:i A');
        $time .= $this->endTime ? '-' : '';
        $time .= $this->endTime ? \Carbon\Carbon::parse($this->endTime)->format('g:i A') : '';
        return $time;
    }

    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('soft_delete', false);
        });
    }

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function breakouts()
    {
        return $this->hasMany(Breakout::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registrant::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_programme', 'programme_id', 'category_id');
    }

    public function speakers()
    {
        return $this->belongsToMany(Speaker::class, 'speaker_programme', 'programme_id', 'speaker_id')->withPivot('type', 'details');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function promocodes()
    {
        return $this->hasMany(Promocode::class);
    }

    public function getActivePromotionAttribute()
    {
        $now = now();
        return $this->promotions()
            ->where('startDate', '<=', $now)
            ->where('endDate', '>=', $now)
            ->where('isActive', true)
            ->first();
    }

    public function getFormattedPriceAttribute()
    {
        if ($this->price <= 0) {
            return 'FREE';
        }
        return '$'.number_format($this->price, 2);
    }

    public function getDiscountedPriceAttribute()
    {
        $activePromo = $this->active_promotion; // coming from getActivePromotionAttribute()
        
        if (!$activePromo)
            return null;

        return '$'.number_format($activePromo->price, 2);
    }

    public function getTotalRegistrationsAttribute()
    {
        return $this->registrations()->count();
    }
}
