@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @include('flash::message')
                <div class="panel-heading">标题：{{ $question->title }}</div>

                <div class="panel-body">
                    内容：
                    {!! $question->body !!}
                    {{--{{$question->body}}// 不解析html标签<p>fff</p>--}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
