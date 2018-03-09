<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Post;
use App\postComment;
use Auth;
use Illuminate\Http\Request;
use Chenhua\MarkdownEditor\MarkdownEditor;
use App\Handlers\ImageUploadHandler;

class PostController extends Controller
{
    public function index()
    {
        $posts=Post::published()->latest('updated_at')->with('user')->paginate(10);//published是Question类里的scope方法

        return view('post.index',compact('posts'));
    }

    public function create()
    {
        return view('post.create');
    }

    public function show($id)
    {
        $post=Post::where('id',$id)->first();
        $post['body']=MarkdownEditor::parse($post['body']);
//        dd($post->comments);

        return view('post.show',compact('post'));
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
        $post=Post::create($data);
        $post->topics()->attach($topics);
        return redirect()->route('post.show',[$post->id]);
    }
    public function normalizeTopic(array $topics)
    {
        //先判断获得来的非数字topic是否有对应的id
        foreach ($topics as $k=>$v){
            if (!is_numeric($v)){
                //不是数字，则查找表里是否有该topic对应的id
                $topic_id=Topic::where('name',$v)->value('id');
                if (!empty($topic_id)){
                    //如果id不为空，则该topic已存在，转化成id保存
                    $topics[$k]=$topic_id;
                }
            }
        }
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

//    public function comment()
//    {
//        $model='App\Post';
//        $comment=Comment::create([
//            'commentable_id'=>request('model'),
//            'commentable_type'=>$model,
//            'user_id'=>Auth::user()->id,
//            'body'=>request('body')
//        ]);
//        flash('评论成功');
//        return back();
//    }
    public function comment()
    {
        postComment::create([
            'user_id'=>Auth::user()->id,
            'post_id'=>request('post_id'),
            'body'=>request('body')
        ]);
        flash('评论成功');
        return back();
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
            $result = $uploader->save($request->upload_file, 'post', \Auth::id(), 1024);
            // 图片保存成功的话
            if ($result) {
                $data['file_path'] = $result['path'];
                $data['msg']       = "上传成功!";
                $data['success']   = true;
            }
        }
        return $data;
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

        $post=Post::find($id);
        $post->update([
            'title'=>$request->get('title'),
            'body'=>$request->get('body'),
        ]);
        $topics=$this->normalizeTopic($request->get('topics'));

        $post->topics()->sync($topics);
        return redirect()->route('post.show',[$post->id]);

    }

    public function edit($id)
    {
        $post=Post::find($id);
        if(Auth::user()->owns($post)){
            return view('post.edit',compact('post'));
        }
        return back();
    }
    public function destroy($id)
    {
        $post=Post::find($id);
        if (Auth::user()->owns($post)){
            $post->delete();
            flash('删除成功');
            return redirect('/');
        }
        abort('403','Forbidden');
    }

}
