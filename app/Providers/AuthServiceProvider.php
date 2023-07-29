<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Page' => 'App\Policies\PagePolicy',
        'App\Models\Post' => 'App\Policies\PostPolicy',
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\User' => 'App\Policies\ManageUsersPolicy',
        'App\Models\Documentation' => 'App\Policies\DocumentationPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
