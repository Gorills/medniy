<div class="l-content">
    <link rel="stylesheet" href="/style.css">
    <div class="styles inner-page">
        <div class="inner-page__inner">
            <div class="inner-page__top">
                <div class="inner-title inner-title--nomargin inner-title--bg">
                    <div class="inner-title__back">
                        <a class="back-btn" href="{{ route('interiors') }}">
                            <img class="back-btn__icon" src="/img/arrow-left.svg" alt="">
                            <div class="back-btn__title">Все интерьеры</div>
                        </a>
                    </div>
                    <h1 class="inner-title__heading">Стилистические решения в отделке</h1>
                </div>
            </div>
            <div class="styles__list">
                <div class="styles__item">
                    <a href="{{ route('whitemoon') }}" class="styles__photo styles__photo--whitemoon" title="Подробнее"></a>
                    <h2 class="styles__title">
                        <a href="{{ route('whitemoon') }}" class="styles__link" title="Подробнее">Whitemoon</a>
                    </h2>
                </div>
                <div class="styles__item">
                    <a href="{{ route('easy') }}" class="styles__photo styles__photo--easy" title="Подробнее"></a>
                    <h2 class="styles__title">
                        <a href="{{ route('easy') }}" class="styles__link" title="Подробнее">Easy</a>
                    </h2>
                </div>
                <div class="styles__item styles__item--mobile-full">
                    <a href="{{ route('colorwater') }}" class="styles__photo styles__photo--colorwater" title="Подробнее"></a>
                    <h2 class="styles__title">
                        <a href="{{ route('colorwater') }}" class="styles__link" title="Подробнее">Colorwater</a>
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>
