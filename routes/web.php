<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DocumentationController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PagesController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Admin\OptionController;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Stripe\StripeController;

use App\Http\Controllers\PayPalController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', function () {
    return Inertia::render('Home/Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
}); */

 //Auth::routes();
$categories = Category::all();

foreach ($categories as $category) {
    Route::get('/'.$category->name.'/{postId}', [HomeController::class, 'post'])->name('item_'.$category->name);
}

$pages = Page::all()->load('pageSections')
            ->load('pageSections.pageFields',
            'pageSections.category',
            'pageSections.category.documentations',
            'pageSections.pageFields.documentation'
            );

foreach ($pages as $page) {
    $page->load('pageSections.category.posts.docValues');
    Route::get($page->url, function() use ($page) {
        return Inertia::render('Home/Client/'.$page->template, [
            'getpage' => $page,

        ]);
    })->name($page->url_name);
}


Route::get('/admin', function() {
    return Inertia::render('Admin/Admin', [
        'getposts' => Post::whereHas('category', function ($query) {
                                return $query->where('type', '=', 'custom');
                            })
                            ->with('user')
                            ->with('category')
                            ->orderBy('updated_at', 'DESC')
                            ->paginate(4),
        'getcategories' => Category::where('type', 'custom')
                            ->with('user')
                            ->with('category')
                            ->orderBy('updated_at', 'DESC')
                            ->paginate(3)
    ]);
})->middleware('admin')->name('admin');

Route::resource('/admin/pages', PagesController::class, ['except' => ['pages.show']]);
Route::resource('/admin/users', UsersController::class);
Route::resource('/admin/posts', BlogController::class);
Route::get('/admin/posts/create/{type}', [BlogController::class, 'create_type'])->name('posts.create_type');
Route::get('/admin/posts/index/{type}', [BlogController::class, 'index_type'])->name('posts.index_type');
Route::resource('/admin/categories', CategoryController::class);
Route::get('/admin/categories/create/{type}', [CategoryController::class, 'create_type'])->name('categories.create_type');
Route::resource('/admin/documentations', DocumentationController::class);
Route::resource('/admin/options', OptionController::class);
Route::resource('/admin/medias', MediaController::class);

 Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/default', [HomeController::class, 'default'])->name('default');
// Route::get('/welcome', [HomeController::class, 'welcome'])->name('welcome');


/* Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/product/{productId}', [HomeController::class, 'product'])->name('product');
Route::get('/news', [HomeController::class, 'news'])->name('news');
Route::get('/free', [HomeController::class, 'free'])->name('free');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq'); */
//

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

if (env('IS_ECOMMERCE') == 1) {
    Route::get('/checkout', [StripeController::class, 'stripe'])->name('checkout');
    Route::post('/payment', [StripeController::class, 'stripePost'])->name('stripe.post');

    Route::get('payment', ['PayPalController::class', 'payment'])->name('payment');
    Route::get('cancel', ['PayPalController::class', 'cancel'])->name('payment.cancel');
    Route::get('payment/success', ['PayPalController', 'success'])->name('payment.success');

}



require __DIR__.'/auth.php';
