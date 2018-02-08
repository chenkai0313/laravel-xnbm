@extends('message::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! config('message.name') !!}
        {{$name}}你好，这是一封测试文件。
        <br>
        <img src='{{$message->embed($imgPath)}}'>
    </p>
@stop
