import React from 'react';
import ReactDOM from 'react-dom';
import App from './components/App';

import AdminHome from './components/admin/AdminHome';

if(document.getElementById('root')){
    ReactDOM.render(
        <App />,
    document.getElementById('root')
    );
}else if(document.getElementById('adminHome')){
    ReactDOM.render(
        <AdminHome />,
    document.getElementById('adminHome')
    );
}