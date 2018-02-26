<?php

namespace App\Http\Controllers;

use App\Test;
use App\testRecord;
use Illuminate\Http\Request;

class TestController extends Controller
{
    //答题控制器
    public function show()
    {
//        Test::create(['title'=>'1','choose_type'=>'1','choose_content'=>'{"A":"选项a","B":"选项B"}','grade'=>'1','test_type'=>'1']);
        $data=Test::where('test_type','php')->get();
        //把choose_content的json数据转换成数组
//        foreach ($data as $k=>$v){
//            $data[$k]['choose_content']=json_decode($v['choose_content'], true);
//        }
//        $data=$data->toArray();
//        $content['test']=$data;
//        foreach ($data as $k=>$v){
//            $fname[$k]='php'.$k;
////            $data['php'.$k]=$v;
//        }
//        $data=array_combine($fname,$data);
//        dd($content);
//        $data[0]=['title'=>'title1','name'=>'name1'];
//        $data[1]=['title'=>'title2','name'=>'name2'];

        return view('test.index');
//        dd(\GuzzleHttp\json_decode($data['choose_content']));
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
