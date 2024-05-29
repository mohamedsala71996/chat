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
        $messages=Message::with(['send','receive'])->where('sender',auth()->user()->id)->where('receiver',$user_id)->orWhere('sender',$user_id)->where('receiver',auth()->user()->id)->get();
        return view('chat',compact('receiver','messages'));
    }
    public function store(Request $request){
        $data=Message::create([
            'sender'=>auth()->user()->id,
           'receiver'=>$request->receiver_id,
           'message'=>$request->message,
        ]);
        $receiver=User::find($request->receiver_id);
        \broadcast(new ChatSent($receiver,$request->message));
        return response()->json([
            'message' => $request->message,
            'name' => auth()->user()->name,
            'status' => 'success'
        ]);    }

    
}
