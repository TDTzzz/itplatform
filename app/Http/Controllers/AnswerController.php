<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Auth;

class AnswerController extends Controller
{
    public function store(Request $request,$question)
    {
        $rules=[
            'body'=>'required'
        ];
        $messages=[
            'body.required'=>'回答不能为空'
        ];
        $this->validate($request,$rules,$messages);
        $answer=Answer::create([
           'user_id'=>Auth::id(),
           'question_id'=>$question,
           'body'=>$request->get('body')
        ]);
        $answer->question()->increment('answers_count');
        flash('评论成功');
        return back();
    }
}
