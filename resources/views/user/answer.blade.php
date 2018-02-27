@extends('user.index')

@section('nav-content')
    <div class="" style="margin-top: 0px;font-size: 30px;border-bottom: 1px solid #979797;padding-bottom: 14px">
        我的回答
    </div>
    @foreach($answers as $answer)

        <div class="media" style="padding-bottom: 10px;border-bottom: 1px solid #979797;height:9%">
            <div class="media-left" style="">
                <div style="@if($answer->question->answers->count()===0) background-color: #ad3a37; @else background-color: #009a61; @endif  text-align:center;color: #fff;width: 50px;height: 80%;padding-top: 5px">
                    {{$answer->question->answers->count()}}
                    <p>回答</p>
                </div>
            </div>
            <div class="media-body" style="padding-left: 30px">
                <h4 class="media-heading" style="font-size: small">
                    <a href="/user/{{$answer->question->user->id}}">{{$answer->question->user->name}}</a>
                    发布于{{$answer->question->updated_at}}
                </h4>
                <div>
                    <a class="title" href="/question/{{$answer->question->id}}" style="font-size: large;color: #000;display: inline-block">
                        {{$answer->question->title}}
                    </a>
                    <div class="media-right" style="display: inline-block;padding: 0 10px 0 0">
                        @foreach($answer->question->topics as $topic)
                            <a class="topic2" href="/topic/{{$topic->name}}">{{$topic->name}}</a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    @endforeach
@endsection
