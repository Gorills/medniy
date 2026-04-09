<div class="conditions-page">
    <div class="conditions-page__inner">
        <div class="conditions-page__grid">
            <div class="conditions-page__grid-col">
                <div class="inner-title">
                    <div class="inner-title__back">
                        <a class="back-btn" href="/">
                            <img class="back-btn__icon" src="/img/arrow-left.svg" alt="На главную"/>
                            <div class="back-btn__title">На главную</div>
                        </a>
                    </div>
                    <h1 class="inner-title__heading">Условия покупки</h1>
                </div>
                <div class="conditions-page__info">
                    <div class="conditions-page__info-title">Информация</div>
                    <div class="conditions-page__info-text">
                        <p>Подбор квартиры, бронирование и фиксация стоимости происходят в момент, когда вы
                            определяетесь с выбором квартиры и приезжаете в офис продаж. Вам предоставляют образцы
                            документов, необходимых для регистрации: </p>
                        <p>1) Образец Доверенности на наших сотрудников для регистрации ДДУ;
                            <br/> 2) Образец нотариального согласия супруга либо заявление о том, что не состоите в
                            браке.</p>
                    </div>
                </div>
                <div class="conditions-page__button">
                    <a href="#root" class="btn btn--green btn--inner js_goto">Ипотечный калькулятор</a>
                </div>
            </div>
        </div>
        <link rel="stylesheet" href="/mortgage/static/css/main.25b390c1.css">
        <div
                class="conditions"
                id="root"
                data-api-url="https://api.capitalgroup.ru/api/1.0.0/objects/mednyj/mortgage_terms"
        ></div>
        <script src="/mortgage/static/js/main.893fb6b7.js"></script>
    </div>
</div>
@push('footer_scripts')
<script>
    $(document).ready(function(){
        $(".conditions-page__button").on("click",".js_goto", function (event) {
            event.preventDefault();
            var id  = $(this).attr('href'),
                top = $(id).offset().top;
            $('body,html').animate({scrollTop: top}, 700);
        });
    });
</script>
@endpush