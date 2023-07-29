<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'is_product', 'category_id'
    ];

    protected $casts = [
        'is_product' => 'boolean',
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($category) {
            $category->posts()->get()->each->delete();
            $category->documentations()->get()->each->delete();
        });
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function posts() {
        return $this->hasMany('App\Models\Post');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function categories() {
        return $this->hasMany('App\Models\Category');
    }

    public function documentations() {
        return $this->hasMany('App\Models\Documentation');
    }

    public function pages()
    {
        return $this->belongsToMany(Page::class);
    }
}
