<?php

namespace App\Observers;

use App\Question;

class QuestionObserver
{

    /**
     * 监听用户删除事件。
     *
     * @param  Question  $question
     * @return void
     */
    public function deleted(Question $question)
    {
        //删除问题时连带着该问题的回答 以及评论等
        //先删除问题下的回答里的评论
        foreach ($question->answers as $v){
            \DB::table('comments')->where(array('commentable_type'=>'App\Answer','commentable_id'=>$v->id))->delete();
        }
        //再删除该问题下的回答
        \DB::table('answers')->where('question_id',$question->id)->delete();
        //再删除该问题的评论
        \DB::table('comments')->where(array('commentable_type'=>'App\Question','commentable_id'=>$question->id))->delete();
        //再删除该问题的topic
        \DB::table('question_topic')->where('question_id',$question->id)->delete();
        //再删除该问题的关注
        \DB::table('user_question')->where('question_id',$question->id)->delete();
    }
}
