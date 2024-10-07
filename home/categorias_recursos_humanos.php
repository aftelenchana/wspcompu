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
        <title>Categoria Recursos Humanos</title>

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
        <link rel="stylesheet" href="https://guibis.com/home/estilos/modal.css">
        <link rel="stylesheet" href="https://guibis.com/home/estilos/guibis.css?v=2">
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
                            <br>


                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                              <div class="card-header table-card-header">
                                                  <h5>Cargos Creados </h5>  <button type="button" class="btn btn-primary" id="boton_agregar_sucursal" name="button">Agregar Cargo <i class="fas fa-plus"></i></button>
                                              </div>
                                              <div class="card-block">
                                                <div class="dt-responsive table-responsive">
                                                  <table id="tabla_sucursales" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                          <th>Acciones</th>
                                                          <th>Nombre</th>
                                                          <th>Descripción</th>
                                                          <th>Fecha</th>
                                                          <th>Salario</th>
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
                  </div>

              </div>

                </div>
            </div>
        </div>



        <style media="screen">
          #tabla_sucursales td {
          white-space: normal; /* Permite saltos de línea */
          word-wrap: break-word; /* Asegura que las palabras largas no desborden la celda */
          }

          #tabla_sucursales td:nth-child(0) { /* Asegúrate de que el índice sea correcto */
           max-width: 100px; /* Ajusta el ancho máximo según tus necesidades */
          }



          </style>


                <div class="modal fade" id="modal_agregar_sucursal" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header header_guibis" style="background-color: #263238;">
                        <h5 class="modal-title" id="proveedorModalLabel">Agregar Cargo</h5>
                        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                      </div>
                      <div class="modal-body">

                        <form action=""  id="add_categoria_wsp" >
                          <div class="mb-3">
                              <label for="" class="form-label">Agregar Nombre del Cargo</label>
                              <input type="text" required class="form-control" name="nombre" required id="nombre_categoria" placeholder="Agregar Nombre del Cargo">
                          </div>
                          <div class="mb-3">
                              <label for="" class="form-label">Agregar El Salario</label>
                              <input type="text" required class="form-control" name="salario" required id="salario" placeholder="Salario">
                          </div>
                          <div class="mb-3">
                            <label for="descripcion" class="form-label">Agregue una descripción </label>
                            <textarea class="form-control" maxlength="120" required name="descripcion" id="descripcion" rows="3"></textarea>
                          </div>

                            <div class="modal-footer">
                              <input type="hidden" name="action" value="agregar_categoria">
                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                              <button type="submit" class="btn btn-primary">Agregar Cargo <i class="fas fa-plus"></i></button>
                            </div>
                            <div class="notificacion_agregar_categoria_wsp"></div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>



                <div class="modal fade" id="modal_editar_sucursal" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header header_guibis" style="background-color: #263238;">
                        <h5 class="modal-title" id="proveedorModalLabel">Editar Categoria  #<span id="codigo_categoria" ></span> </h5>
                        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                      </div>
                      <div class="modal-body">

                        <form action=""  id="update_categoria" >
                          <div class="mb-3">
                              <label for="" class="form-label"> Nombre del Cargo</label>
                              <input type="text" required class="form-control" name="nombre" required id="nombre_categoria_upload" placeholder="Agregar Nombre del Cargo">
                          </div>
                          <div class="mb-3">
                            <label for="descripcion" class="form-label">Agregue una descripción </label>
                            <textarea class="form-control" maxlength="120" required name="descripcion" id="descripcion_upload" rows="3"></textarea>
                          </div>
                          <div class="mb-3">
                              <label for="" class="form-label"> Salario</label>
                              <input type="text" required class="form-control" name="salario" required id="salario_upload" placeholder="Salario">
                          </div>
                            <div class="modal-footer">
                              <input type="hidden" name="action" value="editar_sucursal">
                              <input type="hidden" required class="form-control" name="punto_emision" required id="punto_emision_update" placeholder="Punto de Emisión">
                              <input type="hidden" name="id_categoria" id="id_categoria" value="">
                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                              <button type="submit" class="btn btn-primary">Editar Cargo</button>
                            </div>
                            <div class="alerta_editar_categoria"></div>
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
        <script type="text/javascript" src="medico/categorias_recursos_humanos.js?v=5"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>

    </body>
</html>
