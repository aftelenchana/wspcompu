function sendData_crear_asiento_contable(){
  $('.notificacion_asiento_contable').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#crear_asiento_contable')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/asiento_contable.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_asiento_contable').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_asiento_contable').html('<div class="alert alert-success" role="alert">Asiento Contable Agregado Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_asiento_contable').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}

function sendData_agregar_cliente_deposito(){
  var parametros = new  FormData($('#agregar_cliente_depositos')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/depositos_facturacion.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_deposito_agregado').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
        var info = JSON.parse(response);
          $("#id_cliente").val(info.id);
          $("#nombres_cliente").val(info.nombres);
          $("#identificacion_cliente").val(info.identificacion);



      }

    }

  });

}


(function(){
  $(function(){
    $('.agregar_items').on('click',function(){
    var asiento = $(this).attr('asiento');
    var action = 'agregar_item_asiento';
     console.log(asiento);
    $.ajax({
      url:'jquery_empresa/asiento_contable.php',
      type:'POST',
      async: true,
      data: {action:action,asiento:asiento},
       success: function(response){
        $('#exampleModalLong').modal();
         if (response != 'error') {
           console.log(response);
           var info = JSON.parse(response);
           $('.cuerpo_nody').html('<form  class="" method="post" name="agregar_itrm_asiento" id="agregar_itrm_asiento" onsubmit="event.preventDefault(); sendData_agregar_item_transporte();">'+
                        ' <div class="form-group">'+
                          ' <label for="exampleInputEmail1">Descripción o Concepto</label>'+
                          ' <input type="text" class="form-control" name="descripcion_concepto" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Descripción o Concepto">'+
                         '</div>'+
                         '<div class="form-group">'+
                           '<label for="exampleInputPassword1">Debe</label>'+
                           '<input type="number" name="debe" class="form-control" id="exampleInputPassword1" placeholder="Ingrese Debe">'+
                         '</div>'+
                         '<div class="form-group">'+
                           '<label for="exampleInputPassword1">Haber</label>'+
                           '<input type="number" name="haber" class="form-control" id="exampleInputPassword1" placeholder="Ingrese Haber">'+
                        ' </div>'+
                         '<div class="modal-footer">'+
                          ' <input type="hidden" name="asiento" value="'+info.secuencial+'">'+
                          ' <input type="hidden" name="action" value="agregar_item_asiento_perfomance">'+
                          ' <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>'+
                          ' <button type="submit" class="btn btn-primary">Agregar Item</button>'+
                          ' <div class="notificacion_item_asiento">'+
                          ' </div>'+
                         '</div>'+
                       '</form>');

         }
       },
       error:function(error){
         console.log(error);
         }

       });
    });


  });

}());




function sendData_agregar_item_transporte(){
  $('.notificacion_item_asiento').html(' <div class="notificacion_negativa">'+
     '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
   '</div>');
  var parametros = new  FormData($('#agregar_itrm_asiento')[0]);
  $.ajax({
    data: parametros,
    url: 'jquery_empresa/asiento_contable.php',
    type: 'POST',
    contentType: false,
    processData: false,
    beforesend: function(){

    },
    success: function(response){
      console.log(response);

      if (response =='error') {
        $('.notificacion_item_asiento').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>')
      }else {
      var info = JSON.parse(response);
      if (info.noticia == 'insert_correct') {
        $('.notificacion_item_asiento').html('<div class="alert alert-success" role="alert">Item Agregado Correctamente!</div>');

      }
      if (info.noticia == 'error_insertar') {
      $('.notificacion_item_asiento').html('<div class="alert alert-danger" role="alert">Error en el servidor!</div>');

      }

      }

    }

  });

}
