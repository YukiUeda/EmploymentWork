@extends('htmlTemplate')
@section('main')
    <h1>学校作成</h1>
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
    {!! Form::open(['url' => 'school\create']) !!}
    <div class="mdl-textfield mdl-js-textfield">
        {!! Form::label('name', '名前',['class'=>'mdl-textfield__label']) !!}
        {!! Form::text('name', null,['class'=>'mdl-textfield__input']) !!}
    </div>
    <div class="mdl-textfield mdl-js-textfield">
        {!! Form::label('address', '住所',['class'=>'mdl-textfield__label']) !!}
        {!! Form::text('address', null,['class'=>'mdl-textfield__input']) !!}
    </div>
    <div class="mdl-textfield mdl-js-textfield">
        {!! Form::label('email', 'email',['class'=>'mdl-textfield__label']) !!}
        {!! Form::email('email', null,['class'=>'mdl-textfield__input']) !!}
    </div>
    <div class="mdl-textfield mdl-js-textfield">
        {!! Form::label('password', 'パスワード',['class'=>'mdl-textfield__label']) !!}
        {!! Form::password('password',['class'=>'mdl-textfield__input']) !!}
    </div>
    <div class="mdl-textfield mdl-js-textfield">
        {!! Form::label('telephone_number', '電話番号',['class'=>'mdl-textfield__label']) !!}
        {!! Form::tel('telephone_number', null,['class'=>'mdl-textfield__input']) !!}
    </div>
    <div class="mdl-textfield mdl-js-textfield">
        {!! Form::label('semester', '学期制',['class'=>'mdl-textfield__label']) !!}
        {!! Form::number('semester', 3,['class'=>'mdl-textfield__input','max'=>'3','min'=>'2']) !!}
    </div>
    <div class="mdl-textfield mdl-js-textfield">
        {!! Form::submit('アカウント作成',['class'=>'mdl-button mdl-js-button mdl-button--raised']) !!}
    </div>
    {!! Form::close() !!}
@endsection
