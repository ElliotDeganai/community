<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TestEmail2;
use App\Models\Role;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        //dd(Auth::user()->isAdmin());
        if (Auth::check()) {
            if (Auth::user()->isAdmin() || Auth::user()->isDev()) {
                return Inertia::render('Auth/Register', [
                    'getroles' => Role::all()
                ]);
            }else {
                return redirect(RouteServiceProvider::HOME);
            }
        }else {
            return redirect(RouteServiceProvider::HOME);
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'roles' => 'required|array|min:1'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        foreach($request->roles as $role){
            $user->roles()->save(Role::find($role));
        }

        event(new Registered($user));
        Mail::to($user->email)->send(new TestEmail2($user, $request->password));


        //Auth::login($user);

        //return redirect(RouteServiceProvider::HOME);

        return redirect()->route('users.index')->with('status', 'The user has been created !');
    }
}
