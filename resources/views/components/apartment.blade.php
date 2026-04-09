<div class="flat-view flat-view--spec">
    <div class="flat-view__inner">
        <!-- Title for large screens ¯\_(ツ)_/¯-->
        <div class="flat-view__title-fhd">
            <!-- Inner title-->
            <div class="inner-title">
                <div class="inner-title__back">
                    <a class="back-btn" href="{{ route('block-floor', [$apartment->floor->block->number, $apartment->floor->number]) }}">
                        <img class="back-btn__icon" src="/img/arrow-left.svg" alt="" />
                        <div class="back-btn__title">Назад к выбору этажа</div>
                    </a>
                </div>
                <h2 class="inner-title__heading">Подбор квартиры</h2>
            </div>
        </div>
        <div class="flat-view__grid">
            <div class="flat-view__main">
                <div class="flat-view__title-main">
                    <!-- Inner title-->
                    <div class="inner-title">
                        <div class="inner-title__back">
                            <a class="back-btn" href="{{ route('block-floor', [$apartment->floor->block->number, $apartment->floor->number]) }}">
                                <img class="back-btn__icon" src="/img/arrow-left.svg" alt="" />
                                <div class="back-btn__title">Назад к выбору этажа</div>
                            </a>
                        </div>
                        <h2 class="inner-title__heading">Подбор квартиры</h2>
                    </div>
                </div>
                <div class="flat-view__main-items">
                    <div class="flat-view__main-info">
                        <!-- Apartment info-->
                        <div class="apartment-info apartment-info--inline">
                            <div class="apartment-info__item">
                                <div class="apartment-info__item-title">Этаж</div>
                                <div class="apartment-info__item-value">{{ $apartment->floor->number }}</div>
                            </div>
                            <div class="apartment-info__item">
                                <div class="apartment-info__item-title">Квартира</div>
                                <div class="apartment-info__item-value">{{ $apartment->number }}</div>
                            </div>
                            <div class="apartment-info__item">
                                <div class="apartment-info__item-title">Спален</div>
                                <div class="apartment-info__item-value">{{ $apartment->rooms }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="flat-view__main-scheme">
                        <!-- Flat-->
                        <div class="flat-scheme">
                            <img src="{{ $apartment->images }}" alt="alt" />
                        </div>
                    </div>
                    <div class="flat-view__main-dropdown">
                        <!-- Mobile dropdown-->
                        <div class="mobile-dropdown char">
                            <div class="mobile-dropdown__top">
                                <div class="mobile-dropdown__title">Характеристики</div>
                                <img class="mobile-dropdown__icon" src="/img/arrow-bottom.svg" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flat-view__content">
                <div class="flat-view__content-group">
                    <!-- Tabs controls-->
                    <div class="tabs-controls tabs-controls--big">
                        <div class="tabs-controls__item js_flat-view_switch" data-tab="flat-tab1">Характеристики</div>
                    </div>
                    <!-- Info list-->
                    <div class="flat-view__tab" id="flat-tab1">
                        <div class="select-info__list">
                            <div class="select-info__list-item">Общая площадь — {{ $apartment->total_area }} м²</div>
                            @if($apartment->bathroom_area)<div class="select-info__list-item">Ванная — {{ $apartment->bathroom_area }} м²</div>@endif
                            <div class="select-info__list-item">Количество спален — {{ $apartment->rooms }}</div>
                            {{--<div class="select-info__list-item">Цена — {{ number_format($apartment->price, 0, ',', ' ') }} руб.</div>--}}
                            {{--<div class="select-info__list-item">Отделка —&nbsp;--}}
                                {{--<a href="javascript:void(0)">{{ $apartment->decoration->name }}</a>--}}
                            {{--</div>--}}
                        </div>
                        <div class="select-info__buttons select-info__buttons--group">
                            <!-- <a class="btn btn--green btn--inner" href="{{ route('mortgage-calc', [/*'creditSum' => $apartment->price*/]) }}">Рассчитать ипотеку</a> -->
                            <a class="btn btn--green btn--inner rg-trigger" data-modal="default-modal">Забронировать</a>
                        </div>
                        <div class="select-info__buttons select-info__buttons--group">
                            {{--<a class="btn btn--line btn--inner" href="javascript:void(0)">Отправить на почту</a>--}}
                            <a class="btn btn--line btn--inner" href="{{ route('apartment-detail-pdf', [$apartment->code]) }}" target="_blank">Распечатать презентацию</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>