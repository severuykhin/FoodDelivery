import React, { Component } from 'react';
import Products from './Products';
import { connect } from 'react-redux';
import axios from 'axios';
import { setProducts, getProductCrossSell } from '../../ducks/Store';

class ProductsContainer extends Component {

    async componentDidMount() {
        let response = await axios.get('/backend/api/products');
        this.props.setProductsSummary(response.data.data);
    }

    getCrossSell(productId) {
        this.props.getProductCrossSell(productId);
    }

    render() {

        return (
            <div>
                <Products 
                    summary={this.props.productsSummary}
                    crossSell={this.props.productsCrossSell}
                    getCrossSell={this.getCrossSell.bind(this)}    
                    />
            </div>
        )
    }
}

const mapStateToProps = (state) => {
    return {
        productsSummary: state.store.productsSummary,
        productsCrossSell: state.store.productsCrossSell
    };
};

const mapDispatchToProps = (dispatch) => {
    return {
        setProductsSummary: (summary) => dispatch(setProducts(summary)),
        getProductCrossSell: (productId) => dispatch(getProductCrossSell(productId))
    };
};

export default connect(mapStateToProps, mapDispatchToProps, null, { pure: false })(ProductsContainer);


