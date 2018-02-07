import moment from 'moment';

const data = [{
    'Date': '2018-02-06',
    'Name': 'Dario Aubry',
    'Abo': '10er-Abo'
}, {
    'Date': '2018-02-08',
    'Name': 'Luca Aubry',
    'Abo': 'Einzelstunde'
}, {
    'Date': '2018-02-12',
    'Name': 'Gianni Aubry',
    'Abo': 'Einzelstunde'
}, {
    'Date': '2018-02-10',
    'Name': 'Beatrice Aubry',
    'Abo': '10er-Abo'
}];

const table = d3.select('body').append('table').attr('class', 'table table-bordered');
const thead = table.append('thead');
const tbody = table.append('tbody');

function tabulate(data) {
    // append the header row
    thead.append('tr')
        .append('th')
        .text('Name');

    for (let i = 0; i < 14; i++) {
        thead.select('tr')
            .append('th')
            .text(moment().add(i, 'days').format('D.M.YY'));
    }

    // create a row for each object in the data
    const rows = tbody.selectAll('tr')
        .data(data)
        .enter()
        .append('tr');

    for (let i = 1; i <= data.length; i++) {
        let j = i - 1;
        const row = tbody.select(`tr:nth-child(${i})`);
        row.append('td')
            .text(data[j].Name);

        for (let k = 1; k <= 14; k++) {
            row.append('td');

            if (data[j].Abo === 'Einzelstunde') {
                if (moment(data[j].Date).format('YYYY-MM-DD') === moment(thead.selectAll('th')[0][k].innerHTML, 'D.M.YY').format('YYYY-MM-DD')) {
                    let field = row.select(`td:nth-child(${thead.selectAll('th')[0][k].cellIndex + 1})`)
                        .attr('class', 'einzelstunde');

                    field.on('click', () => { showInfo(k, 'Einzelstunde'); });
                }
            }

            if (data[j].Abo === '10er-Abo') {
                if (moment(data[j].Date).format('YYYY-MM-DD') <= moment(thead.selectAll('th')[0][k].innerHTML, 'D.M.YY').format('YYYY-MM-DD') &&
                    moment(data[j].Date).add(12, 'weeks').format('YYYY-MM-DD') >= moment(thead.selectAll('th')[0][k].innerHTML, 'D.M.YYYY').format('YYYY-MM-DD')) {
                    let field = row.select(`td:nth-child(${thead.selectAll('th')[0][k].cellIndex + 1})`)
                        .attr('class', 'zehnerabo');

                    field.on('click', () => { showInfo(k, '10er-Abo'); });
                }
            }
        }
    }
}

function showInfo(k, abo) {
    if(!d3.event.target.hasChildNodes()) {
        let icon = d3.event.target.appendChild(document.createElement('i'));
        icon.classList.add('fa');
        icon.classList.add('fa-check');
    }

    let response = {
        date: moment(thead.selectAll('th')[0][k].innerHTML, 'D.M.YYYY').format('YYYY-MM-DD'),
        name: d3.event.target.parentNode.firstChild.innerHTML,
        abo: abo
    };
    console.log(response);
}

// render the table
tabulate(data);
