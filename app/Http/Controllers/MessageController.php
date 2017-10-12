<?php

namespace App\Http\Controllers;

use Auth;
use App\Notifications\NewMessageNotification;
use App\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store()
    {
        $message=Message::create([
            'to_user_id'=>request('user'),
            'from_user_id'=>Auth::guard('api')->user()->id,
            'body'=>request('body'),
            'dialog_id'=>(Auth::guard('api')->user()->id+request('user')).(Auth::guard('api')->user()->id*request('user')),

        ]);
        if ($message){
            $message->toUser->notify(new NewMessageNotification($message));
            return response()->json(['status'=>true]);
        }
        return response()->json(['status'=>false]);
    }
}
