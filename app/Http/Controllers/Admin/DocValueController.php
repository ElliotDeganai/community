<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocValue;
use Illuminate\Http\Request;

class DocValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\DocValue  $docValue
     * @return \Illuminate\Http\Response
     */
    public function show(DocValue $docValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocValue  $docValue
     * @return \Illuminate\Http\Response
     */
    public function edit(DocValue $docValue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocValue  $docValue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocValue $docValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocValue  $docValue
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocValue $docValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocValue  $docValue
     * @return \Illuminate\Http\Response
     */
    public function removeImage(DocValue $docValue)
    {
        if ($docValue->value_image == 1) {
            $docValue->clearMediaCollection('image');
        }
        if ($docValue->value_gallery == 1) {
            $docValue->clearMediaCollection('gallery');
        }
        if ($docValue->value_carousel == 1) {
            $docValue->clearMediaCollection('carousel');
        }
    }
}
