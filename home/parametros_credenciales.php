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


  ?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Paramétros Crendenciales</title>

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
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">

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


                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                              <div class="card-header table-card-header">
                                                  <h5>Parámtros Credenciales </h5>  <button type="button" class="btn btn-primary" id="boton_agregar_cliente" name="button">Agregar Parámetro <i class="fas fa-plus"></i></button>
                                              </div>
                                              </div>
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                      <table id="tabla_parametros" class="table table-striped table-bordered nowrap">
                                                          <thead>
                                                              <tr>
                                                                <th>Acciones</th>
                                                                <th>Código</th>
                                                                <th>Nombre</th>
                                                                <th>Descripción</th>
                                                                <th>Visibilidad</th>
                                                                <th>Fecha</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>

                                                          </tbody>

                                                      </table>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div id="styleSelector"></div>
              </div>

                </div>
            </div>
        </div>



                <div class="modal fade" id="modal_agregar_parametro" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="proveedorModalLabel">Agregar Parámetros</h5>
                        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                      </div>
                      <div class="modal-body">

                        <form action=""  id="add_parametro" >
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nombres del Parámetro</label>
                            <input type="text" class="form-control" id="nombres_parametro"  name="nombres_parametro" aria-describedby="emailHelp" placeholder="Nombres del Parámetro">
                          </div>

                          <div class="form-check form-switch">
                            <input class="form-check-input" name="visibilidad" type="checkbox" checked id="customSwitch" onchange="cambiarEstatus(this)">
                            <label class="form-check-label" for="customSwitch">Visibilidad del Parámetro <span class="alerta_estado_visibilidad" ><div class="alert alert-success" role="alert">El parámetro estara visible en todo el sistema!</div></span> </label>
                        </div>

                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Ingrese una descripción </label>
                            <textarea class="form-control" name="descripcion_parametro"  id="descripcion_parametro" rows="3"></textarea>
                          </div>


                            <div class="modal-footer">
                              <input type="hidden" name="action" value="agregar_parametros" required>
                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                              <button type="submit" class="btn btn-primary">Agregar Parámetro</button>
                            </div>
                            <div class="noticia_agregar_parametros">

                            </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>



                <div class="modal fade" id="modal_editar_parametro" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="proveedorModalLabel">Editar Cliente</h5>
                              <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                          </div>
                          <div class="modal-body">
                              <form action="" id="update_parametro">

                                <div class="form-group">
                                  <label for="exampleInputEmail1">Nombres del Parámetro</label>
                                  <input type="text" class="form-control" id="nombres_parametro_update"  name="nombres_parametro" aria-describedby="emailHelp" placeholder="Nombres del Parámetro">
                                </div>

                                <div class="form-check form-switch">
                                  <input class="form-check-input" name="visibilidad" type="checkbox"  id="customSwitch_update" onchange="cambiarEstatus(this)">
                                  <label class="form-check-label" for="customSwitch">Visibilidad del Parámetro <span class="alerta_estado_visibilidad" ></span> </label>
                              </div>

                                <div class="form-group">
                                  <label for="exampleFormControlTextarea1">Ingrese una descripción </label>
                                  <textarea class="form-control" name="descripcion_parametro"  id="descripcion_parametro_update" rows="3"></textarea>
                                </div>


                                  <div class="modal-footer">
                                    <input type="hidden" name="id_parametro" id="id_parametro" value="">
                                      <input type="hidden" name="action" value="editar_parametro" required />
                                      <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                      <button type="submit" class="btn btn-primary">Editar Parámetro</button>
                                  </div>
                                  <div class="noticia_editar_parametro"></div>
                              </form>
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
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script type="text/javascript" src="jquery_credenciales/parametros.js"></script>
        <script>
    function cambiarEstatus(elemento) {
        if(elemento.checked) {

          $('.alerta_estado_visibilidad').html('<div class="alert alert-success" role="alert">El parámetro estara visible en todo el sistema!</div>');


            console.log("El switch está en ON, estatus activado");
            // Aquí puedes manejar el estatus "activado"
        } else {
            console.log("El switch está en OFF, estatus desactivado");
              $('.alerta_estado_visibilidad').html('<div class="alert alert-warning" role="alert">El parámetro no estara visible en todo el sistema!</div>');
            // Aquí puedes manejar el estatus "desactivado"
        }
    }
</script>


    </body>
</html>
