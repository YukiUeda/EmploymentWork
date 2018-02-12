@extends('company.layout')

@section('content')
    <div class="row">
        <div class="border col s12">
            <h2 class="col s10">{{$curriculum->title}}</h2>
            <div class="col s2"><p class="col s2">作業時間{{$curriculum->time}}分</p></div>
        </div>

        <div id="curriculum" class="col s12">
            <div id="main" class="col s12">
                <img class="col s6" src="{{{$curriculum->curriculum_image}}}">
                <div class="col s6">
                    <div class="card-panel col s12">
                        <h3>カリキュラム概要</h3>
                        <p>{{$curriculum->description}}</p>
                    </div>
                </div>
            </div>
            <div class="chips col s12">
                @foreach($objects as $object)
                    <div class="chip">
                        {{$object->name}}
                    </div>
                @endforeach
            </div>

            <div id="content">
                <h3>作業手順</h3>
                @foreach($contents as $content)
                    <div class="col s1 right-align bold">{{$loop->iteration}}</div>
                    <div class="col s11 card-panel">
                        <img class="col s4" src="{{{$content->image}}}">
                        <p  class="col s8">{{$content->contents}}</p>
                    </div>
                @endforeach
                <div class="border col s12"></div>
            </div>

            @if(isset($product))
                <div id="product">
                    <h3 class="col s12">使用教材</h3>
                    <div class="col s1"></div>

                    <div class="col s10 card-panel">
                        <a class="col s12" href="{{$product->url}}">
                            <img class="col s4" src="{{{$product->image}}}">
                            <p class="col s7">{{$product->name}}</p>
                        </a>
                    </div>
                    <div class="col s1"></div>
                </div>
            @endif


            <div class="fixed-action-btn">
                @if($curriculum->auth == 0)
                    <a href="/company/curriculum/{{$curriculum->id}}/auth" class="btn-floating btn-large waves-effect waves-light green">承認</a>
                @else
                    <a href="/company/curriculum/{{$curriculum->id}}/auth" class="btn-floating btn-large waves-effect waves-light red">未承認</a>
                @endif
            </div>

        </div>
    </div>
@endsection