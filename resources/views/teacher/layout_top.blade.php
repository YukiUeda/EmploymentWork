@extends('htmlTemplate')
@section('title')
    教員
@endsection
@section('css')
    <link  type="text/css" rel="stylesheet" href="{{{'/css/layout.css'}}}">
    <link  type="text/css" rel="stylesheet" href="{{{'/css/fullcalendar.min.css'}}}">
    <link  type="text/css" rel="stylesheet" href="{{{'/css/teacher.css'}}}">
    @yield('top_css')
@endsection
@section('js')
    @yield('top_js')
    <script type="text/javascript" src="{{{'/js/teacher.js'}}}"></script>

@endsection
@section('main')

    <div class="navbar-fixed">
        <nav class="nav-extended">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">教員</a>
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right">
                    <li class='dropdown-button' data-activates='dropdown1'><a><i class="material-icons">account_circle</i></a></li>
                </ul>
                <ul id='dropdown1' class='dropdown-content'>
                    <li><p>{{Auth::user()->name}}</p></li>
                    <li><a href="/teacher/logout">ログアウト</a></li>
                    <li><a href="/teacher/delete">全てのカリキュラム削除</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <aside>
        <ul id="slide-out" class="side-nav fixed">
            <li><a href="/teacher/top"><i class="material-icons">home</i>TOP</a></li>
            <li><a href="/teacher/curriculum"><i class="material-icons">book</i>カリキュラム</a></li>
        </ul>
    </aside>

    <main>
        @yield('content')
    </main>
@endsection
