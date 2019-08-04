import React, { Component } from 'react'
import Orders from './Orders'
import { connect } from 'react-redux';
import { setOrders, setOrdersQuery, toggleModal } from '../../ducks/Store';
import axios from 'axios';
import DatePicker from '../DatePicker/DatePicker';

class OrdersContainer extends Component {

  constructor(props) {
    super(props);

    this.state = {
      loadingOrders: false,
      loadingStatistics: false
    };
  }

  async componentDidMount() {

  }

  async handleRangeChange (data) {
    this.ordersRequest(data);
    this.statisticsRequest(data);
  }

  async ordersRequest(data) {
    this.setState({loadingOrders: true});

    const response = await axios.get('/backend/api/orders', {
      params: data
    });

    if (response.data.result !== 'ok') {
      alert('Ошибка');
      return false;
    } 
    this.props.setOrders(response.data.payload);

    this.setState({loadingOrders: false});
  }


  async statisticsRequest(data) {
    this.setState({loadingOrders: true});

    axios.get('/backend/api/statistics', { params: data
    }).then((response) => {
      console.log(response);
      this.setState({loadingOrders: false});
    }).catch(e => {
      console.log(e);
    });
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
    reports: state.reports.items,
    ordersQuery: state.store.ordersQuery
  };
};

const mapDispatchToProps = dispatch => ({
  setOrders: (orders) => dispatch(setOrders(orders)),
  toggleModal: (isOpen) => dispatch(toggleModal(isOpen)),
  setOrdersQuery: (data) => dispatch(setOrdersQuery(data))
});

export default connect(mapStateToProps, mapDispatchToProps, null, { pure: false })(OrdersContainer);