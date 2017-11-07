@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    {{--@include('flash::message')--}}
                    <div class="panel-heading">发布问题</div>

                    <div class="panel-body">
                        <form action="/questions" method="post">
                            {!!csrf_field()!!}
                            <div class="form-group{{$errors->has('title')?'has-error':''}}">
                                <label for="title">标题</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="form-control" placeholder="标题" id="title">
                                @if($errors->has('title'))
                                    <span class="help-block">
                                        <strong>{{$errors->first('title')}}</strong>
                                    </span>
                                    @endif
                            </div>
                            <div class="form-group">
                                <select name="topics[]" class="js-example-basic-multiple form-control" name="states[]" multiple="multiple">
                                    <option value="AL">Alabama</option>
                                    ...
                                    <option value="WY">Wyoming</option>
                                </select>
                            </div>
                        {{--@if (session('status'))--}}
                            {{--<div class="alert alert-success">--}}
                                {{--{{ session('status') }}--}}
                            {{--</div>--}}
                        {{--@endif--}}
                            <div class="form-group{{$errors->has('body')?'has-error':''}}">
                                <script id="container" name="body" type="text/plain">
                                    {!! old('body') !!}
                                </script>
                                @if($errors->has('body'))
                                    <span class="help-block">
                                        <strong>{{$errors->first('body')}}</strong>
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
    {{--<script src="{{ asset('js/app.js') }}"></script>--}}

    <script type="text/javascript">
        var ue = UE.getEditor('container');
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}'); // 设置 CSRF token.
        });
        $(document).ready(function() {
            function formatTopic(topic)
            {
                return "<div class='select2-result-repository clearfix'>"+
                        "<div class='select2-result-repository_meta'>"+
                        "<div class='select2-result-repository_title'>"+
                                topic.name ? topic.name : "Larvel"+
                        "</div></div></div>";
            }
            function formatTopicSelection(topic)
            {
                return topic.name ||topic.text;
            }
            $('.js-example-basic-multiple').select2({
                tags:true,
                placeholder:'选择相关话题',
                minimumInputLength:2,
                ajax:{
                    url:'/api/topics',
                    dataType:'json',
                    delay:250,
                    data:function(params)
                    {
                        return {
                            q:params.term
                        };
                    },
                    processResults:function(data,params){
                        return {
                            results:data
                        };
                    },
                    cache:true
                },
                templateResult:formatTopic,
                templateSelection:formatTopicSelection,
                escapeMarkup:function(markup){return markup;}
            });
        });
    </script>

    <!-- 编辑器容器 -->
@endsection
