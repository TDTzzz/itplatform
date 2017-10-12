<?php

namespace App\Http\Controllers;

use App\Answer;
use Auth;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function index($id)
    {
        //判断当前用户是否已经对此答案点赞了
        if (Auth::guard('api')->user()->hasVotedFor($id)){
            return response()->json(['voted'=>true]);
        }
        return response()->json(['voted'=>false]);
    }

    public function vote()
    {
        $answer=Answer::find(request('answer'));
        $vote=Auth::guard('api')->user()->voteFor(request('answer'));
        if ($vote['attached']!=[]){
            $answer->increment('votes_count');
            return response()->json(['voted'=>true]);
        }
        $answer->decrement('votes_count');

        return response()->json(['voted'=>false]);

    }
}
