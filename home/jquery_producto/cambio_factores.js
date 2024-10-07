function vista_tangibilidad(){
  $('.notidicacion_factor').html('<div class="proceso">'+
    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
  '</div>');

  try{
        tangibilidad = (document.getElementById('tangibilidad').value) || 0;

         if (tangibilidad=='Digital') {
           $('.caso_digital').html('<tr>'+
             '<td>Enlace Mega</td>'+
             '<td class="conten_enlace_mega"></td>'+
             '<td> <input type="text" name="enlace_mega_int_d" value=""> </td>'+
           '</tr>'+
           '<tr>'+
             '<td>Codigo Encriptado</td>'+
             '<td class="conte_encrip_meg" >'+
             '</td>'+
             '<td> <input type="text" name="codigo_encriptado_int" value=""> </td>'+
           '</tr>');
         }else {
           $('.caso_digital').html('');


         }


  } catch (e){}
}
