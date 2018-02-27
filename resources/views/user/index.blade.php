@extends('layouts.app')

@section('content')
    <div class="container" style="margin-bottom: 30px;">
        <div class="row">
            <div class="col-md-2 col-sm-3 col-xs-6">
                <img width="100%" style="border-radius:50%" src="{{$user->avatar}}" alt="{{$user->name}}">
            </div>
            <div class="col-md-5 col-sm-9 col-xs-6 col-md-offset-2">
                <p style="font-size: 30px;color: #000;">{{$user->name}}</p>
                <p style="font-size: large">回答个数:{{$user->answers->count()}}</p>
                <p style="font-size: large">提问个数:{{$user->questions->count()}}</p>
                @if(Auth::check()&&Auth::user()->id!=$user->id)
                    <user-follow user="{{$user->id}}"></user-follow>
                    <send-message user="{{$user->id}}"></send-message>
                @else

                @endif
            </div>
        </div>
    </div>
    <div class="row" style="background-color: #fff;padding-top: 20px;">
        <div class="col-md-2 col-md-offset-2">
            <div class="row" style="border-bottom: 1px solid #eee;margin-bottom: 20px;" >
                <div class="col-md-6 col-xs-6" style="border-right: 1px solid #eee;cursor:pointer;" onclick="window.location.href='/user/{{$user->id}}/followers'">
                    关注了
                    <p style="color: #000;font-weight: bold;font-size: large">{{$user->followers->count()}}人</p>
                </div>
                <div class="col-md-6 col-xs-6" style="cursor:pointer;" onclick="window.location.href='/user/{{$user->id}}/followed'">
                    粉丝
                    <p style="color: #000;font-weight: bold;font-size: large">{{$user->followersUser->count()}}人</p>
                </div>
            </div>
            <ul class="nav nav-pills nav-stacked">
                <li class="@if($nav==='0') user-active @else  @endif">
                    <a class="user-nav" href="/user/{{$user->id}}">我的回答
                        <span class="small-num" >{{$user->answers->count()}}</span>
                    </a>
                </li>
                <li class="@if($nav==='1') user-active @else @endif">
                    <a class="user-nav" href="/user/{{$user->id}}/question">我的提问
                        <span class="small-num" >{{$user->questions->count()}}</span>
                    </a>
                </li>
                <li class="@if($nav==='4') user-active @else @endif">
                    <a class="user-nav" href="/user/{{$user->id}}/post">我的文章
                        <span class="small-num" >{{$user->posts->count()}}</span>
                    </a>
                </li>
                <li class="@if($nav==='2') user-active @else @endif">
                    <a class="user-nav" href="/user/{{$user->id}}/followQuestion">关注的问题
                        <span class="small-num" >{{$user->follows->count()}}</span>
                    </a>
                </li>
                <li class="@if($nav==='5') user-active @else @endif">
                    <a class="user-nav" href="/user/{{$user->id}}/followPost">收藏的文章
                        <span class="small-num" >{{$user->follows->count()}}</span>
                    </a>
                </li>
                <li class="@if($nav==='3') user-active @else @endif">
                    <a class="user-nav" href="/user/{{$user->id}}/followers">关注的人
                        <span class="small-num" >{{$user->followers->count()}}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="col-md-6 col-xs-10 col-xs-offset-1 col-md-offset-0">
            @yield('nav-content')
        </div>
    </div>
@endsection
