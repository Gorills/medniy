<ul class="page-header__menu">
    @foreach($menuItems as $item)
        <li class="page-header__menu-item @if(Request::path() == trim($item['link'], '/')) is-active @endif">
            <a class="page-header__menu-link" href="{{ $item['link'] }}">
                {{ $item['name'] }}
            </a>
        </li>
    @endforeach
</ul>