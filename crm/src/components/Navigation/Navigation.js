import React, { Component } from 'react'
import { NavLink } from 'react-router-dom';

export default class Navigation extends Component {
  render() {
    return (
        <div className="btn-group" role="group" aria-label="...">
            <NavLink to="/backend/crm/orders" className="btn btn-default">Сводка по заказам</NavLink>
            <NavLink to="/backend/crm/customers" className="btn btn-default">Сводка по клиентам</NavLink>
            <NavLink to="/backend/crm/products" className="btn btn-default">Сводка по меню</NavLink>
        </div>
    )
  }
}
