import React, {Component} from 'react';

class DeleteModal extends Component {
    render() {
        return (
            <div id={this.props.id} className="modal fade" role="dialog">
                <div className="modal-dialog">

                    <div className="modal-content">
                        <div className="modal-header">
                            <button type="button" className="close" data-dismiss="modal">&times;</button>
                            <h4 className="modal-title">{this.props.title}</h4>
                        </div>
                        <div className="modal-body">
                            {this.props.text}

                            <button id="modalDeleteLink" className="btn btn-default">Ja</button>
                            <button type="button" className="btn btn-default" data-dismiss="modal">Nein</button>
                        </div>
                    </div>

                </div>
            </div>
        );
    }
}

export default DeleteModal;