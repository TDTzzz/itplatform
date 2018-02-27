@extends('layouts.app')
<style>
    .box{
        width:50px;height: 50px;background-color: #dddddd;
        display: inline-block;border:1px solid #dddddd;margin: 10px;cursor:pointer;
        font-size: 30px;font-weight: bold;
        text-align: center;line-height: 50px;
    }
    .active{
        background-color: #00cc66;
        color: #fff!important;
    }

</style>
@section('content')
    <div class="container">
        <div class="row">
            @if(Auth::check())
                <test type="{{$type}}" user="{{Auth::user()->id}}"></test>
            @else
                <a href="/login" class="btn btn-success btn-block">请登录后再答题</a>
            @endif
        </div>
    </div>
@endsection


