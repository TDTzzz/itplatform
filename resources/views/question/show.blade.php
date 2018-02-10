@extends('layouts.app')

@section('content')
    {{--@include('vendor.ueditor.assets')--}}

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1 topic-content">
                <div class="panel panel-default">
                    <div class="panel-heading" >
                        <div style="font-size: 30px;">
                            {{$question->title}}
                        </div>
                        @foreach($question->topics as $topic)
                            <a class="topic2" href="/topic/{{$topic->name}}">{{$topic->name}}</a>
                        @endforeach
                        <span onclick="window.location.href='/user/{{$question->user->id}}'" style="cursor: pointer;color: #4c9f2d;font-weight: bold;padding-left: 10px;">{{$question->user->name}}</span>
                        <span style="color: #979797">于{{$question->created_at}}创建</span>
                    </div>
                    <div class="panel-body topic-body">
                        {!!$question->body!!}
                    </div>
                    <div class="actions">
                        @if(Auth::check() && Auth::user()->owns($question))
                            <span class="edit"><a href="/question/{{$question->id}}/edit" style="text-decoration: none;color: #8c8c8c">编辑</a></span>
                            <form action="/question/{{$question->id}}" method="post" class="delete-form">
                                {{method_field('DELETE')}}
                                {{csrf_field()}}
                                <button class="button is-naked delete-button" style="text-decoration: none;color: #8c8c8c">删除</button>
                            </form>
                        @endif
                        <comments type="question" model="{{$question->id}}" count="{{$question->comments()->count()}}"></comments>
                    </div>
                </div>
                </div>
            <div class="col-md-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h2 style="text-align: center">{{$question->followers_count}}</h2>
                        <div style="text-align: center;font-size: large">关注者</div>
                    </div>
                    <div class="panel-body">
                        {{--<a href="/question/{$question->id}/follow" class="btn btn-block">关注该问题</a>--}}
                        @if(Auth::check())
                            <question-follow style="margin-left: 36%;" question="{{$question->id}}"></question-follow>
                        @else
                            <a href="/login" class="btn btn-success btn-block">登录后可关注</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{$question->answers->count()}}个答案
                    </div>
                    <div class="panel-body">
                        @foreach($question->answers as $answer)
                            <div class="media">
                                <div class="media-left">
                                    <user-vote answer="{{$answer->id}}" count="{{$answer->votes_count}}"></user-vote>
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <a href="/user/{{$answer->user->id}}">{{$answer->user->name}}</a>
                                    </div>
                                    {!! $answer->body !!}
                                </div>
                            </div>
                            <comments type="answer" model="{{$answer->id}}" count="{{$answer->comments()->count()}}"></comments>
                        @endforeach
                    </div>

                </div>
            @if(Auth::check())
                <form action="/question/{{$question->id}}/answer" method="post">
                    {!! csrf_field() !!}
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
                                <a href="#"><img width="70px" src="{{$question->user->avatar}}" alt="{{$question->user->name}}"></a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    {{$question->user->name}}
                                </h4>
                            </div>
                            <div class="user-statics">
                                <div class="statics-item text-center">
                                    <div class="statics-text">问题</div>
                                    <div class="statics-count">{{$question->user->questions->count()}}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">回答</div>
                                    <div class="statics-count">{{$question->user->answers->count()}}</div>
                                </div>
                                <div class="statics-item text-center">
                                    <div class="statics-text">关注者</div>
                                    <div class="statics-count">{{$question->user->followers_count}}</div>
                                </div>
                            </div>
                            @if(Auth::check())
                                @if(Auth::user()->id!=$question->user->id)
                            <user-follow user="{{$question->user->id}}"></user-follow>
                                <send-message user="{{$question->user->id}}"></send-message>
                                    @else
                                <div style="text-align: center;border-top: 1px solid #979797;padding-top: 5px;">这就是我</div>
                                @endif
                            @else
                                <a href="/login" class="btn btn-success btn-block">请先登录</a>
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
                    url: '{{ route('question.upload_image') }}',
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
