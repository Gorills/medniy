<div class="contacts-page">
    <div class="contacts-page__map" id="contentMap"></div>
    <div class="contacts-page__route-info" id="routeInfo" hidden="hidden">
        <div class="route-info">
            <div class="route-info__list">
                <div class="route-info__item">
                    <div class="route-info__counter">1</div>
                    <div class="route-info__text" id="routeFrom">115432, Россия, г. Москва, Проектируемый проезд №4062, 4 строение 2</div>
                </div>
                <div class="route-info__item">
                    <div class="route-info__counter">2</div>
                    <div class="route-info__text" id="routeTo">115432, Россия, ул. Академика Петровского, 7/18</div>
                </div>
            </div>
            <div class="route-info__info">
                <div class="map-item__info">
                    <div class="map-item__info-item">
                        <div class="map-item__info-title" id="routeDistance">2100 м</div>
                    </div>
                    <div class="map-item__info-item">
                        <img class="map-item__info-icon" id="travelMode" src="/img/car.svg" alt="alt" />
                        <div class="map-item__info-title" id="routeDuration">25 мин</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contacts-page__inner">
        <div class="contacts-page__group">
            <div class="swiper-lazy-preloader" id="routePreloader" hidden="hidden"></div>
            <div class="inner-title">
                <div class="inner-title__back">
                    <a class="back-btn" href="/">
                        <img class="back-btn__icon" src="/img/arrow-left.svg" alt="На главную" />
                        <div class="back-btn__title">На главную</div>
                    </a>
                </div>
                <h2 class="inner-title__heading">Контакты</h2>
            </div>
            <div class="contacts-page__item">
                <div class="contacts-page__item-title">Адрес</div>
                <div class="contacts-page__item-text">123317 Москва, Пресненская наб., д. 8 стр. 1
                    <br/> ММДЦ «Москва-Сити», МФК «Город Столиц»</div>
            </div>
            <div class="contacts-page__route">
                <div class="route-select">
                    <div class="route-select__title">Построить маршрут:</div>
                    <div class="route-select__select">
                        <select id="routeSelect">
                            <option value="Выбрать" hidden="hidden">Выбрать</option>
                            <option value="WALKING">Пешком</option>
                            <option value="DRIVING">На автомобиле</option>
                            <option value="TRANSIT">Общественным транспортом</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="contacts-page__item">
                <div class="contacts-page__item-title">Часы работы</div>
                <div class="contacts-page__item-text">с 9:00 до 21:00 (без выходных)</div>
            </div>
            <div class="contacts-page__item contacts-page__item--phone">
                <div class="contacts-page__item-title">Телефон отдела продаж</div>
                <a class="contacts-page__item-text" href="tel:{{ $companyPhoneTag }}">
                    {{ $companyPhone }}
                </a>
            </div>
            <div class="contacts-page__buttons">
                <a class="top-screen__button" href="{{ $documentsLink }}">
                    <div class="top-screen__button-icon">
                        <img src="/img/docs-icon.svg" alt="Документы" />
                    </div>
                    <div class="top-screen__button-title">Документы</div>
                </a>
                <a class="top-screen__button" target="_blank" href="{{ $presentationLink }}">
                    <div class="top-screen__button-icon">
                        <img src="/img/keynote-icon.svg" alt="alt" />
                    </div>
                    <div class="top-screen__button-title">Презентация</div>
                </a>
            </div>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key={{ urlencode(config('services.google_maps.key')) }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function()
    {
        contactsMap.init();
    });
</script>