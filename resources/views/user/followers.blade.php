@extends('user.index')

@section('nav-content')
    <div class="" style="margin-top: 0px;font-size: 30px;border-bottom: 1px solid #979797;padding-bottom: 14px">
        关注的人
    </div>
    @foreach($followers as $follower)
        <div class="media" style="padding-bottom: 10px;border-bottom: 1px solid #979797;height: 60px">
            <div class="media-left" style="">
                <a href="">
                <img style="width:50px;height: 50px; border-radius:50%; overflow:hidden;" src="{{$follower->avatar}}" alt="{{$follower->name}}">
                </a>

            </div>
            <div class="media-body" style="padding-left: 30px">
                {{--<span class="media-heading" style="font-size: large">--}}
                    {{--{{$user->name}}--}}
                {{--</span>--}}
                {{--<div>--}}
                    {{--<div class="media-right" style="display: inline-block" style="padding: 0 10px 0 0">--}}
                        {{--<user-follow user="{{$user->id}}"></user-follow>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <a href="/user/{{$follower->id}}" style="color: #979797;text-decoration:none;font-size: large">{{$follower->name}}</a>
                <user-follow style="float: right;" user="{{$follower->id}}"></user-follow>
            </div>

        </div>
    @endforeach
@endsection
