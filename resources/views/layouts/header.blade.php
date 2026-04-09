<div class="pretop-screen">
    <div class="pretop-screen__cg">
        <img src="/img/logo2.png" alt="Capital Group" />
    </div>
    <div class="pretop-screen__logo">
        <div class="pretop-screen__img">
            <img src="/img/logo.svg" alt="Медный 3.14" />
        </div>
    </div>
    <div class="pretop-screen__scroll"></div>
</div>
<header class="page-header page-header--inner">
    <div class="page-header__inner">
        <div class="page-header__left">
            <div class="page-header__logo">
                <a href="/"><img src="/img/logo-small.svg" alt="logo" /></a>
            </div>
            @include('layouts.header_menu')
        </div>
        <div class="page-header__contacts">

            <div class="page-header__keynote-desktop">
                <a class="page-header__keynote" href="{{ $documentsLink }}">
                    <div class="page-header__keynote-icon">
                        <img src="/img/docs-icon.svg" alt="Документы" />
                    </div>
                    <div class="page-header__keynote-title">Документы</div>
                </a>
                <a class="page-header__keynote" target="_blank"  href="{{ $presentationLink }}">
                    <div class="page-header__keynote-icon">
                        <img src="/img/keynote-icon.svg" alt="Презентация" />
                    </div>
                    <div class="page-header__keynote-title">Презентация</div>
                </a>
            </div>

            <div class="page-header__phone">
                <a class="page-header__phone-link" href="tel:{{ $companyPhoneTag }}" style="display: block; height: 100%; width: 100%;">
                    <span>{{ $companyPhone }}</span>
                </a>
            </div>

            <div class="page-header__view">
                <a class="scrollTo" href="#contacts">
                    <img src="/img/view.svg" alt="Заказать звонок" />
                </a>
            </div>

            <div class="page-header__button">
                <a class="btn btn--line-inner rg-trigger scrollTo" data-modal="default-modal" href="#contacts">
                    Заказать звонок
                </a>
            </div>
        </div>
        <div class="page-header__mobile-menu">
            @include('layouts.header_menu_mobile')
            <div class="page-header__keynote-tablet">
                <a class="page-header__keynote" href="{{ $documentsLink }}">
                    <div class="page-header__keynote-icon">
                        <img src="/img/docs-icon.svg" alt="Документы" />
                    </div>
                    <div class="page-header__keynote-title">Документы</div>
                </a>
                <a class="page-header__keynote" href="{{ $presentationLink }}">
                    <div class="page-header__keynote-icon">
                        <img src="/img/keynote-icon.svg" alt="Презентация" />
                    </div>
                    <div class="page-header__keynote-title">Презентация</div>
                </a>

            </div>
        </div>
    </div>
</header>