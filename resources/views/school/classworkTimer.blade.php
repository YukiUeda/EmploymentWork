@extends('school.layout')
@section('content')
    {!! Form::open(['url' => 'school/classworkTimer']) !!}
    <div class="row">
        <?php $i = 1 ?>
        @foreach($table as $lesson)
            <div class="col s6">
                {!! Form::label('lesson'.$i.'_str', $i.'時間目開始') !!}
                {!! Form::text('lesson'.$i.'_str', $lesson['start'],['class'=>'timepicker']) !!}
            </div>
            <div class=" col s6">
                {!! Form::label('lesson'.$i.'_end', $i.'時間目終了') !!}
                {!! Form::text('lesson'.$i.'_end', $lesson['end'],['class'=>'timepicker']) !!}
            </div>
            <?php $i++ ?>
        @endforeach
        @for(;$i<7;$i++)
            <div class="col s6">
                {!! Form::label('lesson'.$i.'_str', $i.'時間目開始') !!}
                {!! Form::text('lesson'.$i.'_str', null,['class'=>'timepicker']) !!}
            </div>
            <div class=" col s6">
                {!! Form::label('lesson'.$i.'_end', $i.'時間目終了') !!}
                {!! Form::text('lesson'.$i.'_end', null,['class'=>'timepicker']) !!}
            </div>
        @endfor
    </div>
    <button class="btn waves-effect" type="submit" name="action"><i class="material-icons right">send</i>設定</button>
    {!! Form::close() !!}
@endsection