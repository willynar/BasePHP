
//solo numeross
jQuery(document).ready(function () {
    jQuery('.validate_numbers').keypress(function (tecla) {
        if (tecla.charCode < 48 || tecla.charCode > 57) return false;
    });
});
function blocklet(e) {
    var unicode = e.charCode ? e.charCode : e.keyCode
    if (unicode != 8 && unicode != 44) {
        if (unicode < 48 || unicode > 57) //if not a number
        { return false } //disable key press    
    }
}

//solo letras

jQuery('.validate_letters').keypress(function (tecla) {
    if ((tecla.charCode < 97 || tecla.charCode > 122) 
    && (tecla.charCode < 65 || tecla.charCode > 90) 
    && (tecla.charCode != 45)
    && (tecla.charCode >= 192 && tecla.charCode <= 255)) return false;
});
function blocknum(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = " ?????abcdefghijklmn?opqrstuvwxyz";
    especiales = "8-37-39-46";

    tecla_especial = false
    for (var i in especiales) {
        if (key == especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
        return false;
    }
}