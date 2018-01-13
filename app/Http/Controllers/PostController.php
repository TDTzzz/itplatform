<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Post;
use App\Comment;
use Auth;
use Illuminate\Http\Request;
use Chenhua\MarkdownEditor\MarkdownEditor;

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

    public function comment()
    {
        $model='App\Post';
        $comment=Comment::create([
            'commentable_id'=>request('model'),
            'commentable_type'=>$model,
            'user_id'=>Auth::user()->id,
            'body'=>request('body')
        ]);
        flash('评论成功');
        return back();
    }
}
