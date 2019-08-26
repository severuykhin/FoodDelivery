import React, { Component } from 'react'

export default class Customers extends Component {

  render() {
    
    let { regularCustomerReport } = this.props;

    return (
      <div>
        <div className="row">
          <div className="col-lg-9">
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
          <div className="col-lg-3">
          { regularCustomerReport && this.renderRegularCusomerReport() }
          </div>
        </div>
      </div>
    )
  }

  renderRows() {
    if (this.props.summary.length <= 0) return <tr></tr>;

    return this.props.summary.map((customer, index) => {

      let elem = null;

      try { 
        // Just because i can. But serious - in early version a used .pop() to get last element of orders array.
        // This led to an error and data loss because pop() deletes element completely - because of memoisation of data
        let customerTotalCount = customer.count.reduce((pVal, nValue) => {
          return pVal + nValue.order_total;
        }, 0);

        let lastOrderIndex = customer.orders.length - 1;
  
        let firstCustomerOrderTimestamp = customer.orders[0].created_at * 1000;
        let lastCustomerOrderTimeStamp = customer.orders[lastOrderIndex].created_at * 1000;
  
        elem = (
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
      } catch (e) {
        elem = (
          <tr key={index}>
            <td>{ index + 1 }</td>
            <td>{ e.message }</td>
            <td>{ e.stack }</td>
            { [1,2,3,4,5].map((i, k) => <td key={k}></td>) }
          </tr>
        );
      }

      return elem;
    });
  }

  renderRegularCusomerReport() {

    let { regularCustomerReport } = this.props;

    return (
      <table className="table table-striped">
          <tbody>
              <tr>
                  <td>Всего покупателей</td>
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
