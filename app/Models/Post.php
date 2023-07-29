<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = [
        'name', 'slug', 'body', 'excerpt', 'published', 'published_at', 'category_id', 'post_id'
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($documentation) {
            $documentation->docValues()->get()->each->delete();
        });
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function post() {
        return $this->belongsTo('App\Models\Post');
    }

    public function posts() {
        return $this->hasMany('App\Models\Post');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function docValues() {
        return $this->hasMany('App\Models\DocValue');
    }

    public function categoryHasParent() {
        $category = $this->belongsTo('App\Models\Category');
        if ($category) {
            return true;
        }else {
            return false;
        }
    }
}
