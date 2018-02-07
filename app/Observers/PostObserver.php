<?php

namespace App\Observers;

use App\Post;

class PostObserver
{

    /**
     * 监听文章删除事件。
     *
     * @param  Post $post
     * @return void
     */
    public function deleted(Post $post)
    {
        //删除该文章的评论
        \DB::table('comments')->where(array('commentable_type'=>'App\Post','commentable_id'=>$post->id))->delete();
        //再删除该问题的topic
        \DB::table('post_topic')->where('post_id',$post->id)->delete();
        //再删除该问题的关注
        \DB::table('user_post')->where('post_id',$post->id)->delete();
    }
}
