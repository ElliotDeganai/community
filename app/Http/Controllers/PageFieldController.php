<?php

namespace App\Http\Controllers;

use App\Models\PageField;
use App\Models\PageSection;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PageFieldController extends Controller
{
    public function destroy(PageField $page_field)
    {
/*         if (Auth::user()->cant('delete', $page)) {
            return redirect()->route('admin')->with('status', "You cannot delete page fields !");
        } */

        //dd($section);
        $page_section = PageSection::find($page_field->page_section_id);
        //dd($page_section);
        if (Auth::user()->isDev() || Auth::user()->isAdmin()) {
            $page_field->delete();
            return redirect()->route('pages.edit', $page_section->page_id)->with('status', "The field has been deleted !");
        }
        else {
            return redirect()->route('admin')->with('status', "You cannot delete sections !");
        }
    }
}
