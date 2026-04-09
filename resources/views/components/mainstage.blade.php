<section class="top-screen">
    <div class="top-screen__content">
        <div class="top-screen__content-top">
            <div class="top-screen__logo">
                <img src="/img/logo.svg" alt="alt" />
            </div>
            <div class="top-screen__title">
                
                <br/></div>
        </div>
        <div class="top-screen__content-bottom">
            <div class="top-slider">
                <div class="top-slider__controls">
                    <div class="slider-controls">
                        <div class="slider-controls__buttons">
                            <div class="slider-controls__control slider-controls__control--prev"></div>
                            <div class="slider-controls__control slider-controls__control--next">
                                <div class="slider-controls__control-bg"></div>
                            </div>
                        </div>
                        <div class="slider-controls__info">0 из 0</div>
                    </div>
                </div>
                <div class="top-slider__items">
                    <div class="swiper-wrapper">
                        @foreach($mainStageItems as $slide)
                            <div class="swiper-slide">
                                <div class="top-slider__item">
                                    <h2 class="top-slider__title">
                                        {!! $slide->title !!}
                                    </h2>
                                    <div class="top-slider__text">
                                        {!! $slide->description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="top-screen__mobile-btn">
                <a href="#contacts" class="btn btn--green scrollTo">
                    Заказать звонок
                </a>
            </div>
            <div class="top-screen__buttons">
                <a class="top-screen__button" href="{{ $documentsLink }}">
                    <div class="top-screen__button-icon">
                        <img src="/img/docs-icon.svg" alt="Документы"/>
                    </div>
                    <div class="top-screen__button-title">Документы</div>
                </a>
                <a class="top-screen__button" target="_blank" href="{{ $presentationLink }}">
                    <div class="top-screen__button-icon">
                        <img src="/img/keynote-icon.svg" alt="Презентация"/>
                    </div>
                    <div class="top-screen__button-title">Презентация</div>
                </a>
            </div>
        </div>
    </div>
    <div class="top-screen__image">
        <div class="image-slider">
            <div class="image-slider__items">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="image-slider__slide" style="background-image: url(/img/top-image1.jpg);"></div>
                    </div>
                    <div class="swiper-slide">
                        <div class="image-slider__slide" style="background-image: url(/img/top-image2.jpg);"></div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.mainstage_nav')
    </div>
</section>