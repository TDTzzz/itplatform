<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Topic;
use Auth;
use App\Question;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;

class QuestionController extends Controller
{

    public function index()
    {
        $questions=Question::published()->latest('updated_at')->with('user')->paginate(10);//published是Question类里的scope方法
        return view('question.index',compact('questions'));
    }
    public function create()
    {
        return view('question.create');
    }

    public function store(Request $request)
    {
        $topics=$this->normalizeTopic($request->get('topics'));
        //验证
        $rules=[
            'title'=>'required',
            'topics'=>'required',
            'body'=>'required'
        ];
        $message=[
            'title.required'=>'标题不能为空',
            'topics.required'=>'话题不能为空',
            'body.required'=>'内容不能为空'
        ];
        $this->validate($request,$rules,$message);
        $data=[
            'title'=>$request->get('title'),
            'body'=>$request->get('body'),
            'user_id'=>Auth::id(),
        ];
        $question=Question::create($data);
        $question->topics()->attach($topics);
        return redirect()->route('question.show',[$question->id]);
    }

    public function normalizeTopic(array $topics)
    {
        return collect($topics)->map(function ($topic){
            //判断是否是数字，已存在的topic会已id形式记录。未存在的是name，要是name是数字就无奈了
            if (is_numeric($topic)){
                Topic::find($topic)->increment('questions_count');
                return (int)$topic;
            }
            $newTopic=Topic::create(['name'=>$topic,'questions_count'=>1]);
            return $newTopic->id;
        })->toArray();
    }

    public function update(Request $request,$id)
    {
        //验证
        $rules=[
            'title'=>'required',
            'body'=>'required'
        ];
        $message=[
            'title.required'=>'标题不能为空',
            'body.required'=>'内容不能为空'
        ];
        $this->validate($request,$rules,$message);

        $question=Question::find($id);
        $question->update([
            'title'=>$request->get('title'),
            'body'=>$request->get('body'),
        ]);
        $topics=$this->normalizeTopic($request->get('topics'));

        $question->topics()->sync($topics);
        return redirect()->route('question.show',[$question->id]);

    }

    public function edit($id)
    {
        $question=Question::find($id);
        if(Auth::user()->owns($question)){
            return view('question.edit',compact('question'));
        }
        return back();
    }

    public function show($id)
    {
        $question=Question::where('id',$id)->first();

        return view('question.show',compact('question'));
    }

    public function destroy($id)
    {
        $question=Question::find($id);
        if (Auth::user()->owns($question)){
            $question->delete();
            flash('删除成功');
            return redirect('/');
        }
        abort('403','Forbidden');
    }

    public function select(Request $request)
    {

        $questions=Question::with('user')->where('title','like','%'.$request->get('question').'%')->get();
//        $questions=Question::with('user')->first();
        return view('question.select',compact('questions'));
    }

    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        // 初始化返回数据，默认是失败的
        $data = [
            'success'   => false,
            'msg'       => '上传失败!',
            'file_path' => ''
        ];
        // 判断是否有上传文件，并赋值给 $file
        if ($file = $request->upload_file) {
            // 保存图片到本地
            $result = $uploader->save($request->upload_file, 'question', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
    }
}
