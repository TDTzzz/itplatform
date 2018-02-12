<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="apiToken" content="{{Auth::check()?'Bearer '.Auth::user()->api_token:'Bearer '}}">
    <meta name="description" content="itplatform" />
    {{--<meta name="description" content="itplatform" />--}}

    <title>{{ config('app.name') }}</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    @yield('styles')
    <script>
        @if(Auth::check())
            window.Zhihu={
                name:"{{Auth::user()->name}}",
                avatar:"{{Auth::user()->avatar}}"
        }
        @endif
    </script>
</head>
<style>
    .active{
        color: #ff841b;
    }

</style>
<body>
    <div id="app">
        {{--box-shadow: 5px 5px 5px #c9c9c9;--}}
        @guest
        <nav class="navbar navbar-default navbar-static-top" style="margin-bottom:0;padding-bottom: 10px;">
        @else
        <nav class="navbar navbar-default navbar-static-top" style="margin-bottom: 20px;box-shadow: 5px 5px 5px #c9c9c9;padding-bottom: 10px;">
        @endguest
            <div class="container">
                <div class="navbar-header col-md-2">

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}" style="padding-top: 17px;font-size: 25px;font-weight: bold">
                        {{--{{ config('app.name') }}--}}
                        <span onclick="window.location.href='/'" style="color: #01ad8c">iT-</span>Plat<span style="color: #01ad8c">Form</span>
                    </a>
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <div class="col-md-7" style="padding: 0">
                        <ul class="nav navbar-nav" >
                            <div class="col-md-3" style="height: 50px">
                                <div style="display: inline-block;text-align: center;line-height: 52px;font-size: large;font-weight: bold;width: 40%">
                                    <a href="/" style="color: #636b6f;text-decoration: none">问题</a>
                                </div>
                                <div style="display: inline-block;text-align: center;line-height: 52px;font-size: large;font-weight: bold;width: 40%">
                                    <a href="/post" style="color: #636b6f;text-decoration: none">文章</a>
                                </div>
                            </div>
                            <div class="col-md-4 col-xs-6" style="padding-top:10px ">
                                <form action="/topic/select" method="post" style="margin:0px; padding:0px;">
                                    {{csrf_field()}}
                                    <div class="input-group">
                                        <input type="text" name="topic" class="form-control" placeholder="搜索话题（Topic）...">
                                        <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Go!</button>
                                    </span>
                                    </div><!-- /input-group -->
                                </form>

                            </div><!-- /.col-lg-6 -->
                            {{--<div class="col-lg-5 col-xs-6" style="padding-top:10px ">--}}
                                {{--<form action="/question/select" method="post" style="margin:0px; padding:0px;">--}}
                                    {{--{{csrf_field()}}--}}
                                    {{--<div class="input-group">--}}
                                        {{--<input type="text" name="question" class="form-control" placeholder="搜索问题（Question）...">--}}
                                        {{--<span class="input-group-btn">--}}
                                    {{--<button class="btn btn-default" type="submit">Go!</button>--}}
                                    {{--</span>--}}
                                    {{--</div><!-- /input-group -->--}}
                                {{--</form>--}}

                            {{--</div><!-- /.col-lg-6 -->--}}
                            <a class="btn btn-success col-md-2 col-xs-12" style="margin-top: 10px;font-weight: bold;" href="/question/create">&nbsp;提问题&nbsp;</a>
                            <a class="btn btn-success col-md-2 col-xs-12" style="margin-top: 10px;margin-left:10px;font-weight: bold;" href="/post/create">发文章</a>
                        </ul>
                    </div>



                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right col-md-3" style="">
                        <!-- Authentication Links -->
                        @guest
                            <li class="col-md-4 col-xs-4"><a href="{{ route('login') }}">登录</a></li>
                            <li class="col-md-4 col-xs-4"><a href="{{ route('register') }}">注册</a></li>
                        @else
                                {{--<span class="glyphicon glyphicon-bell col-xs-3" style="cursor: pointer;margin-top: 15px;line-height: 24px;font-size: 25px;" onclick="window.location.href='/notification'"></span>--}}
                                <notice user="{{Auth::user()->id}}"></notice>
                                <li class="dropdown" style="float: right">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <img src="{{Auth::user()->avatar}}" width="35px" style="border-radius:50%" alt="{{ Auth::user()->name }}">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    @can('manage_contents')
                                        <li>
                                            <a href="{{ url(config('administrator.uri')) }}">
                                                <span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
                                                管理后台
                                            </a>
                                        </li>
                                    @endcan
                                    <li>
                                        <a href="/user/{{Auth::user()->id}}">
                                            我的主页
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/avatar">
                                            更换头像
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            登出
                                        </a>
                                    </li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
                <div style="border-top: 1px solid #d5d5d5;padding-top: 5px;">
                    <span class="top-label">热门标签:</span>
                    <span class="top-label"><a href="/topic/php">php</a></span>
                    <span class="top-label"><a href="/topic/linux">linux</a></span>
                    <span class="top-label"><a href="/topic/laravel">laravel</a></span>
                    <span class="top-label"><a href="/topic/javascript">javascript</a></span>
                    <span class="top-label"><a href="/topic/java">java</a></span>
                    <span class="top-label"><a href="/topic/vue.js">vue.js</a></span>
                    <span class="top-label"><a href="/topic/c语言">c语言</a></span>
                    <span class="top-label"><a href="/topic/html">html</a></span>
                    <span class="top-label"><a href="/topic/css">css</a></span>
                    <span class="top-label"><a href="/topic/前端">前端</a></span>
                    <span class="top-label"><a href="/topic/python">python</a></span>
                </div>
            </div>
        </nav>
        @guest
        <div class="row" style="background: linear-gradient(to right, #009a61, rgb(1, 173, 140));height: 187px;margin-bottom: 20px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-7">
                        <h1 style="color: #fff;margin-top: 50px;font-weight: bold">在iT-PlatForm上，学习技能，解决问题</h1>
                        <p style="color: #fff;font-size: large">每个月，我们帮助 0.001 万的开发者解决各种各样的技术问题。并助力他们在技术能力、职业生涯、影响力上获得提升。</p>
                    </div>
                    <div class="col-md-4 col-md-offset-1" style="margin-top: 50px;">
                        <a class="btn btn-success btn-lg" href="{{ route('register') }}" style="background: #fff;color: #00cc66">免费注册</a>
                        <a class="btn btn-success btn-lg" href="{{ route('login') }}" style="border: 1px solid #fff;">立即登陆</a>
                    </div>
                </div>
            </div>
        </div>
        @endguest
        <div class="container">
            @include('flash::message')
        </div>
        @yield('content')

    </div>
    @include('layouts._footer')

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>

    @yield('js')
    <script>
        $('#flash-overlay-modal').modal();
    </script>
    <script>
        if($('#app').height()<window.screen.height-165){
            $('#app').height(window.screen.height-165);
        }
    </script>
</body>
<style>
    .top-label{
        color: #979797;
        padding: 0 10px 0 10px;
    }
    .top-label a{
        color: #979797;
        text-decoration: none;
        padding: 0 10px 0 10px;
    }
</style>
</html>
