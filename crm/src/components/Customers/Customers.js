import React, { Component } from 'react'

export default class Customers extends Component {

  renderRows() {
    if (this.props.summary.length <= 0) return <tr></tr>;

    return this.props.summary.map((customer, index) => {

      let customerTotalCount = customer.count.reduce((pVal, nValue) => {
        return pVal + nValue.order_total;
      }, 0);

      let firstCustomerOrderTimestamp = customer.orders[0].created_at * 1000, //Microtime
          date = new Date(firstCustomerOrderTimestamp),
          dateString = `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()}`;

      return (
        <tr key={`customer-${index}`}>
          <td>{customer.phone}</td>
          <td>{customer.name}</td>
          <td>{customer.total_count}</td>
          <td>
            {customerTotalCount} р.
          </td>
          <td>{ Math.floor(customerTotalCount / customer.count.length) } р.</td>
          <td>{ dateString }</td>
        </tr>
      );
    });
  }

  render() {
    return (
      <div>
        <table className="table table-striped">
            <thead>
              <tr>
                <th style={{width: '300px'}}>Номер телефона</th>
                <th>Имя</th>
                <th>Количество заказов</th>
                <th>Общая сумма</th>
                <th>Средний чек</th>
                <th>Первый заказ</th>
              </tr>
            </thead>
            <tbody>
                { this.renderRows() }
            </tbody>
        </table>
      </div>
    )
  }
}
