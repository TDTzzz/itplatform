
@extends('layouts.app')

@section('content')
    {{--@include('vendor.ueditor.assets')--}}
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading" >
                        <div style="font-size: 30px;">
                            {{$post->title}}
                        </div>
                        @foreach($post->topics as $topic)
                            <a class="topic2" href="/topic/{{$topic->name}}">{{$topic->name}}</a>
                        @endforeach
                        <span onclick="window.location.href='/user/{{$post->user->id}}'" style="cursor: pointer;color: #4c9f2d;font-weight: bold;padding-left: 10px;">{{$post->user->name}}</span>
                        <span style="color: #979797">于{{$post->created_at}}创建</span>
                    </div>
                    <div class="panel-body content">
                        {{--{!! \Chenhua\MarkdownEditor\Facades\MarkdownEditor::parse($post->body) !!}--}}
                        {{--{!! MarkdownEditor::parse($post->body) !!}--}}
                        {!! $post->body !!}
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($post))
                            <span class="edit"><a href="/post/{{$post->id}}/edit" style="text-decoration: none;color: #8c8c8c">编辑</a></span>
                            <form action="/post/{{$post->id}}" method="post" class="delete-form">
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                                <button class="button is-naked delete-button" style="text-decoration: none;color: #8c8c8c">删除</button>
                            </form>
                        @endif
                        <comments type="question" model="{{$post->id}}" count="0"></comments>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 style="text-align: center">{{$post->followers_count}}</h2>
                        <div style="text-align: center;font-size: large">收藏者</div>
                    </div>
                    <div class="panel-body">
                        {{--<a href="/question/{$post->id}/follow" class="btn btn-block">关注该问题</a>--}}
                        {{--<question-follow style="margin-left: 36%;" question="{{$post->id}}"></question-follow>--}}
                        <post-follow style="margin-left: 36%;" post="{{$post->id}}"></post-follow>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{--{{$post->answers->count()}}个答案--}}
                    </div>
                    <div class="panel-body">
                        @foreach($post->comments as $comment)
                            <div class="media">
                                <div class="media-left">
                                    {{--<user-vote answer="{{$comment->id}}" count="0"></user-vote>--}}
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <a href="/user/{{$comment->user->id}}">{{$comment->user->name}}</a>
                                    </div>
                                    {!! $comment->body !!}
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
                @if(Auth::check())
                    <form action="/post/{{$post->id}}/comment" method="post">
                        {!! csrf_field() !!}
                        <input type="hidden" name="model" value="{{$post->id}}">
                        <div class="form-group{{ $errors->has('body') ? ' has-error' : '' }}">
                            <label for="body">描述</label>
                            {{--<script id="container" name="body" style="height:120px;" type="text/plain">--}}
                                {{--{!! old('body') !!}--}}
                            {{--</script>--}}
                            <textarea name="body" class="form-control" id="editor" rows="3" height="100px;" placeholder="请回答。" required>{{ old('body') }}</textarea>

                        @if ($errors->has('body'))
                            <span class="help-block">
                                <strong>{{ $errors->first('body') }}</strong>
                                </span>
                                    @endif
                                </div>
                                <button class="btn btn-success pull-right" type="submit">提交答案</button>
                                </form>
                                    @else
                                <a href="/login" class="btn btn-success btn-block">登录提交答案</a>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                <div class="panel panel-default">
                                <div class="panel-heading">
                                <span>关于作者</span>
                                </div>
                                <div class="panel-body">
                                <div class="media">
                                <div class="media-left">
                                <a href="#"><img width="70px" src="{{$post->user->avatar}}" alt="{{$post->user->name}}"></a>
                                </div>
                                <div class="media-body">
                                <h4 class="media-heading">
                                    {{$post->user->name}}
                                </h4>
                                </div>
                                <div class="user-statics">
                                <div class="statics-item text-center">
                                <div class="statics-text">问题</div>
                                <div class="statics-count">{{$post->user->questions->count()}}</div>
                                </div>
                                <div class="statics-item text-center">
                                <div class="statics-text">回答</div>
                                <div class="statics-count">{{$post->user->answers->count()}}</div>
                                </div>
                                <div class="statics-item text-center">
                                <div class="statics-text">关注者</div>
                                <div class="statics-count">{{$post->user->followers_count}}</div>
                                </div>
                                </div>
                                    @if(Auth::check())
                                    @if(Auth::user()->id!=$post->user->id)
                                <user-follow user="{{$post->user->id}}"></user-follow>
                                <send-message user="{{$post->user->id}}"></send-message>
                                    @else
                                <div style="text-align: center;border-top: 1px solid #979797;padding-top: 5px;">这就是我</div>
                                    @endif
                                    @else
                                <a href="#" class="btn btn-success btn-block">请先登录</a>
                                    @endif
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>



                                </div>
@section('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/simditor.css') }}">
@stop
@section('js')
    <script type="text/javascript"  src="{{ asset('js/module.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/hotkeys.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/uploader.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('js/simditor.js') }}"></script>

    <script>
        $(document).ready(function(){
            var editor = new Simditor({
                textarea: $('#editor'),
                upload: {
                    url: '{{ route('post.upload_image') }}',
                    params: { _token: '{{ csrf_token() }}' },
                    fileKey: 'upload_file',
                    connectionCount: 3,
                    leaveConfirm: '文件上传中，关闭此页面将取消上传。'
                },
                pasteImage: true,
            });
        });
    </script>
@endsection
@endsection
