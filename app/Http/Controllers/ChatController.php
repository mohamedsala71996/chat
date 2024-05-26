<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    
    public function index($user_id){
        $receiver=User::find($user_id);
        return view('chat',compact('receiver'));
    }
    public function store(Request $request){
        $data=Message::create([
            'sender'=>auth()->user()->id,
           'receiver'=>$request->receiver_id,
           'message'=>$request->message,
        ]);
        $receiver=User::find($request->receiver_id);
        \broadcast(new ChatSent($receiver,$request->message));
        return response()->json('Message sent successfully');
    }

    
}
