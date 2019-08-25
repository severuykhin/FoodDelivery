import React, { Component } from 'react'
import Customers from './Customers';
import axios from 'axios';
import { setCustomers } from '../../ducks/Store';
import { connect } from 'react-redux';
import { getRegularCustomerReport } from '../../redux/selectors/customers';

class CustomersContainer extends Component {

  async componentDidMount() {
    let response = await axios.get('/backend/api/customers');
    this.props.setCustomersSummary(response.data);
  }

  render() {
    return (
      <div>
        <Customers 
          summary={this.props.customers} 
          regularCustomerReport={this.props.regularCustomerReport}
          />
      </div>
    )
  }
}

const mapStateToProps = (store) => {
  return {
    customers: store.store.customerSummary,
    regularCustomerReport: getRegularCustomerReport({...store})
  };
}

const mapDispatchToProps = (dispatch) => {
  return {
    setCustomersSummary: (customersSummery) => dispatch(setCustomers(customersSummery))
  };
};

export default connect(mapStateToProps, mapDispatchToProps)(CustomersContainer);
