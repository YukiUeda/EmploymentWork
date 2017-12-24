@extends('school.layout')

@section('content')
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
    {!! Form::open(['url' => 'school/objective/setting']) !!}
    <div class="row">
        <div class="input-field col s12">
            {!! Form::select('year', ['0' => '本年度','1' => '来年度'])!!}
            {!! Form::label('year', '設定日') !!}
        </div>
        <div class="input-field col s12">
            {!! Form::label('grade', '学年')!!}
            {!! Form::number('grade',null,['min'=>'1','max'=>'6']) !!}
        </div>
        <div class="input-field col s12">
            {!! Form::select('subject', ['' => '選択してください']+Config::get('const.curriculum','id')) !!}
            {!! Form::label('subject', '科目名')!!}
        </div>
    </div>
    <button class="btn waves-effect" type="submit" name="action"><i class="material-icons right">send</i>設定</button>
    {!! Form::close() !!}
@endsection