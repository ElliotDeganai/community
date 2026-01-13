<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PageSection;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;

class PageSectionController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PageSection  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageSection $page_section)
    {

        //dd($section);
        $page = Page::find($page_section->page);
        //dd($page_section);
        if (Auth::user()->isDev() || Auth::user()->isAdmin()) {
            $page_section->delete();
            return redirect()->route('pages.edit', $page_section->page_id)->with('status', "The section has been deleted !");
        }
        else {
            return redirect()->route('admin')->with('status', "You cannot delete sections !");
        }
    }
}
