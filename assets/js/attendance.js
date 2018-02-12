import moment from 'moment';
import d3 from 'd3';

/*const data = [
    {
        'Date': '2018-02-06',
        'Name': 'Dario Aubry',
        'Abo': '10er-Abo'
    },
    {
        'Date': '2018-02-13',
        'Name': 'Luca Aubry',
        'Abo': 'Einzelstunde'
    },
    {
        'Date': '2018-02-16',
        'Name': 'Gianni Aubry',
        'Abo': 'Einzelstunde'
    },
    {
        'Date': '2018-02-10',
        'Name': 'Beatrice Aubry',
        'Abo': '10er-Abo'
    }
];*/

$.ajax({
    type:'GET',
    url:'http://localhost:8000/api/attendance',
    dataType: 'json',
    async: true,
    contentType: "application/json; charset=utf-8"
}).done(data => {
    createTable(data);
});

const table = d3.select('#attendance-table').append('table').attr('class', 'table table-bordered');
const thead = table.append('thead');
const tbody = table.append('tbody');

function createTable(data) {// append the header row
    thead.append('tr')
        .append('th')
        .text('Name');

    for (let i = 0; i < 15; i++) {
        thead.select('tr')
            .append('th')
            .text(moment().add(i, 'days').format('D.M.YY'));
    }

    // create a row for each object in the data
    tbody.selectAll('tr')
        .data(data)
        .enter()
        .append('tr');

    data.forEach((item, i) => {
        const row = tbody.select(`tr:nth-child(${i})`);
        let itemDate = moment(item.date).format('YYYY-MM-DD');

        row.append('td')
            .text(`${item.firstname} ${item.surname}`);

        for (let j = 1; j <= 15; j++) {
            let theadDate = moment(thead.selectAll('th')[0][j].innerHTML, 'D.M.YY').format('YYYY-MM-DD');

            row.append('td');

            switch(item.abo_id) {
                //Einzelstunde
                case '1':
                    if (itemDate === theadDate) {
                        let field = row.select(`td:nth-child(${thead.selectAll('th')[0][j].cellIndex + 1})`)
                            .attr('class', 'einzelstunde');

                        field.on('click', () => { showInfo(theadDate, 'Einzelstunde'); });
                    }
                    break;

                //Schnupperstunde
                case '2':
                    console.log('Schnupperstunde');
                    break;

                //10er-Abo
                case '3':
                    if (itemDate <= theadDate && moment(item.date).add(12, 'weeks').format('YYYY-MM-DD') >= theadDate) {
                        let field = row.select(`td:nth-child(${thead.selectAll('th')[0][j].cellIndex + 1})`)
                            .attr('class', 'zehnerabo');

                        field.on('click', () => { showInfo(theadDate, '10er-Abo'); });
                    }
                    break;

                //Jahresabo
                case '4':
                    console.log('Jahresabo');
                    break;
            }
        }
    });
}

function showInfo(date, abo) {
    if(!d3.event.target.hasChildNodes()) {
        let icon = d3.event.target.appendChild(document.createElement('i'));
        icon.classList.add('fa');
        icon.classList.add('fa-check');
    }

    let response = {
        date: date,
        name: d3.event.target.parentNode.firstChild.innerHTML,
        abo: abo
    };
    console.log(response);
}
