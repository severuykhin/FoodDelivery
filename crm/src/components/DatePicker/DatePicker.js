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



class DatePicker extends Component {

    constructor(props) {
        super(props);

        let today = getDate();
        let monthStart = getStartOfMonth();
        let weekStart = getStartOfTheWeek();

        this.datepicker = null;

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
            },
            activeVariant: 1,
            rangeActive: false
        };
    }

    componentDidMount() {
        // Force trigger default init range
        this.props.onChange(this.state.variants[this.state.activeVariant]);
    }

    resolveBtnClick = (btnKey) => {

        this.setState({ activeVariant: btnKey });
        if (parseInt(btnKey, 10) === 5) {
            this.setState({ rangeActive: true });
            this.initDatepicker();
            return;
        } else {
            this.setState({ rangeActive: false });
        }

        let selectedRange = {...this.state.variants[btnKey]}
        this.props.onChange(selectedRange);
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
                </button>
            );
        });
    }

    handleRangeChange = (date) => {
        let range = date.split(' - ');
        if (range.length <= 1) return;

        this.props.onChange({
            id: 5,
            title: 'Диапазон',
            start: range[0],
            end: range[1],
            type: 'range'
        });

        if (this.datepicker != null) {
            this.datepicker.hide();
        }
    }

    render() {

        return (
            <div>
                <div className="btn-group" style={{marginRight: '20px'}} role="group" aria-label="...">
                    { this.renderButtons() }
                </div>
            </div>
        )
    }
}

export default DatePicker;
