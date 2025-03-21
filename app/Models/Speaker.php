<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Speaker extends Model
{
    use HasSlug;

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
        return $this->belongsToMany(Programme::class, 'speaker_programme', 'speaker_id', 'programme_id')->withPivot('type');
    }


    
}
