const formatYears = (year) => {
  let suffix = '';
  let number = year % 100;

  if (number >= 5 && number <= 20) {
    suffix = 'лет';
  } else {
    number %= 10;
    if (number === 1) {
      suffix = 'год';
    } else if (number >= 2 && number <= 4) {
      suffix = 'года';
    } else {
      suffix = 'лет';
    }
  }

  return year + ' ' + suffix
};

export default formatYears;


// WEBPACK FOOTER //
// ./src/helpers/format-years/index.js