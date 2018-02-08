@extends('message::layouts.master')

@section('content')
    <h1>Hello World</h1>
    <p>
        {{--This view is loaded from module: {!! config('message.name') !!}--}}
    </p>
    {{$name}}你好，这是一封测试图片，请查收。
    <br><br>
    <img src='{{$message->embed($imgPath)}}'>
@stop
