@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row" style="margin: 10px 0 20px 0;">
            <div class="col-md-9">
                搜索到的话题:
                @foreach($topics as $topic)
                    <span style="padding: 0 5px 0 5px;font-size: 25px;color: #00cc66">
                        {{$topic->name}}
                    </span>
                @endforeach
            </div>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <form action="/topic/select" method="post" style="margin-bottom: 20px;margin-left: 15px;">
                {{csrf_field()}}
                <div class="input-group" style="width: 100%">
                    <input type="text" name="topic" class="form-control" style="height: 50px;width: 60%;" placeholder="搜索话题（Topic）...">
                    <a href="" class="btn btn-success btn-lg" style="display: inline-block;width: 15%;margin-left: 5%">搜索</a>
                </div>
            </form>
            <ul class="nav nav-tabs">
                <li class="{{ active_class(if_route_param('order','all')||if_route_param('order',''))}}"><a href="/topic/select/all/{{$old_topic}}">全部</a></li>
                <li class="{{ active_class(( if_route_param('order','question') )) }}"><a href="/topic/select/question/{{$old_topic}}">问题</a></li>
                <li class="{{ active_class(( if_route_param('order','post') )) }}"><a href="/topic/select/post/{{$old_topic}}">文章</a></li>
            </ul>
        </div>
        <div class="row">

            <div class="col-md-9">

                @foreach($questions as $question)
                    <div class="media" style="padding-bottom: 10px;border-bottom: 1px solid #979797;height: 60px">
                        <div class="media-left" style="@if($question->answers->count()===0) background-color: #ad3a37; @else background-color: #009a61; @endif color: #fff;height: 80%">
                            {{--<a href="">--}}
                            {{--<img style="width:80px;height: 80px; border-radius:50%; overflow:hidden;" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">--}}
                            {{--</a>--}}
                            <div style="width: 40px;height: 55px;text-align: center;padding-top: 5px">
                                {{$question->answers->count()}}
                                <p>回答</p>
                            </div>
                        </div>
                        <div class="media-body" style="padding-left: 30px">
                            <h4 class="media-heading" style="font-size: small">
                                <a href="/user/{{$question->user->id}}">{{$question->user->name}}</a>
                                发布于{{$question->updated_at}}
                            </h4>
                            <div>
                                <a class="title" href="/question/{{$question->id}}" style="font-size: large;color: #000;display: inline-block">
                                    {{$question->title}}
                                </a>
                                <div class="media-right" style="display: inline-block">
                                    @foreach($question->topics as $topic)
                                        <a class="topic2" href="/topic/{{$topic->id}}">{{$topic->name}}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                @endforeach
                    @foreach($posts as $post)
                        <div class="media" style="padding-bottom: 10px;border-bottom: 1px solid #979797;height: 60px">
                            <div class="media-left" style="@if($post->comments->count()===0) background-color: #ad3a37; @else background-color: #009a61; @endif color: #fff;height: 80%">
                                {{--<a href="">--}}
                                {{--<img style="width:80px;height: 80px; border-radius:50%; overflow:hidden;" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">--}}
                                {{--</a>--}}
                                <div style="width: 40px;height: 55px;text-align: center;padding-top: 5px">
                                    {{$post->comments->count()}}
                                    <p>评论</p>
                                </div>
                            </div>
                            <div class="media-body" style="padding-left: 30px">
                                <h4 class="media-heading" style="font-size: small">
                                    <a href="/user/{{$post->user->id}}">{{$post->user->name}}</a>
                                    发布于{{$post->updated_at}}
                                </h4>
                                <div>
                                    <a class="title" href="/question/{{$post->id}}" style="font-size: large;color: #000;display: inline-block">
                                        {{$post->title}}
                                    </a>
                                    <div class="media-right" style="display: inline-block">
                                        @foreach($post->topics as $topic)
                                            <a class="topic2" href="/topic/{{$topic->id}}">{{$topic->name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
            </div>
        </div>

    </div>


@endsection
