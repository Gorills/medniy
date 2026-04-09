<nav class="top-screen__nav">
    <ul class="top-screen__menu">
        @foreach($menuItems as $item)
            <li class="top-screen__menu-item">
                <a class="top-screen__menu-link" href="{{ $item['link'] }}">
                   {{ $item['name'] }}
                </a>
            </li>
        @endforeach
    </ul>
    <div class="top-screen__contacts">
        <a class="top-screen__phone" href="tel:{{ $companyPhoneTag }}">
            <span class="top-screen__phone-number">
                {{ $companyPhone }}
            </span>
        </a>
        <div class="top-screen__btn">
            <a class="btn btn--white scrollTo" href="#contacts">
                Заказать звонок
            </a>
        </div>
    </div>
</nav>