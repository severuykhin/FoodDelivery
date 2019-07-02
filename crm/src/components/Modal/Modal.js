import React, { Component } from 'react'

export default class Modal extends Component {
  render() {
    return (
        <div className="modal fade">
        <div className="modal-dialog">
          <div className="modal-content">
            <div className="modal-header">
              <button type="button" className="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 className="modal-title">Название модали</h4>
            </div>
            <div className="modal-body">
              <p>One fine body&hellip;</p>
            </div>
            <div className="modal-footer">
              <button type="button" className="btn btn-default" data-dismiss="modal">Закрыть</button>
              <button type="button" className="btn btn-primary">Сохранить изменения</button>
            </div>
          </div>
        </div>
      </div>
    )
  }
}
