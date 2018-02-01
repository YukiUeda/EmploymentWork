@extends('htmlTemplate')
@section('title')
    教員
@endsection
@section('css')
    <link  type="text/css" rel="stylesheet" href="{{{'/css/teacherHeader.css'}}}">
    <link  type="text/css" rel="stylesheet" href="{{{'/css/fullcalendar.min.css'}}}">
@endsection
@section('js')
    <script type="text/javascript" src="{{{'/js/moment.min.js'}}}"></script>
    <script type="text/javascript" src="{{{'/js/fullcalendar.min.js'}}}"></script>
    <script>
        $(function(){
            $(".button-collapse").sideNav();
        });
        $(document).ready(function(){
            $('ul.tabs').tabs();
        });

    </script>
@endsection
@section('main')

    <div class="navbar-fixed">
        <nav class="nav-extended">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">教員</a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right">
                    <li class='dropdown-button' data-activates='dropdown1'><a><i class="material-icons">account_circle</i></a></li>
                </ul>
                <ul id='dropdown1' class='dropdown-content'>
                    <li><p>{{Auth::user()->name}}</p></li>
                    <li><a href="/teacher/logout">ログアウト</a></li>
                    <li><a href="/teacher/delete">全てのカリキュラム削除</a></li>
                </ul>

            </div>
            <div class="nav-content">
                <ul class="tabs tabs-transparent col s12">
                    @foreach(Config::get('const.curriculum') as $key=>$curriculum )
                        <li class="tab col s1"><a href="#curriculum{{$key}}">{{$curriculum}}</a></li>
                    @endforeach
                </ul>
            </div>
        </nav>
    </div>
    <main>
        @yield('content')
    </main>

    <aside>
        <ul class="side-nav fixed">
            <li><a href="/teacher/top"><i class="material-icons">home</i>TOP</a></li>
            <li><a href="/teacher/curriculum"><i class="material-icons">book</i>カリキュラム</a></li>
        </ul>
    </aside>
@endsection
