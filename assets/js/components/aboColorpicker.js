import ajax from './ajaxCall';
import colorpicker from 'spectrum-colorpicker';

export default function aboColorpicker() {
    $('.colorpicker').spectrum({
        change: color => {
            $('.colorpicker').val(color.toHexString());
        }
    });
}