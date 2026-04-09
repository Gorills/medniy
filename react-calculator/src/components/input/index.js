import React, { Component } from 'react';

import './index.css'

export default class Input extends Component {

  render(){

    const { label, type, onChange, value, required } = this.props;

    return (
      <div className="input-item">
        <label>
          <div className={'input-item__label ' + (type === 'select' ? 'input-item__label--big' : '')}>{label}</div>
          {type === 'select' ? (
              <div className="input-item__container">
                  <div className="input-item__wrapper">
                      <select onChange={onChange}>
                      {value.map((value, i) =>
                              <option key={i} value={value}>{value}</option>
                      )}
                      </select>
                  </div>
              </div>
          ) : (
            <input
              type={type || 'text'}
              value={value}
              onChange={onChange}
              required={required}
            />
          )}
        </label>
      </div>
    )
  }
}


// WEBPACK FOOTER //
// ./src/components/input/index.js