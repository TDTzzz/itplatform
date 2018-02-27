@extends('user.index')

@section('nav-content')
    <div class="" style="margin-top: 0px;font-size: 30px;border-bottom: 1px solid #979797;padding-bottom: 14px">
        收藏的文章
    </div>
    @foreach($followPost as $post)
        <div class="media" style="padding-bottom: 10px;border-bottom: 1px solid #979797;height: 9%;">
            <div class="media-left" style="">
                <div style="@if($post->comments->count()===0) background-color: #ad3a37; @else background-color: #009a61; @endif  text-align:center;color: #fff;width: 50px;height: 80%;padding-top: 5px">
                    {{$post->comments->count()}}
                    <p>回答</p>
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
                    <div class="media-right" style="display: inline-block" style="padding: 0 10px 0 0">
                        @foreach($post->topics as $topic)
                            <a class="topic2" href="/topic/{{$topic->name}}">{{$topic->name}}</a>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    @endforeach
@endsection
