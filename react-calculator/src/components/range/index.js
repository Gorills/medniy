import React, { Component } from 'react';

//import style from '../../../node_modules/nouislider/distribute/nouislider.min.css'
import './nouislider.css'
import noUiSlider from '../../../node_modules/nouislider/distribute/nouislider.min.js'

import formatMoney from '../../helpers/format-money/'

import './index.css'

export default class Range extends Component {

  initRange = () => {
    const { range } = this.refs;
    const { value, min, max, isMoney } = this.props;

    noUiSlider.create(range, {
      start: value,
      connect: [true, false],
      range: {
        'min': min,
        'max': max
      },
      step: isMoney ? 1000 : 0
    });

    range.noUiSlider.on('slide', () => {
      if (window.getSelection){
        if (window.getSelection().empty){
          window.getSelection().empty();
        } else if (window.getSelection().removeAllRanges){
          window.getSelection().removeAllRanges();
        }
      } else if (document.selection){
        document.selection.empty();
      }

      this.handleChange(Math.round(Number(range.noUiSlider.get())))
    });
  };

  componentDidMount() {
    this.initRange();
  }

  componentWillReceiveProps(){
    const { min, max } = this.props;
    this.refs.range.noUiSlider.updateOptions({
      range: {
        'min': min,
        'max': max === min ? max + 1 : max
      }
    });
  }

  checkMinMax = (value, min, max) => {
    if (value < min){
      return min
    } else if (value > max){
      return max
    } else {
      return value
    }
  };

  handleInput = event => {
    let value = event.target.value;
    const valueType = value.replace(/[^\d]/g, '');
    if (isNaN(+valueType) || valueType === "")  return 0

    value.length ? value = formatMoney().from(value) : value = 0;
    if (value > this.props.max){
      value = this.props.max
    }
    this.refs.range.noUiSlider.set(value);
    this.handleChange(value)
  };

  handleBlur = event => {
    let value = event.target.value;
    value.length ? value = formatMoney().from(value) : value = 0;
    this.handleChange(this.checkMinMax(value, this.props.min, this.props.max))
  };

  handleFocus = event => {
    event.target.select()
  };

  handleChange = value => {
    this.props.onChange(value)
  };

  renderNote = () => {
    if (this.props.hasOwnProperty('note')){
      return (
        <div className="input-item__note">{this.props.note}</div>
      )
    }
  };

  renderTip = () => {
    if (this.props.hasOwnProperty('tip')){
      return (
        <div className="input-item__tip">
          {this.props.tip}
        </div>
      )
    }
  };

  render(){
    return (
        <div className={"input-item " + (this.props.error ? 'input-item--error' : '')}>
          <label>
            <div className="input-item__label">{this.props.label}</div>

            <div className="input-item__container">
            {this.renderNote()}
              <div className="input-item__wrapper">
              <input
                type="text"
                value={this.props.isMoney ? formatMoney().to(this.props.value) : this.props.value}
                onChange={this.handleInput}
                onBlur={this.handleBlur}
                onFocus={this.handleFocus}
                ref="input"
              />
              <div className="range" ref="range"></div>
              </div>
            </div>
          </label>
          {this.renderTip()}
        </div>
    )
  }
}


// WEBPACK FOOTER //
// ./src/components/range/index.js