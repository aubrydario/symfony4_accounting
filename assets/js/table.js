import ajax from './components/ajaxCall';

modal(window.location.pathname);

function modal(uri) {
    const modalLink = document.getElementById('modalDeleteLink');

    Array.from(document.getElementsByClassName('deleteLink')).forEach(link => {
        link.addEventListener('click', () => {
            modalLink.setAttribute('data-id', link.getAttribute('data-id'))
        });
    });

    document.getElementById('modalDeleteLink').addEventListener('click', () => {
        if(uri === '/customer') {
            ajax('PUT', `/api${uri}s/${modalLink.getAttribute('data-id')}`, {
                data: JSON.stringify({active: 0})
            });
        } else {
            ajax('DELETE', `/api${uri}s/${modalLink.getAttribute('data-id')}`);
        }
    });
}
