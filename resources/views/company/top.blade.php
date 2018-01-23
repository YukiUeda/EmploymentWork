@extends('company.layout')

@section('content')
    <a href="/code">コード生成</a><br>
    <a href="logout">ログアウト</a><br>
    <a href="classworkTimer">時間割</a>
    <p>{{$name}}</p>
@endsection