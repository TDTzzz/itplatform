@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row" style="margin-top: 30px;">
            <div class="col-md-9 col-md-offset-1">
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
                                <a href="#">{{$question->user->name}}</a>
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
            </div>
        </div>

    </div>


@endsection
