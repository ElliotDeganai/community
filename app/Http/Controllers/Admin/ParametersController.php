<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Parameters;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Helpers\Helpers;

class ParametersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $param)
    {
        return Inertia::render('Admin/Parameter/Show', [
            'getpost' => Parameters::where('id', $param)->with('medias')
            ->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $param)
    {
        return Inertia::render('Admin/Parameter/Edit', [
            'getpost' => Parameters::where('id', $param)->with('medias')
            ->first()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->files['logo_dark']);
        //dd($request->file('logo_light'));
        $post = Parameters::where('id', $id)
            ->first();
        $post->fill($request->only(['site_name', 'email', 'phone', 'mobile', 'address', 'city', 'postal_code', 'country',
        'logo', 'logo_footer', 'favicon', 'facebook', 'instagram', 'linkedin', 'youtube', 'tiktok',
        'footer_text', 'google_maps_embed', 'meta_description', 'meta_keywords', 'maintenance_mode']));
        $post->save();
        if($request->file('logo_light')){
            Helpers::addMediaToModel($request->file('logo_light')[0], 'logo_light', $post);
        }
        if($request->file('logo_dark')){
            Helpers::addMediaToModel($request->file('logo_dark')[0], 'logo_dark', $post);
        }
        if($request->file('logo_footer')){
            Helpers::addMediaToModel($request->file('logo_footer')[0], 'logo_footer', $post);
        }
        return redirect()->route('parameters.show', $post->id)->with('status', "The site information have been updated !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
