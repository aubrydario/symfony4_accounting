import React, {Component} from 'react';
import ReactDom from 'react-dom';
import { BrowserRouter, Switch, Route } from 'react-router-dom';
import Sidebar from "./components/sidebar.jsx";
import moment from 'moment';
import CustomerTable from "./components/CustomerView/customerTable";
import AboTable from "./components/AboListView/aboTable";


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

        fetch('/api/customers?active=1')
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
                    <Switch>
                        <Route path="/customers" component="CustomerTable" />
                        <Route path="/abo" component="AboTable" />
                    </Switch>
                    <CustomerTable customers={this.state.customers} userid={this.state.user.id}/>
                </div>
            </React.Fragment>
        );
    }
}

ReactDom.render((
    <BrowserRouter>
        <App />
    </BrowserRouter>
  ), document.getElementById('root'));
