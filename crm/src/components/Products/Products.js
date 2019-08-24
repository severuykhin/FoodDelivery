import React, { Component } from 'react'

export default class Products extends Component {

    render() {
        return (
            <div>
                <table className="table table-striped">
                    <thead>
                        <tr>
                            <th style={{ width: '300px' }}>Название блюда</th>
                            <th>Модификация</th>
                            <th>Количество заказов</th>
                            <th style={{width: '400px'}}>Cross sell</th>
                        </tr>
                    </thead>
                    <tbody>
                        {this.renderRows()}
                    </tbody>
                </table>
            </div>
        )
    }


    renderRows() {
        return this.props.summary.map((item, index) => {
            return (
                <tr key={`product-${index}`}>
                    <td>{item.title}</td>
                    <td>{item.modification_name}</td>
                    <td>{item.quantity}</td>
                    <td style={{height: '51px'}}>{ this.renderCrossSellTd(item.product_id) }</td>
                </tr>
            );
        });
    }

    renderCrossSellTd(product_id) {
        const { crossSell } = this.props;
        
        if (typeof crossSell[product_id] !== 'undefined') {
            return this.renderCrossSellItems(crossSell[product_id]);
        } else {
            return (
                <button
                    onClick={() => { this.props.getCrossSell(product_id) }} 
                    className="btn btn-sx btn-default">
                    Посмотреть cross sell
                </button>
            )
        }
    }

    renderCrossSellItems(items) {
        return items.map((item, index) => {
            console.log(item);
            return <div key={index}>{ item.title } - { item.count }</div>
        });
    }
}
