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
        <title>Usuarios Punto Venta</title>

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
                                                  <h5>Clientes Creados</h5>  <button type="button" class="btn btn-primary" id="boton_agregar_cliente" name="button">Agregar Usuarios Punto Venta <i class="fas fa-plus"></i></button>
                                              </div>
                                              </div>
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                      <table id="tabla_usuarios_punto_venta" class="table table-striped table-bordered nowrap">
                                                          <thead>
                                                              <tr>
                                                                <th>Acciones</th>
                                                                <th>Código</th>
                                                                <th>Nombres</th>
                                                                <th>Identificación</th>
                                                                <th>Permisos</th>
                                                                <th>Celular</th>
                                                                <th>Telefono</th>
                                                                <th>Email</th>
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



                <div class="modal fade" id="modal_agregar_cliente" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="proveedorModalLabel">Agregar Usuarios Punto Venta</h5>
                        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                      </div>
                      <div class="modal-body">

                        <form action=""  id="add_usuario_punto_venta" >
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nombres del Usuario Punto Venta</label>
                            <input type="text" class="form-control" id="nombres"  name="nombres" aria-describedby="emailHelp" placeholder="Nombres del Usuario Punto Venta">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Email del Usuario Punto Venta</label>
                            <input type="email" name="mail_user" class="form-control"  id="email" placeholder="Ingresa el Email del Usuario Punto Venta">
                          </div>

                          <div class="form-group">
                            <label for="exampleInputPassword1">Ingrese el Celular del Usuario Punto Venta</label>
                            <input type="number" name="celular" class="form-control"  id="celular" placeholder="Ingresa el celular del Usuario Punto Venta">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Ingrese el Teléfono del Usuario Punto Venta</label>
                            <input type="number" name="telefono" class="form-control"  id="celular" placeholder="Ingresa el teléfono del Usuario Punto Venta">
                          </div>

                          <div class="form-group">
                            <label for="exampleInputPassword1">Identificación del Usuario Punto Venta</label>
                            <input type="text" name="identificacion" class="form-control" required id="identificacion" placeholder="Identificación del Usuario Punto Venta">
                          </div>



                          <div class="form-group">
                            <label for="exampleInputPassword1">Dirección del Usuario Punto Venta</label>
                            <input type="text" name="direccion" class="form-control"  id="direccion" placeholder="Ingresa la Usuario Punto Venta">
                          </div>

                          <div class="form-group">
                            <label for="exampleInputPassword1">Ingrese la Contraseña</label>
                            <input type="password" name="password" class="form-control"  id="password" placeholder="Ingresa la Contraseña">
                          </div>


                          <div class="form-group">
                              <label for="exampleFormControlFile1">Ingresa una Imagen</label>
                              <input type="file" accept="image/png, .jpeg, .jpg" name="foto" class="form-control-file" id="exampleFormControlFile1">
                          </div>


                            <div class="modal-footer">
                              <input type="hidden" name="action" value="agregar_usuario_punto_venta" required>
                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                              <button type="submit" class="btn btn-primary">Agregar Usuario Punto Venta</button>
                            </div>
                            <div class="noticia_agregar_clientes">

                            </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>



                <div class="modal fade" id="modal_editar_usuario_punto_venta" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="proveedorModalLabel">Editar Usuario Punto Venta</h5>
                              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                              <form action="" id="update_cliente_usuario_punto_venta">
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Nombres del Usuario Punto Venta</label>
                                      <input type="text" class="form-control" id="nombres_update" name="nombres" aria-describedby="emailHelp" placeholder="Nombres del Cliente" />
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Email del Usuario Punto Venta</label>
                                      <input type="email" name="mail_user" class="form-control" id="email_update" placeholder="Ingresa el Email del Cliente" />
                                  </div>

                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Ingrese el Celular del Usuario Punto Venta</label>
                                      <input type="number" name="celular" class="form-control" id="celular_update" placeholder="Ingresa el celular del Cliente" />
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Ingrese el Teléfono del Usuario Punto Venta</label>
                                      <input type="number" name="telefono" class="form-control" id="telefono_update" placeholder="Ingresa el teléfono del Cliente" />
                                  </div>

                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Identificación del Usuario Punto Venta</label>
                                      <input type="text" name="identificacion" class="form-control" required id="identificacion_update" placeholder="Identificación del Cliente" />
                                  </div>


                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Dirección del Usuario Punto Venta</label>
                                      <input type="text" name="direccion" class="form-control" id="direccion_update" placeholder="Ingresa la Dirección" />
                                  </div>

                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Ingrese la nueva Contraseña</label>
                                    <input type="password" name="password" class="form-control"  id="password" placeholder="Ingresa la Contraseña">
                                  </div>



                                  <div class="modal-footer">
                                    <input type="hidden" name="id_cliente_usuario_punto_venta" id="id_cliente_usuario_punto_venta" value="">
                                      <input type="hidden" name="action" value="editar_usuario_punto_ventas" required />
                                      <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                      <button type="submit" class="btn btn-primary">Editar Punro Venta</button>
                                  </div>
                                  <div class="noticia_editar_usuario_punto_ventas"></div>
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
        <script type="text/javascript" src="jquery_administrativo/usuarios_punto_venta.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
    </body>
</html>
