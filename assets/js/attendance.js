import moment from 'moment';
import d3 from 'd3';

moment.locale('de');

function getBills() {
    return $.ajax({
        type: "GET",
        dataType: 'json',
        url: "http://localhost:8000/api/attendance",
        async: true,
        contentType: "application/json; charset=utf-8"
    });
}

function getAttendance() {
    return $.ajax({
        type: "GET",
        dataType: 'json',
        url: "http://localhost:8000/api/attendanceDetails",
        async: true,
        contentType: "application/json; charset=utf-8"
    });
}

// Trigger when both Ajax requests are done
$.when(getBills(), getAttendance()).done((bills, attendances) => {
    createTable(bills[0], attendances[0]);
});
const table = d3.select('#attendance-table').append('table').attr('class', 'table table-bordered');
const thead = table.append('thead');
const tbody = table.append('tbody');

function createTable(data, attendances) {
    // append the header row
    thead.append('tr')
        .append('th')
        .text('Name');

    for (let i = 0; i < 15; i++) {
        thead.select('tr')
            .append('th')
            .text(moment().add(i, 'days').format('dd D.M.YY'));
    }

    // create a row for each object in the data
    tbody.selectAll('tr')
        .data(data)
        .enter()
        .append('tr');

    data.forEach((item, i) => {
        const row = tbody.select(`tr:nth-child(${++i})`);
        let itemDateArray = item.date ? item.date.split(',') : [];
        let aboIdArray = item.abo_id ? item.abo_id.split(',') : [];

        row.append('td')
            .text(item.name);

        for (let j = 1; j <= 15; j++) {
            let theadDate = moment(thead.selectAll('th')[0][j].innerHTML, 'D.M.YY').format('YYYY-MM-DD');

            row.append('td');

            attendances.forEach(attendance => {
                let currentField = row.select(`td:nth-child(${thead.selectAll('th')[0][j].cellIndex + 1})`)[0][0];
                if(moment(attendance.date).format('YYYY-MM-DD') === theadDate && currentField.parentNode.firstChild.innerHTML === attendance.name) {
                    let icon = currentField.appendChild(document.createElement('i'));
                    icon.classList.add('fa');
                    icon.classList.add('fa-check');
                }
            });

            itemDateArray.forEach((date, index) => {
                let itemDate = moment(date).format('YYYY-MM-DD');

                switch(aboIdArray[index]) {
                    //Einzelstunde
                    case '1':
                        if (itemDate === theadDate) {
                            let field = row.select(`td:nth-child(${thead.selectAll('th')[0][j].cellIndex + 1})`)
                                .attr('class', 'einzelstunde');

                            field.on('click', () => { showInfo(theadDate); });
                        }
                        break;

                    //Schnupperstunde
                    case '2':
                        console.log('Schnupperstunde');
                        break;

                    //10er-Abo
                    case '3':
                        if (itemDate <= theadDate && moment(itemDate).add(12, 'weeks').format('YYYY-MM-DD') >= theadDate) {
                            let field = row.select(`td:nth-child(${thead.selectAll('th')[0][j].cellIndex + 1})`)
                                .attr('class', 'zehnerabo');

                            field.on('click', () => { showInfo(theadDate); });
                        }
                        break;

                    //Jahresabo
                    case '4':
                        console.log('Jahresabo');
                        break;
                }
            });
        }
    });
}

function showInfo(date) {
    if(!d3.event.target.hasChildNodes()) {
        let icon = d3.event.target.appendChild(document.createElement('i'));
        icon.classList.add('fa');
        icon.classList.add('fa-check');

        let response = {
            date: date,
            name: d3.event.target.parentNode.firstChild.innerHTML
        };
        console.log(response);

        fetch('http://localhost:8000/api/attendanceDetails', {
            method: 'POST',
            body: response,
            headers: new Headers({
                'Content-Type': 'application/json'
            })
        }).then(res => res.json())
            .catch(error => console.error('Error:', error))
            .then(response => console.log('Success:', response));
    }
}
