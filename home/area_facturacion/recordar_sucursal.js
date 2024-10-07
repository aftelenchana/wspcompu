function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

document.getElementById('sucursal_facturacion').addEventListener('change', function() {
    var selectedOption = this.value;
    console.log(selectedOption);
    setCookie('selectedSucursal', selectedOption, 7); // Guarda la opción por 7 días
});

document.addEventListener('DOMContentLoaded', (event) => {
    var savedSucursal = getCookie('selectedSucursal');
    var selectElement = document.getElementById('sucursal_facturacion');

    if(savedSucursal !== null && savedSucursal !== "") {
        selectElement.value = savedSucursal;
    } else if(selectElement.options.length > 0) {
        selectElement.selectedIndex = 0;
    }
});
