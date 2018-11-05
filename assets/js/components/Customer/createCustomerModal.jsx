import React, {Component} from 'react';

class CreateCustomerModal extends Component {
    render() {
        return (
            <div id="addModal" className="modal fade" role="dialog">
                <div className="modal-dialog">

                    <div className="modal-content">
                        <div className="modal-header">
                            <button type="button" className="close" data-dismiss="modal">&times;</button>
                            <h4 className="modal-title">Kunde hinzufügen</h4>
                        </div>
                        <div className="modal-body">
                            <form id="addForm">

                            </form>

                            <div className="mandatory"><span>*</span> Pflichtfelder</div>
                        </div>
                        <div className="modal-footer">
                            <input className="btn btn-default" name="submit" type="submit" form="addForm" value="Hinzufügen"/>
                            <button type="button" className="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>

                </div>
            </div>
        );
    }
}

export default CreateCustomerModal;