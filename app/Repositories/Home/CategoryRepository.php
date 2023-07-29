<?php

namespace App\Repositories\Home;

use App\Comment;
use App\Helpers\Helpers;

use App\Country;
use App\Forum\Post;
use App\Models\Category;
use App\Models\Page;
use Carbon\Carbon;

class CategoryRepository {

    //private $user;
    private $category;

    public function __construct(Category $category){
        $this->category = $category;
    }

    public function getAllCategoriesWithPosts(){
        return $this->category
        ->with('posts')
        ->with('posts.docValues')
        ->with('posts.docValues.documentation')
        ->with('posts.docValues.medias')
        ->get();
    }

    public function getCategoryWithPosts($categoryId){
        return $this->category->where('id', $categoryId)->with('user')
        ->with('posts')
        ->with('posts.docValues')
        ->with('posts.docValues.documentation')
        ->with('posts.docValues.medias')
        ->first();
    }

}
