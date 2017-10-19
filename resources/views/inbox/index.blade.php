@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">消息通知</div>
                    <div class="panel-body">
                        @foreach($messages as $messageGroup)
                            <div class="media {{$messageGroup->first()->isHasRead()?'unread':''}}">
                                <div class="media-left">
                                    <a href="#">
                                        <img style="border-radius: 50%" width="100px" src="{{ $messageGroup->first()->fromUser->avatar }}" alt="">
                                    </a>
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">
                                        <a href="#">
                                            {{ $messageGroup->first()->fromUser->name }}
                                        </a>
                                    </h4>
                                    <p>
                                        <a href="/inbox/{{ $messageGroup->first()->fromUser->id }}">
                                            {{ $messageGroup->first()->body }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
