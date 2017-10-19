@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">更换头像</div>
                    <div class="panel-body">
                        <change-avatar avatar="{{ Auth::user()->avatar }}"></change-avatar>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
