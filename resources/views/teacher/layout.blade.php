@extends('htmlTemplate')
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
                <a href="#" class="brand-logo">Logo</a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <li><a href="collapsible.html"><i class="material-icons">account_circle</i></a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="sass.html">Sass</a></li>
                    <li><a href="badges.html">Components</a></li>
                    <li><a href="collapsible.html">JavaScript</a></li>
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
