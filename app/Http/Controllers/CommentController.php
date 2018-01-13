<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\Question;
use App\Answer;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function answer($id)
    {
        $comments=Answer::with('comments','comments.user')->where('id',$id)->first();

        return $comments->comments;

    }
    public function question($id)
    {
        $comments=Question::with('comments','comments.user')->where('id',$id)->first();

        return $comments->comments;
    }

    public function post($id)
    {
        $comments=Post::with('comments','comments.user')->where('id',$id)->first();

        return $comments->comments;
    }

    public function store()
    {
        $model=$this->getModelNameFromType(request('type'));
        $comment=Comment::create([
            'commentable_id'=>request('model'),
            'commentable_type'=>$model,
            'user_id'=>\Auth::guard('api')->user()->id,
            'body'=>request('body')
        ]);
        return $comment;
    }

    public function getModelNameFromType($type)
    {
        return $type==='question'?'App\Question':'App\Answer';
    }


}
