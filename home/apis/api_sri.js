
  $(document).ready(function() {
      $('.ocupar_api_sacar_informacion').on('input', function() {
          const valor = $(this).val();
          console.log(valor);
          // Validar si el valor tiene 9 o más dígitos
          if (valor.length >= 9) {
              $.ajax({
                  url: '/home/apis/api_sri.php',
                  type: 'POST',
                  data: { numeroIdentificacion: valor },
                  success: function(response) {
                      console.log(response);
                      if (response != 'error') {
                          var info = JSON.parse(response);
                          if (info.error == 'numero_no_valido') {
                              // Manejar el error si el número no es válido
                              $('.resultado_nombres_consumo_api').val('');
                              //console.log('Número no válido');
                          } else {
                              $('.resultado_nombres_consumo_api').val(info.nombreCompleto);
                              if (info.tipoIdentificacion == 'C') {
                                $('#tipo_identificacion').val('05');
                              }
                              if (info.tipoIdentificacion == 'R') {
                                $('#tipo_identificacion').val('04');
                              }
                          }
                      }
                  },
                  error: function(error) {
                      console.log(error);
                  }
              });
          }
      });
  });
