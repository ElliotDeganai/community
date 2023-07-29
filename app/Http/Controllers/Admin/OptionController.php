<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocOption;
use App\Models\Documentation;
use Illuminate\Http\Request;

class OptionController extends Controller
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
     * @param  \App\Models\DocOption  $docOption
     * @return \Illuminate\Http\Response
     */
    public function show(DocOption $docOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocOption  $docOption
     * @return \Illuminate\Http\Response
     */
    public function edit(DocOption $docOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocOption  $docOption
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocOption $docOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocOption  $docOption
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $docOptionId)
    {
        $docOption = DocOption::find($docOptionId);
        //dd(Documentation::find($docOption->documentation_id));
        $documentation = Documentation::find($docOption->documentation_id);
        $docOption->delete();
        return redirect()->route('categories.edit', $documentation->category_id)->with('status', "The option has been deleted !");
    }
}
