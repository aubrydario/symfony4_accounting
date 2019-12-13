import React, {Component} from 'react';
import moment from 'moment';
import axios from 'axios';
import MaterialTable from 'material-table';

class AboTable extends Component {
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
                title="Abonnement Liste"
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
                localization={{
                    pagination: {
                        labelDisplayedRows: '{from}-{to} von {count}',
                        labelRowsSelect: 'Zeilen',
                        firstAriaLabel: 'Erste Seite',
                        firstTooltip: 'Erste Seite',
                        previousAriaLabel: 'Vorherige Seite',
                        previousTooltip: 'Vorherige Seite',
                        nextAriaLabel: 'Nächste Seite',
                        nextTooltip: 'Nächste Seite',
                        lastAriaLabel: 'Letzte Seite',
                        lastTooltip: 'Letzte Seite'
                    },
                    toolbar: {
                        nRowsSelected: '{0} Zeile(n) ausgewählt',
                        searchTooltip: 'Suchen',
                        searchPlaceholder: 'Suchen'
                    },
                    header: {
                        actions: 'Aktion'
                    },
                    body: {
                        emptyDataSourceMessage: 'Keine Daten vorhanden',
                        addTooltip: 'Hinzufügen',
                        deleteTooltip: 'Löschen',
                        editTooltip: 'Bearbeiten',
                        editRow: {
                            deleteText: 'Wollen Sie diese Zeile löschen?',
                            cancelTooltip: 'Abbrechen',
                            saveTooltip: 'Speichern'
                        }
                    }
                }}
            />
        );
    }
}

export default CustomerTable;
