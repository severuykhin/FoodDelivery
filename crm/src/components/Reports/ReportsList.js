import React from 'react'

export default function Reports(props) {

    let manageActions = props.manageActions === false ? false : true;

    const renderList = () => {
        return props.items.map((item, index) => {
            return (
                <div key={`report-${ item.id }`} className="panel panel-default">
                    <div className="panel-heading">
                        { item.title }
                        { manageActions && <button
                            onClick={ () => { props.deleteReport(item.id) } }
                            className="btn btn-xs btn-default pull-right">
                            <span className="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </button> }
                    </div>
                    <div className="panel-body">
                        { item.text }
                    </div>
                    <div className="panel-footer">{ getReportFullDateTime(item.created_at * 1000) }</div>
                </div>
            );
        });
    };

    /**
     * Returns formatted datetime value on given timestamp
     * @param { number } reportCreatedAtTimestamp 
     * @returns { string } dateTime - dd-mm-yyyy hh:mm
     */
    const getReportFullDateTime = (reportCreatedAtTimestamp) => {
        let date = new Date(reportCreatedAtTimestamp),
            dateTime = `${date.getDate()}-${date.getMonth() + 1}-${date.getFullYear()} ${date.getHours()}:${date.getHours()}`;

        return dateTime;
    }

    return (
        <div>
            { props.items.length > 0 && renderList() }
        </div>
    )
}
