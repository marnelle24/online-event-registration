<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\MediaLibrary\HasMedia;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;

class Speaker extends Model implements HasMedia
{
    use HasSlug, InteractsWithMedia;

    protected $fillable = [
        'title',
        'name',
        'slug',
        'email',
        'about',
        'socials',
        'is_active',
        'profession',
        'thumbnail'
    ];

    protected $casts = [
        'socials' => 'json',
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function programmes()
    {
        return $this->belongsToMany(Programme::class, 'speaker_programme', 'speaker_id', 'programme_id')
            ->withPivot('type', 'details');
    }


    
}
