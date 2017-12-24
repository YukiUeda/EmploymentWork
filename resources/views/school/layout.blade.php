@extends('htmlTemplate')
@section('title')
    学校
@endsection
@section('css')
    <link href="{{{'/css/school.css'}}}" rel="stylesheet">
    @yield('layout_css')
@endsection
@section('js')
    <script type="text/javascript"  src="{{{'/js/school.js'}}}"></script>
    @yield('layout_js')
@endsection
@section('main')

    <div class="navbar-fixed">
        <nav class="nav-extended">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">Logo</a>
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right">
                    <li class='dropdown-button' data-activates='dropdown1'><a><i class="material-icons">account_circle</i></a></li>
                </ul>
                <ul id='dropdown1' class='dropdown-content'>
                    <li><p>{{$name}}</p></li>
                    <li><a href="/school/logout">ログアウト</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <aside>
        <ul id="slide-out" class="side-nav fixed">
            <li><a href="/school/top"><i class="material-icons">home</i>TOP</a></li>
            <li><a href="/school/classworkTimer"><i class="material-icons">date_range</i>時間設定</a></li>
            <li><a href="/school/class/grade"><i class="material-icons">supervisor_account</i>クラス設定</a></li>
            <li><a href="/school/objective/choice"><i class="material-icons">supervisor_account</i>学年 科目別目標</a></li>
            <li><a href="/school/classworkTimer"><i class="material-icons">school</i>時間割設定</a></li>
            <li><a href="/school/create/code"><i class="material-icons">supervisor_account</i>コード生成</a></li>
        </ul>
    </aside>
    <main>
        @yield('content')
    </main>
@endsection
