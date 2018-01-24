@extends('teacher.layout_top')

@section('top_css')

@endsection
@section('top_js')

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
    <p data-max="{{$curriculum->time}}">必要時間{{$curriculum->time}}分</p>
    <p data-total="0" class="total">合計時間0分</p>
    <div class="row form">
        {!! Form::open(['url' => Request::url(),'class'=>'submit']) !!}
            <div class="clone">
                <div class="input-field col s12">
                    {!! Form::label('date', '実施日')!!}
                    {!! Form::text('date[]', null,['class'=>'datepicker mdl-textfield__input date_input date']) !!}
                </div>
                <div class="input-field col s12" data-time="{{json_encode(array_pluck($times,'time'))}}">
                    {{Debugbar::addMessage(json_encode(array_pluck($times,'time')))}}
                    {!! Form::select('time[]',['0' => '選択してください']+array_pluck($times,'timetable','timetable'),null,['class','time']) !!}
                    {!! Form::label('time', '実施時間')!!}
                </div>
            </div>

            <div class="group">

            </div>
            <button type="submit" class="submit">決定</button>
        {!! Form::close() !!}
    </div>
@endsection