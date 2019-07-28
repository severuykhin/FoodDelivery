import React, { Component } from 'react'
import Orders from './Orders'
import { connect } from 'react-redux';
import { setOrders, toggleModal } from '../../ducks/Store';
import axios from 'axios';
import DatePicker from '../DatePicker/DatePicker';

class OrdersContainer extends Component {

  constructor(props) {
    super(props);

    this.state = {
      loading: false
    };
  }

  async componentDidMount() {

  }

  async handleRangeChange (data) {
    this.setState({loading: true});
    const response = await axios.get('/backend/api/orders', {
      params: data
    });

    if (response.data.result !== 'ok') {
      alert('Ошибка');
      return false;
    } 

    this.props.setOrders(response.data.payload);

    this.setState({loading: false});
  }

  componentDidUpdate(prevProps, prevState) {
    // Object.entries(this.props).forEach(([key, val]) =>
    //   prevProps[key] !== val && console.log(`Prop '${key}' changed`)
    // );
  }

  showDearestOrder = () => {
    this.props.toggleModal(true);
  }

  render() {
    return (
      <div className="row">
        <div className="col-lg-12" style={{marginBottom: '20px'}}>
          <DatePicker
           onChange={this.handleRangeChange.bind(this)}/>
        </div>
        <Orders 
          summary={this.props.ordersSummary} 
          showDearestOrder={this.showDearestOrder}/>
      </div>
    )
  }
}

const mapStateToProps = (state) => {
  return {
    ordersSummary: state.store.ordersSummary,
    reports: state.reports.items
  };
};

const mapDispatchToProps = dispatch => ({
  setOrders: (orders) => dispatch(setOrders(orders)),
  toggleModal: (isOpen) => dispatch(toggleModal(isOpen))
});

export default connect(mapStateToProps, mapDispatchToProps, null, { pure: false })(OrdersContainer);