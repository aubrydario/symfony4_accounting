import React, {Component} from 'react';
import moment from 'moment';
import axios from 'axios';
import MaterialTable from 'material-table';

class CustomerTable extends Component {
    constructor(props) {
        super(props);

        this.state = {
            columns: [
                { title: 'Geschlecht', field: 'gender', lookup: { 'Frau': 'Frau', 'Herr': 'Herr' }, },
                { title: 'Vorname', field: 'firstname' },
                { title: 'Nachname', field: 'surname' },
                { title: 'Geburtstag', field: 'birthday', type: 'date', render: rowData => moment(rowData.birthday).format('DD.MM.YYYY') },
                { title: 'Email', field: 'email' },
                { title: 'Tel Privat', field: 'telprivat' },
                { title: 'Tel Mobile', field: 'telmobile' },
                { title: 'Strasse', field: 'street' },
                { title: 'Strassennummer', field: 'streetnr' },
                { title: 'Ort', field: 'city' },
                { title: 'PLZ', field: 'plz', type: 'numeric' },
                { title: 'Eintrittsdatum', field: 'startdate', type: 'date', render: rowData => moment(rowData.startdate).format('DD.MM.YYYY') },
                { title: 'Austrittsdatum', field: 'enddate', type: 'date', render: rowData => rowData.enddate === null ? '' : moment(rowData.enddate).format('DD.MM.YYYY') },
            ],
            data: props.customers,
        };
    }

    componentWillReceiveProps(nextProps) {
        this.setState(nextProps);
    }

    render() {
        return (
            <MaterialTable
                title="Kunden Liste"
                columns={this.state.columns}
                data={this.state.customers}
                editable={{
                    onRowAdd: newData =>
                        new Promise((resolve, reject) => {
                            setTimeout(() => {
                                {
                                    const customers = this.state.customers;
                                    newData.active = 1;
                                    newData.plz = parseInt(newData.plz);
                                    newData.user = '/api/users/' + this.state.userid;
                                    customers.push(newData);
                                    this.setState({ customers }, () => resolve());

                                    axios.post('/api/customers', newData);
                                }
                                resolve();
                            }, 1000);
                        }),

                        onRowUpdate: (newData, oldData) =>
                            new Promise((resolve, reject) => {
                                setTimeout(() => {
                                    {
                                        const customers = this.state.customers;
                                        const index = customers.indexOf(oldData);
                                        newData.plz = parseInt(newData.plz);
                                        customers[index] = newData;
                                        this.setState({ customers }, () => resolve());

                                        axios.put('/api/customers/' + customers[index].id, newData);
                                    }
                                    resolve();
                                }, 1000);
                            }),
                        onRowDelete: data =>
                            new Promise((resolve, reject) => {
                                setTimeout(() => {
                                    {
                                        const customers = this.state.customers;
                                        const index = customers.indexOf(data);
                                        const customerId = customers[index].id;
                                        customers.splice(index, 1);

                                        data.active = 0;
                                        this.setState({ customers }, () => resolve());

                                        axios.put('/api/customers/' + customerId, data);

                                    }
                                    resolve();
                                }, 1000);
                            })
                }}
            />
        );

        /*return (
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
        );*/
    }
}

export default CustomerTable;
