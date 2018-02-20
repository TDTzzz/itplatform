<?php

namespace App\Http\Controllers;

use App\Topic;
use Illuminate\Http\Request;

class TopicsController extends Controller
{
    public function index(Request $request)
    {
        return Topic::select(['id','name'])
            ->where('name','like','%'.$request->query('q').'%')->get();
    }

    public function select(Request $request)
    {
        $old_topic=$request->get('topic');
        $topics=Topic::select(['id','name'])
            ->where('name','like','%'.$request->get('topic').'%')->get();
        if ($request->get('order')!='post'){
            $i=0;
            $array=[];
            foreach($topics as $k=>$topic){
                foreach ($topic->questions as $k2=>$question){
                    $array[$i++]=$question;
                }
            }
            $array=collect($array);
            $questions=$array->unique('title');
        }
        //文章
        if ($request->get('order')!='question'){
            $j=0;
            $array=[];
            foreach($topics as $k=>$topic){
                foreach ($topic->posts as $k2=>$post){
                    $array[$j++]=$post;
                }
            }
            $array=collect($array);
            $posts=$array->unique('title');
        }
        return view('topic.index',compact('old_topic','topics','questions','posts'));
    }

    public function selectQuestion(Request $request)
    {
        $old_topic=$request->old_topic;
        $topics=Topic::select(['id','name'])
            ->where('name','like','%'.$request->old_topic.'%')->get();

        $questions=collect([]);
        if ($request->order!='post'){
            $i=0;
            $array=[];
            foreach($topics as $k=>$topic){
                foreach ($topic->questions as $k2=>$question){
                    $array[$i++]=$question;
                }
            }
            $array=collect($array);
            $questions=$array->unique('title');
        }
        //文章
        $posts=collect([]);
        if ($request->order!='question'){
            $j=0;
            $array=[];
            foreach($topics as $k=>$topic){
                foreach ($topic->posts as $k2=>$post){
                    $array[$j++]=$post;
                }
            }
            $array=collect($array);
            $posts=$array->unique('title');
        }
        return view('topic.index',compact('old_topic','topics','questions','posts'));
    }

    public function show()
    {
        $topic=Topic::where('name',request('topic'))->first();
        if($topic==null){
            return view('topic.error');
        }else{
            $questions=$topic->questions;
            return view('topic.show',compact('topic','questions'));
        }
//        $topic=Topic::where('name',request('topic'))->first();

    }


}
