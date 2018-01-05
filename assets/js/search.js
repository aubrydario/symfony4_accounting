(() => {
    const searchField = document.getElementById('searchField');
    const table = document.getElementById('searchTable');
    const tableRows = table.childNodes[3].getElementsByTagName('tr');
    let found = false;

    searchField.addEventListener('keyup', () => {
        for(const tableRow of tableRows) {
            const tableDataElements = tableRow.getElementsByTagName('td');

            for(const tableData of tableDataElements) {
                if(tableData.innerHTML.toUpperCase().includes(searchField.value.toUpperCase())) {
                    found = true;
                }
            }

            if(found) {
                tableRow.style.display = '';
                found = false;
            } else {
                tableRow.style.display = 'none';
            }
        }
    });
})();
