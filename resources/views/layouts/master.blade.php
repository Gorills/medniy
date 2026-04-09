<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>
        Медный 3.14
    </title>
    <meta name="keywords" content="жк медный 3.14, москва, донская улица 14, жилой комплекс, капитал групп, capital group, новостройка, донской район">
    <meta name="description" content="Официальный сайт жилого комплекса премиум-класса Медный 3.14 на Донской, 14. Квартиры с 1, 2, 3-я спальнями площадью от 41 до 130 кв.м рядом с парком Горького, м Шаболовская.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" href="/img/favicon/favicon.png">
    <link rel="shortcut icon" href="/img/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/img/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <meta name="yandex-verification" content="a155f2ca4661d3d3" />
    <meta name="google-site-verification" content="ZjVSqF23rekakEVkNNi0ps_7fSk3K7Y7oLG6UaebC5E">
    <link rel="stylesheet" href="/css/style.css">
    <script>
        var __cs = __cs || [];
        __cs.push(["setCsAccount", "{{ $comagicSiteID }}"]);
    </script>
    <script async src="//app.comagic.ru/static/cs.min.js"></script>
    @stack('header_scripts')
</head>
<body class="page-loading page-front is-header-online-bar">
@include('layout_inner.metrics')
<div class="l-wrapper">
    <a href="https://online.capitalgroup.ru/" class="header-online-bar" target="_blank">
      <div class="header-online-bar__title">
        Узнай как купить квартиру онлайн
      </div>
      <svg xmlns="http://www.w3.org/2000/svg" width="23.5" height="5">
        <path fill="none" stroke="#fff" d="M0 2.5h20"/>
        <path d="M23.5 2.5l-4 2.5V0z" fill="#fff"/>
      </svg>
    </a>
    <div class="page-overlay js-menuClose"></div>
    <div class="l-content">
        @include('layouts.header')
        @yield('content')
    </div>
</div>
<script src="/js/app.js"></script>
<script src="/js/custom.js"></script>
@stack('footer_scripts')
@yield('footer_current_page_metrics', '')
</body>
</html>
