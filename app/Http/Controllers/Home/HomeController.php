<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Page;
use App\Models\PageField;
use App\Models\PageSection;
use App\Models\Post;
use App\Repositories\Home\PageRepository;
use App\Repositories\Home\PostRepository;
use App\Repositories\Home\CategoryRepository;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    private $homeRepository;
    public function __construct(PageRepository $pageRepository, PostRepository  $postRepository, CategoryRepository $categoryRepository)
    {
        //$this->middleware('auth');
        $this->pageRepository = $pageRepository;
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function default(){
        $posts = $this->postRepository->getAllPosts();
        $categories = $this->categoryRepository->getAllCategoriesWithPosts();
        return Inertia::render('Home/Default', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function welcome(){
        return Inertia::render('Home/Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    }

    public function index(){
        //dd('test');
        $homePage = Page::where('url', '/')->get();
        $posts = $this->postRepository->getAllPosts();
        //dd(count($posts));
        $categories = Category::with('categories')->with('documentations')->with('posts.docValues')->with('category')->get();
        if (count($posts) > 0) {
            if (count($homePage) > 0) {
                $homePage[0]->load('pageSections')
                    ->load('pageSections.pageFields', 'medias',
                    'pageSections.category',
                    'pageSections.category.documentations',
                    'pageSections.pageFields.documentation',
                    'pageSections.category.posts.user',
            );
                    return Inertia::render('Home/Client/'.$homePage[0]->template, [
                        'getpage' => $homePage[0],
                        'getcategories' => $categories
                    ]);
            }else {
                return Inertia::render('Home/Default', [
                    'canLogin' => Route::has('login'),
                    'canRegister' => Route::has('register'),
                    'laravelVersion' => Application::VERSION,
                    'phpVersion' => PHP_VERSION,
                    'getposts' => $posts,
                    //'getintent' => Auth::user()->createSetupIntent(),
                    'getcategories' => $categories,
                ]);
            }
        }else{
            //dd('test');
            return Inertia::render('Home/Home', [
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
                'laravelVersion' => Application::VERSION,
                'phpVersion' => PHP_VERSION,
                'getposts' => $posts,
                //'getintent' => Auth::user()->createSetupIntent(),
                'getcategories' => $categories,
            ]);
        }
/*         $page = $this->pageRepository->getPageByTitle('Home');
        $category_product = $page->pageSections[0]->category;

        if (!isset($category_product)) {
            return Inertia::render('Home/Default');
        }
        //dd($category_product);
        $products = $this->postRepository->getPostByCategoryId($category_product->id);
        $category_videos = $page->pageSections[1]->category;

        if (!isset($category_videos)) {
            return Inertia::render('Home/Default');
        }
        //dd($category_videos);
        $videos = $this->postRepository->getPostByCategoryId($category_videos->id);

        return Inertia::render('Home/Home', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            //'getproducts' => $products,
            //'getvideos' =>  $videos,
            'getcategories' => Category::where('type', '=', 'custom')->get(),
            //'getpage' => $page
        ]); */
    }

    public function shop(){
        $page = $this->pageRepository->getPageByTitle('Shop');
        //dd($page);

        $category_product = $page->pageSections[0]->category;
        //dd($category_product);

        if (!isset($category_product)) {
            abort(404);
        }
        $products = $this->postRepository->getPostByCategoryId($category_product->id);
        //dd($products);

        return Inertia::render('Home/Shop', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'getproducts' => $products,
            'getcategories' => Category::where('type', '=', 'custom')->get(),
            'getpage' => $page
        ]);
    }

    public function product(int $productId){
        $page = $this->pageRepository->getPageByTitle('Product');
        //dd($page);

        //$category_product = $page->pageSections[0]->category;
        //dd($category_product);

/*         if (!isset($category_product)) {
            abort(404);
        } */
        $product = $this->postRepository->getPostById($productId);

        return Inertia::render('Home/Product/Show', [
            'canLogin' => Route::has('login'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'getproduct' => $product,
            'getcategories' => Category::where('type', '=', 'custom')->get(),
            'getpage' => $page
        ]);
    }

    public function post(int $postId){
        $post = $this->postRepository->getPostById($postId);
        $category = Category::find($post->category_id);
        $section_fields = [];

        $new_section = new PageSection([
            'category_id' => $category->id,
            'page_id' => 0,
            'name' => $category->name,
            'description' => '',
            'user_id' => 0
        ]);
        //dd($post->docValues);

        foreach($post->docValues as $field){
            $new_field = new PageField([
                'documentation_id' => $field['documentation']['id'],
                'page_section_id' => 0,
                'name' => $field['documentation']['name'],
                'user_id' => 0
            ]);
            array_push($section_fields, $new_field);
        }
        return Inertia::render('Home/Client/Show/Item', [
            'getpost' => $post,
            'getprojetsection' => $new_section,
            'getfields' => $section_fields
        ]);
    }

    public function news(){
        $page = $this->pageRepository->getPageByTitle('News');

        $category_news = $page->pageSections[0]->category;

        if (!isset($category_news)) {
            abort(404);
        }
        $news = $this->postRepository->getPostByCategoryId($category_news->id);
        return Inertia::render('Home/News', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'getnews' => $news,
            'getcategories' => Category::where('type', '=', 'custom')->get(),
            'getpage' => $page
        ]);
    }

    public function free(){
        $page = $this->pageRepository->getPageByTitle('Free Downloads');
        //dd($page);

        $category_free = $page->pageSections[0]->category;
        //dd($category_free);

        if (!isset($category_free)) {
            abort(404);
        }
        $free_download = $this->postRepository->getPostByCategoryId($category_free->id);
        //dd($free_download);
        return Inertia::render('Home/Free', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'getfree' => $free_download,
            'getcategories' => Category::where('type', '=', 'custom')->get(),
            'getpage' => $page
        ]);
    }

    public function about(){
        $page = $this->pageRepository->getPageByTitle('About');

        $category_about = $page->pageSections[0]->category;

        if (!isset($category_about)) {
            abort(404);
        }
        $about = $this->postRepository->getPostByCategoryId($category_about->id);
        //dd($about);
        return Inertia::render('Home/About', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'getabout' => $about,
            'getcategories' => Category::where('type', '=', 'custom')->get(),
            'getpage' => $page
        ]);
    }

    public function faq(){
        $page = $this->pageRepository->getPageByTitle('FAQ');

        $category_faq = $page->pageSections[0]->category;

        if (!isset($category_faq)) {
            abort(404);
        }
        $faqs = $this->postRepository->getPostByCategoryId($category_faq->id);
        //dd($page);
        return Inertia::render('Home/Faq', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
            'getfaqs' => $faqs,
            'getcategories' => Category::where('type', '=', 'custom')->get(),
            'getpage' => $page
        ]);
    }
}
