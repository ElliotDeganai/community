<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = [
        'header_title', 'header_subtitle', 'title', 'url', 'url_name', 'template', 'description', 'published', 'published_at',
        'image'
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($page) {
            //$page->pageFields()->get()->each->delete();
            $page->pageSections()->get()->each->delete();
        });
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function pageSections()
    {
        return $this->hasMany(PageSection::class);
    }

    public function medias() {
        return $this->hasMany('App\Models\Media');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
        ->singleFile();
    }
}
