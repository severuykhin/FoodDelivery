import React, { Component } from 'react'
import Customers from './Customers';
import axios from 'axios';
import { setCustomers } from '../../ducks/Store';
import { connect } from 'react-redux';

class CustomersContainer extends Component {

  async componentDidMount() {
    let response = await axios.get('/backend/api/customers');
    this.props.setCustomersSummary(response.data);
  }

  render() {
    return (
      <div>
        <Customers summary={this.props.customers} />
      </div>
    )
  }
}

const mapStateToProps = (state) => {
  return {
    customers: state.store.customerSummary
  };
}

const mapDispatchToProps = (dispatch) => {
  return {
    setCustomersSummary: (customersSummery) => dispatch(setCustomers(customersSummery))
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(CustomersContainer);
