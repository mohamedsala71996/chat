<?php

namespace App\Http\Controllers;

use App\Events\GroupChatSent;
use App\Http\Requests\StoreGroupRequest;
use App\Models\Group;
use App\Models\GroupChat;
use Illuminate\Http\Request;

class GroupController extends Controller
{

    public function index($id){

        $group = Group::where('id', $id)->first();
        $messages = GroupChat::with('user')->where('group_id', $group->id)->get();
        return view('group-chat', compact('messages','group'));
    }
    
  public  function store(Request $request)
  {
      Group::create([
        'name' => auth()->user()->name,
        'admin_id' => auth()->user()->id,
      ]);  
      return redirect()->back();
  }

  public function messageStore(Request $request)
  {
    $group = Group::where('id', $request->group_id)->first();
      $message = GroupChat::create([
          'group_id' => $request->group_id,
          'sender_id' => auth()->user()->id,
          'message' => $request->message,
      ]);

      broadcast(new GroupChatSent($message->user,$group, $request->message))->toOthers();

      return response()->json('Message sent successfully');
  }



}
