import React, { Component, Fragment } from 'react';
import Navigation from '../Navigation/Navigation'

import {
  BrowserRouter,
  Route,
  Switch
} from 'react-router-dom';

import OrdersContainer from '../Orders/OrdersContainer';
import CustomersContainer from '../Customers/CustomersContainer';
import ProductsContainer from '../Products/ProductsContainer';
import ReportsContainer from '../Reports/ReportsContainer';

const crmBaseStyle = {
  padding: '20px'
};

const crmContainerStyle = {
  paddingTop: '20px'
};

export default class App extends Component {
  render() {
    return (
      <div style={crmBaseStyle} className="crm">
        <BrowserRouter>
          <Fragment>
            <Navigation />

            <div style={crmContainerStyle} className="crm-container">

              <Switch>
                <Route exact path="/backend/crm/orders" component={OrdersContainer} />
                <Route exact path="/backend/crm/customers" component={CustomersContainer} />
                <Route exact path="/backend/crm/products" component={ProductsContainer} />
                <Route exact path="/backend/crm/reports" component={ReportsContainer} />
              </Switch>

            </div>

          </ Fragment>

        </ BrowserRouter>

      </div>
    )
  }
}
