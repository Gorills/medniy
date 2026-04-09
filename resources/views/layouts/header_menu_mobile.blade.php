<div class="mobile-menu">
    <div class="mobile-menu__toggle">
        <div class="mobile-menu__toggle-icon menu-toggle" id="menuToggle">
            <div class="burger-icon"></div>
            <div class="mobile-menu__toggle-title">Меню</div>
        </div>
    </div>
    <ul class="mobile-menu__list">
        @foreach($menuItems as $item)
            <li class="mobile-menu__list-item @if(Request::path() == trim($item['link'], '/')) is-active @endif">
                <a class="mobile-menu__list-link" href="{{ $item['link'] }}">{{ $item['name'] }}</a>
            </li>
        @endforeach

        <li class="mobile-menu__list-item mobile-menu__keynote">
            <a class="keynote-button" target="_blank"  href="{{ $presentationLink }}">
                <div class="keynote-button__icon">
                    <img src="/img/keynote-icon.svg" alt="Презентация" />
                </div>
                <div class="keynote-button__title">Презентация</div>
            </a>
        </li>
    </ul>
</div>
