import React, {Component} from 'react';
import moment from "moment";

class CustomerTable extends Component {
    render() {
        return (
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
                {this.props.customers.map(customer => (
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
                        <td><a href={"customers/edit/" + customer.id}><i className="fa fa-pencil" /></a></td>
                        <td><a href="" className="deleteLink" data-toggle="modal" data-id={customer.id} data-target="#deleteCustomerModal"><i className="fa fa-trash red" /></a></td>
                    </tr>
                ))}
                </tbody>
            </table>
        );
    }
}

export default CustomerTable;