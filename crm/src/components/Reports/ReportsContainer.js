import React, { Component } from 'react'
import ReportsList from './ReportsList'
import ReportsForm from './ReportsForm'
import { connect } from 'react-redux'
import { getReports, updateForm, sendReport, deleteReport } from '../../ducks/Reports';

class ReportsContainer extends Component {

    componentDidMount() {
        this.props.getReports();
    }

    updateFormData = (data) => {
        this.props.updateForm(data);
    }

    sendReport = (formData) => {
        this.props.sendReport(formData);
    }

    deleteReport = (id) => {
        this.props.deleteReport(id);
    }

    render() {
        return (
            <div className="row">
                <div className="col-md-7">
                    <h5>Все отчеты</h5>
                    <ReportsList
                        deleteReport={ this.deleteReport } 
                        items={this.props.reportsList} />
                </div>
                <div className="col-md-5">
                    <h5>Добавить</h5>
                    <ReportsForm
                        sendReport={this.sendReport}
                        updateFormData={this.updateFormData} 
                        data={this.props.formData} />
                </div>
            </div>
        )
    }
}

const mapStateToProps = (state) => ({
    reportsList: state.reports.items,
    formData: state.reports.form
});

const mapDispatchToProps = (dispatch) => ({
    getReports: () => dispatch(getReports()),
    updateForm: (data) => dispatch(updateForm(data)),
    sendReport: (data) => dispatch(sendReport(data)),
    deleteReport: (id) => dispatch(deleteReport(id))
});

export default connect(mapStateToProps, mapDispatchToProps, null, { pure: false })(ReportsContainer);
