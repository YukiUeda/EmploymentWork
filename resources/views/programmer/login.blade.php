@extends('htmlTemplate')
@section('title')
    プログラマーログイン
@endsection
@section('main')
    <h1>プログラマーログイン</h1>
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
    {!! Form::open(['url' => '/programmer/login']) !!}
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
    <a href="/programmer/create">アカウント作成がまだの方はこちら</a>
@endsection