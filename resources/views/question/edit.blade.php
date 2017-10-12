@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">编辑问题</div>
                    <div class="panel-body">
                        <form action="/question/{{$question->id}}" method="post">
                            {{method_field('PATCH')}}
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title">标题</label>
                                <input type="text" value="{{ $question->title }}" name="title" class="form-control" placeholder="标题" id="title">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <select name="topics[]" class="js-example-placeholder-multiple js-data-example-ajax form-control" multiple="multiple">
                                    @foreach($question->topics as $topic)
                                        <option value="{{$topic->id}}" selected="selected">{{$topic->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="body">描述</label>
                                <script id="container" name="body" style="height:200px;" type="text/plain">{!! $question->body !!}</script>
                                @if ($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-success pull-right" type="submit">发布问题</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
                                        @section('js')
                                    <!-- 实例化编辑器 -->
                                    <script type="text/javascript">
                                var ue = UE.getEditor('container');
                                ue.ready(function() {
                                    ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
                                });


                                $(document).ready(function() {
                                    function formatTopic (topic) {
                                        return "<div class='select2-result-repository clearfix'>" +
                                        "<div class='select2-result-repository__meta'>" +
                                        "<div class='select2-result-repository__title'>" +
                                        topic.name ? topic.name : "Laravel"   +
                                            "</div></div></div>";
                                    }
                                    function formatTopicSelection (topic) {
                                        return topic.name || topic.text;
                                    }
                                    $(".js-example-placeholder-multiple").select2({
                                        tags: true,
                                        placeholder: '选择相关话题',
                                        minimumInputLength: 2,
                                        ajax: {
                                            url: '/api/topics',
                                            dataType: 'json',
                                            delay: 250,
                                            data: function (params) {
                                                return {
                                                    q: params.term
                                                };
                                            },
                                            processResults: function (data, params) {
                                                return {
                                                    results: data
                                                };
                                            },
                                            cache: true
                                        },
                                        templateResult: formatTopic,
                                        templateSelection: formatTopicSelection,
                                        escapeMarkup: function (markup) { return markup; }
                                    });
                                });
                                </script>
@endsection
@endsection
