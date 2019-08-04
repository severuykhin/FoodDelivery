import React, { Component } from 'react'

/** 
 * @param { Object } date - Standard new Date() instance
 * @returns { String } dd-mm-yyyy
*/
const getDate = (date = false) => {
    let today = date ? date : new Date();
    let dd = today.getDate();
    let mm = today.getMonth()+1; 
    let yyyy = today.getFullYear();
    
    if(dd<10) dd='0'+dd; 
    if(mm<10) mm='0'+mm; 
    
    return dd+'-'+mm+'-'+yyyy;
}

const getStartOfMonth = () => {
    let d = new Date();
    d.setDate(1);
    return getDate(d);
}

const getStartOfTheWeek = () => {
    let d = new Date();
    var day = d.getDay(),
        diff = d.getDate() - day + (day === 0 ? -6:1); // adjust when day is sunday
    return getDate(new Date(d.setDate(diff)));
}

const rangeInputStyle = (isActive) => ({
    height: '20px',
    width: isActive ? '161px' : '0px',
    transition: 'all 400ms ease', 
    marginLeft: isActive ? '10px' : 0,
    border: 'none',
    background: 'transparent'
});

const dateInputStyle = (isActive) => {
    let baseStyles = rangeInputStyle(isActive);
    baseStyles.width = isActive ? '100px' : '0px';
    return baseStyles; 
};



class DatePicker extends Component {

    constructor(props) {
        super(props);

        let today = getDate();
        let monthStart = getStartOfMonth();
        let weekStart = getStartOfTheWeek();

        this.datepicker = null;
        this.dateDatepicker = null;

        this.state = {
            variants: {
                1: {
                    id: 1,
                    title: 'Сегодня',
                    start: today,
                    end: today,
                    type: 'today'
                },
                2: {
                    id: 2,
                    title: 'За неделю',
                    start: weekStart,
                    end: today,
                    type: 'today'
                },
                3: {
                    id: 3,
                    title: 'За месяц',
                    start: monthStart,
                    end: today,
                    type: 'week'
                },
                4: {
                    id: 4,
                    title: 'За все время',
                    start: 0,
                    end: today,
                    type: 'all'
                },
                5: {
                    id: 5,
                    title: 'Диапазон',
                    start: 0,
                    end: 0,
                    type: 'range'
                },
                6: {
                    id: 6,
                    title: 'Дата',
                    start: 0,
                    end: 0,
                    type: 'date'
                },
            },
            detailVariants: {
                1: {
                    id: 1,
                    title: 'По дням',
                    type: 'days'
                },
                2: {
                    id: 2,
                    title: 'По месяцам',
                    type: 'monthes'
                }
            },
            activeVariant: 1,
            activeDetailVariant: 1,
            rangeActive: false,
            dateActive: false,
            activeQuery: {}
        };
    }

    componentDidMount() {
        // Force trigger default init range
        let queryData = this.state.variants[this.state.activeVariant];
        queryData.detail = this.getDetailType();
        this.setState({ activeQuery: queryData });
        this.props.onChange(queryData);
    }

    getDetailType(index) {
        if (typeof index !== 'undefined') {
            return this.state.detailVariants[index].type;
        } 
        return this.state.detailVariants[this.state.activeDetailVariant].type;
    }

    resolveBtnClick = (btnKey) => {

        let key = parseInt(btnKey, 10);

        this.setState({ activeVariant: btnKey });
        if (key === 5) {
            this.setState({ rangeActive: true, dateActive: false });
            this.initDatepicker();
            return;
        } 
        else if (key === 6) {
            this.setState({ dateActive: true, rangeActive: false });
            this.initDateDatepicker();
            return;
        }
        else {
            this.setState({ rangeActive: false, dateActive: false });
        }

        let selectedRange = {
            ...this.state.variants[btnKey],
            detail: this.getDetailType()
        }
        this.props.onChange(selectedRange);
    }

    initDateDatepicker() {
        this.dateDatepicker = window.$('#datepicker-date').datepicker({
            onSelect: this.handleDateChange,
            dateFormat: 'dd-mm-yyyy'
        }).data('datepicker');

        this.dateDatepicker.show();
    }

    initDatepicker() {
        this.datepicker = window.$('#datepicker-range').datepicker({
            range: true,
            multipleDatesSeparator: ' - ',
            onSelect: this.handleRangeChange,
            dateFormat: 'dd-mm-yyyy'
        }).data('datepicker');

        this.datepicker.show();
    }

    renderButtons() {
        let keys = Object.keys(this.state.variants);

        return keys.map((key, index) => {

            let item = this.state.variants[key];
            let activeClassName = +key === +this.state.activeVariant ? 'active' : '';
            let isRange = parseInt(key, 10) === 5;
            let isDate = parseInt(key, 10) === 6;

            return (
                <button 
                    key={`btn-${key}`}
                    className={`btn btn-default ${activeClassName} ${isRange && 'btn-range'}`}
                    onClick={() => { this.resolveBtnClick(key) }}>
                    { item.title }
                    { isRange && 
                        <input
                            onChange={this.handleRangeChange} 
                            type="text" 
                            id="datepicker-range"
                            style={ rangeInputStyle(this.state.rangeActive) } />  }
                    { isDate && 
                        <input
                            onChange={this.handleDateChange} 
                            type="text" 
                            id="datepicker-date"
                            style={dateInputStyle(this.state.dateActive)} />  }
                </button>
            );
        });
    }

    handleRangeChange = (date) => {
        let range = date.split(' - ');
        if (range.length <= 1) return;

        let detail = this.getDetailType();

        this.handleChange(range[0], range[1], detail);
        if (this.datepicker != null) {
            this.datepicker.hide();
        }
    }

    handleDateChange = (date) => {

        let detail = this.getDetailType();

        this.handleChange(date, date, detail);
        if (this.dateDatepicker != null) {
            this.dateDatepicker.hide();
        }
    }

    handleChange = (start, end, detail) => {

        let queryData = this.state.variants[this.state.activeVariant];
        queryData.start = start;
        queryData.end = end;
        queryData.detail = detail;

        this.setState({ activeQuery: queryData });
        this.props.onChange(queryData);
    }

    renderDetailButtons() {
        let keys = Object.keys(this.state.detailVariants);

        return keys.map((key, index) => {
            let item = this.state.detailVariants[key];
            let activeClassName = +key === +this.state.activeDetailVariant ? 'active' : '';

            return (
                <button 
                    key={`btn-${key}`}
                    className={`btn btn-default ${activeClassName}`}
                    onClick={() => { this.resolveDetailClick(key) }}>
                    { item.title }
                </button>
            );
        });
    }

    resolveDetailClick(index) {
        this.setState({ activeDetailVariant: index });
        this.handleChange(
            this.state.activeQuery.start, 
            this.state.activeQuery.end,
            this.getDetailType(index)
        );

    }

    render() {

        return (
            <div>
                <div className="btn-group" style={{marginRight: '20px'}} role="group" aria-label="...">
                    { this.renderButtons() }
                </div>
                <div className="btn-group" style={{marginRight: '20px'}} role="group" aria-label="...">
                    { this.renderDetailButtons() }
                </div>
            </div>
        )
    }
}

export default DatePicker;
