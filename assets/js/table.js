import search from './search.js'

search();
modal(window.location.pathname);

function modal(uri) {
    Array.from(document.getElementsByClassName('deleteLink')).forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('modalDeleteLink').href = uri + '/delete/' + link.getAttribute('data-id');
        });
    });
}
