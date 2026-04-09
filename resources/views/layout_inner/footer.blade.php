<footer class="page-footer">
    <div class="page-footer__inner">
        <div class="page-footer__copyright">
            © 2022. Информация на сайте не является публичной офертой.
        </div>
        <form action="#" method="method" name="showroom">
            <div class="page-footer__form">
                <div class="page-footer__form-field">
                    <div class="form-group">
                        <input type="text" placeholder="Ваше имя" required="required"/>
                    </div>
                </div>
                <div class="page-footer__form-field">
                    <div class="form-group">
                        <input type="tel" placeholder="Телефон" required="required"/>
                    </div>
                </div>
                <div class="page-footer__form-field">
                    <button class="btn btn--line-inner miniform">
                        Записаться на показ
                    </button>
                </div>
                <div class="contact-form__note">
                    Нажимая на кнопку «Отправить заявку» вы соглашаетесь с
                    <br/>
                    <a class="contact-form__note-link" target="_blank" href="{{ $comagicPersonalDataLink }}">
                        условиями использования персональных данных
                    </a>
                </div>
                <div class="contact-form__inner contact-form__inner--mini contact-form__inner--success">
                    <div class="contact-form__title contact-form__title--mini">Заявка отправлена. Спасибо! Наш менеджер свяжется с&nbsp;вами для более подробной информации.</div>
                </div>
                <div class="contact-form__inner contact-form__inner--mini contact-form__inner--error">
                    <div class="contact-form__title contact-form__title--mini">Что-то пошло не так. Нам очень жаль, но произошла непредвиденная ошибка. Попробуйте обновить страницу.</div>
                </div>
            </div>
        </form>
        <div class="page-footer__callback-btn">
            <div class="btn btn--line-inner rg-trigger" data-modal="default-modal">
                Записаться на показ
            </div>
        </div>
    </div>
</footer>