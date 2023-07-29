<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageField extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'description', 'user_id', 'page_section_id', 'documentation_id'
    ];

    public static function boot() {
        parent::boot();

/*         static::deleting(function($pageField) {
            $pageField->pageFieldValues()->get()->each->delete();
        }); */
/*         static::created(function($pageField) {
            $pages = Page::where('page_id', $pageField->page_id)->get();
            //dd($documentation);
            foreach($pages as $page){
                $field = new DocValue([
                    'documentation_id' => $pageField->id,
                    'post_id' => $page->id,
                    'value_text' => null,
                    'value_number' => null,
                    'value_html' => null,
                    'value_date' => null,
                    'value_date_time' => null,
                    'value_list' => null,
                    'value_gallery' => null,
                    'value_image' => null,
                    'value_carousel' => null,
                    'user_id' => $pageField->user_id
                ]);
                $page->pageFieldValues()->save($field);
                //dd($doc);
            }
        }); */
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function page() {
        return $this->belongsTo('App\Models\Page');
    }

    public function documentation() {
        return $this->belongsTo('App\Models\Documentation');
    }

/*     public function pageFieldValues() {
        return $this->hasMany('App\Models\PageFieldValue');
    } */
}
