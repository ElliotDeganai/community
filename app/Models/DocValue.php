<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class DocValue extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $fillable = [
        'value_text',
        'value_price',
        'value_number',
        'value_html',
        'value_date',
        'value_date_time',
        'value_list',
        'value_link',
        'value_option',
        'value_gallery',
        'value_carousel',
        'value_image',
        'value_audio',
        'documentation_id', 'user_id', 'post_id', 'option_id',
        'images',
        'audio',
        'gallery',
        'carousel'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'images' => AsStringable::class,
        'audio' => AsStringable::class,
        'gallery' => AsStringable::class,
        'carousel' => AsStringable::class,
    ];

    protected $appends = ['current_value'];

    public function value() {
        if ($this->value_text !== null) {
            return $this->value_text;
        } else if($this->value_price !== null) {
            return $this->value_price;
        } else if($this->value_number !== null) {
            return $this->value_number;
        } else if($this->value_html !== null) {
            return $this->value_html;
        } else if($this->value_date !== null) {
            return $this->value_date;
        } else if($this->value_date_time !== null) {
            return $this->value_date_time;
        } else if($this->value_image !== null) {
            return $this->value_image;
        } else if($this->value_gallery !== null) {
            return $this->value_gallery;
        } else if($this->value_carousel !== null) {
            return $this->value_carousel;
        } else if($this->value_audio !== null) {
            return $this->value_audio;
        }

    }

    public function getCurrentValueAttribute()
    {
        if ($this->value_text !== null) {
            return $this->value_text;
        } else if($this->value_price !== null) {
            return $this->value_price;
        } else if($this->value_number !== null) {
            return $this->value_number;
        } else if($this->value_html !== null) {
            return $this->value_html;
        } else if($this->value_date !== null) {
            return $this->value_date;
        } else if($this->value_date_time !== null) {
            return $this->value_date_time;
        } else if($this->value_image !== null) {
            return $this->value_image;
        } else if($this->value_gallery !== null) {
            return $this->value_gallery;
        } else if($this->value_carousel !== null) {
            return $this->value_carousel;
        } else if($this->value_audio !== null) {
            return $this->value_audio;
        }
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function documentation() {
        return $this->belongsTo('App\Models\Documentation');
    }

    public function option() {
        return $this->belongsTo('App\Models\DocOption');
    }
/*
    public function type() {
        return $this->with('documentation')->first()->documentation->type;
    } */

    public function post() {
        return $this->belongsTo('App\Models\Post');
    }

    public function medias() {
        return $this->hasMany('App\Models\Media');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('image')
        ->singleFile();
        $this->addMediaCollection('audio')
        ->singleFile();
        $this->addMediaCollection('gallery');
        $this->addMediaCollection('carousel');
    }
}
