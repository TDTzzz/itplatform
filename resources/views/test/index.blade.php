@extends('layouts.app')
<style>
    .box{
        width:18%;height: 30%;background-image: linear-gradient(to bottom, #fff,#89dd9b73);
        display: inline-block;margin: 10px;
        font-size: 30px;font-weight: bold;
        padding: 10px;
        text-align: center;
        /*word-break:break-all;*/
    }

</style>
@section('content')
    <div class="container">
        <div class="row">
            @if(Auth::check())
                @foreach($data as $k=>$v)
                    <div class="box">
                        <p style="margin: 15% 0 30% 0">{{$v}}</p>
                        @if(Auth::user()->hasTest($v))
                            <a class="btn btn-success btn-block" href="/test/{{$v}}">查看报告</a>
                        @else
                            <a class="btn btn-primary btn-block" href="/test/{{$v}}">开始测试</a>
                        @endif
                    </div>
                @endforeach
            @else
                <a href="/login" class="btn btn-success btn-block">请登录后再答题</a>
            @endif
        </div>
    </div>
@endsection


