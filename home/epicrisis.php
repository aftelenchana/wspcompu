<?php

ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();

      if (empty($_SESSION['active'])) {

        header('location:/');

      }else {

      }
       $iduser= $_SESSION['id'];


       $paciente = $_GET['paciente'];

       $query_consulta = mysqli_query($conection, "SELECT * FROM clientes
          WHERE clientes.iduser ='$iduser'  AND clientes.estatus = '1' AND clientes.id = '$paciente' ");
        $data_paciente = mysqli_fetch_array($query_consulta);
        $nombres_paciente = $data_paciente['nombres'];
        $secuencial = $data_paciente['secuencial'];
        $foto = $data_paciente['foto'];
        $url_img_upload_paciente = $data_paciente['url_img_upload'];
        $identificacion_paciente = $data_paciente['identificacion'];
        $fecha_nacimient_pacienteo = $data_paciente['fecha_nacimiento'];
        $genero_paciente = $data_paciente['genero'];
        $historial_medico = $data_paciente['historial_medico'];
        $alergias_paciente = $data_paciente['alergias'];
        $celular_paciente = $data_paciente['celular'];
        $telefono_paciente = $data_paciente['telefono'];
        $mail_paciente = $data_paciente['mail'];
        $direccion_paciente = $data_paciente['direccion'];
        $historial_medico = $data_paciente['historial_medico'];
        $alergias = $data_paciente['alergias'];
        $estado_civil = $data_paciente['estado_civil'];

  ?>




<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Epicrisis de <?php echo $nombres_paciente ?></title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#" />
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app" />
        <meta name="author" content="#" />
        <link rel="icon" href="/img/guibis.png" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/feather/css/feather.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/prism/prism.css" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/extensions/buttons/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/style.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/jquery.mCustomScrollbar.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/pcoded-horizontal.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" href="estilos/modal.css?v=2">

    </head>

    <body>

     <?php
          if ($_SESSION['rol'] == 'cuenta_empresa') {
       require 'scripts/loader.php';
       require 'scripts/iconos.php';

     }


     if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
       require 'scripts_usuario_venta/loader.php';
       require 'scripts_usuario_venta/iconos.php';

     }

              ?>
              <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                      <div class="main-body">
                          <div class="page-wrapper">
                            <br>


                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                              <div class="card-header  table-card-header con-marca-de-agua con-marca-de-agua-inferior text-white"   style="background-color: #263238;">
                                                  <h5>Epicris de <?php echo $nombres_paciente ?> </h5>
                                              </div>

                                              <div class="imagen_paciente">
                                                <img class="user-img img-radius" src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $foto ?>" alt="user-img" />
                                              </div>
                                              <style media="screen">
                                              .imagen_paciente img{
                                                max-width: 100px;
                                              }
                                              .imagen_paciente{
                                                text-align: center;
                                              }
                                              .card-header h5{
                                                color: #fff !important;
                                                font-weight: bold !important;
                                              }

                                              </style>
                                              <div class="card-block">
                                                <form method="post" name="epicrisis" id="epicrisis" onsubmit="event.preventDefault(); sendData_epicrisis();">

                                                  <div class="row">
                                                    <div class="col">
                                                      <div class="mb-3">
                                                        <label for="nombre_producto" class="form-label">Nombre del Paciente</label>
                                                        <input type="text" maxlength="120" name="nombre_paciente" class="form-control" readonly id="nombre_paciente" value="<?php echo $nombres_paciente ?>" placeholder="Nombre del Paciente">
                                                      </div>
                                                    </div>
                                                    <div class="col">
                                                      <div class="mb-3">
                                                        <label for="nombre_producto" class="form-label">Historia Clínica</label>
                                                        <input type="text" maxlength="120" name="secuencial" class="form-control" readonly id="secuencial" value="<?php echo $secuencial ?>" placeholder="Secuencial">
                                                      </div>
                                                    </div>
                                                  </div>

                                                  <div class="mb-3">
                                                    <label for="nombre_producto" class="form-label">Talla (cm)</label>
                                                    <input type="text" maxlength="120" name="talla" class="form-control"  id="talla"  placeholder="Talla del Paciente">
                                                  </div>

                                                  <div class="mb-3">
                                                    <label for="nombre_producto" class="form-label">Peso (kg)</label>
                                                    <input type="text" maxlength="120" name="peso" class="form-control"  id="peso"  placeholder="Peso del Paciente">
                                                  </div>

                                                  <div class="mb-3">
                                                    <label for="nombre_producto" class="form-label">Presión Arterial(mmHg)</label>
                                                    <input type="text" maxlength="120" name="presion_arterial" class="form-control"  id="presion_arterial"  placeholder="Presión Arterial">
                                                  </div>

                                                  <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Motivo de Admisión</label>
                                                    <textarea class="form-control" maxlength="120" required name="motivo_admision" id="motivo_admision" rows="3"></textarea>
                                                  </div>

                                                  <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Diagnóstico</label>
                                                    <textarea class="form-control" maxlength="120" required name="diagnostico" id="diagnostico" rows="3"></textarea>
                                                  </div>

                                                  <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Recomendaciones</label>
                                                    <textarea class="form-control" maxlength="120" required name="recomendaciones" id="recomendaciones" rows="3"></textarea>
                                                  </div>
                                                  <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Observaciones</label>
                                                    <textarea class="form-control" maxlength="120" required name="observaciones" id="observaciones" rows="3"></textarea>
                                                  </div>


                                                  <div class="mb-3">
                                                    <label for="exampleFormControlFile1" class="form-label">Agregue Imagenes</label>
                                                    <input type="file" class="form-control" name="lista[]"  multiple id="lista"  accept="image/png, .jpeg, .jpg" >
                                                  </div>

                                                  <style media="screen">
                                                    #miniaturas_productos img{
                                                      width: 10%;
                                                      display: inline-block;

                                                    }
                                                  </style>

                                                  <div class="row">
                                                     <span class="conte_img_pr" id="salida_imagenes_contenedor">
                                                       <output id="miniaturas_productos"></output>
                                                      </span>
                                                   </div>


                                                   <div class="mb-3">
                                                     <label for="exampleFormControlSelect1">Subir Video del Evento</label>
                                                     <div class="input-group mb-3">
                                                         <div class="input-group-prepend">
                                                             <span class="input-group-text">Subir Video</span>
                                                         </div>
                                                         <div class="custom-file">
                                                             <input type="file" class="custom-file-input" accept="video/*" name="video_explicativo" id="inputGroupFile01">
                                                             <label class="custom-file-label" for="inputGroupFile01">Agregar Video</label>
                                                         </div>
                                                     </div>
                                                 </div>

                                                    <div class="contenedor_boton_enviar">
                                                      <button type="submit" class="btn btn-primary">Epicris <i class="fas fa-calendar-plus"></i></button>

                                                    </div>
                                                    <style media="screen">
                                                      .contenedor_boton_enviar{
                                                        text-align: center;
                                                      }
                                                    </style>
                                                      <input type="hidden" name="action" value="epicrisis">
                                                      <input type="hidden" name="paciente" id="paciente" value="<?php echo $paciente ?>">

                                                    <div class="alerta_epicrisis"></div>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>


              </div>

                </div>
            </div>
        </div>






        <script type="text/javascript" src="files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>



        <script type="text/javascript" src="files/bower_components/i18next/i18next.min.js"></script>
        <script type="text/javascript" src="files/bower_components/i18next-xhr-backend/i18nextXHRBackend.min.js"></script>
        <script type="text/javascript" src="files/bower_components/i18next-browser-languagedetector/i18nextBrowserLanguageDetector.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-i18next/jquery-i18next.min.js"></script>


        <script type="text/javascript" src="files/bower_components/modernizr/modernizr.js"></script>
        <script type="text/javascript" src="files/bower_components/modernizr/feature-detects/css-scrollbars.js"></script>

        <script type="text/javascript" src="files/bower_components/chart.js/dist/Chart.js"></script>

        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/amcharts.js"></script>
        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/serial.js"></script>
        <script type="text/javascript" src="files/assets/pages/dashboard/amchart/js/light.js"></script>

        <script type="text/javascript" src="files/assets/pages/dashboard/custom-dashboard.min.js"></script>
        <script src="files/assets/js/pcoded.min.js"></script>
        <script src="files/assets/js/horizontal-layout.min.js"></script>
        <script src="files/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
        <script type="text/javascript" src="files/assets/js/script.js"></script>


        <script src="files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>

        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="files/assets/pages/data-table/js/dataTables.bootstrap4.min.js"></script>
        <script src="files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>



        <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="jquery_administrativo/almacen.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script src="medico/epicrisis.js"></script>

        <script type="text/javascript">
            function handleFileSelect(evt) {
                var files = evt.target.files;
                for (var i = 0, f; f = files[i]; i++) {
                  if (!f.type.match('image.*')) {
                    continue;
                  }

                  var reader = new FileReader();
                  reader.onload = (function(theFile) {
                    return function(e) {
                      var span = document.createElement('span');
                      span.innerHTML = ['<img class="img_galeria" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
                      document.getElementById('miniaturas_productos').insertBefore(span, null);
                    };
                  })(f);
                  reader.readAsDataURL(f);
                }
              }
                document.getElementById('lista').addEventListener('change', handleFileSelect, false);

              // jQuery para actualizar el nombre del archivo en el label
              $(document).ready(function(){
                  $('.custom-file-input').on('change', function() {
                      // Obtener el nombre del archivo
                      var fileName = $(this).val().split('\\').pop();
                      // Actualizar el texto del label asociado
                      $(this).next('.custom-file-label').addClass("selected").html(fileName);
                  });
              });
</script>



    </body>

</html>
