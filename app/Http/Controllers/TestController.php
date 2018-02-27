<?php

namespace App\Http\Controllers;

use App\Test;
use App\testRecord;
use Illuminate\Http\Request;

//答题控制器
class TestController extends Controller
{
    //显示全部类型的测试题
    public function totalShow()
    {
        $data=Test::pluck('test_type')->unique();
        //检查这些类型的
//        foreach ($data as $k=>$v){
//            $arr[$k]=testRecord::where(['test_type'=>$v,'user_id'=>\Auth::user()->id])->first();
//            if ($arr[$k]!=null){
//                $data[$k]['has_test']=1;
//            }else{
//                $data[$k]['has_test']=0;
//            }
//        }
//        dd($data);
        return view('test.index',compact('data'));
    }

    public function show(Request $request)
    {
        $type=$request->type;

        return view('test.show',compact('type'));
    }

    public function getTest(Request $request)
    {

    }

    public function hasTest(Request $request)
    {
        $hasTest=testRecord::where(['test_type'=>$request->type,'user_id'=>$request->user])->count();

        $correct=Test::where('test_type',$request->type)->pluck('correct_choose');

        //对比对错
        if ($hasTest>0){
            $data=testRecord::where(['test_type'=>$request->type,'user_id'=>$request->user])->first();
            $record=$data['choose_record'];
            $grade=$data['grade'];
            return response()->json(['has_test'=>$hasTest,'grade'=>$grade,'correct'=>$correct,'record'=>$record]);
        }else{
            return response()->json(['has_test'=>$hasTest,'correct'=>$correct]);
        }

    }
}
