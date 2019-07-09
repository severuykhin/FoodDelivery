import React, { Component } from 'react'

export default class Orders extends Component {
  render() {

    const summary = this.props.summary;

    return (
      <div>
        <table className="table table-striped">
            <thead>
              <tr>
                <th style={{width: '300px'}}>Метрика</th>
                <th>Значение</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Всего заказов с онлайна</td>
                <td>{ summary.count ? summary.count : '-' }</td>
              </tr>
              <tr>
                <td>Средний чек</td>
                <td>{ summary.avg ? `${summary.avg} р` : '-' }</td>
              </tr>
              <tr>
                <td>В день</td>
                <td>{ summary.perDay ? summary.perDay : '-' }</td>
              </tr>
              <tr>
                <td>Самый объемный заказ</td>
                <td>
                  { summary.biggest ? `${summary.biggest.summ} р` : '-' }
                  {/* <button 
                    onClick={this.props.showDearestOrder}
                    style={{marginLeft: '10px', borderRadius: '50%'}} 
                    type="button" 
                    className="btn btn-default btn-xs">
                    <span className="glyphicon glyphicon-question-sign"></span>
                  </button> */}
                </td>
              </tr>
              <tr>
                <td>Общий доход</td>
                <td>{ summary.totalSumm ? `${summary.totalSumm} р` : '-' }</td>
              </tr>
            </tbody>
        </table>
      </div>
    )
  }
}