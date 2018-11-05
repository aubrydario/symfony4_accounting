import React, {Component} from 'react';

class TriggerModalButton extends Component {
    render() {
        return (
            <button type="button" className="btn anthrazit" data-toggle="modal" data-target={this.props.dataTarget}><i className="fa fa-plus" /> {this.props.text}</button>
        );
    }
}

export default TriggerModalButton;