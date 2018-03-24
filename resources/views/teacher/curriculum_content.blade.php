@extends('teacher.layout_top')

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

            @isset($product)
                <div id="product">
                    <h3 class="col s12">使用教材</h3>
                    <div class="col s1"></div>

                    <div class="col s10 card-panel">
                        <a class="col s12" href="/teacher/click/{{$curriculum->id}}/">
                            <img class="col s4" src="{{{$product->image}}}">
                            <p class="col s7">{{$product->name}}</p>
                        </a>
                    </div>
                    <div class="col s1"></div>
                </div>
            @endisset


            <div id="padding" class="col s12">
                @isset($flg['0'])
                    <div class="stars col s12" data-stars="1">
                        @for($i=1;$i<=5;$i++)
                            @isset($flg[0])
                                @if($i<=$flg[0]->ecaluation)
                                    <svg height="25" fill="#ffd055" width="23" class="star rating" data-rating="{{$i}}">
                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                    </svg>
                                @else
                                    <svg height="25" fill="#d8d8d8" width="23" class="star rating" data-rating="{{$i}}">
                                        <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                    </svg>
                                @endif
                            @else
                                <svg height="25" fill="#ffd055" width="23" class="star rating" data-rating="{{$i}}">
                                    <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                </svg>
                            @endisset
                        @endfor
                    </div>
                    <div class="col s12">
                        {!! Form::open(['url'=>Request::url().'/comment']) !!}
                        <div class="input-field">
                            {!! Form::number('evaluation',isset($flg[0]->ecaluation)? $flg[0]->ecaluation : 5,['style'=>'display:none','id'=>'evaluation']) !!}
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">comment</i>
                            {!! Form::textarea('comment',isset($flg[0]->comment)? $flg[0]->comment : null, ['class' => 'materialize-textarea']) !!}
                            {!! Form::label('comment', 'コメント') !!}
                        </div>
                        <div class="center">
                            <button class="btn waves-effect"  type="submit">コメントを投稿</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                @else
                    <div class="col s12">
                        <form action="{{Request::url()}}/add">
                            <div class="center">
                                <button class="btn waves-effect center"  type="submit">カリキュラムを追加</button>
                            </div>
                        </form>
                    </div>
                @endisset
            </div>


            @isset($comments[0])
                <div class="border col s12"></div>
                <h3 class="col s12">コメント</h3>
                @foreach($comments as $comment)
                    <div class="col s12">
                        <div class="card-panel white col s12">
                            <div class="comment">
                                <div class="col s12 evaluation">
                                    @for($i=1;$i<=5;$i++)
                                        @if($i<=$comment->ecaluation)
                                            <svg height="25" fill="#ffd055" width="23">
                                                <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                            </svg>
                                        @else
                                            <svg height="25" fill="#d8d8d8" width="23">
                                                <polygon points="9.9, 1.1, 3.3, 21.78, 19.8, 8.58, 0, 8.58, 16.5, 21.78" style="fill-rule:nonzero;"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <span>{{$comment->comment}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col s12">
                    {{ $comments->links('vendor.pagination.foundation') }}
                </div>
            @endisset
        </div>
    </div>
@endsection