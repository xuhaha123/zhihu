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
            @foreach($questions as $question)
                <div class="media">
                    <div class="media-left">
                        <a href=""><img src="{{ $question->user->avatar }}" alt="{{$question->user->name}}"></a>
                    </div>
                    <div class="media-body">
                        <h4 class="media-heading">
                            <a href="/questions/{{$question->id}}">
                                {{$question->title}}
                            </a>
                        </h4>
                    </div>
                </div>
                @endforeach
        </div>
    </div>
</div>
@endsection
