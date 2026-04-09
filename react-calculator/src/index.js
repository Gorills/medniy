import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import registerServiceWorker from './registerServiceWorker';

const rootId = document.getElementById('root');
/*rootId.setAttribute('data-lang', 'en');*/
/*rootId.setAttribute('data-api-url', 'http://api.capitalgroup.ru/api/1.0.0/objects/kytyzovsky/mortgage_terms');*/
/*rootId.setAttribute('data-api-url', 'http://d.filonov.api.cg.dev.cg.notamedia.ru/api/1.0.0/objects/capitaltowers/mortgage_terms');*/
ReactDOM.render(<App />, rootId);
registerServiceWorker();



// WEBPACK FOOTER //
// ./src/index.js