import React, {Component} from 'react';
import moment from "moment";
import Table from 'material-ui/Table';
import TableHeader from 'material-ui/Table/TableHeader';
import TableBody from 'material-ui/Table/TableBody';
import TableRow from 'material-ui/Table/TableRow';
import TableCell from 'material-ui/Table/TableRowColumn';
import Paper from 'material-ui/Paper';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider'

class CustomerTable extends Component {
    render() {
        return (
            <MuiThemeProvider>
            <Paper>
              <Table>
                  <TableHeader displaySelectAll={false} adjustForCheckbox={false}>
                    <TableRow>
                      <TableCell>Vorname</TableCell>
                      <TableCell>Nachname</TableCell>
                      <TableCell>Geburtstag</TableCell>
                      <TableCell>Email</TableCell>
                      <TableCell>Telefon Privat</TableCell>
                      <TableCell>Telefon Mobile</TableCell>
                      <TableCell>Strasse</TableCell>
                      <TableCell>Ort</TableCell>
                      <TableCell>PLZ</TableCell>
                      <TableCell>Eintrittsdatum</TableCell>
                      <TableCell>Austrittsdatum</TableCell>
                      <TableCell>Aktionen</TableCell>
                  </TableRow>
                </TableHeader>
                <TableBody displayRowCheckbox={false}>
                  {this.props.customers.map(customer => (
                      <TableRow key={customer.id}>
                          <TableCell>{customer.firstname}</TableCell>
                          <TableCell>{customer.surname}</TableCell>
                          <TableCell>{moment(customer.birthday).format('DD.MM.YYYY')}</TableCell>
                          <TableCell>{customer.email}</TableCell>
                          <TableCell>{customer.telprivate}</TableCell>
                          <TableCell>{customer.telmobile}</TableCell>
                          <TableCell>{customer.street} {customer.streetnr}</TableCell>
                          <TableCell>{customer.city}</TableCell>
                          <TableCell>{customer.plz}</TableCell>
                          <TableCell>{moment(customer.startdate).format('DD.MM.YYYY')}</TableCell>
                          <TableCell>{customer.enddate === null ? '' : moment(customer.enddate).format('DD.MM.YYYY')}</TableCell>
                          <TableCell><a href={"customers/edit/" + customer.id}><i className="fa fa-pencil" /></a><a href="" className="deleteLink" data-toggle="modal" data-id={customer.id} data-target="#deleteCustomerModal"><i className="fa fa-trash red" /></a></TableCell>
                      </TableRow>
                  ))}
                  </TableBody>
                </Table>
                </Paper>
            </MuiThemeProvider>
        );
    }
}

export default CustomerTable;
