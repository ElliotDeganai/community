<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocOption extends Model
{
    use HasFactory;
    protected $fillable = [
        'option', 'documentation_id'
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($doc_option) {
            $doc_option->docValues()->get()->each->delete();
        });
        static::created(function($documentation) {
            $posts = Post::where('category_id', $documentation->category_id)->get();
            //dd($documentation->docOptions);
            foreach($posts as $post){
                $doc = new DocValue([
                    'documentation_id' => $documentation->id,
                    'post_id' => $post->id,
                    'value_text' => null,
                    'value_number' => null,
                    'value_html' => null,
                    'value_date' => null,
                    'value_date_time' => null,
                    'value_list' => null,
                    'value_gallery' => null,
                    'value_image' => null,
                    'value_carousel' => null,
                    'user_id' => $documentation->user_id
                ]);
                $post->docValues()->save($doc);
            }
        });
    }

    public function documentation() {
        return $this->belongsTo('App\Models\Documentation');
    }

    public function docValues() {
        return $this->belongsTo('App\Models\DocValue');
    }
}
