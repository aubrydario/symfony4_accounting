import ajax from './ajaxCall';
import colorpicker from 'spectrum-colorpicker';

export default function aboColorpicker() {
    const aboid = window.location.pathname.match('/([^/]+)$')[1];

    let dataColorpicker = ajax('GET', `/api/abos/${aboid}`, { complete: () => {
        dataColorpicker = dataColorpicker.responseJSON;

        $('.colorpicker').spectrum({
            change: color => {
                $('.colorpicker').val(color.toHexString());
            }
        });
    }})
}