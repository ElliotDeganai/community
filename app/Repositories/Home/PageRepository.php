<?php

namespace App\Repositories\Home;

use App\Comment;
use App\Helpers\Helpers;

use App\Country;
use App\Forum\Post;
use App\Models\Page;
use Carbon\Carbon;

class PageRepository {

    //private $user;
    private $page;

    public function __construct(Page $page){
        $this->page = $page;
    }

    public function getPageByTitle(string $pageTitle){
        return $this->page->where('title', $pageTitle)
        ->with('pageSections')
        ->with('pageSections.pageFields')
        ->with('pageSections.category')
        ->with('pageSections.category.posts')
        ->with('pageSections.category.posts.docValues')
        ->with('pageSections.category.posts.docValues.medias')
        ->first();
    }

}
