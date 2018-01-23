@extends('school.layout')

@section('layout_js')
    <script type="text/javascript"  src="{{{'/js/school/weekday.js'}}}"></script>
@endsection


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
    {!! Form::open(['url' => 'school/class/weekday/save']) !!}
        <div class="row">
            {!! Form::hidden('year','0',['id'=>'year']) !!}
            <div class="input-field col s12">
                {!! Form::select('class',  ['' => '選択してください']+array_pluck($class,'class_name','id'),null,['id'=>'class'])!!}
                {!! Form::label('class', 'クラス') !!}
            </div>
            <div class="input-field col s12">
                {!! Form::select('week', ['' => '選択してください']+Config::get('const.weekday'),null,['id'=>'week','disabled'])!!}
                {!! Form::label('week', '曜日') !!}
            </div>
            <div class="input-field col s12">
                {!! Form::select('timetable', ['' => '選択してください']+array_pluck($timetable,'time_table','id'),null,['id'=>'timetable','disabled'])!!}
                {!! Form::label('subject', '何限目まで？') !!}
            </div>
            @for($i=1;$i<=count($timetable);$i++)
                <div class="input-field col s12">
                    {!! Form::select('subject[]', ['' => '選択してください']+Config::get('const.curriculum'),null,['class'=>'subject','disabled'])!!}
                    {!! Form::label('subject', $i.'限目') !!}
                </div>
            @endfor
        </div>
        <div class="center">
            <button class="btn waves-effect" type="submit" name="action"><i class="material-icons right">send</i>設定</button>
        </div>
    {!! Form::close() !!}
@endsection