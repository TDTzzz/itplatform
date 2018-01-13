@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row" style="margin-top: 30px;">
            @if(Auth::check())

                <div class="col-md-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">发布文章</div>

                        <div class="panel-body">
                            <form action="/post" method="post">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="title">标题</label>
                                    <input type="text" value="{{ old('title') }}" name="title" class="form-control" placeholder="标题" id="title">
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <select class="js-example-placeholder-multiple js-data-example-ajax form-control" name="topics[]" multiple="multiple">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="body">描述</label>
                                    <div id="test-editormd">
                                        <textarea name="body" style="display:none;"></textarea>
                                    </div>

                                    @include('markdown::encode',['editors'=>['test-editormd']])
                                    </div>
                                    <button class="btn btn-success pull-right" type="submit">发布问题</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <a href="/login" class="btn btn-success btn-block" style="margin-top: 100px">请先登录</a>
            @endif

        </div>

    </div>
@section('js')
    <script>
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
