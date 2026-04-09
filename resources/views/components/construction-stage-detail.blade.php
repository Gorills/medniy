<div class="gallery">
    <div class="gallery__inner">
        <div class="gallery__top">
            <div class="inner-title inner-title--nomargin inner-title--bg">
                <div class="inner-title__back">
                    <a class="back-btn" href="{{ route('construction-stages') }}">
                        <img class="back-btn__icon" src="/img/arrow-left.svg" alt="На главную"/>
                        <div class="back-btn__title">Все этапы</div>
                    </a>
                </div>
                <h1 class="inner-title__heading">{{ App\FormatDate::formatDate($stages->first()->created_at->format("F Y")) }}</h1>
            </div>
        </div>
        <div class="gallery__slider">
            <div class="gallery-slider">
                <div class="gallery-slider__items">
                    <div class="swiper-wrapper">
                        @foreach($stages as $stage)
                            <div class="swiper-slide">
                                <a class="gallery-slider__item" href="/{{ $stage->image }}">
                                    <img class="gallery-slider__item-image"
                                         src="{{ $glidePrefix }}{{ $stage->image }}?w=1152&h=1152"
                                         alt="{{ $stage->name }}"/>
                                    <div class="gallery-slider__item-caption">{{ $stage->name }}</div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
