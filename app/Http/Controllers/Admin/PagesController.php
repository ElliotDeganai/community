<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WorkWithPage;
use App\Models\Category;
use App\Models\Documentation;
use App\Models\Page;
use App\Models\PageField;
use App\Models\PageSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Helpers\Helpers;

class PagesController extends Controller
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
        if (Auth::user()->cant('viewAny', Page::class)) {
            return redirect()->route('admin')->with('status', "You cannot see pages !");
        }
        $pages=Page::with('user')
        ->with('categories')->paginate(10);
        return Inertia::render('Admin/Page/Index', ['getpages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->cant('create', Page::class)) {
            return redirect()->route('admin')->with('status', "You cannot create pages !");
        }
        $categories=Category::where('type', 'custom')
        ->with('documentations')
        ->get();
        return Inertia::render('Admin/Page/Create', [
            'getcategories' => $categories,
            'getiteration' => PageField::all()->count()+1000,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkWithPage $request)
    {
        if (Auth::user()->cant('create', Page::class)) {
            return redirect()->route('admin')->with('status', "You cannot create pages !");
        }
        $page = new Page($request->only(['header_title', 'header_subtitle', 'title', 'url', 'url_name', 'template', 'description', 'published', 'published_at']));
        //$post->post_id = $request->post_id['id'];
        Auth::user()->pages()->save($page);
        if(count($request->images) > 0){
                Helpers::addMediaToModel($request->images[0], 'image', $page);
                //$page->value_image = true;
        }

        if(count($request->page_sections) > 0){
            foreach($request->page_sections as $section){
                $new_section = new PageSection([
                    'category_id' => $section['new_category']['id'],
                    'page_id' => $page->id,
                    'name' => $section['name'],
                    'description' => $section['description'],
                    'user_id' => Auth::user()->id
                ]);
                $new_section->save();

                foreach($section['page_fields'] as $field){
                    $new_field = new PageField([
                        'documentation_id' => $field['new_documentation']['id'],
                        'page_section_id' => $new_section->id,
                        'name' => $field['name'],
                        'user_id' => Auth::user()->id
                    ]);
                    $new_field->save();
                }
        }
        }
        //
        //dd($request);
        //Auth::user()->pages()->save(new Page($request->only(['title', 'url', 'content', 'published', 'published_at'])));
        return redirect()->route('pages.index')->with('status', 'The page has been created !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        //(Auth::user()->can('update', $page));
        if (Auth::user()->cant('update', $page)) {
            return redirect()->route('admin')->with('status', "You cannot edit pages !");
        }
        $categories=Category::where('type', 'custom')
        ->with('documentations')
        ->get();
        return Inertia::render('Admin/Page/Edit', [
            'getpage' => $page->load('pageSections')
                        ->load('pageSections.pageFields', 'pageSections.category', 'pageSections.category.documentations', 'pageSections.pageFields.documentation')
                        ->load('medias'),
            'getcategories' => $categories,
            'getiteration' => PageField::all()->count()+1000,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(WorkWithPage $request, Page $page)
    {
        //(Auth::user()->can('update', $page));
        //dd(count($request->page_sections) > 0);
        if (Auth::user()->cant('update', $page)) {
            return redirect()->route('admin')->with('status', "You cannot update pages !");
        }
        $page->fill($request->only(['header_title', 'header_subtitle', 'title', 'url', 'url_name', 'template', 'description', 'published', 'published_at']));
        $page->save();
        if(count($request->images) > 0){
                Helpers::addMediaToModel($request->images[0], 'image', $page);
                //$page->value_image = true;
        }
        if(is_array($request->page_sections) && count($request->page_sections) > 0){
            foreach($request->page_sections as $section){
                $page_section = PageSection::find($section['id']);
                if ($page_section !== null) {
                    $page_section->fill([
                        'category_id' => $section['new_category']['id'],
                        'page_id' => $page->id,
                        'name' => $section['name'],
                        'description' => $section['description'],
                        'user_id' => Auth::user()->id
                    ]);
                    $page_section->save();


                    foreach($section['page_fields'] as $field){
                        $page_field = PageField::find($field['id']);
                        if ($page_field !== null) {
                            $page_field->fill([
                                'documentation_id' => $field['new_documentation']['id'],
                                'page_section_id' => $page_section->id,
                                'name' => $field['name'],
                                'user_id' => Auth::user()->id
                            ]);
                            $page_field->save();
                        }else {
                            $page_field = new PageField([
                                'documentation_id' => $field['new_documentation']['id'],
                                'page_section_id' => $page_section->id,
                                'name' => $field['name'],
                                'user_id' => Auth::user()->id
                            ]);
                            $page_field->save();
                        }
                    }
                }else {
                    $page_section = new PageSection([
                        'category_id' => $section['new_category']['id'],
                        'page_id' => $page->id,
                        'name' => $section['name'],
                        'description' => $section['description'],
                        'user_id' => Auth::user()->id
                    ]);
                    $page_section->save();


                    foreach($section['page_fields'] as $field){
                        $page_field = PageField::find($field['id']);
                        if ($page_field !== null) {
                            $page_field->fill([
                                'documentation_id' => $field['new_documentation']['id'],
                                'page_section_id' => $page_section->id,
                                'name' => $field['name'],
                                'user_id' => Auth::user()->id
                            ]);
                            $page_field->save();
                        }else {
                            $page_field = new PageField([
                                'documentation_id' => $field['new_documentation']['id'],
                                'page_section_id' => $page_section->id,
                                'name' => $field['name'],
                                'user_id' => Auth::user()->id
                            ]);
                            $page_field->save();
                        }
                    }
                }
            }
        }
        return redirect()->route('pages.index')->with('status', "The page $page->title has been updated !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if (Auth::user()->cant('delete', $page)) {
            return redirect()->route('admin')->with('status', "You cannot delete pages !");
        }
        $page->delete();
        return redirect()->route('pages.index')->with('status', "The page has been deleted !");
    }
}
