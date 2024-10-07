



(function(){
  $(function(){
    $('.editar_codigo_referido').on('click', function() {
      var numerica = $(this).attr('numerica');
      var no_numerica = $(this).attr('no_numerica');
      $(".result_codigo_referido").html('<form method="post" name="edit_codigo_referido" id="edit_codigo_referido" onsubmit="event.preventDefault(); sendData_edit_codigo_registro();">' +
        '<div class="input-group">' +
        '<input type="text" name="codigo_referido" id="codigo_referido" required class="form-control" value="' + no_numerica + '" >' +
        '<div class="input-group-append">' +
        '<button type="submit" class="btn btn-rounded btn-info">' + numerica + '</button>' +
        '</div>' +
        '</div>' +
        '<div class="modal-footer">' +
        '<input type="hidden" name="action" value="edit_codigo_referido" required>' +
        '<button type="submit" class="btn btn-primary">Guardar</button>' +
        '</div>' +
        '</form>');
        // Adjunta el evento input al campo dinámico #codigo_referido
        $('#codigo_referido').on('input', function() {
          var inputValue = this.value;
          var pattern = /^[A-Za-z\s!"#$%&'()*+,\-.\/:;<=>?@[\\\]^_`{|}~]+$/;

          if (!pattern.test(inputValue)) {
            this.setCustomValidity('Solo se permiten letras y símbolos, sin números.');
          } else {
            this.setCustomValidity('');
          }

          // Vacía el campo si se ingresan números
          if (inputValue.match(/[0-9]/)) {
            this.value = '';
          }
        });



    });
  });
}());



(function(){
  $(function(){
    $('.editar_identificacion').on('click',function(){
    var identificacion = $(this).attr('identificacion');
     $(".result_identidicacion").html(' <form   method="post" name="add_cedula_identidad" id="add_cedula_identidad" onsubmit="event.preventDefault(); sendData_cedula_identidad();">'+
     ' <div class="form-group">'+
       ' <input type="text" class="form-control" value="'+identificacion+'"  required id="cedula_identidad" name="cedula_identidad" aria-describedby="emailHelp" placeholder="Ingrese la Identidicación">'+
     ' </div>'+
                    ' <div class="modal-footer">'+
                '   <input type="hidden" name="action" value="editt_cedula" required>'+
                '   <button type="submit" class="btn btn-primary">Guardar</button>'+
                ' </div>'+
              '</form>');
    });
  });

}());






(function(){
  $(function(){
    $('.editar_nombres').on('click',function(){
    var nombresh = $(this).attr('nombresh');
     $(".result_nombres").html(' <form   method="post" name="add_form_nombres" id="add_form_nombres" onsubmit="event.preventDefault(); sendDataedit_nombres();">'+
     ' <div class="form-group">'+
       ' <input type="text" class="form-control" value="'+nombresh+'"  required id="name_user" name="name_user" aria-describedby="emailHelp" placeholder="Ingrese los Nombres">'+
     ' </div>'+
                    ' <div class="modal-footer">'+
                '   <input type="hidden" name="action" value="editt_nombre" required>'+
                '   <button type="submit" class="btn btn-primary">Guardar</button>'+
                ' </div>'+
              '</form>');
    });
  });

}());
(function(){
  $(function(){
    $('.editar_apellidos').on('click',function(){
    var apellidos = $(this).attr('apellidos');
     $(".result_apellidos").html(' <form   method="post" name="add_form_apellidos" id="add_form_apellidos" onsubmit="event.preventDefault(); sendDataedit_apellidos();">'+
     ' <div class="form-group">'+
       ' <input type="text" class="form-control" value="'+apellidos+'"  required id="editt_apellido" name="editt_apellido" aria-describedby="emailHelp" placeholder="Apellidos">'+
     ' </div>'+
                    ' <div class="modal-footer">'+
                '   <input type="hidden" name="action" value="editt_Apellido" required>'+
                '   <button type="submit" class="btn btn-primary">Guardar</button>'+
                ' </div>'+
              '</form>');
    });
  });

}());
(function(){
  $(function(){
    $('.editar_nombre_empresa').on('click',function(){
    var nombre_empresa = $(this).attr('nombre_empresa');
     $(".result_nombre_empresa").html(' <form   method="post" name="add_form_name_empresa" id="add_form_name_empresa" onsubmit="event.preventDefault(); sendData_name_empresa();">'+
     ' <div class="form-group">'+
       ' <input type="text" class="form-control" value="'+nombre_empresa+'"  required id="name_empresa" name="name_empresa" aria-describedby="emailHelp" placeholder="Empresa">'+
     ' </div>'+
                    ' <div class="modal-footer">'+
                '   <input type="hidden" name="action" value="editt_name_empresa" required>'+
                '   <button type="submit" class="btn btn-primary">Guardar</button>'+
                ' </div>'+
              '</form>');
    });
  });

}());



(function(){
  $(function(){
    $('.editar_razon_social').on('click',function(){
    var razon_social = $(this).attr('razon_social');
     $(".result_razon_social").html(' <form   method="post" name="add_razon_social" id="add_razon_social" onsubmit="event.preventDefault(); sendData_razon_social();">'+
     ' <div class="form-group">'+
       ' <input type="text" class="form-control" value="'+razon_social+'"  required id="razon_social" name="razon_social" aria-describedby="emailHelp" placeholder="Razon Social">'+
     ' </div>'+
                    ' <div class="modal-footer">'+
                '   <input type="hidden" name="action" value="editt_razon_social" required>'+
                '   <button type="submit" class="btn btn-primary">Guardar</button>'+
                ' </div>'+
              '</form>');
    });
  });

}());
