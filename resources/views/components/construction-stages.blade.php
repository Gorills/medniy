<div class="gallery">
    <div class="gallery__inner">
        <div class="gallery__top">
            <div class="inner-title inner-title--nomargin inner-title--bg">
                <div class="inner-title__back">
                    <a class="back-btn" href="/">
                        <img class="back-btn__icon" src="/img/arrow-left.svg" alt="На главную"/>
                        <div class="back-btn__title">На главную</div>
                    </a>
                </div>
                <h1 class="inner-title__heading">Этапы строительства</h1>
            </div>
        </div>
        <div class="gallery__slider">
            <div class="gallery-slider">
                <div class="gallery-slider__items">
                    <div class="swiper-wrapper">
                        @foreach($stages as $date => $stage)
                            <div class="swiper-slide mix">
                                <a class="gallery-slider__item album"
                                   href="{{ route('construction-stage-detail', [str_replace(' ','_',$date)]) }}">
                                    <img class="gallery-slider__item-image"
                                         src="{{ $glidePrefix }}{{ $stage->first()->image }}?w=1152&h=1152"
                                         alt="{{ $stage->first()->name }}"/>
                                    <div class="gallery-slider__item-caption">{{ $date }}</div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
