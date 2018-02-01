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

        $topics=Topic::select(['id','name'])
            ->where('name','like','%'.$request->get('topic').'%')->get();
        $i=0;
        $array=[];
        foreach($topics as $k=>$topic){
            foreach ($topic->questions as $k2=>$question){
                $array[$i++]=$question;
            }
        }
        $array=collect($array);
        $questions=$array->unique('title');
        return view('topic.index',compact('topics','questions'));
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
