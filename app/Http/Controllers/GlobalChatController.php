<?php

namespace App\Http\Controllers;

use App\Events\GlobalChatSent;
use App\Models\GlobalChat;
use Illuminate\Http\Request;

class GlobalChatController extends Controller
{
    
    public function index()
    {
        $messages = GlobalChat::with('user')->get();
        return view('global-chat', compact('messages'));
    }

    public function store(Request $request)
    {
        $message = GlobalChat::create([
            'sender' => auth()->user()->id,
            'message' => $request->message,
        ]);

        broadcast(new GlobalChatSent($message->user, $request->message))->toOthers();

        return response()->json('Message sent successfully');
    }

}
