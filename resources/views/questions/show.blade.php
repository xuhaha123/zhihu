@extends('layouts.app')

@section('content')
    @include('vendor.ueditor.assets')
    <style>
        .xu_select{background: #eff6fa;padding:1px 15px 0px;border-radius: 30px;
            text-decoration: none;margin: 0px 5px 5px 0px;display: inline-block;white-space: nowarp;cursor: pointer}
        .xu_select:hover{background: #259;color:#fff;text-decoration: none;}
    </style>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @include('flash::message')
                <div class="panel-heading">标题：{{ $question->title }}
                    @foreach($question->topics as $topic)
                        <a href="" class="xu_select">{{$topic->name}}</a>
                    @endforeach
                </div>

                <div class="panel-body">
                    内容：
                    {!! $question->body !!}
                    {{--{{$question->body}}// 不解析html标签<p>fff</p>--}}
                </div>
                <div class="actions">
                    @if(\Illuminate\Support\Facades\Auth::check() && Auth::user()->owns($question))
                        <span class="edit btn btn-info"><a href="/questions/{{$question->id}}/edit">编辑</a></span>
                        <form action="/questions/{{$question->id}}" method="post" class="delete-form">
                            {{method_field('DELETE')}}
                            {{csrf_field()}}
                            <button class="btn btn-danger">删除 </button>
                        </form>
                        @endif
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @include('flash::message')
                <div class="panel-heading">
                    {{$question->answer_count}}个答案
                </div>

                <div class="panel-body">
                    <form action="/questions/{{$question->id}}/answer" method="post">
                        {!!csrf_field()!!}
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
                        <button class="btn btn-success pull-right" type="submit">提交答案</button>


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
    </script>

    <!-- 编辑器容器 -->
@endsection
