<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Page;
use App\Models\Post;
use App\Notifications\TestNotification;
use App\Repositories\Home\PageRepository;
use App\Repositories\Home\PostRepository;
use App\Repositories\Home\CategoryRepository;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PusherController extends Controller
{
    public function index()
    {

        $conversation = Conversation::find(1);
        //dd($conversation->users);
        $messages = Message::where('conversation_id', $conversation->id)->with('user')->orderBy('created_at')->get();
        //$messages->load('user');
        return Inertia::render('Home/Client/Broadcast/Index', [
            'getmessages' => $messages,
            'getconversation' => $conversation
        ]);
    }


    /**
     * process transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function broadcast(Request $request)
    {
        //broadcast(new PusherBroadcast($request->content))->toOthers();

/*         return Inertia::render('Home/Client/Broadcast/Broadcast', [
            'getmessage' => $request->message
        ]); */
        $message = new Message($request->only(['content', 'conversation_id']));
        //$post->post_id = $request->post_id['id'];
        Auth::user()->messages()->save($message);

        $conversation = Conversation::find(1);
        $toNotify = $conversation->users;

        foreach($toNotify as $user){
            if (Auth::user()->id !== $user->id) {
                $user->notify(new TestNotification($message));
            }
        }

        return redirect()->route('pusher')->with('new message');
    }


    public function receive(Request $request)
    {
        return Inertia::render('Home/Client/Broadcast/Receive', [
            'getmessage' => $request->message
        ]);
    }
}
