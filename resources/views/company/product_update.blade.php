@extends('company.layout')

@section('layout_css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropper/1.0.0/cropper.min.css" rel="stylesheet" type="text/css" media="all"/>
@endsection

@section('layout_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropper/1.0.0/cropper.min.js"></script>
@endsection

@section('content')
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
    <div id="from" class="col s12">
        {!! Form::open(['url' => 'company\product\create','enctype'=>'multipart/form-data']) !!}
        {!! Form::hidden('x',null,['id'=>'upload-image-x']) !!}
        {!! Form::hidden('y',null,['id'=>'upload-image-y']) !!}
        {!! Form::hidden('w',null,['id'=>'upload-image-w']) !!}
        {!! Form::hidden('h',null,['id'=>'upload-image-h']) !!}
         <div class="input-field">
             {!! Form::label('product', '商品名') !!}
             {!! Form::text('name', null,['class'=>'validate']) !!}
            </div>
        <div class="input-field">
            {!! Form::label('url', '商品URL') !!}
            {!! Form::url('url', null,['class'=>'validate']) !!}
        </div>
        <div class="input-field">
            {!! Form::label('price', '価格') !!}
            {!! Form::number('price',null ,['class'=>'validate']) !!}
        </div>
        <div class="input-field">
            {!! Form::label('clickPrice', '1クリック単価') !!}
            {!! Form::number('click_price',null ,['class'=>'validate']) !!}
        </div>
        <div class="file-field input-field">
            <a class="waves-effect waves-light btn modal-trigger" href="#modal1">サイズ変更</a>
            <div class="btn">
                <span>File</span>
                {!! Form::file('image',['class'=>'validate','id'=>'profile-image']) !!}
            </div>
            <div class="file-path-wrapper">
                {!! Form::text('path', null,['class'=>'file-path validate']) !!}
            </div>
        </div>
        <div class="input-field">
            {!! Form::submit('商品登録',['class'=>'mdl-button mdl-js-button mdl-button--raised submit']) !!}
        </div>
        {!! Form::close() !!}
    </div>
    <div class="cropper-example-1">
        <div id="modal1" class="modal modal-fixed-footer">
            <div class="modal-content">
                <img id="img" style="max-height: 500px;" class="img-responsive" alt="">
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat">Agree</a>
            </div>
        </div>
    </div>
@endsection