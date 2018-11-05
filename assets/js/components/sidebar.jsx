import React from 'react';

class Sidebar extends React.Component{
    render() {
        return (
            <div className="sidebar">
                <a href="/"><img className="logo" src="build/images/logo.3a97e839.png" alt="Lu Jong Tibetisches Yoga Logo"/></a>
                <ul>
                    <li className="sidebar-menu-item"><a href="/dashboard"><i className="fa fa-tachometer" aria-hidden="true"></i>Dashboard</a></li>
                    <li className="sidebar-menu-item"><a href="/customers"><i className="fa fa-address-card" aria-hidden="true"></i>Kunden</a></li>
                    <li className="sidebar-menu-item"><a href="/attendance"><i className="fa fa-calendar" aria-hidden="true"></i>Anwesenheitsliste</a></li>
                    <li className="sidebar-menu-item"><a href="/bill"><i className="fa fa-file-text" aria-hidden="true"></i>Abonnemente</a></li>
                    <li className="sidebar-menu-item"><a href="/abo"><i className="fa fa-files-o" aria-hidden="true"></i>Abos verwalten</a></li>
                    <li className="sidebar-menu-item"><a href="/payment"><i className="fa fa-credit-card" aria-hidden="true"></i>Zahlungen</a></li>
                    <li className="sidebar-menu-item"><a href="/hour"><i className="fa fa-clock-o" aria-hidden="true"></i>Stunden</a></li>
                    <li className="sidebar-menu-item"><a href="/profile"><i className="fa fa-user" aria-hidden="true"></i>{this.props.username}</a></li>
                    <li className="sidebar-menu-item"><a href="/logout"><i className="fa fa-power-off" aria-hidden="true"></i>Abmelden</a></li>
                </ul>
            </div>
        );
    }
}

export default Sidebar;