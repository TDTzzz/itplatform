<?php

namespace App\Http\Controllers;

use Auth;
use App\Notifications\NewMessageNotification;
use App\Message;
use Illuminate\Http\Request;

class InboxController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $id=Auth::user()->id;
        $messages=Message::where('from_user_id',$id)->orWhere('to_user_id',$id)
            ->with(['fromUser'=>function($query){
                return $query->select(['id','name','avatar']);
            },'toUser'=>function($query){
                return $query->select(['id','name','avatar']);
            }])->get();
        return view('inbox.index',['messages'=>$messages->groupBy('dialog_id')]);
    }

    public function show($dialogId)
    {
        $messages = Message::where('dialog_id',$dialogId)->with(['fromUser' => function ($query) {
            return $query->select(['id','name','avatar']);
         },'toUser' => function ($query) {
            return $query->select(['id','name','avatar']);
         }])->latest()->get();
        $messages->markAsRead();
        return view('inbox.show',compact('messages','dialogId'));
    }
    public function store($dialogId)
    {
        $message = Message::where('dialog_id',$dialogId)->first();
        $toUserId = $message->from_user_id === Auth::user()->id ? $message->to_user_id : $message->from_user_id;
        $newMessage=Message::create([
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $toUserId,
            'body' => request('body'),
            'dialog_id' => $dialogId
        ]);
        $newMessage->toUser->notify(new NewMessageNotification($newMessage));

        return back();
    }

}
