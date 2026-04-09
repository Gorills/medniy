<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <title>
        {{ isset($pageTitle) ?  $pageTitle : 'Медный 3.14' }}
    </title>
    <meta name="keywords" content="{{ isset($pageKeywords) ?  $pageKeywords : '' }}">
    <meta name="description" content="{{ isset($pageDescription) ?  $pageDescription : '' }}">

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
<body class="page- is-header-online-bar">
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
    @include('layout_inner.header')
    <div class="l-content">
        @yield('content')
    </div>
    @include('layout_inner.footer')
    <div class="rg-modal">
        <div class="rg-modal__overlay"></div>
        <div class="rg-modal__modal" id="default-modal">
            <div class="rg-modal__close rg-close">
                <svg class="icon icon-close ">
                    <use xlink:href="/img/sprite.svg#close"></use>
                </svg>
            </div>
            <div class="rg-modal__content contact-form__inner contact-form__inner--default is-visible">
                <form class="modal-form" action="#" method="method" name="showroom">
                    <div class="modal-form__row">
                        <div class="form-group">
                            <input type="text" placeholder="Ваше имя" required="required">
                        </div>
                        <div class="form-group">
                            <input type="tel" placeholder="Телефон" required="required">
                        </div>
                    </div>
                    <div class="modal-form__button">
                        <button class="btn btn--line-inner">Забронировать</button>
                    </div>
                    <div class="modal-form__note">Нажимая кнопку «Отправить заявку» вы соглашаетесь с
                        <a target="_blank" href="{{ $comagicPersonalDataLink }}">условиями передачи персональных данных</a>
                    </div>
                </form>
            </div>
            <!-- Success state-->
            <div class="contact-form__inner contact-form__inner--success">
                <div class="contact-form__title contact-form__title--compact">Заявка отправлена</div>
                <div class="contact-form__message contact-form__message--compact">Спасибо! Наш менеджер свяжется с&nbsp;вами для более подробной информации.</div>
                <div class="contact-form__info">© 2020. Информация на сайте не является публичной офертой.</div>
            </div>
            <!-- Error state-->
            <div class="contact-form__inner contact-form__inner--error">
                <div class="contact-form__title contact-form__title--compact">Что-то пошло не так</div>
                <div class="contact-form__message contact-form__message--compact">Нам очень жаль, но произошла непредвиденная ошибка. Попробуйте отправить заявку еще раз.</div>
                <div class="contact-form__button">
                    <div class="btn btn--green js-try-again">Попробовать снова</div>
                </div>
                <div class="contact-form__info">© 2020. Информация на сайте не является публичной офертой.</div>
            </div>
        </div>
    </div>
</div>
<script src="/js/app.js"></script>
<script src="/js/custom.js"></script>
@stack('footer_scripts')
@yield('footer_current_page_metrics', '')
</body>
</html>
