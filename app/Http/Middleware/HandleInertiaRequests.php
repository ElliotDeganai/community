<?php

namespace App\Http\Middleware;

use App\Models\Category;
use App\Models\Page;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        if (Auth::user()) {
            $userId = Auth::user()->id;
        }else{
            $userId = null;
        }
        //Session::put('message', '5%');
        //dd(Session::get('message.status'));
        //dd(session()->all());

        return array_merge(parent::share($request), [
            'app_name' => env('APP_NAME'),
            'is_ecommerce' => env('IS_ECOMMERCE'),
            'calendar' => env('CALENDAR'),
            'calendar_slot_time' => env('CALENDAR_SLOT_TIME'),
            'calendar_slot_time_unit' => env('CALENDAR_SLOT_TIME_UNIT'),
            'test' => 'test',
            'pusher_key' => env('PUSHER_APP_KEY'),
            'pusher_id' => env('PUSHER_APP_ID'),
            'test' => 'test',
            'auth' => [
                'user' => Auth::user() ? User::where('id', $userId)->with('roles', 'user', 'calendar')->first() : null,
                'unReadNotifications' => Auth::user() ? User::where('id', $userId)->first()->unreadNotifications : null,
                'isDev' => Auth::user() ? User::find(Auth::user()->id)->isDev() : null,
                'isAdmin' => Auth::user() ? User::find(Auth::user()->id)->isAdmin() : null,
                'isEditor' => Auth::user() ? User::find(Auth::user()->id)->isEditor() : null,
                'isClient' => Auth::user() ? User::find(Auth::user()->id)->isClient() : null,
                'isCollaborator' => Auth::user() ? User::find(Auth::user()->id)->isCollaborator() : null,
            ],
            'currentPage' => [
                'url' => $request->fullUrl(),
                'path' => $request->path(),
                'route' => $request->route()?->getName(), // nom de la route (ex: 'pages.show')
                'params' => $request->route()?->parameters(), // paramètres de la route (ex: ['slug' => 'contact'])
                'query' => $request->query(), // paramètres GET
                'pageObject' => Page::where('url_name', $request->route()?->getName())->with('medias')->first()
            ],
            'ziggy' => function () {
                return (new Ziggy)->toArray();
            },
            'posts' => Post::all()->load('docValues', 'docValues.documentation'),
            'pages' => Page::all()->load('pageSections')
                        ->load('pageSections.pageFields',
                        'pageSections.category',
                        'medias',
                        'pageSections.category.posts',
                        'pageSections.category.posts.user',
                        'pageSections.category.posts.docValues',
                        'pageSections.category.posts.docValues.medias',
                        'pageSections.category.posts.docValues.documentation',
                        'pageSections.category.documentations',
                        'pageSections.pageFields.documentation'),
/*             'can' => [
                'user' => [
                    'manage_user' => Auth::user() ? Auth::user()->can('manageUsers', User::class) : false,
                ],
                'post' => [
                    'create' => Auth::user() ? Auth::user()->can('create', Post::class) : false,
                    'update' => Auth::user() ? Auth::user()->can('update', Post::class) : false,
                    'delete' => Auth::user() ? Auth::user()->can('delete', Post::class) : false,
                    'managePosts' => Auth::user() ? Auth::user()->can('managePosts', Post::class) : false,
                ],
                'category' => [
                    'create' => Auth::user() ? Auth::user()->can('create', Category::class) : false,
                    'update' => Auth::user() ? Auth::user()->can('update', Category::class) : false,
                    'delete' => Auth::user() ? Auth::user()->can('delete', Category::class) : false,
                ],
                'documentation' => [
                    'create' => Auth::user() ? Auth::user()->can('create', Documentation::class) : false,
                    'update' => Auth::user() ? Auth::user()->can('update', Documentation::class) : false,
                    'delete' => Auth::user() ? Auth::user()->can('delete', Documentation::class) : false,
                ]
            ], */
            'status' => [
                'message' => session('status'),
            ]
        ]);
    }
}
