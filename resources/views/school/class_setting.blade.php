@extends('school.layout')

@section('layout_js')

@endsection
@section('content')
    {{-- エラーの表示を追加 --}}
    @if (isset($errors))
        {{Debugbar::addMessage($errors)}}
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
    {!! Form::open(['url' => 'school/class/check']) !!}
    {!! Form::hidden('year' ,$year) !!}
    {!! Form::hidden('grade',$grade) !!}
    {{Debugbar::addMessage($class)}}
    @if(0 < count($class))
        <div class="row clone">
            <div class="input-field col s6">
                {!! Form::text('class[0]',$class[0]['class_name'])!!}
                {!! Form::label('class', 'クラス名') !!}
            </div>
            <div class="input-field col s6">
                {!! Form::select('teacher[0]', ['' => '選択してください']+array_pluck($teacher,'name','id'),$class[0]['teacher_id']) !!}
                {!! Form::label('teacher', '教師')!!}
            </div>
        </div>
    @else
        <div class="row clone">
            <div class="input-field col s6">
                {!! Form::text('class[0]',null)!!}
                {!! Form::label('class', 'クラス名') !!}
            </div>
            <div class="input-field col s6">
                {!! Form::select('teacher[0]', ['' => '選択してください']+array_pluck($teacher,'name','id'),null) !!}
                {!! Form::label('teacher', '教師')!!}
            </div>
        </div>
    @endif
    <div class="row form">
        @for ($i = 1; $i < count($class); $i++)
            <div class="input-field col s6">
                {!! Form::text('class['.$i.']',old('class.'.$i,$class[$i]['class_name']))!!}
                {!! Form::label('class', 'クラス名') !!}
            </div>
            <div class="input-field col s6">
                {!! Form::select('teacher['.$i.']', ['' => '選択してください']+array_pluck($teacher,'name','id'),old('teacher.'.$i,$class[$i]['teacher_id'])) !!}
                {!! Form::label('teacher', '教師')!!}
            </div>
        @endfor
    </div>
    <div class="center">
        <button class="btn waves-effect" id="del" type="button"><i class="material-icons right">delete</i>クラス削除</button>
        <button class="btn waves-effect" id="add" type="button"><i class="material-icons right">add</i>クラス追加</button>
        <button class="btn waves-effect" type="submit" name="action"><i class="material-icons right">send</i>設定</button>
    </div>
    {!! Form::close() !!}
@endsection