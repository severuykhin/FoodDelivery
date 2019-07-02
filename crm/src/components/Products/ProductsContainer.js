import React, { Component } from 'react';
import Products from './Products';
import { connect } from 'react-redux';
import axios from 'axios';
import { setProducts } from '../../ducks/Store';

class ProductsContainer extends Component {

    async componentDidMount() {
        let response = await axios.get('/backend/api/products');
        this.props.setProductsSummary(response.data.data);
    }

    render() {
        return (
            <div>
                <Products summary={this.props.productsSummary}/>
            </div>
        )
    }
}

const mapStateToProps = (state) => {
    return {
        productsSummary: state.store.productsSummary
    };
};

const mapDispatchToProps = (dispatch) => {
    return {
        setProductsSummary: (summary) => dispatch(setProducts(summary))
    };
};

export default connect(mapStateToProps, mapDispatchToProps)(ProductsContainer);


