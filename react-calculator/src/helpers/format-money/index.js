import wNumb from '../../../node_modules/wnumb/wNumb.js'

const formatMoney = (suffix) => {
  const options = {
    mark: ',',
    thousand: ' ',
    decimals: 0
  };

  if (suffix){
    options.suffix = ' руб.'
  }

  return wNumb(options);
};

export default formatMoney;


// WEBPACK FOOTER //
// ./src/helpers/format-money/index.js