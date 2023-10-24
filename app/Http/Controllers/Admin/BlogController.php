<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkWithPost;
use App\Models\Category;
use App\Models\DocValue;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Mockery\Undefined;
use App\Repositories\Home\CategoryRepository;

class BlogController extends Controller
{
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->middleware('admin');
        $this->categoryRepository = $categoryRepository;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (true) {
            $posts=Post::whereHas('category', function ($query) {
                            return $query->where('type', '=', 'custom');
                        })->with('user')
                        ->with('docValues')
                        ->with('category')
                        ->with('docValues.medias')
                        ->with('docValues.documentation')
                        ->paginate(10);
        }else {
            $posts=Auth::user()->posts()->whereHas('category', function ($query) {
                return $query->where('type', '=', 'custom');
            })
                        ->with('user')
                        ->with('docValues')
                        ->with('category')
                        ->with('docValues.documentation')
                        ->withCount('docValues.medias')
                        ->paginate(10);
        }
        return Inertia::render('Admin/Post/Index', ['getposts' => $posts]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_type($type='custom')
    {
        $text_category = Category::where('name', $type)->first();
        if (Auth::user()->isAdminOrEditor()) {
            $posts=Post::where('posts.category_id', $text_category->id)->with('user')
            ->with('docValues')
            ->with('category')
            ->with('docValues.medias')
            ->with('docValues.documentation')
            ->paginate(10);
        }else {
            $posts=Auth::user()
            ->posts()->with('user')
            ->where('posts.category_id', $text_category->id)->with('docValues')
            ->with('docValues.documentation')
            ->with('posts.category')
            ->withCount('docValues.medias')
            ->paginate(10);
        }
        return Inertia::render('Admin/Post/Index', [
            'getcategory' => $text_category,
            'getposts' => $posts,
            'gettype' => $type
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->cant('create', Post::class)) {
            return redirect()->route('posts.index')->with('status', "You cannot create posts !");
        }
        return Inertia::render('Admin/Post/Create', [
            'getcategories' => Category::where('type', 'custom')
            ->with('documentations')
            ->with('posts')
            ->with('category')
            ->with('categories')
            ->with('categories.posts')
            ->with('category.posts')
            ->with('category.categories')
            ->with('category.categories.posts')
            ->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_type($type='custom')
    {
        $text_category = Category::where('name', $type)->first();
        if (Auth::user()->cant('create', Post::class)) {
            return redirect()->route('posts.index')->with('status', "You cannot create posts !");
        }
        return Inertia::render('Admin/Post/Create', [
            'getcategories' => Category::where('id', $text_category->id)->with('documentations')->with('posts')->with('category')->with('category.posts')->get(),
            'gettype' => $type
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkWithPost $request)
    {
        //dd($request);
        if (Auth::user()->cant('create', Post::class)) {
            return redirect()->route('posts.index')->with('status', "You cannot create posts !");
        }
        $pic = null;
        //dd($request->doc_values);
        $post = new Post($request->only(['name', 'slug', 'body', 'excerpt', 'published', 'published_at', 'post_id']));
        $post->category_id = $request->category_id['id'];
        $request->post_id !== null ? $post->post_id = $request->post_id['id'] : null;
        //$post->post_id = $request->post_id['id'];
        Auth::user()->posts()->save($post);

        foreach($request->doc_values as $doc_value){
            $doc = new DocValue([
                'documentation_id' => $doc_value['documentation_id'],
                'post_id' => $post->id,
                'value_text' => $doc_value['value_text'],
                'value_number' => $doc_value['value_number'],
                'value_price' => $doc_value['value_price'],
                'value_html' => $doc_value['value_html'],
                'value_date' => $doc_value['value_date'],
                'value_date_time' => $doc_value['value_date_time'],
                'value_list' => $doc_value['value_list'],
                'value_link' => $doc_value['value_link'],
                'user_id' => Auth::user()->id
            ]);
            //dd($doc);
            if (isset($doc_value['option_id'])) {
                $doc->option_id = $doc_value['option_id'];
                $doc->save();
            }
            $post->docValues()->save($doc);
            if($doc_value['value_image'] == 1 ){
                    Helpers::addMediaToModel($doc_value['images'][0], 'image', $doc);
                    $doc->value_image = true;
            }
            if($doc_value['value_gallery'] == 1){
                for ($i=0; $i < count($doc_value['gallery']); $i++) {
                    Helpers::addMediaToModel($doc_value['gallery'][$i], 'gallery', $doc);
                }
                $doc->value_gallery = true;
            }
            if($doc_value['value_carousel'] == 1){
                for ($i=0; $i < count($doc_value['carousel']); $i++) {
                    Helpers::addMediaToModel($doc_value['carousel'][$i], 'carousel', $doc);
                }
                $doc->value_carousel = true;
            }
            if(isset($doc_value['value_audio']) && $doc_value['value_audio'] == 1 ){
                    Helpers::addMediaToModel($doc_value['audio'][0], 'audio', $doc);
                    $doc->value_audio = true;
            }
            $doc->save();
        }
        return redirect()->route('posts.index')->with('status', 'The post has been created !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return Inertia::render('Admin/Post/Show', [
            'getpost' => Post::where('id', $post->id)
            ->with('post')
            ->with('docValues.documentation')
            ->with('docValues')
            ->with('category')
            ->with('posts')
            ->with('docValues.medias')
            ->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //dd($post->docValues()->load('docValues.documentation')->get());
        if (Auth::user()->cant('update', $post)) {
            return redirect()->route('posts.index');
        }
        $parentCat = null;
        if ($post->categoryHasParent()) {
            $category = $post->category;
            $parentCat = $this->categoryRepository->getCategoryWithPosts($category->category_id);
        }
        /* dd($post->load('user')
        ->load('docValues')
        ->load('docValues.medias')
        ->load('category')
        ->load('category.documentations')); */
        //dd($parentCat);
        return Inertia::render('Admin/Post/Edit', [
            'getpost' => $post->load('user')
                                ->load('docValues')
                                ->load('docValues.medias')
                                ->load('category')
                                ->load('post')
                                ->load('category.documentations'),
                                //->load('category.documentations.docOptions'),
            'getcategories' => Category::where('type', 'custom')->with('documentations')->get(),
            'getParentCategory' => $parentCat
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(WorkWithPost $request, Post $post)
    {
        //dd($request);
        if (Auth::user()->cant('update', $post)) {
            return redirect()->route('posts.index');
        }
        $post->fill($request->only(['name', 'slug', 'body', 'excerpt', 'published', 'published_at']));
        $request->post_id !== null ? $post->post_id = $request->post_id['id'] : null;
        //$post->post_id = $request->post_id['id'];
        $post->save();

        if (count($post->docValues) === 0) {

            foreach($request->doc_values as $doc_value){
                $doc = new DocValue([
                    'documentation_id' => $doc_value['documentation_id'],
                    'post_id' => $post->id,
                    'value_text' => $doc_value['value_text'],
                    'value_number' => $doc_value['value_number'],
                    'value_price' => $doc_value['value_price'],
                    'value_html' => $doc_value['value_html'],
                    'value_date' => $doc_value['value_date'],
                    'value_date_time' => $doc_value['value_date_time'],
                    'value_list' => $doc_value['value_list'],
                    'value_link' => $doc_value['value_link'],
                    'user_id' => Auth::user()->id
                ]);
                $post->docValues()->save($doc);
                if($doc_value['value_image'] == 1 ){
                        Helpers::addMediaToModel($doc_value['images'][0], 'image', $doc);
                        $doc->value_image = true;
                        $post->docValues()->save($doc);
                }
                if($doc_value['value_gallery'] == 1){
                    for ($i=0; $i < count($doc_value['gallery']); $i++) {
                        Helpers::addMediaToModel($doc_value['gallery'][$i], 'gallery', $doc);
                    }
                    $doc->value_gallery = true;
                    $post->docValues()->save($doc);
                }
                if($doc_value['value_carousel'] == 1){
                    for ($i=0; $i < count($doc_value['carousel']); $i++) {
                        Helpers::addMediaToModel($doc_value['carousel'][$i], 'carousel', $doc);
                    }
                    $doc->value_carousel = true;
                    $post->docValues()->save($doc);
                }
                if(isset($doc_value['value_audio']) && $doc_value['value_audio'] == 1 ){
                        Helpers::addMediaToModel($doc_value['audio'][0], 'audio', $doc);
                        $doc->value_audio = true;
                        $post->docValues()->save($doc);
                }
            }
        }else {
            foreach($request->doc_values as $doc_value){
                //dd(isset($doc_value['images']));
                $doc = DocValue::find($doc_value['id']);
                $doc->value_text = $doc_value['value_text'];
                $doc->value_html = $doc_value['value_html'];
                $doc->value_number = $doc_value['value_number'];
                $doc->value_price = $doc_value['value_price'];
                $doc->value_date = $doc_value['value_date'];
                $doc->value_date_time = $doc_value['value_date_time'];
                $doc->value_list = $doc_value['value_list'];
                $doc->value_link = $doc_value['value_link'];
                $post->docValues()->save($doc);
                if($doc_value['value_image'] == 1 && isset($doc_value['images'])){
                        Helpers::addMediaToModel($doc_value['images'][0], 'image', $doc);
                        $doc->value_image = true;
                        $post->docValues()->save($doc);
                }
                if($doc_value['value_gallery'] == 1 && isset($doc_value['gallery'])){
                    for ($i=0; $i < count($doc_value['gallery']); $i++) {
                        Helpers::addMediaToModel($doc_value['gallery'][$i], 'gallery', $doc);
                    }
                    $doc->value_gallery = true;
                    $post->docValues()->save($doc);
                }
                if($doc_value['value_carousel'] == 1 && isset($doc_value['carousel'])){
                    for ($i=0; $i < count($doc_value['carousel']); $i++) {
                        Helpers::addMediaToModel($doc_value['carousel'][$i], 'carousel', $doc);
                    }
                    $doc->value_carousel = true;
                    $post->docValues()->save($doc);
                }
                if($doc_value['value_audio'] == 1 && isset($doc_value['audio'])){
                        Helpers::addMediaToModel($doc_value['audio'][0], 'audio', $doc);
                        $doc->value_audio = true;
                        $post->docValues()->save($doc);
                }
            }
        }
        return redirect()->route('posts.index')->with('status', "The post $post->title has been updated !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (Auth::user()->cant('delete', $post)) {
            return redirect()->route('posts.index')->with('status', "You cannot delete other author posts !");
        }

        $posts = $post->posts;

        foreach ($posts as $post) {
            $post->post_id = null;
        }

        $post->delete();
        //$deleted = DocValue::where('post_id', $post->id)->delete();
        return redirect()->route('posts.index')->with('status', "The post has been deleted !");
    }
}
