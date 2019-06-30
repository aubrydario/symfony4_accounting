import React, {Component} from 'react';
import ReactDom from 'react-dom';
import Sidebar from "./components/sidebar.jsx";
import moment from 'moment';
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
                    <CustomerTable customers={this.state.customers} userid={this.state.user.id}/>
                </div>
            </React.Fragment>
        );
    }
}

ReactDom.render(<App />, document.getElementById('root'));
