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
    {!! Form::open(['url' => 'school/objective/check']) !!}
    {!! Form::hidden('year',$year) !!}
    {!! Form::hidden('grade',$grade) !!}
    {!! Form::hidden('subject',$subject) !!}
    <div class="row">
        <div class="input-field col s12">
            {!! Form::label('objective', '目標')!!}
            {!! Form::text('',null,['id'=>'autocomplete-input','class'=>'autocomplete','autocomplete'=>'off']) !!}
        </div>
        <div class="input-field col s12 center">
            @for($i=1;$i <= Auth::user()->semester;$i++)
                <button class="btn waves-effect" id="objective{{$i}}" type="button" data-semester="{{$i}}"><i class="material-icons right">add</i>{{$i}}学期追加</button>
            @endfor
        </div>

        @for($i=1;$i <= Auth::user()->semester;$i++)
            <div class="col s12">
                <label>{{$i}}学期の目標</label>
                <div class="col s12" id="input_objective{{$i}}">
                    @if(isset($objective[$i]))
                        @for($j=0;$j < count($objective[$i]);$j++)
                            <div class="chip">
                                {{$objective[$i][$j]}}
                                <i class="close material-icons">close</i>
                                {!! Form::hidden('objective['.$i.']['.$j.']',$objective[$i][$j]) !!}
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
        @endfor
    </div>
    <div class="input-field col s12 center">
        <button class="btn waves-effect" type="submit" name="action"><i class="material-icons right">send</i>設定</button>
    </div>
    {!! Form::close() !!}
@endsection