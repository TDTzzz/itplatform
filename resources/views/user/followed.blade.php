@extends('user.index')

@section('nav-content')
    <div class="" style="margin-top: 0px;font-size: 30px;border-bottom: 1px solid #979797;padding-bottom: 14px">
        我的粉丝
    </div>
    @foreach($followersUser as $follower)
        <div class="media" style="padding-bottom: 10px;border-bottom: 1px solid #979797;height: 60px">
            <div class="media-left" style="">
                <a href="">
                    <img style="width:50px;height: 50px; border-radius:50%; overflow:hidden;" src="{{$follower->avatar}}" alt="{{$follower->name}}">
                </a>

            </div>
            <div class="media-body" style="padding-left: 30px">
                <a href="/user/{{$follower->id}}" style="color: #979797;text-decoration:none;font-size: large">{{$follower->name}}</a>
                <user-follow style="float: right;" user="{{$follower->id}}"></user-follow>
            </div>

        </div>
    @endforeach
@endsection
