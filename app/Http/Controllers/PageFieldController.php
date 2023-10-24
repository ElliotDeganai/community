<?php

namespace App\Http\Controllers;

use App\Models\PageField;
use Illuminate\Http\Request;

class PageFieldController extends Controller
{
    public function destroy(PageField $field)
    {
/*         if (Auth::user()->cant('delete', $page)) {
            return redirect()->route('admin')->with('status', "You cannot delete page fields !");
        } */
        $field->delete();
        return redirect()->back()->with('status', "The page field has been deleted !");
    }
}
