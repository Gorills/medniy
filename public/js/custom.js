$(function () {
    var squareSlider = document.querySelector('form[name=apartments] .range-slider__value[data-type=square]');
    if (typeof squareSlider !== 'undefined' && squareSlider !== null) {
        var squareMin = document.querySelector('form[name=apartments] [name="square[min]"]');
        var squareMax = document.querySelector('form[name=apartments] [name="square[max]"]');
        squareSlider.noUiSlider.on('update', function (values, handle) {
            // console.log(values, handle);
            squareMin.value = values[0];
            squareMax.value = values[1];
        });
    }

    var priceSlider = document.querySelector('form[name=apartments] .range-slider__value[data-type=price]');
    if (typeof priceSlider !== 'undefined' && priceSlider !== null) {
        var priceMin = document.querySelector('form[name=apartments] [name="price[min]"]');
        var priceMax = document.querySelector('form[name=apartments] [name="price[max]"]');
        priceSlider.noUiSlider.on('update', function (values, handle) {
            // console.log(values, handle);
            priceMin.value = values[0];
            priceMax.value = values[1];
        });
    }

    $(document).on('submit', '#call_back_form, form[name=showroom]', function (e) {
        e.preventDefault();

        const form = this;
        const defaultState = $('.contact-form__inner--default');
        const errorState = $('.contact-form__inner--error');
        const successState = $('.contact-form__inner--success');
        const visibleClass = 'is-visible';
        const tryAgain = $('.js-try-again');

        const phoneInput = $(form).find('input[type=tel]');
        const realValue = phoneInput.get(0).inputmask.unmaskedvalue();
        var isValidPhone = false;
        if (realValue.length < 10) {
            phoneInput.parent().addClass('error');
            isValidPhone = false;
        } else {
            phoneInput.parent().removeClass('error');
            isValidPhone = true;
        }

        if (isValidPhone) {
            if (typeof ComagicWidget !== 'undefined') {
                ComagicWidget.sitePhoneCall(
                    {
                        phone: '7' + realValue,
                        delayed_call_time: new Date().getTime()
                    },
                    function (resp) {
                        defaultState.removeClass(visibleClass);
                        if (resp.success) {
                            successState.addClass(visibleClass);
                            console.log('Ваша заявка принята.');
                        }
                        else {
                            errorState.addClass(visibleClass);
                            if (tryAgain) {
                                tryAgain.on('click', () => {
                                    errorState.removeClass(visibleClass);
                                    defaultState.addClass(visibleClass);
                                });
                            }
                            console.log('Что-то пошло не так');
                        }
                    }
                );
            }
        }
        if (yaCounter50916131) yaCounter50916131.reachGoal('feedback');
        if (ga) ga('send', 'event', 'button', 'click', 'feedback');
        return false;
    })
});