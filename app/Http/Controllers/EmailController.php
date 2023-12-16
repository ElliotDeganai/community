<?php

namespace App\Http\Controllers;
use App\Mail\TestTemplate;
use App\Mail\TestEmail2;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function test(){
        $user = User::find(3);
        Mail::to($user)->send(new TestEmail2($user));
        return redirect()->route('resume')->with('status', "Chèr(e) $user->name, tes réponses ont bien été enregistrées !");

    }
}
