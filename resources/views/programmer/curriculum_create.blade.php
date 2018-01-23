@extends('programmer.layout')

@section('layout_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropper/1.0.0/cropper.min.css" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('layout_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/1.0.0/cropper.min.js"></script>
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

    <div class="input-field col s12">
        {!! Form::label('objective', '目標')!!}
        {!! Form::text('',null,['id'=>'autocomplete-input','class'=>'autocomplete','autocomplete'=>'off']) !!}
    </div>
    <button type="button" class="btn waves-effect" id="objective">目標追加</button>

    {!! Form::open(['url' => 'programmer/product/'.$product->id.'/create' ,'enctype'=>'multipart/form-data']) !!}
    <div class="input-field col s6">
        {!! Form::label('title', 'タイトル') !!}
        {!! Form::text('title', null,['class'=>'validate']) !!}
    </div>
    <div class="input-field col s6">
        {!! Form::label('time', '使用時間') !!}
        {!! Form::number('time', null,['class'=>'validate']) !!}
    </div>
    <div class="input-field col s6">
        {!! Form::select('grade', [''=>'選択してください','1'=>'１年','2'=>'2年','3'=>'3年','4'=>'4年','5'=>'5年','6'=>'6年']) !!}
        {!! Form::label('grade', '学年') !!}
    </div>
    <div class="input-field col s6">
        {!! Form::select('subject', ['' => '選択してください']+Config::get('const.curriculum','id')) !!}
        {!! Form::label('subject', '科目名')!!}
    </div>
    <div class="text_area">
        <div class="input-field col s6">
            {!! Form::label('description', '説明文') !!}
            {!! Form::textarea('description', null,['class'=>'validate']) !!}
        </div>

        <div class="file-field input-field col s6">
            <div class="btn">
                <a class="waves-effect waves-light btn modal-trigger" href="#modal0">サイズ変更</a>
                <div class="cropper-example-1">
                    <div id="modal0" class="modal modal-fixed-footer">
                        <div class="modal-content">
                            {!! Form::hidden('x[]',null,['id'=>'upload-image-x-0']) !!}
                            {!! Form::hidden('y[]',null,['id'=>'upload-image-y-0']) !!}
                            {!! Form::hidden('w[]',null,['id'=>'upload-image-w-0']) !!}
                            {!! Form::hidden('h[]',null,['id'=>'upload-image-h-0']) !!}
                            <img id="img0" style="max-height: 500px;" class="img-responsive" alt="">
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                        </div>
                    </div>
                </div>
                <span>コンテンツ画像</span>
                {!! Form::file('image',['class'=>'validate','id'=>'profile-image','data-img'=>'0']) !!}
            </div>
            <div class="file-path-wrapper">
                {!! Form::text('path', null,['class'=>'file-path validate']) !!}
            </div>
        </div>

    </div>
    <div id="input_objective">

    </div>
    <h2>コンテンツ説明</h2>
    <div class="text_area content">
        <div class="input-field col s6">
            {!! Form::label('contents', 'コンテンツ') !!}
            {!! Form::textarea('contents[]', null,['class'=>'validate']) !!}
        </div>
        <div class="file-field input-field col s6">
            <div class="btn">
                <a class="waves-effect waves-light btn modal-trigger" href="#modal1">サイズ変更</a>
                <div class="cropper-example-1">
                    <div id="modal1" class="modal modal-fixed-footer">
                        <div class="modal-content">
                            {!! Form::hidden('x[]',null,['id'=>'upload-image-x-1']) !!}
                            {!! Form::hidden('y[]',null,['id'=>'upload-image-y-1']) !!}
                            {!! Form::hidden('w[]',null,['id'=>'upload-image-w-1']) !!}
                            {!! Form::hidden('h[]',null,['id'=>'upload-image-h-1']) !!}
                            <img id="img1" style="max-height: 500px;" class="img-responsive" alt="">
                        </div>
                        <div class="modal-footer">
                            <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
                        </div>
                    </div>
                </div>
                <span>コンテンツ画像</span>
                {!! Form::file('images[]',['class'=>'validate','id'=>'profile-image','data-img'=>'1']) !!}
            </div>
            <div class="file-path-wrapper">
                {!! Form::text('path', null,['class'=>'file-path validate']) !!}
            </div>
        </div>
    </div>
    <div class="form text_area">

    </div>
    <div class="input-field col s12">
        <button type="button" id="add">追加</button>
        {!! Form::submit('コンテンツ追加',['class'=>'mdl-button mdl-js-button mdl-button--raised']) !!}
    </div>
    {!! Form::close() !!}
@endsection