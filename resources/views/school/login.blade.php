@extends('htmlTemplate')

@section('main')
    <h1>学校</h1>
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
    {!! Form::open(['url' => '/school/login']) !!}
    <div class="input-field">
        {!! Form::text('email', null,['class'=>'validate']) !!}
        {!! Form::label('email', 'メールアドレス') !!}
    </div>
    <div class="input-field">
        {!! Form::label('password', 'パスワード',['class'=>'mdl-textfield__label']) !!}
        {!! Form::password('password',['class'=>'class="validate"']) !!}
    </div>
    <button class="btn waves-effect" type="submit" name="action">ログイン</button>
    {!! Form::close() !!}
@endsection