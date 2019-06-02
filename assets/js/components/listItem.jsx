import React from 'react';

class ListItem extends React.Component{
    render() {
        return (
            <li className="sidebar-menu-item"><a className="mdc-list-item__text" href={"/" + this.props.href}>{this.props.text}</a></li>
        );
    }
}

export default ListItem;
