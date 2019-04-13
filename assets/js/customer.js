import React, {Component} from 'react';
import ReactDom from 'react-dom';
import Sidebar from "./components/sidebar.jsx";
import TriggerModalButton from "./components/triggerModalButton";
import moment from 'moment';
import DeleteModal from "./components/deleteModal";
import CreateCustomerModal from "./components/Customer/createCustomerModal";
import CustomerTable from "./components/Customer/customerTable";


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
                    <CustomerTable customers={this.state.customers}/>
                    <DeleteModal id="deleteCustomerModal" title="Kunde entfernen" text="Wollen Sie den Kunden entfernen?" />
                    <CreateCustomerModal />
                </div>
            </React.Fragment>
        );
    }
}

ReactDom.render(<App />, document.getElementById('root'));