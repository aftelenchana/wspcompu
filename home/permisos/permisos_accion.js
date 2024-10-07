document.addEventListener('DOMContentLoaded', function() {
    var action = 'visualizar_permisos';

    $.ajax({
        url: 'permisos/permisos_accion.php',
        type: 'POST',
        data: { action: action },
        success: function(response) {
            var permisos = JSON.parse(response);

            // Función para manejar la visualización de elementos basada en permisos
            function manejarVisualizacionPermiso(idElemento, permiso) {
                var elemento = document.getElementById(idElemento);
                if (permisos[permiso] === "0") {
                  //  console.log('No tiene permiso, ocultando ' + idElemento);
                    elemento.style.display = "none";
                } else {
                  //  console.log('Tiene permiso o no está definido, mostrando ' + idElemento);
                  //  elemento.style.display = ""; // "" para el valor predeterminado
                }
            }

            // Ejecuta la función para cada elemento y permiso correspondiente
            manejarVisualizacionPermiso('contenedor_permisos_ver_clientes', 'clientes_ver');
            manejarVisualizacionPermiso('contenedor_permisos_ver_productos', 'productos_ver');

            // Obtén el elemento select
            var selectDocumentoElectronico = document.getElementById('documento_electronico');

            // Función para eliminar una opción por valor
            function eliminarOpcionPorValor(selectElement, value) {
                for (var i = 0; i < selectElement.options.length; i++) {
                    if (selectElement.options[i].value === value) {
                        selectElement.remove(i);
                        break;
                    }
                }
            }

            // Verificar y actuar sobre el permiso de facturación
            if (permisos['facturacion'] === "0") {
                eliminarOpcionPorValor(selectDocumentoElectronico, 'Facturación');
            } else {
                //console.log('Tiene permiso o no está definido, mostrando la opción de facturación');
            }

            // Verificar y actuar sobre el permiso de tiket_venta
            if (permisos['tiket_venta'] === "0") {
                eliminarOpcionPorValor(selectDocumentoElectronico, 'Tiket Venta');
            } else {
              //  console.log('Tiene permiso o no está definido, mostrando la opción de tiket_venta');
            }

            // Verificar y actuar sobre el permiso de nota_venta
            if (permisos['nota_venta'] === "0") {
                eliminarOpcionPorValor(selectDocumentoElectronico, 'Nota de Venta Autorizada');
            } else {
              //  console.log('Tiene permiso o no está definido, mostrando la opción de nota_venta');
            }

            // Verificar y actuar sobre el permiso de proforma
            if (permisos['proforma'] === "0") {
                eliminarOpcionPorValor(selectDocumentoElectronico, 'Proforma');
            } else {
              //  console.log('Tiene permiso o no está definido, mostrando la opción de proforma');
            }

            // Repite para otras áreas si es necesario...
        },
        error: function(error) {
            console.log(error);
        }
    });
});
