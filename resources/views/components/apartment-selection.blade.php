<div class="apartment-select">
    <div class="apartment-select__inner">
        <div class="apartment-select__grid">
            <div class="apartment-select__form">
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
                <div class="btn btn--line btn--inner js_filter_switch is-active mb30" data-tab="apartment-filter">Показать фильтр</div>
                <div class="apartment-tab" id="apartment-filter">
                    <form name="apartments" method="post" action="">
                        @csrf
                        <input name="test" value="{{request()->cookie('medniy_session')}}" type="hidden">
                        <button type="submit" class="btn btn--line btn--inner mb30">Применить фильтр</button>
                        <!-- Apartment form-->
                        <div class="apartment-form">
                                <input type="hidden" name="filter" value="Y">
                            <div class="apartment-form__grid">
                                @if(count($filter['blocks']) > 1)
                                <div class="apartment-form__row">
                                    <div class="apartment-group">
                                        <div class="apartment-group__label">Корпуса</div>
                                        <div class="apartment-group__content">
                                            <div class="checkbox-group">
                                                @foreach($filter['blocks'] as $id => $name)
                                                <label class="checkbox-group__item">
                                                    <input type="checkbox" name="blocks[]" value="{{$id}}" @if(in_array($id, $filter['current']['blocks'])) checked="checked" @endif >
                                                    <span>{{$name}}</span>
                                                </label>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @if(count($filter['rooms']) > 1)
                                <div class="apartment-form__row">
                                    <div class="apartment-group">
                                        <div class="apartment-group__label">Количество спален</div>
                                        <div class="apartment-group__content">
                                            <div class="checkbox-group">
                                                @foreach($filter['rooms'] as $name)
                                                <label class="checkbox-group__item">
                                                    <input type="checkbox" name="rooms[]" value="{{$name}}" @if(in_array($name, $filter['current']['rooms'])) checked="checked" @endif >
                                                    <span>{{$name}}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                {{--@if(count($filter['decorations']) > 1)
                                <div class="apartment-form__row">
                                    <div class="apartment-group">
                                        <div class="apartment-group__label">Отделка</div>
                                        <div class="apartment-group__content">
                                            <div class="checkbox-group">
                                                @foreach($filter['decorations'] as $id => $name)
                                                <label class="checkbox-group__item">
                                                    <input type="checkbox" name="decorations[]" value="{{$id}}" @if(in_array($id, $filter['current']['decorations'])) checked="checked" @endif >
                                                    <span>{{$name}}</span>
                                                </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif--}}
                                <div class="apartment-form__row">
                                    <div class="apartment-group">
                                        <div class="apartment-group__label">Площадь</div>
                                        <div class="apartment-group__content">
                                            <!-- Range slider-->
                                            <div class="range-slider">
                                                <div class="range-slider__input">
                                                    <input type="hidden" name="square[min]">
                                                    <input type="hidden" name="square[max]">
                                                </div>
                                                <div class="range-slider__value"
                                                     data-type="square"
                                                     data-min="{{$filter['square']['min']}}"
                                                     data-max="{{$filter['square']['max']}}"
                                                     data-startfirst="{{$filter['current']['square']['min']}}"
                                                     data-startlast="{{$filter['current']['square']['max']}}"
                                                     data-postfix="кв.м"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<div class="apartment-form__row">
                                    <div class="apartment-group">
                                        <div class="apartment-group__label">Стоимость</div>
                                        <div class="apartment-group__content">
                                            <!-- Range slider-->
                                            <div class="range-slider">
                                                <div class="range-slider__input">
                                                    <input type="hidden" name="price[min]">
                                                    <input type="hidden" name="price[max]">
                                                </div>
                                                <div class="range-slider__value"
                                                     data-type="price"
                                                     data-min="{{$filter['price']['min']}}"
                                                     data-max="{{$filter['price']['max']}}"
                                                     data-startfirst="{{$filter['current']['price']['min']}}"
                                                     data-startlast="{{$filter['current']['price']['max']}}"
                                                     data-postfix="руб"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                    </form>

                </div>
                <div class="apartment-tab is-active" id="apartment-list">
                    @if(count($apartments))
                        @include('components.apartments-list')
                    @else
                        По заданным параметрам ничего не найдено
                    @endif
                </div>
            </div>
            <div class="apartment-select__gap"></div>
            <div class="apartment-select__list">
                <div class="floor-choser__rose">
                    <img src="/img/rose.jpg" alt="" />
                </div>
                <div class="floor-choser">
                    <div class="floor-choser__holder">
                        {{--@foreach($filter['blocks'] as $id => $name)--}}
                        <div class="floor-choser__item floor-choser__item_1 @if(in_array(1, $filter['current']['blocks']))is-active @endif">
                            @foreach($floors['1.14'] as $number => $floor)
                            <a class="floor-choser__floor-x floor_1_ @if(!$floor->active) is-inactive @endif" href="{{route('block-floor', ['1.14',$number])}}"></a>
                            @endforeach
                            <a class="floor-choser__bld-chose" href="{{route('apartment-selection',['filter' => 'Y', 'blocks[]' => 1])}}"></a>
                        </div>
                        {{--@endforeach--}}
                        <div class="floor-choser__item floor-choser__item_2 @if(in_array(3, $filter['current']['blocks']))is-active @endif">
                            @foreach($floors['3.14'] as $number => $floor)
                                <a class="floor-choser__floor-x floor_1_{{$floor->number}} @if(!$floor->active) is-inactive @endif" href="{{route('block-floor', ['3.14',$number])}}"></a>
                            @endforeach
                            <a class="floor-choser__bld-chose" href="{{route('apartment-selection',['filter' => 'Y', 'blocks[]' => 3])}}"></a>
                        </div>
                        <div class="floor-choser__item floor-choser__item_3 @if(in_array(2, $filter['current']['blocks']))is-active @endif">
                            @foreach($floors['2.14'] as $number => $floor)
                                <a class="floor-choser__floor-x floor_1_{{$floor->number}} @if(!$floor->active) is-inactive @endif" href="{{route('block-floor', ['2.14',$number])}}"></a>
                            @endforeach
                            <a class="floor-choser__bld-chose" href="{{route('apartment-selection',['filter' => 'Y', 'blocks[]' => 2])}}"></a>
                        </div>
                    </div>

                    <div class="floor-choser__corp floor-choser__corp_1">
                        <img src="/img/corp114.svg" alt="" />
                    </div>
                    <div class="floor-choser__corp floor-choser__corp_2">
                        <img src="/img/corp214.svg" alt="" />
                    </div>
                    <div class="floor-choser__corp floor-choser__corp_3">
                        <img src="/img/corp314.svg" alt="" />
                    </div>
                    {{--<a class="floor-choser__floor-x" href="{{ route('block-floor',['1.14','22']) }}"></a>--}}
                </div>
            </div>
        </div>
    </div>
</div>
