document.addEventListener('DOMContentLoaded', function() {
    // Suponiendo que tienes una variable global con el ID del usuario
    var id_usuario = window.idUsuario || 'El ID del usuario aquí';
    var codigo_usuario = document.getElementById('codigo_usuario').value;
    var rol = document.getElementById('rol').value;

    document.querySelectorAll('#permisosForm .form-check-input').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            var permiso = this.id;
            var valor = this.checked ? 1 : 0;
            var action = 'enviar_petision_permiso';


            // Datos a enviar
            var data = {
                id_usuario: id_usuario,
                permiso: permiso,
                valor: valor,
                action: action,
                codigo_usuario:codigo_usuario,
                rol:rol
            };

            $.ajax({
              url:'permisos/usuarios_punto_venta.php',
              type:'POST',
              async: true,
              data: data,
               success: function(response){
                 console.log(response);

               },
               error:function(error){
                 console.log(error);
                 }
               });


            // ...
        });
    });
});



document.addEventListener('DOMContentLoaded', function() {
    var action = 'vizualizar_permisos';
    var codigo_usuario = document.getElementById('codigo_usuario').value;
    var rol = document.getElementById('rol').value;

    // Obtener los permisos del usuario al cargar la página
    $.ajax({
        url:'permisos/usuarios_punto_venta.php',
        type: 'POST', // O POST si es necesario
        data: { action: action,codigo_usuario:codigo_usuario,rol:rol },
        success: function(response) {
          console.log(response);
            var permisos = JSON.parse(response);
            // Establecer el estado de los checkboxes
            for (var permiso in permisos) {
                var checkbox = document.getElementById(permiso);
                if (checkbox) {
                    checkbox.checked = permisos[permiso] == "1";
                }
            }
        },
        error: function(error) {
            console.log(error);
        }
    });

    // Resto de tu código para manejar cambios en los checkboxes...
});
