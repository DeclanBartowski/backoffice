<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Верстка</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
    <meta name="theme-color" content="#000">
</head>

<body class="authorization-page">
@yield('content')
@include('partial.copyright')
<script src="{{asset('js/app.min.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
@yield('notification')
</body>
</html>
