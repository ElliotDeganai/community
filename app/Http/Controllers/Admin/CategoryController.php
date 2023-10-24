<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\DocOption;
use App\Models\Documentation;
use App\Models\DocValue;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (true ) {
            $categories=Category::where('type', 'custom')->with('user')
                                ->with('documentations')
                                ->with('category')
                                ->withCount('posts')
                                ->paginate(10);
        }else {
            //$categories=Auth::user()->categories()->where('category.type', 'custom')->with('user')->with('documentations')->with('category')->withCount('posts')->paginate(5);

            $categories=Category::where('type', 'custom')->with('user')
                                ->with('documentations')
                                ->with('category')
                                ->withCount('posts')
                                ->paginate(10);
        }
        return Inertia::render('Admin/Category/Index', ['getcategories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->cant('create', Category::class)) {
            return redirect()->route('categories.index')->with('status', "You cannot create categories !");
        }
        return Inertia::render('Admin/Category/Create', [
            'getiteration' => Documentation::all()->count()+1000,
            //'getiterationoption' => DocOption::all()->count()+1000,
            'getcategories' => Category::where('type', 'custom')->with('posts')->get()
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
        if (Auth::user()->cant('create', Category::class)) {
            return redirect()->route('categories.index')->with('status', "You cannot create categories !");
        }
        return Inertia::render('Admin/Category/Create', [
            'getiteration' => Documentation::all()->count()+1000,
            'getcategories' => Category::where('id', $text_category->id)->get(),
            'gettype' => $type
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        if (Auth::user()->cant('create', Category::class)) {
            return redirect()->route('categories.index')->with('status', "You cannot create categories !");
        }
        //dd($request);
        $category = new Category($request->only(['name', 'description', 'is_product']));
        $request->category_id !== null ? $category->category_id = $request->category_id['id'] : null;
        Auth::user()->categories()->save($category);

        foreach($request->documentations as $documentation){
            $doc = new Documentation([
                'name' => $documentation['name'],
                'description' => $documentation['description'],
                'type' => $documentation['type'],
                'user_id' => Auth::user()->id
            ]);
            //dd($doc);
            $category->documentations()->save($doc);
            if ($doc->type === 'list') {
                foreach($documentation['doc_options'] as $doc_option){
                    $option = new DocOption([
                        'name' => $doc_option['option'],
                        'documentation_id' => $doc->id,
                    ]);
                    $doc->docOptions()->save($option);
                }
            }
        }

        return redirect()->route('categories.index')->with('status', 'The category has been created !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return Inertia::render('Admin/Category/Show', [
            'getcategory' => Category::where('id', $category->id)->with('categories')->with('documentations')->with('category')->with('posts')->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if (Auth::user()->cant('update', $category)) {
            return redirect()->route('categories.index');
        }
        //dd(Category::where('id', $category->id)->with('categories')->with('documentations')->first());
        //dd(Category::where('id', $category->id)->with('documentations')->first());
        return Inertia::render('Admin/Category/Edit', [
            'getcategory' => Category::where('id', $category->id)->with('categories')->with('documentations')->with('category')->first(),
            'getiteration' => Documentation::all()->count()+1000,
            //'getiterationoption' => DocOption::all()->count()+1000,
            'getcategories' => Category::where('id', '<>' , $category->id)->where('type', 'custom')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryRequest $request, Category $category)
    {
        //dd($request['documentations']);
        if (Auth::user()->cant('update', $category)) {
            return redirect()->route('categories.index');
        }
        $category->fill($request->only(['name', 'description', 'is_product']));
        $request->category_id !== null ? $category->category_id = $request->category_id['id'] : null;
        $category->save();

        foreach($request->documentations as $documentation){
            $doc = Documentation::find($documentation['id']);
            //dd(Documentation::find(3));
            if ($doc !== null) {
                $doc->fill(['name' => $documentation['name'], 'description' => $documentation['description']]);
                $doc->save();
                if ($doc->type === 'list') {
                    //dd($documentation['doc_options']);
                    foreach($documentation['doc_options'] as $doc_option){
                        $option = DocOption::find($doc_option['id']);
                        if ($option !== null) {
                            $option->fill(['option' => $doc_option['option']]);
                            $option->save();
                            $doc->docOptions()->save($option);
                        }else {
                            $option = new DocOption([
                                'option' => $doc_option['option'],
                                'documentation_id' => $doc->id,
                            ]);
                            $option->save();
                            $doc->docOptions()->save($option);
                        }
                    }
                }
            } else {
                $doc = new Documentation([
                    'name' => $documentation['name'],
                    'description' => $documentation['description'],
                    'type' => $documentation['type'],
                    'user_id' => Auth::user()->id
                ]);
                if ($doc->type === 'list') {
                    //dd($documentation['doc_options']);
                    foreach($documentation['doc_options'] as $doc_option){
                        $option = DocOption::find($doc_option['id']);
                        if ($option !== null) {
                            $option->fill(['option' => $doc_option['option']]);
                            $option->save();
                            $doc->docOptions()->save($option);
                        }else {
                            $option = new DocOption([
                                'option' => $doc_option['option'],
                                'documentation_id' => $doc->id,
                            ]);
                            $option->save();
                            $doc->docOptions()->save($option);
                        }
                    }
                }
                $category->documentations()->save($doc);
            }
        }
        $category->save();
        return redirect()->route('categories.index')->with('status', "The category $category->name has been updated !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (Auth::user()->cant('delete', $category)) {
            return redirect()->route('categories.index')->with('status', "You cannot delete other author categories !");
        }
        $posts = $category->posts;
        //dd($posts);
        $categories = $category->categories;
        //dd($categories);

        foreach ($posts as $post) {
            $deleted = $post->delete();
        }

        foreach ($categories as $category) {
            $category->category_id = null;
            $posts = $category->posts();
            foreach ($posts as $post) {
                $post->post_id = null;
            }
        }

        $deleted = $category->delete();
        //$deleted = Post::where('category_id', $category->id)->delete();
        return redirect()->route('categories.index')->with('status', "The category has been deleted !");
    }
}
