<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Cashier\Billable;
use function Illuminate\Events\queueable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    /**
    * The "booted" method of the model.
    *
    * @return void
    */
   protected static function booted()
   {
       static::updated(queueable(function ($customer) {
           if ($customer->hasStripeId()) {
               $customer->syncStripeCustomerDetails();
           }
       }));
   }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'city',
        'address',
        'zip_code',
        'password',
        'is_partying',
        'has_company',
        'has_answered',
        'is_accompanied',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function pages() {
        return $this->hasMany('App\Models\Page');
    }

    public function pageFields() {
        return $this->hasMany('App\Models\PageField');
    }

    public function pageSections() {
        return $this->hasMany('App\Models\PageSection');
    }

    public function categories() {
        return $this->hasMany('App\Models\Category');
    }

    public function posts() {
        return $this->hasMany('App\Models\Post');
    }

    public function orders() {
        return $this->hasMany('App\Models\Order');
    }

    public function isAdminOrEditor() {
        return $this->hasAnyRole(['admin', 'editor']) !== null ? true : false;
    }

    public function roles() {
        return $this->belongsToMany('App\Models\Role');
    }

    public function hasAnyRole($roles) {
        return $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role) {
        return $this->roles()->where('name', $role)->first();
    }

    public function isAdmin() {
        return $this->hasAnyRole(['admin']) !== null ? true : false;
    }

    public function isDev() {
        return $this->hasAnyRole(['dev']) !== null ? true : false;
    }

    public function isEditor() {
        return $this->hasAnyRole(['editor']) !== null ? true : false;
    }

    public function isClient() {
        return $this->hasAnyRole(['client']) !== null ? true : false;
    }
}
