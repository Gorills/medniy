<section class="section contacts" id="contacts">
    <div class="contacts__label">
        <div class="contacts__label-logo">
            <img class="contacts__logo-desktop" src="/img/logo1.png" alt="Capital group"/>
            <img class="contacts__logo-mobile" src="/img/logo2.png" alt="Capital group"/>
        </div>
        <a class="contacts__label-link" href="http://capitalgroup.ru" target="_blank">
            capitalgroup.ru
        </a>
    </div>
    <div class="section__inner">
        <div class="contacts__grid">
            <div class="contacts__form">
                <div class="contact-form">
                    <div class="contact-form__inner contact-form__inner--default is-visible">
                        <div class="contact-form__title">
                            Запишитесь на&nbsp;показ
                        </div>

                        <form id="call_back_form" class="contact-form__form" action="#">
                            @csrf
                            <div class="contact-form__form-fields">
                                <div class="form-group">
                                    <input name="name" type="text" placeholder="Ваше имя" required/>
                                    <div id="name_error" class="error-message">Введите имя</div>
                                </div>
                                <div class="form-group">
                                    <input name="phone" class="tel" type="tel" placeholder="Телефон" />
                                    <div id="phone_error" class="error-message">Номер телефона должен состоять из 11 цифр</div>
                                </div>
                            </div>
                            <div class="contact-form__form-submit">
                                <button id="submit_button_collback"  type="submit" class="btn btn--green">
                                    Отправить заявку
                                </button>
                            </div>
                            <div class="contact-form__note">
                                Нажимая на кнопку «Отправить заявку», вы соглашаетесь с
                                <br/>
                                <a class="contact-form__note-link"
                                    href="{{ $comagicPersonalDataLink }}"
                                    target="_blank">
                                    условиями использования персональных данных
                                </a>
                            </div>
                            <div class="contact-form__info">© 2022. Информация на сайте не является публичной офертой.</div>
                        </form>
                    </div>
                    <!-- Success state-->
                    <div class="contact-form__inner contact-form__inner--success">
                        <div class="contact-form__title">Заявка отправлена</div>
                        <div class="contact-form__message">Спасибо! Наш менеджер свяжется с&nbsp;вами для более подробной информации.</div>
                        <div class="contact-form__info">© 2022. Информация на сайте не является публичной офертой.</div>
                    </div>
                    <!-- Error state-->
                    <div class="contact-form__inner contact-form__inner--error">
                        <div class="contact-form__title">Что-то пошло не так</div>
                        <div class="contact-form__message">Нам очень жаль, но произошла непредвиденная ошибка. Попробуйте отправить заявку еще раз.</div>
                        <div class="contact-form__button">
                            <div class="btn btn--green js-try-again">Попробовать снова</div>
                        </div>
                        <div class="contact-form__info">© 2022. Информация на сайте не является публичной офертой.</div>
                    </div>
                </div>
            </div>
            <div class="contacts__content">
                <div class="contacts__content-group init-animation">
                    <div class="contacts__contacts-title">
                        Контакты
                    </div>
                    <div class="contacts__contact-list">
                        <div class="contacts__contact-item">
                            <div class="contact-item">
                                <div class="contact-item__title">
                                    Адрес
                                </div>
                                <div class="contact-item__text">
                                    123317 Москва, Пресненская наб., д. 8
                                    <br/> стр. 1 ММДЦ «Москва-Сити», МФК
                                    <br/> «Город Столиц»
                                </div>
                            </div>
                        </div>
                        <div class="contacts__contact-item">
                            <div class="contact-item">
                                <div class="contact-item__title">
                                    Часы работы
                                </div>
                                <div class="contact-item__text">
                                    с 9:00 до 21:00 (без выходных)
                                </div>
                            </div>
                        </div>
                        <div class="contacts__contact-item">
                            <div class="contact-item">
                                <div class="contact-item__title">
                                    Телефон отдела продаж
                                </div>
                                <a class="contact-item__phone" href="tel:{{ $companyPhoneTag }}">
                                    {{ $companyPhone }}
                                </a>
                            </div>
                        </div>
                        <div class="contacts__contact-item">
                            <div class="contact-item">
                                <div class="contact-item__text">
                                    <a class="contact-item__docs" href="{{ $documentsLink }}">
                                        Документы
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('footer_scripts')

@endpush