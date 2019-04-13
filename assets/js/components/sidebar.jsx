import React from 'react';
import ListItem from "./listItem";

class Sidebar extends React.Component{

    getItemData() {
        return [
            { id: 1, text: 'Dashboard', href: 'dashboard', icon: 'bar_chart' },
            { id: 2, text: 'Kunden', href: 'customers', icon: 'address-card'},
            { id: 3, text: 'Anwesenheitsliste', href: 'attendance', icon: 'calendar'},
            { id: 4, text: 'Abonnemente', href: 'bill', icon: 'file-text'},
            { id: 5, text: 'Abos verwalten', href: 'abo', icon: 'files-o'},
            { id: 6, text: 'Zahlungen', href: 'payment', icon: 'credit-card'},
            { id: 7, text: 'Stunden', href: 'hour', icon: 'clock-o'},
            { id: 8, text: this.props.username, href: 'profile', icon: 'user'},
            { id: 9, text: 'Abmelden', href: 'logout', icon: 'power-off'},
        ];
    }

    render() {
        return (
            <div className="sidebar">
                <div className="inner-sidebar">
                    <a href="/"><img className="logo" src="build/images/logo.3a97e839.png" alt="Lu Jong Tibetisches Yoga Logo"/></a>
                    <ul className="mdc-list">
                        {this.getItemData().map(item => (
                            <ListItem key={item.id} text={item.text} href={item.href} icon={item.icon} />
                        ))}
                    </ul>
                </div>
            </div>
        );
    }
}

export default Sidebar;
