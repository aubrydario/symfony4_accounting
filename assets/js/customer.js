import React, {Component} from 'react';
import ReactDom from 'react-dom';
import Sidebar from "./components/sidebar.jsx";
import TriggerModalButton from "./components/triggerModalButton";
import moment from 'moment';

moment.locale('de-ch');

class App extends Component {
    constructor() {
        super();

        this.state = {
            user: [],
            customers: []
        }
    }

    componentDidMount() {
        fetch('/api/activeUser')
            .then(response => response.json())
            .then(user => {
                this.setState({
                    user: user[0]
                });
            });

        fetch('/api/customers')
            .then(response => response.json())
            .then(customers => {
               this.setState({
                  customers: customers['hydra:member']
               });
            });
    }

    render() {
        return (
            <React.Fragment>
                <Sidebar username={this.state.user.username}/>
                <div className="content">
                    <h1>Kunden Liste</h1>
                    <div className="filter-options">
                        <TriggerModalButton dataTarget="#addModal" text="Kunde hinzufügen"/>
                    </div>
                    <table className="table table-striped">
                        <thead>
                            <tr>
                                <th>Vorname</th>
                                <th>Nachname</th>
                                <th>Geburtstag</th>
                                <th>Email</th>
                                <th>Telefon Privat</th>
                                <th>Telefon Mobile</th>
                                <th>Strasse</th>
                                <th>Ort</th>
                                <th>PLZ</th>
                                <th>Eintrittsdatum</th>
                                <th>Austrittsdatum</th>
                            </tr>
                        </thead>
                        <tbody>
                            {this.state.customers.map(customer => (
                                <tr key={customer.id}>
                                    <td>{customer.firstname}</td>
                                    <td>{customer.surname}</td>
                                    <td>{moment(customer.birthday).format('DD.MM.YYYY')}</td>
                                    <td>{customer.email}</td>
                                    <td>{customer.telprivate}</td>
                                    <td>{customer.telmobile}</td>
                                    <td>{customer.street} {customer.streetnr}</td>
                                    <td>{customer.city}</td>
                                    <td>{customer.plz}</td>
                                    <td>{moment(customer.startdate).format('DD.MM.YYYY')}</td>
                                    <td>{customer.enddate === null ? '' : moment(customer.enddate).format('DD.MM.YYYY')}</td>
                                </tr>
                            ))}

                        </tbody>
                    </table>
                </div>
            </React.Fragment>
        );
    }
}

ReactDom.render(<App />, document.getElementById('root'));