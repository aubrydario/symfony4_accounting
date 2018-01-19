import search from './search.js'

search();

document.addEventListener('DOMContentLoaded', () => {
    Array.from(document.getElementsByClassName('deactiveCustomerLink')).forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('modalDeactiveCustomerLink').href = '/customers/delete/' + link.parentElement.getAttribute('data-customer-id');
        });
    });
});
