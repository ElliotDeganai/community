<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'name', 'description', 'user_id'
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($documentation) {
            $documentation->docValues()->get()->each->delete();
        });
        static::created(function($documentation) {
            $posts = Post::where('category_id', $documentation->category_id)->get();
            //dd($documentation->docOptions);
            $value_image = null;
            $value_gallery = null;
            $value_carousel = null;
            $value_audio = null;
            foreach($posts as $post){
                $doc = new DocValue([
                    'documentation_id' => $documentation->id,
                    'post_id' => $post->id,
                    'value_text' => null,
                    'value_price' => null,
                    'value_number' => null,
                    'value_html' => null,
                    'value_date' => null,
                    'value_date_time' => null,
                    'value_list' => null,
                    'value_gallery' => null,
                    'value_image' => null,
                    'value_carousel' => null,
                    'value_audio' => null,
                    'user_id' => $documentation->user_id
                ]);
                $post->docValues()->save($doc);
            }
        });
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

    public function docValues() {
        return $this->hasMany('App\Models\DocValue');
    }

    public function docOptions() {
        return $this->hasMany('App\Models\DocOption');
    }
}
