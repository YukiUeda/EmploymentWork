@extends('htmlTemplate')
@section('title')
    会社
@endsection
@section('css')
    <link href="{{{'/css/company.css'}}}" rel="stylesheet">
    @yield('layout_css')
@endsection
@section('js')
    <script>
        $(function () {
            $('.button-collapse').sideNav();
        });
    </script>
    @yield('layout_js')
@endsection
@section('main')

    <div class="navbar-fixed">
        <nav class="nav-extended">
            <div class="nav-wrapper">
                <a href="#" class="brand-logo">会社</a>
                <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul id="nav-mobile" class="right">
                    <li class='dropdown-button' data-activates='dropdown1'><a><i class="material-icons">account_circle</i></a></li>
                </ul>
                <ul id='dropdown1' class='dropdown-content'>
                    <li><p>{{Auth::user()->name}}</p></li>
                    <li><a href="/company/logout">ログアウト</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <aside>
        <ul id="slide-out" class="side-nav fixed">
            <li><a href="/company/top"><i class="material-icons">home</i>TOP</a></li>
            <li><a href="/company/product"><i class="material-icons">date_range</i>商品一覧</a></li>
            <li><a href="/company/product/create"><i class="material-icons">supervisor_account</i>商品追加</a></li>
            <li><a href="/company/product/plugin/create"><i class="material-icons">supervisor_account</i>プラグイン商品追加</a></li>

        </ul>
    </aside>
    <main class="row">
        @yield('content')
    </main>
@endsection
