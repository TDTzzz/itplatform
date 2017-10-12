@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row" style="margin-top: 30px;">
            <div class="col-md-8 col-md-offset-1">
                @foreach($questions as $question)
                    <div class="media" style="padding-bottom: 10px;border-bottom: 1px solid #000">
                        <div class="media-left">
                            <a href="">
                                <img width="100px" src="{{$question->user->avatar}}" alt="{{$question->user->name}}">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="/question/{{$question->id}}">
                                    {{$question->title}}
                                </a>
                            </h4>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    <style>
        .panel-body img{
            width:100%;
        }
    </style>

@endsection
