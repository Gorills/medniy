<section class="section object" id="object">
    <div class="section__inner">
        <div class="object__grid">
            <div class="object__image init-animation">
                <div class="object-slider-image__items">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="object-slider-image__item">
                                <img src="/img/01.jpg" srcset="/img/01@2x.jpg 2x" alt="Медь в оформлении фасада ЖК Медный 3.14">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="object-slider-image__item">
                                <img src="/img/02.jpg" srcset="/img/02@2x.jpg 2x" alt="Кирпичное оформление фасада жилого комплекса Медный 3.14">
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="object-slider-image__item">
                                <img src="/img/03.jpg" srcset="/img/03@2x.jpg 2x" alt="Ресепшен в ЖК Медный 3,14">
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn btn--green ninja_s mt25" href="{{ route('blocks-list') }}">Выбрать квартиру</a>
            </div>
            <div class="object__content">
                <div class="object__content-image init-animation">
                    <img src="/img/object.jpg" srcset="/img/object@2x.jpg 2x" alt="ЖК Медный 3,14">
                </div>
                <div class="object__content-group">
                    <div class="object__controls">
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
                    <h2 class="object__title">Объект</h2>
                    <div class="object-slider">
                        <div class="object-slider__controls">
                            <div class="tabs-controls">
                                @foreach($objectSlides as $slide)
                                    <div class="tabs-controls__item{{ ($loop->iteration == 1) ? ' is-active' : '' }}">
                                        {{ $slide->name }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="object-slider__items">
                            <div class="swiper-wrapper">
                                @foreach($objectSlides as $slide)
                                    <div class="swiper-slide">
                                        <div class="object-slider__item">
                                            {!! $slide->description !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <a class="btn btn--green s_ninja mt25" href="{{ route('blocks-list') }}">Выбрать квартиру</a>
                </div>
            </div>
        </div>
    </div>
</section>