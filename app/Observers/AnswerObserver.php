<?php

namespace App\Observers;

use App\Answer;

class AnswerObserver
{

    /**
     * 监听文章删除事件。
     *
     * @param  Answer $answer
     * @return void
     */
    public function deleted(Answer $answer)
    {
        //删除该回答下的评论
        \DB::table('comments')->where(array('commentable_type'=>'App\Answer','commentable_id'=>$answer->id))->delete();
        //删除该回答的点赞
        \DB::table('votes')->where('answer_id',$answer->id)->delete();
    }
}
