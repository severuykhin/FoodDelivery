import React, { Component } from 'react'
import { connect } from 'react-redux'
import OrderMap from './OrderMap'
import { getOrderMapSelector } from '../../redux/selectors/orders';


const mapStateToProps = (state) => {
    return {
        data: getOrderMapSelector(state)
    };
};

const mapDispatchToProps = () => {
    return {

    };
}

class OrderMapContainer extends Component {
    render() {

        const { data: { items, ordersCount } } = this.props;
        
        return (
            <OrderMap 
                items={items} 
                ordersCount={ordersCount} 
                />
            )
        }
    }
    
export default connect(mapStateToProps, mapDispatchToProps, null, { pure: false })(OrderMapContainer);