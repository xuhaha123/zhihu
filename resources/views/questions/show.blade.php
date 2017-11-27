@extends('layouts.app')

@section('content')
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
                        <span class="edit"><a href="/questions/{{$question->id}}/edit">编辑</a></span>
                        <form action="/questions/{{$question->id}}" method="post" class="delete-form">
                            {{method_field('DELETE')}}
                            {{csrf_field()}}
                            <button class="button is-naked delete-button">删除 </button>
                        </form>
                        @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
