<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Parameters extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'site_name', 'email', 'phone', 'mobile', 'address', 'city', 'postal_code', 'country',
        'logo', 'logo_footer', 'favicon', 'facebook', 'instagram', 'linkedin', 'youtube', 'tiktok',
        'footer_text', 'google_maps_embed', 'meta_description', 'meta_keywords', 'maintenance_mode',
    ];

    // Helper pour récupérer le logo complet
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }

    public function medias() {
        return $this->hasMany('App\Models\Media');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo_light')
        ->singleFile();
        $this->addMediaCollection('logo_dark')
        ->singleFile();
        $this->addMediaCollection('logo_footer')
        ->singleFile();
        $this->addMediaCollection('carousel');
    }
}
