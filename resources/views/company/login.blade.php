@extends('htmlTemplate')
@section('title')
    会社ログイン
@endsection
@section('main')
    <h1>会社ログイン</h1>
    {{-- エラーの表示を追加 --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['url' => '/company/login']) !!}
    <div class="mdl-textfield mdl-js-textfield">
        {!! Form::label('email', 'メールアドレス',['class'=>'mdl-textfield__label']) !!}
        {!! Form::text('email', null,['class'=>'mdl-textfield__input']) !!}
    </div>
    <div class="mdl-textfield mdl-js-textfield">
        {!! Form::label('password', 'パスワード',['class'=>'mdl-textfield__label']) !!}
        {!! Form::password('password',['class'=>'mdl-textfield__input']) !!}
    </div>
    <div class="mdl-textfield mdl-js-textfield">
        {!! Form::submit('ログイン',['class'=>'mdl-button mdl-js-button mdl-button--raised']) !!}
    </div>
    {!! Form::close() !!}
    <a href="/company/create">アカウント作成がまだの方はこちら</a>
@endsection