import React, { Component } from 'react';
import './App.css';

import Input from './components/input';
import Range from './components/range';
import Results from './components/results';

//import formatMoney from './helpers/format-money/'
import formatYears from './helpers/format-years/'

class App extends Component {
  constructor(props){
    super(props);

    //const { credits } = window.__DATA__;

    /* API URL */
    let apiUrl = document.getElementById('root').getAttribute('data-api-url');
    if (!apiUrl) { console.error('API URL is not defined as "data-api-url" attribute in "#root".'); }

    let credits = [];
    let citizenshipList = [];
    let firstFeePercentArray = [];
    let creditMinLengthArray = [];

    this.getDataFromServer(apiUrl, data => {
      // console.log(data.data);
      data.data.forEach((credit, i) => {
        const availableCitizenship = this.getCitizenshipList(credit.citizenships);
        credits.push({
          title: credit.bank.name,
          availableCitizenship: availableCitizenship,
          age: {
            min: credit.age_min,
            max: credit.age_max
          },
          creditLength: {
            min: credit.credit_term_min,
            max: credit.credit_term_max
          },
          percent: credit.percent,
          minFirstFeePercent: credit.initial_fee_min_percent,
          img: credit.bank.image,

          stateSupport: credit.is_state_support,

          id: i
        });

        availableCitizenship.forEach(citizenship => {
          if (citizenshipList.indexOf(citizenship) === -1){
            citizenshipList.push(citizenship)
          }
        });
      });

      credits.forEach(credit => {
        if (credit.creditLength.max > defaultProps.creditLengthMax){
          defaultProps.creditLengthMax = credit.creditLength.max
        }
        if (credit.age.max > defaultProps.ageMax){
          defaultProps.ageMax = credit.age.max
        }

        firstFeePercentArray.push(credit.minFirstFeePercent);
        creditMinLengthArray.push(credit.creditLength.min)
      });

      this.setState({
        credits: credits,
        citizenshipList: citizenshipList,
        mostFrequentFirstFeePercent: this.findMostFrequentInArray(firstFeePercentArray),
        mostFrequentMinCreditLength: this.findMostFrequentInArray(creditMinLengthArray),
      })
    }, 'ru');

    const urlData = this.parseURL(window.location.href);


    let defaultProps = {
      maxPrice: 200000000,
      creditSum: urlData && urlData.creditSum ? urlData.creditSum : 17700000,

      creditLengthMin: 0,
      creditLengthMax: 30,

      ageMin: 18,
      ageMax: 80,
      age: 30,

      credits: credits,

      firstFeePercent: 20,
      maxFirstFeePercent: 90,

      citizenship: 'РФ',

      stateSupport: 0,

      email: ''
    };

    defaultProps.firstFee = defaultProps.creditSum / 100 * defaultProps.firstFeePercent;
    defaultProps.maxFirstFee = Math.round(defaultProps.creditSum / 100 * defaultProps.maxFirstFeePercent);

    defaultProps.creditLength = Math.floor((defaultProps.creditLengthMax + defaultProps.creditLengthMin) / 2);

    this.state = defaultProps;
  };

  getDataFromServer = (url, callback, lang) => {
    const httpRequest = new XMLHttpRequest();

    httpRequest.onreadystatechange = () => {
      if (httpRequest.readyState === 4 && httpRequest.status === 200){
        callback(JSON.parse(httpRequest.responseText));
      }
    };

    httpRequest.open('get', url, true);
    httpRequest.setRequestHeader('Accept-Language', lang);
    httpRequest.send();
  };

  parseURL = (url) => {
    const data = {};

    url = url.slice(url.indexOf('?') + 1, url.length + 1).split('&');

    url.forEach(item => {
      item = item.split('=');
      data[item[0]] = Number(item[1])
    });

    return data;
  };

  getCitizenshipList = (arr) => {
    let citizenshipList = [];
    arr.forEach(item => {
      citizenshipList.push(item.name)
    });
    return citizenshipList
  };

  findMostFrequentInArray = (array) => {
    if (!array.length) return;
    let reduced = array.reduce((reduced, number) => {
      if (number in reduced){
        reduced[number]++;
      } else {
        reduced[number] = 1;
      }

      return reduced;
    }, {});

    return Object.keys(reduced).reduce((a, b) => reduced[a] >= reduced[b] ? a : b)
  };

  handleChange = (prop, value) => {
    if (typeof(value) === 'object'){
      value = value.target.value
    }
    this.setState({
      [prop]: value
    })
  };

  changeCreditSum = value => {
    if (value < Math.round(this.state.firstFee / 9 * 10)){
      this.setState({
        firstFee: this.calcMaxFirstFee(value)
      })
    };
    this.setState({
      creditSum: value,
      maxFirstFee: this.calcMaxFirstFee(value),
      firstFeePercent: this.calcFirstFeePercent(),
    })
  };

  changeFirstFee = value => {
    this.setState({
      firstFee: value,
      firstFeePercent: this.calcFirstFeePercent()
    });
  };

  calcMaxFirstFee = value => Math.round(value / 10 * 9);

  calcFirstFeePercent = () => {
    const result = Math.round(this.state.firstFee / (this.state.creditSum / 100));
    return isNaN(result) || result === Infinity ? 0 : result
  };

  filterCredits = () => {
    const formData = this.state;
    //let { credits } = window.__DATA__;
    let { credits } = this.state;

    let disabledCredits = [];

    credits = credits.filter(credit => {
      if (
        credit.availableCitizenship.indexOf(formData.citizenship) !== -1 &&
        credit.age.min <= formData.age &&
        credit.age.max >= formData.age
      ){
        if (
          credit.creditLength.min <= formData.creditLength &&
          credit.creditLength.max >=  formData.creditLength &&
          credit.minFirstFeePercent <= formData.firstFeePercent
        ){
          return credit
        } else {
          disabledCredits.push(credit);
          return null
        }
      } else return null
    });

    let smallestPercent = Infinity;

    credits.forEach(credit => {
      const percentPerMonth = credit.percent / 100 / 12;
      const monthsToPay = formData.creditLength * 12;
      const creditTotal = formData.creditSum - formData.firstFee;

      credit.payPerMonth = this.calculatePayPerMonth(percentPerMonth, monthsToPay, creditTotal);

      if (credit.percent < smallestPercent){
        smallestPercent = credit.percent;
      }
    });

    let bestCredits = [];
    let otherCredits = [];

    credits.forEach(credit => {
      if (credit.percent === smallestPercent){
        bestCredits.push(credit);
      } else {
        otherCredits.push(credit);
      }
    });

    if (otherCredits.length){
      this.sortArr(otherCredits, 'percent')
    }

    if (disabledCredits.length){
      this.sortArr(disabledCredits, 'minFirstFeePercent');
      disabledCredits = disabledCredits.slice(0, 3);
    }

    return {
      best: bestCredits,
      other: otherCredits,
      disabled: disabledCredits
    }
  };

  calculatePayPerMonth = (percentPerMonth, monthsToPay, creditSum) => {
    const presentValueInterestFactor = Math.pow(1 + percentPerMonth, monthsToPay);
    return percentPerMonth / (presentValueInterestFactor - 1) * creditSum * presentValueInterestFactor;
  };

  sortArr = (arr, prop) => {
    return arr.sort((a, b) => {
      return a[prop] - b[prop]
    });
  };

  renderPreloader = () => {
    return (
      <div className="preloader">
        <div className="preloader__wrapper">
          <div className="preloader__spinner"></div>
        </div>
      </div>
    )
  };

  getProperScrollDestination = (dest) => dest - 0;

  componentDidMount = () => {
    this.setState({
      scrollButtonAlternativeFlag: false
    });

    document.addEventListener('scroll', () => {
      if (this.refs.results.getBoundingClientRect().top <= 0){
        this.setState({
          scrollButtonAlternativeFlag: true
        })
      } else {
        this.setState({
          scrollButtonAlternativeFlag: false
        })
      }
    })
  };

  handleScroll = () => {
    const { scrollButtonAlternativeFlag } = this.state;
    const { results, calctitle } = this.refs;
    window.scroll({
      top: scrollButtonAlternativeFlag ? calctitle.getBoundingClientRect().top + window.pageYOffset - 20 : results.getBoundingClientRect().top + window.pageYOffset,
      behavior: 'smooth'
    })
  };

  handlePick = (credit) => {
    this.setState({
      pickedCredit: credit
    })
  };

  openModal = () => {
    this.setState({
      modalOpenFlag: true
    })
  };

  closeModal = () => {
    this.setState({
      modalOpenFlag: false
    })
  };

  handleSubmit = (pickedCredit) => {
    //alert(JSON.stringify(pickedCredit))
    this.setState({
      sending: true
    });
    setTimeout(() => {
      this.setState({
        sending: false,
        sendSuccess: true
      });
    }, 1000);
  };

  hideBanner = () => {
    this.setState({
      sendSuccess: false
    })
  };

  checkIfPickedCreditInResults = (results, pickedCredit) => results.indexOf(pickedCredit) !== -1 ? true : false;

  render() {

    const {
      credits,
      citizenshipList,
      creditSum,
      maxPrice,
      firstFee, maxFirstFee, firstFeePercent, mostFrequentFirstFeePercent,
      age, ageMin, ageMax,
      creditLength, creditLengthMax, creditLengthMin, mostFrequentMinCreditLength,
      pickedCredit,
      modalOpenFlag,
      email,
      scrollButtonAlternativeFlag
    } = this.state;

    if (!credits.length){
      return this.renderPreloader();
    }

    const results = this.filterCredits();

    return (
      <div className="app" ref="app">

        <div className="center-wrapper">
          <div className="col-wrapper">
            <div className="col col--left">
              <h2 ref="calctitle">Ипотечный калькулятор</h2>
              <form className="form" onSubmit={(e) => {e.preventDefault(); this.openModal()}}>
                <Input
                  type="select"
                  label="Гражданство"
                  value={citizenshipList}
                  onChange={this.handleChange.bind(this, 'citizenship')}
                />
                <Range
                  label="Возраст заемщика, лет."
                  value={age}
                  min={ageMin}
                  max={ageMax}
                  onChange={this.handleChange.bind(this, 'age')}
                />
                <Range
                  label="Стоимость квартиры, руб."
                  value={creditSum}
                  min={0}
                  max={maxPrice}
                  onChange={this.changeCreditSum.bind(this)}
                  isMoney={true}
                />
                <Range
                  label="Первоначальный взнос, руб."
                  value={firstFee}
                  min={0}
                  max={maxFirstFee}
                  onChange={this.changeFirstFee.bind(this)}
                  isMoney={true}
                  note={`${this.calcFirstFeePercent()}%`}
                  tip={
                    firstFeePercent < mostFrequentFirstFeePercent &&
                    `У большинства кредитов первоначальный взнос более ${mostFrequentFirstFeePercent}%`
                  }
                  error={ firstFeePercent < mostFrequentFirstFeePercent }
                />
                <Range
                  label="Срок кредита, лет"
                  value={creditLength}
                  min={creditLengthMin}
                  max={creditLengthMax}
                  onChange={this.handleChange.bind(this, 'creditLength')}
                  tip={
                    creditLength < mostFrequentMinCreditLength &&
                    `У большинства кредитов минимальный срок: ${formatYears(mostFrequentMinCreditLength)}`
                  }
                  error={ creditLength < mostFrequentMinCreditLength }
                />
                {/*<div className="calculation">
                  <span className="calculation__title">Сумма кредита: </span>
                  <span className="calculation__value">
                    {formatMoney(true).to(creditSum - firstFee)}
                  </span>
                </div>*/}

                {this.checkIfPickedCreditInResults([...results.best, ...results.other], pickedCredit) && (
                  <input
                    type="submit"
                    value="Отправить на почту"
                    className="button"
                  />
                )}
                <button
                  type="button"
                  className={'scroll-button' + (
                    scrollButtonAlternativeFlag ? ' scroll-button--active' : ''
                  )}
                  onClick={this.handleScroll}
                >
                  {scrollButtonAlternativeFlag ? 'Вернуться наверх' : 'Перейти к результатам'}
                </button>
                {/* <div className="disclaim">
                  <p><span className={'disclaim-star'}>*</span> - В&nbsp;рамках программы &laquo;Ипотека с&nbsp;господдержкой 2020&raquo; ставка в&nbsp;размере 4,3% действует в&nbsp;течение 6&nbsp;месяцев, ставка 5,3% действует в&nbsp;течение 12&nbsp;месяцев с&nbsp;даты заключения кредитного договора в&nbsp;случае оформления полного комплексного страхования и&nbsp;первоначальном взносе не&nbsp;менее 15%. По&nbsp;окончанию указанного периода ставка составит 6,5% при оформлении комплексного страхования. Заемщики&nbsp;&mdash; граждане РФ. Программа распространяется на&nbsp;покупку строящегося жилья у&nbsp;юридического лица (за&nbsp;исключением инвестиционного фонда, в&nbsp;том числе его управляющей компании) и&nbsp;готового жилья по&nbsp;договору купли-продажи у&nbsp;застройщика. Сумма кредита для Москвы, Московской области, Санкт-Петербурга и&nbsp;Ленинградской области&nbsp;&mdash; не&nbsp;более 12&nbsp;млн. руб., для остальных регионов&nbsp;&mdash; не&nbsp;более 6&nbsp;млн. руб. Валюта кредита&nbsp;&mdash; рубли. Срок кредита&nbsp;&mdash; от&nbsp;1&nbsp;до&nbsp;30&nbsp;лет. Срок заключения кредитного договора до&nbsp;01.07.2021 (включительно).</p>
                  <p>Условия действительны на&nbsp;25.05.2021&nbsp;г.</p>
                  <p>Банк ВТБ (ПАО) оказывает исключительно банковские услуги. Банк вправе отказать в&nbsp;предоставлении кредита без объяснения причин. Банк предоставляет кредит в&nbsp;случае, если заемщик (созаемщик/поручитель, при наличии) соответствует требованиям госпрограммы и&nbsp;Банка и&nbsp;предоставил полный пакет необходимых документов.</p>
                  <p>Банк ВТБ (ПАО). Генеральная лицензия Банка России &#8470;&nbsp;1000.</p>
                </div> */}
              </form>
            </div>
            <div className="col col--right" ref="results">
              <Results
                credits={results}
                handlePick={this.handlePick}
                pickedCredit={pickedCredit}
              />
            </div>
          </div>
        </div>

        {modalOpenFlag && (
          <div className="modal" onClick={this.closeModal}>
            <div className="modal__body" onClick={(e) => {e.stopPropagation()}}>
              {this.state.sendSuccess ? (
                <React.Fragment>
                  <div className="banner">
                    <div className="banner-logo"></div>
                    <div>Отправлено успешно</div>
                  </div>
                  <button className="button" onClick={this.hideBanner}>Ок</button>
                </React.Fragment>
              ) : (
                this.state.sending ? (
                  this.renderPreloader()
                ) : (
                  <form onSubmit={(e) => {e.preventDefault(); this.handleSubmit(pickedCredit)}}>
                    <Input
                      type="email"
                      label="Введите адрес электронной почты, на который нужно отправить данные по выбранному предложению:"
                      value={email}
                      onChange={this.handleChange.bind(this, 'email')}
                      required={false}
                    />
                    <Input
                      type="submit"
                      value="Отправить"
                    />
                  </form>
                )
              )}
              <button className="modal__close" onClick={this.closeModal} />
            </div>
          </div>
        )}
      </div>
    );
  }
}

export default App;



// WEBPACK FOOTER //
// ./src/App.js