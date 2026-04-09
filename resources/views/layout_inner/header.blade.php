<header class="page-header page-header--inner">
    <div class="page-header__inner">
        <div class="page-header__left">
            <a class="page-header__logo" href="/">
                <img src="/img/logo-small.svg" alt="alt" />
            </a>
            <ul class="page-header__menu">
                @foreach($menuItems as $item)
                    <li class="page-header__menu-item @if(Request::path() == trim($item['link'], '/')) is-active @endif">
                        <a class="page-header__menu-link" href="{{ $item['link'] }}">
                            {{ $item['name'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="page-header__contacts">
            <div class="page-header__keynote-desktop">
                <a class="page-header__keynote" href="{{ $documentsLink }}">
                    <div class="page-header__keynote-icon">
                        <img src="/img/docs-icon.svg" alt="Документы" />
                    </div>
                    <div class="page-header__keynote-title">
                        Документы
                    </div>
                </a>
                <a class="page-header__keynote" target="_blank" href="{{ $presentationLink }}">
                    <div class="page-header__keynote-icon">
                        <img src="/img/keynote-icon.svg" alt="Презентация" />
                    </div>
                    <div class="page-header__keynote-title">
                        Презентация
                    </div>
                </a>
            </div>
            <div class="page-header__phone">
                <a class="page-header__phone-link" href="tel:{{ $companyPhoneTag }}" style="display: block; height: 100%; width: 100%;">
                    <span>{{ $companyPhone }}</span>
                </a>
            </div>
            <div class="page-header__view rg-trigger" data-modal="default-modal">
                <img src="/img/view.svg" alt="Заказать звонок" />
            </div>
            <div class="page-header__button">
                <div class="btn btn--line-inner rg-trigger" data-modal="default-modal">
                    Заказать звонок
                </div>
            </div>
        </div>
        <div class="page-header__mobile-menu">
            <div class="mobile-menu">
                <div class="mobile-menu__toggle">
                    <div class="mobile-menu__toggle-icon menu-toggle" id="menuToggle">
                        <div class="burger-icon"></div>
                        <div class="mobile-menu__toggle-title">
                            Меню
                        </div>
                    </div>
                </div>
                <ul class="mobile-menu__list">
                    @foreach($menuItems as $item)
                        <li class="mobile-menu__list-item @if(Request::path() == trim($item['link'], '/')) is-active @endif">
                            <a class="mobile-menu__list-link" href="{{ $item['link'] }}">
                                {{ $item['name'] }}
                            </a>
                        </li>
                    @endforeach
                    <li class="mobile-menu__list-item mobile-menu__keynote">
                        <a class="keynote-button" href="{{ $documentsLink }}">
                            <div class="keynote-button__icon">
                                <img src="/img/docs-icon.svg" alt="Документы" />
                            </div>
                            <div class="keynote-button__title">
                                Документы
                            </div>
                        </a>
                        <a class="keynote-button" target="_blank"  href="{{ $presentationLink }}">
                            <div class="keynote-button__icon">
                                <img src="/img/keynote-icon.svg" alt="Презентация" />
                            </div>
                            <div class="keynote-button__title">
                                Презентация
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="page-header__keynote-tablet">
                <a class="page-header__keynote" href="{{ $documentsLink }}">
                    <div class="page-header__keynote-icon">
                        <img src="/img/docs-icon.svg" alt="Документы" />
                    </div>
                    <div class="page-header__keynote-title">
                        Документы
                    </div>
                </a>
                <a class="page-header__keynote" target="_blank" href="{{ $presentationLink }}">
                    <div class="page-header__keynote-icon">
                        <img src="/img/keynote-icon.svg" alt="Презентация" />
                    </div>
                    <div class="page-header__keynote-title">
                        Презентация
                    </div>
                </a>
            </div>
        </div>
    </div>
</header>
