<?php

namespace App\Repositories\Home;

use App\Comment;
use App\Helpers\Helpers;

use App\Models\Post;
use Carbon\Carbon;

class PostRepository {

    //private $user;
    private $post;

    public function __construct(Post $post){
        $this->post = $post;
    }

    public function getPostByCategoryId(int $category_id){
        return $this->post->where('category_id', $category_id)->with('user')
        ->with('docValues')
        ->with('category')
        ->with('docValues.medias')
        ->with('docValues.documentation')
        ->paginate(5);
    }

    public function getPostById(int $postId){
        return $this->post->where('id', $postId)->with('user')
        ->with('docValues')
        ->with('category')
        ->with('docValues.medias')
        ->with('docValues.documentation')
        ->first();
    }

    public function getAllPosts(){
        return $this->post->with('user')
        ->with('docValues')
        ->with('category')
        ->with('docValues.medias')
        ->with('docValues.documentation')
        ->get();
    }

}
