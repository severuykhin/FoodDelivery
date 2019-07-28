import React, { Component } from 'react'

class ReportsForm extends Component {

    componentDidMount() {

        window.addEventListener('load', () => {
            this.datepicker = window.$('#report-date').datepicker({
                multipleDatesSeparator: ' - ',
                dateFormat: 'dd-mm-yyyy',
                timepicker: true,
                onSelect: (fDate, date, inst) => {
                    this.props.updateFormData({
                        name: 'date',
                        value: fDate
                    });
                }
            }).data('datepicker');
        });
    }

    update = (e) => {
        let data = { 
            name: e.currentTarget.name, 
            value: e.currentTarget.value 
        };

        this.props.updateFormData(data);
    }

    submit = (e) => {
        e.preventDefault();
        const data = new FormData(e.currentTarget);
        this.props.sendReport(data);
    }

    render() {

        return (
            <div className="panel panel-default">
                <div className="panel-body">
                    <form onSubmit={this.submit}>
                        <input
                            onChange={this.update} 
                            type="hidden" 
                            name="id" 
                            value={this.props.data.id} />
                        <div className="form-group">
                            <label htmlFor="exampleInputEmail1">Заголовок</label>
                            <input 
                                onChange={this.update}
                                name="title" 
                                value={this.props.data.title} 
                                type="text" 
                                className="form-control" 
                                placeholder="Заголовок" /> 
                        </div>
                        <div className="form-group">
                            <label htmlFor="exampleInputPassword1">Дата</label>
                            <input
                                id="report-date"
                                onChange={this.update} 
                                name="date" 
                                type="text" 
                                value={this.props.data.date} 
                                className="form-control" 
                                placeholder="Дата" /> 
                        </div>
                        <div className="form-group">
                            <textarea
                                onChange={this.update} 
                                value={this.props.data.text} 
                                name="text" 
                                style={{'resize': 'none'}} 
                                className="form-control" 
                                rows="5" 
                                placeholder="Краткий отчет"></textarea> 
                        </div>
                        <div className="form-group">
                            <button className="btn btn-default">Сохранить</button> 
                        </div>
                    </form>   
                </div>
            </div>
        )
    }
}

export default ReportsForm;
