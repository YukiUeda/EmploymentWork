@extends('htmlTemplate')
@section('main')
    <h1>teacher</h1>
    {{-- エラーの表示を追加 --}}
    @if (isset($errors))
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (isset($msgs))
        <div class="alert alert-danger">
            @foreach($msg as $msg)
                <ul>
                    <li>{{ $msg }}</li>
                </ul>
            @endforeach
        </div>
    @endif
    {!! Form::open(['url' => 'teacher\create']) !!}
    <div class="input-field">
        {!! Form::label('code', 'コード') !!}
        {!! Form::text('code', null,['class'=>'validate']) !!}
    </div>
    <div class="input-field">
        {!! Form::label('name', '名前') !!}
        {!! Form::text('name', null,['class'=>'validate']) !!}
    </div>
    <div class="input-field">
        {!! Form::label('email', 'メールアドレス') !!}
        {!! Form::text('email', null,['class'=>'validate']) !!}
    </div>
    <div class="input-field">
        {!! Form::label('password', 'パスワード') !!}
        {!! Form::password('password',['class'=>'validate']) !!}
    </div>
    <div class="input-field">
        {!! Form::submit('アカウント作成',['class'=>'mdl-button mdl-js-button mdl-button--raised']) !!}
    </div>
    {!! Form::close() !!}
@endsection