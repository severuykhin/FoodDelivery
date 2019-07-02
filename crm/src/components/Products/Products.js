import React, { Component } from 'react'

export default class Products extends Component {

    renderRows() {
        return this.props.summary.map((item, index) => {
            return (
                <tr key={`product-${index}`}>
                    <td>{item.title}</td>
                    <td>{item.modification_name}</td>
                    <td>{item.quantity}</td>
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
                            <th style={{ width: '300px' }}>Название блюда</th>
                            <th>Модификация</th>
                            <th>Количество заказов</th>
                        </tr>
                    </thead>
                    <tbody>
                        {this.renderRows()}
                    </tbody>
                </table>
            </div>
        )
    }
}
