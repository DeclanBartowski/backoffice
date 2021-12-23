<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>{!! SEOMeta::getTitle() !!}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="{{asset('css/app.min.css')}}">
    <meta name="theme-color" content="#464A53">
</head>
<body>

<header class="header">
    <div class="header-top">
        <div class="container">
            <div class="mobile-menu-btn"></div>
            <a href="/" class="logo">backoffice</a>
            @include('partial.menu_account')
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            @include('partial.menu')
        </div>
    </div>
</header>
<div class="navigation">
    <div class="container">
        <h4>{!! SEOMeta::getTitle() !!}</h4>
        @yield('btn')
    </div>
</div>
<main class="main">
    <div class="container">
        <div class="content-scroll-wrapper">
            @yield('content')
        </div>
    </div>
</main>




<div class="notification" id="remove-notification" style="background-color: #FF0000;">
    Удалено
</div>
<div class="notification" id="save-notification" style="background-color: #7DC970;">
    Сохранено
</div>
<div class="notification" id="save-draft-notification" style="background-color: #F3AF00;">
    Сохранено как черновик
</div>
<div class="notification" id="published-notification" style="background-color: #7F63F4;">
    Опубликовано
</div>
<div class="notification" id="tq-error" style="background-color: #FF0000;">

</div>

<script src="{{asset('libs/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('libs/fancybox-master/dist/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('libs/tablesorter/jquery.tablesorter.min.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>

<script src="{{asset('js/custom.js')}}"></script>


@yield('notification')
@yield('cke')
<style>
    .active.btn-sort::before{
        color: black;
    }
</style>
</body>
</html>
