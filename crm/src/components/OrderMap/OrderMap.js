import React from 'react'

class OrderMap extends React.Component {

    constructor(props) {
        super(props);

        this.days = {
            1: 'Пн',
            2: 'Вт',
            3: 'Ср',
            4: 'Чт',
            5: 'Пт',
            6: 'Сб',
            7: 'Вс',
        }

    }

    render() {

        const { items } = this.props;

        return (
            <div>
                <h5>Карта заказов</h5>
                {
                    items && 
                    <table className="table">
                        { this.renderHead() }
                        { this.renderItems() }
                    </table>   
                }
            </div>
        )
    }

    renderHead() {

        const { items } = this.props;

        return (
            <thead>
                <tr>
                    <th></th>
                    { items && Object.keys(items).map((day, index) => {
                        return (
                            <th key={index}>{ this.days[day] }</th>
                        );
                    }) }
                </tr>
            </thead>
        );
    }

    renderItems() {

        const { items, ordersCount } = this.props;
        const days = Object.keys(items);

        const start = items[days[0]];
        const startKeys = Object.keys(start).sort();

        return (
            <tbody>
                { startKeys.map((hour, index) => {
                    return (
                        <tr key={index}>

                            <td>{ `${hour}:00` }</td>

                            { this.renderDayHourCounter(hour, days, items, ordersCount) }
                            
                        </tr>
                    );
                }) }
            </tbody>
        );
    }

    renderDayHourCounter(hour, days, items, ordersCount) {

        return (days.map((day, index) => {

            let count = 0;
            let alfaChannelValue = 0;
            let percent = ordersCount / 100;
            let categoriesTop = <div className="categories-top">Нет данных</div>;

            if (items[day] && items[day][hour]) {
                count = items[day][hour]['count'];
                alfaChannelValue = ((count / percent) / 20).toFixed(4);

                if (Array.isArray(items[day][hour]['categories']['data']) === false) {
                    categoriesTop = this.renderCategoriesTop(items[day][hour]['categories']);
                }
            } 
            return <td 
                    key={index}
                    className="orderMap-td"
                    style={{
                        'color': '#6d6d6d',
                        'textAlign': 'center',
                        'background': `rgba(255,0,0, ${alfaChannelValue})`
                    }}
                    >{ count } { categoriesTop }</td>
        }) )
    }

    renderCategoriesTop(categoriesData) {
        let categoriesArray = Object.keys(categoriesData.data)
                                .map(key => categoriesData.data[key])
                                .sort((a,b) => a.quantity > b.quantity ? -1 : 1)
                                .slice(0, 5);

        return <div className="categories-top"> { categoriesArray.map(category => {
            return (
                <div 
                    key={category.id} 
                    className="categories-top-item">
                    {`${category.title} ${category.percentage}%`}
                </div>
            );
        }) }
        </div>
    }


}

export default OrderMap;
