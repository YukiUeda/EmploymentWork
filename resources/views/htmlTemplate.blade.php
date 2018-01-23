<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--js-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{{'/js/materialize.min.js'}}}"></script>
    @yield('js')

    <!--css-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{{'/css/materialize.min.css'}}}"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="{{{'/css/layout.css'}}}"  media="screen,projection"/>
    @yield('css')

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title')</title>
</head>
<body>
    @yield('main')
</body>
</html>
