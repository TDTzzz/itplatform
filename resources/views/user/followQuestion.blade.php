@extends('user.index')

@section('nav-content')
    <div class="" style="margin-top: 0px;font-size: 30px;border-bottom: 1px solid #979797;padding-bottom: 14px">
        关注的问题
    </div>
    @foreach($followQuestion as $question)
        <div class="media" style="padding-bottom: 10px;border-bottom: 1px solid #979797;height: 9%">
            <div class="media-left" style="">
                {{--<a href="">--}}
                {{--<img style="width:80px;height: 80px; border-radius:50%; overflow:hidden;" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">--}}
                {{--</a>--}}
                <div style="@if($question->answers->count()===0) background-color: #ad3a37; @else background-color: #009a61; @endif text-align:center;color: #fff;width: 50px;height: 80%;padding-top: 5px">
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
                    <div class="media-right" style="display: inline-block" style="padding: 0 10px 0 0">
                        @foreach($question->topics as $topic)
                            <a class="topic2" href="/topic/{{$topic->name}}">{{$topic->name}}</a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    @endforeach
@endsection
