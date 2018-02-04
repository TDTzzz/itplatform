@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">编辑文章</div>
                    <div class="panel-body">
                        <form action="/post/{{$post->id}}" method="post">
                            {{method_field('PATCH')}}
                            {!! csrf_field() !!}
                            <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                <label for="title">标题</label>
                                <input type="text" value="{{ $post->title }}" name="title" class="form-control" placeholder="标题" id="title">
                                @if ($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <select name="topics[]" class="js-example-placeholder-multiple js-data-example-ajax form-control" multiple="multiple">
                                    @foreach($post->topics as $topic)
                                        <option value="{{$topic->id}}" selected="selected">{{$topic->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="body">描述</label>
                                <div id="test-editormd">
                                    <textarea name="body" style="display:none;">{{$post->body}}</textarea>
                                </div>

                                @include('vendor.markdown.encode',['editors'=>['test-editormd']])
                            </div>
                            <button class="btn btn-success pull-right" type="submit">发布问题</button>
                        </form>
                    </div>
                </div>
            </div>
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
