<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function __construct()
    {
        //$this->middleware('admin');
        //$this->middleware('can:manageUsers,App\Models\User');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
/*         if (Auth::user()->isAdminOrEditor()) {
            $pages=Page::all();
        }else {
            $pages=Auth::user()->pages()->get();
        } */
        $users=User::with('roles')->withCount('posts')->withCount('categories')->paginate(10);
        //dd($users);
        return Inertia::render('Admin/User/Index', ['getusers' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        if (Auth::user()->cant('manageUsers', $user)) {
            return redirect()->route('admin')->with('status', "You cannot edit users !");
        }
        return Inertia::render('Admin/User/Edit', [
            'getuser' => $user->load('roles'),
            'getroles' => Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        dd('start campaign', $request);
        if (Auth::user()->isClient()) {
            //dd($request);
            $user->fill($request->only(['is_partying', 'is_accompanied', 'has_company', 'has_answered', 'flight_taken']));
            $user->save();
            return redirect()->back()->with('status', "Dear $user->name, your answers has been saved !");
        } else {
            //dd($request->roles);
            $user->fill($request->only(['name', 'email', 'city', 'address', 'zip_code', 'is_partying', 'is_accompanied', 'has_company', 'has_answered', 'flight_taken']));
            $user->save();
            for ($i=0; $i < count($request->roles); $i++) {
                //dd($request->roles[$i]);
                $user->roles()->sync($request->roles[$i]);
            }
            //$user->roles()->sync($request->roles);
            return redirect()->route('users.index')->with('status', "$user->name was updated !");
        }
    }
    public function startCampaign(Request $request)
    {
        //dd('start campaign', $request->users);
        for ($i=0; $i < count($request->users); $i++) {
            //dd($request->roles[$i]);
            $user = User::find($request->users[$i]['id']);

            if (isset($request->users[$i]['new_user'])) {
                $user->user_id = $request->users[$i]['new_user'];
                $user->save();
            }
        }
        //$user->roles()->sync($request->roles);
        return redirect()->route('resume')->with('status', "Chèr(e) $user->name, tes réponses ont bien été enregistrées !");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::user()->cant('delete', $user)) {
            return redirect()->route('users.index')->with('status', "You cannot do it !");
        }
        $user->delete();
        return redirect()->route('users.index')->with('status', "The user has been deleted !");
    }
}
