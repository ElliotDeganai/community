<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'url', 'url_name', 'template', 'description', 'published', 'published_at'
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
}
