<!-- Floor select-->
<div class="floor-select">
    <div class="floor-select__inner">
        <!-- Inner title-->
        <div class="inner-title">
            <div class="inner-title__back">
                <a class="back-btn" href="{{ route('blocks-list') }}">
                    <img class="back-btn__icon" src="/img/arrow-left.svg" alt="" />
                    <div class="back-btn__title">Назад к выбору дома</div>
                </a>
            </div>
            <h1 class="inner-title__heading">Подбор квартиры</h1>
        </div>
        <div class="floor-select__grid">
            <div class="floor-select__switcher">
                <!-- Apartment info-->
                <div class="apartment-info">
                    <div class="apartment-info__item">
                        <div class="apartment-info__item-title">Корпус</div>
                        <div class="apartment-info__item-value">
                            <div class="apartment-switcher">
                                @if ($blocks2floor['prev'] !== null)
                                <a href="{{ route('block-floor', ['block' => $blocks['prev']->number, 'floor' => $blocks2floor['prev']->number]) }}">
                                    <img class="apartment-switcher__control apartment-switcher__control--prev" src="/img/arrow-left.svg" alt="" />
                                </a>
                                @endif
                                <div class="apartment-switcher__value">{{ $floor->block->number }}</div>
                                @if ($blocks2floor['next'] !== null)
                                <a href="{{ route('block-floor', ['block' => $blocks['next']->number, 'floor' => $blocks2floor['next']->number]) }}">
                                    <img class="apartment-switcher__control apartment-switcher__control--next" src="/img/arrow-right.svg" alt="" />
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="apartment-info__item">
                        <div class="apartment-info__item-title">Этаж</div>
                        <div class="apartment-info__item-value">
                            <div class="apartment-switcher">
                                @if($floors['prev'] !== null)
                                <a href="{{ route('block-floor', [$floor->block->number, $floors['prev']->number]) }}">
                                    <img class="apartment-switcher__control apartment-switcher__control--prev" src="/img/arrow-left.svg" alt="" />
                                </a>
                                @endif
                                <div class="apartment-switcher__value">{{ $floor->number }}</div>
                                @if($floors['next'] !== null)
                                <a href="{{ route('block-floor', ['block' => $floor->block->number, 'floor' => $floors['next']->number]) }}">
                                    <img class="apartment-switcher__control apartment-switcher__control--next" src="/img/arrow-right.svg" alt="" />
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="floor-select__scheme">
                <div class="floor-scheme">
                    <div class="floors-item">
                        <div class="floors-item__inner" style="background-image: url('/{{ $floor->scheme->scheme_img }}');">
                            {!! $floor->scheme->scheme_svg !!}
                            <div class="floors-numbers scheme-{{ $floor->scheme->code }}">
                                @foreach($apartments as $apartment)
                                    <div class="floors-numbers__item @if(!$apartment->active) disabled @endif"
                                         data-key="{{ $loop->index }}"
                                         @if($apartment->active) data-link="{{ route('apartment-detail', $apartment->code) }}" @endif>{{ $apartment->number }}
                                    </div>
                                    {{--<div class="floors-numbers__item disabled" data-key="3">123</div>--}}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="floor-select__building">
                <div class="building-select-small">
                    <img src="/img/bld-sel.jpg" alt="Корпус 2.14 жилого комплекса Медный">
                    <div class="building-select-small__hover">
                        @foreach($blocks['all'] as $block)
                            <?if ($firstFloor=$block->floors->where('active', 1)->first()){?>
                        <a class="building-select-small__hover-item building-select-small__hover-item--{{ ($loop->index + 1) }} @if($floor->block->id === $block->id)building-select-small__hover-item--active @endif"
                           href="{{ route('block-floor', ['block' => $block->number, 'floor' => $block->floors->where('active', 1)->first()->number]) }}"></a>
                            <?}?>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>