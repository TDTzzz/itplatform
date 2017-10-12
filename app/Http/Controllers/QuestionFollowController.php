<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuestionFollowController extends Controller
{
    public function follower(Request $request)
    {
        return Auth::guard('api')->user();
        if (Auth::guard('api')->followed($request->get('question'))){
            return response()->json(['followed'=>true]);
        }else{
            return response()->json(['followed'=>false]);
        }
    }

    public function followThisQuestion(Request $request)
    {

        $question=Question::find($request->get('question'));
        return $question;
        $followed=Auth::user()->followThis($question->id);

        if(count($followed['detached'])>0){//detached是啥
            $question->decrement('followers_count');
            return response()->json(['followed'=>false]);
        }
        $question->increment('followers_count');

        return response()->json(['followed'=>true]);
    }
}
