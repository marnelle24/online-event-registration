<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    use HasSlug;

    protected $table = 'ministries';
    
    protected $fillable = [
        'name',          
        'slug',          
        'bio',           
        'contactPerson', 
        'contactNumber', 
        'contactEmail',  
        'websiteUrl',    
        'publishabled',  
        'searcheable',   
        'approvedBy',    
        'status',        
        'createdBy',
        'approvedBy',
        'created_at',
        'updated_at',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    public function programmes()
    {
        return $this->hasMany(Programme::class);
    }
}
