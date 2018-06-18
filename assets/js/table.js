import ajax from './components/ajaxCall';

modal(window.location.pathname);

function modal(uri) {
    const modalLink = document.getElementById('modalDeleteLink');
    const modalId = uri[1].toUpperCase() + uri.slice(2, uri.length);

    Array.from(document.getElementsByClassName('deleteLink')).forEach(link => {
        link.addEventListener('click', () => {
            modalLink.setAttribute('data-id', link.getAttribute('data-id'))
        });
    });

    document.getElementById('modalDeleteLink').addEventListener('click', () => {
        if(uri === '/customers') {
            ajax('PUT', `/api${uri}/${modalLink.getAttribute('data-id')}`, {
                data: JSON.stringify({active: 0}),
                complete: () => {
                    $(`#delete${modalId.slice(0, modalId.length - 1)}Modal`).hide();
                    $('.modal-backdrop').hide();

                    document.getElementById('success-message').innerHTML = 'Kunde deaktiviert.';
                    document.getElementById('success-message').style.display = 'inline-block';
                }
            });
        } else {
            ajax('DELETE', `/api${uri}s/${modalLink.getAttribute('data-id')}`);

            $(`#delete${modalId}Modal`).hide();
            $('.modal-backdrop').hide();
        }
    });
}
