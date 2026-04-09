import React, { Component } from 'react';
// import { CSSTransitionGroup } from 'react-transition-group';
// import { CSSTransitionGroup } from 'react-transition-group'
// import { CSSTransition } from '../../../node_modules/react-transition-group/dist/react-transition-group'

import formatMoney from '../../helpers/format-money/'
import formatYears from '../../helpers/format-years/'

import './index.css'

export default class Results extends Component {
  // renderResults = (credits, disabledFlag) => {
  //   return (
  //     <CSSTransition
  //       transitionName="fade"
  //       transitionEnterTimeout={300}
  //       transitionLeaveTimeout={100}
  //     >
  //       {credits.map((credit, i) => <Result credit={credit} key={i} disabledFlag={disabledFlag} handlePick={this.props.handlePick} pickedCredit={this.props.pickedCredit} />)}
  //     </CSSTransition>
  //   )
  // };
  renderResults = (credits, disabledFlag) => {
    return (
      credits.map((credit, i) => 
        <Result
          key={credit.id}
          credit={credit}
          disabledFlag={disabledFlag}
          handlePick={this.props.handlePick}
          pickedCredit={this.props.pickedCredit}
        />
      )
    )
  };

  render(){
    const { credits } = this.props;

    return (
      <React.Fragment>
        {credits.best.length ? (
          <React.Fragment>
            {credits.other.length ? (
              <React.Fragment>
                <div className="mortgage-results mortgage-results--best">
                  <h3>{credits.best.length > 1 ? 'Лучшие предложения' : 'Лучшее предложение'}</h3>
                  {this.renderResults(credits.best)}
                </div>
                <div className="mortgage-results">
                  <h3>{credits.other.length > 1 ? 'Другие предложения' : 'Другое предложение'}</h3>
                  {this.renderResults(credits.other)}
                </div>
              </React.Fragment>
            ) : (
              <div className="mortgage-results">
                {this.renderResults(credits.best)}
              </div>
            )}
          </React.Fragment>
          ) : (
            <React.Fragment>
              <div className="message-card">
                <div className="message-card__item">Не удалось подобрать кредит по заданным параметрам.</div>
                <div className="message-card__item">Попробуйте увеличить первоначальный взнос или срок кредита.</div>
              </div>
            <div className="mortgage-results">
              <h3>{credits.disabled.length > 1 ? 'Возможные предложения' : 'Возможное предложение'}</h3>
              {this.renderResults(credits.disabled, true)}
            </div>
          </React.Fragment>
          )
        }
      </React.Fragment>
    )
  }
};

class Result extends Component {
  constructor(props){
    super(props);

    this.state = {
      imageState: true
    }
  };

  handleImageError = () => {
    this.setState({
      imageState: false
    })
  };

  handlePick = credit => this.props.handlePick(credit);

  render(){
    const { credit, disabledFlag, /*handlePick,*/ pickedCredit } = this.props;
    const { imageState } = this.state;

    return (
      <div
        className={
          'mortgage-result' +
          (disabledFlag ? ' mortgage-result--disabled' : '') +
          (pickedCredit === credit ? ' mortgage-result--picked' : '')
        }
        /*onClick={disabledFlag ? () => { return } : this.handlePick.bind(this, credit)}*/
      >
        <div className="mortgage-result__wrapper">
          <div className="mortgage-result__top">
            {(credit.img && imageState) && (
              <div className="mortgage-result__logo">
                <img src={credit.img} alt={credit.title} onError={this.handleImageError}/>
              </div>
            )}
            <div className="mortgage-result__heading">{credit.title}</div>
          </div>
          <div className="mortgage-result__items">
            <div className="mortgage-result__item">
              <div className="mortgage-result__title">Ставка от {credit.stateSupport ? <span className={"disclaim-star"}>*</span> : ''}</div>
              <div className="mortgage-result__value">{credit.percent}</div>
            </div>
            {!disabledFlag && (
              <div className="mortgage-result__item">
                <div className="mortgage-result__title">Платеж в мес.</div>
                <div className="mortgage-result__value">{formatMoney(true).to(credit.payPerMonth)}</div>
              </div>
            )}
            <div className="mortgage-result__item">
              <div className="mortgage-result__title">Срок до</div>
              <div className="mortgage-result__value">{formatYears(credit.creditLength.max)}</div>
            </div>
          </div>
        </div>
      </div>
    )
  }
};


// WEBPACK FOOTER //
// ./src/components/results/index.js