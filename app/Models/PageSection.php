<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'user_id', 'page_id', 'category_id'
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($pageSection) {
            $pageSection->pageFields()->get()->each->delete();
        });
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }


    public function page()
    {
        return $this->belongsTo(Page::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function pageFields()
    {
        return $this->hasMany(PageField::class);
    }
}
