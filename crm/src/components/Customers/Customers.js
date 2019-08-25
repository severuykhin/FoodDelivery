import React, { Component } from 'react'

export default class Customers extends Component {

  renderRows() {
    if (this.props.summary.length <= 0) return <tr></tr>;

    return this.props.summary.map((customer, index) => {

      let customerTotalCount = customer.count.reduce((pVal, nValue) => {
        return pVal + nValue.order_total;
      }, 0);

      let firstCustomerOrderTimestamp = customer.orders[0].created_at * 1000;
      let lastCustomerOrderTimeStamp = customer.orders.pop().created_at * 1000;

      return (
        <tr key={`customer-${index}`}>
          <td>{ index + 1 }</td>
          <td>{ customer.phone }</td>
          <td>{ customer.name }</td>
          <td>{ customer.total_count }</td>
          <td>
            {customerTotalCount} р.
          </td>
          <td>{ Math.floor(customerTotalCount / customer.count.length) } р.</td>
          <td>{ this.formatDate(firstCustomerOrderTimestamp) }</td>
          <td>{ this.formatDate(lastCustomerOrderTimeStamp) }</td>
        </tr>
      );
    });
  }

  render() {
    
    let { regularCustomerReport } = this.props;

    return (
      <div>
        <div className="row">
          <div className="col-lg-8">
            <table className="table table-striped">
              <thead>
                <tr>
                  <th style={{width: '50px'}}>#</th>
                  <th style={{width: '150px'}}>Номер телефона</th>
                  <th style={{width: '130px'}}>Имя</th>
                  <th style={{width: '130px'}}>Кол-во зак.</th>
                  <th style={{width: '150px'}}>Общая сумма</th>
                  <th style={{width: '150px'}}>Средний чек</th>
                  <th style={{width: '150px'}}>Первый заказ</th>
                  <th style={{width: '150px'}}>Последний заказ</th>
                </tr>
              </thead>
              <tbody>
                  { this.renderRows() }
              </tbody>
            </table>
          </div>
          <div className="col-lg-4">
          { regularCustomerReport && this.renderRegularCusomerReport() }
          </div>
        </div>
      </div>
    )
  }

  renderRegularCusomerReport() {

    let { regularCustomerReport } = this.props;

    console.log('sdf');

    return (
      <table className="table table-striped">
          <tbody>
              <tr>
                  <td>Все покупателей</td>
                  <td>{ regularCustomerReport.totalCount }</td>                  
              </tr>
              <tr>
                  <td>Заказали более 1 раза</td>
                  <td>{ regularCustomerReport.regularCustomersCount }</td>                  
              </tr>
              <tr>
                  <td>Соотношение</td>
                  <td>{ regularCustomerReport.percentage }%</td>                  
              </tr>
              
          </tbody>
      </table>
    );
  }

  formatDate(timeStamp) {
    let date = new Date(timeStamp);
    return `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}`;
  }
}
