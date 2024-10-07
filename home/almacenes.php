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
        <title>Almacenes</title>

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
                                                  <h5>Almacenes Creados</h5> <button type="button" class="btn btn-primary" id="boton_agregar_almacen" name="button">Agregar Almacen</button>
                                              </div>
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                    <table id="tabla_productos" class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Acciones</th>
                                                                <th>Nombre Almacen</th>
                                                                <th>Dirección Almacen</th>
                                                                <th>Dirección Sucursal</th>
                                                                <th>Responsable</th>
                                                                <th>Descripción</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- Las filas de datos se insertarán aquí automáticamente por DataTables -->
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




        <div class="modal fade" id="modal_agregar_almacen" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="proveedorModalLabel">Agregar Proveedor</h5>
                <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
              </div>
              <div class="modal-body">

                <form action=""  id="add_almacen" >

                  <div class="row">
                    <div class="col">
                      <div class="mb-3">
                        <label for="nombre_producto" class="form-label">Nombre del Almacen</label>
                        <input type="text" maxlength="120" name="nombre_almacen" class="form-control" id="nombre_almacen" placeholder="Nombre del Almacen">
                      </div>

                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label for="nombre_producto" class="form-label">Responsable</label>
                        <input type="text" maxlength="120" name="responsable" class="form-control" id="responsable" placeholder="Nombre del Responsable">
                      </div>
                    </div>
                  </div>
                    <div class="mb-3">
                      <label for="nombre_producto" class="form-label">Dirección del Alacen</label>
                      <input type="text" maxlength="120" name="direccion_almacen" class="form-control" id="direccion_almacen" placeholder="Dirección del Almacen">
                    </div>
                  <div class="mb-3">
                        <label for="proveedor" class="form-label">Elija la sucursal si no tienes  <a href="add_sucrusales">Agrega una sucursal</a></label>
                      <select class="form-control" name="sucursal" id="sucursal">
                        <?php
                        $query_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.iduser= '$iduser'   AND sucursales.estatus = 1");
                        while ($data_sucursal = mysqli_fetch_array($query_sucursal)) {
                          echo '<option  value="' . $data_sucursal['id'].'">' . $data_sucursal['direccion_sucursal'] .'</option>';
                        }
                        ?>
                      </select>
                  </div>
                    <div class="mb-3">
                      <label for="descripcion" class="form-label">Agregue una Descripción</label>
                      <textarea class="form-control" maxlength="120" required name="descripcion" id="descripcion" rows="3"></textarea>
                    </div>

                    <div class="modal-footer">
                      <input type="hidden" name="action" value="agregar_almacen">
                      <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                      <button type="submit" class="btn btn-primary">Agregar Almacen</button>
                    </div>
                    <div class="alerta_almacen"></div>
                  </form>
              </div>
            </div>
          </div>
        </div>




                <div class="modal fade" id="modal_editar_almacen" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="proveedorModalLabel">Editar Almacen</h5>
                        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                      </div>
                      <div class="modal-body">

                        <form action=""  id="update_almacen" >
                          <div class="row">
                            <div class="col">
                              <div class="mb-3">
                                <label for="nombre_producto" class="form-label">Nombre del Almacen</label>
                                <input type="text" maxlength="120" name="nombre_almacen" class="form-control" id="nombre_almacen_upload" placeholder="Nombre del Almacen">
                              </div>

                            </div>
                            <div class="col">
                              <div class="mb-3">
                                <label for="nombre_producto" class="form-label">Responsable</label>
                                <input type="text" maxlength="120" name="responsable" class="form-control" id="responsable_upload" placeholder="Nombre del Responsable">
                              </div>
                            </div>
                          </div>
                            <div class="mb-3">
                              <label for="nombre_producto" class="form-label">Dirección del Alacen</label>
                              <input type="text" maxlength="120" name="direccion_almacen" class="form-control" id="direccion_almacen_upload" placeholder="Dirección del Almacen">
                            </div>
                          <div class="mb-3">
                                <label for="proveedor" class="form-label">Elija la sucursal si no tienes  <a href="add_sucrusales">Agrega una sucursal</a></label>
                              <select class="form-control" name="sucursal" id="sucursal_upload">
                                <?php
                                $query_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.iduser= '$iduser'   AND sucursales.estatus = 1");
                                while ($data_sucursal = mysqli_fetch_array($query_sucursal)) {
                                  echo '<option  value="' . $data_sucursal['id'].'">' . $data_sucursal['direccion_sucursal'] .'</option>';
                                }
                                ?>
                              </select>
                          </div>
                            <div class="mb-3">
                              <label for="descripcion" class="form-label">Agregue una Descripción</label>
                              <textarea class="form-control" maxlength="120" required name="descripcion" id="descripcion_upload" rows="3"></textarea>
                            </div>

                            <div class="modal-footer">
                              <input type="hidden" name="action" value="editar_almacen">
                              <input type="hidden" name="id_almacen" id="id_almacen" value="">
                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                              <button type="submit" class="btn btn-primary">Editar Almacen</button>
                            </div>
                            <div class="alerta_editar_almacen"></div>
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
        <script type="text/javascript" src="jquery_administrativo/almacen.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>

        <script type="text/javascript">
        $(document).ready(function() {
            // Inicialización de DataTable
            var tabla_productos = $('#tabla_productos').DataTable({
                "ajax": {
                    "url": "jquery_administrativo/almacen.php",
                    "type": "POST",
                    "data": {
                        "action": 'consultar_datos'
                    },
                    "dataSrc": "data",
                    "error": function(xhr, error, thrown) {
                        console.error('Error al cargar los datos:', error);
                    }
                },
                "columns": [
                    { "data": "id", "render": function(data, type, row) {
                        return '<button type="button" almacen="'+data+'" class="btn btn-danger sucursal_'+data+' eliminar_almacen"><i class="fas fa-trash-alt"></i></button>' +
                               '<button type="button" almacen="'+data+'" class="btn btn-warning sucursal_'+data+' editar_almacen"><i class="fas fa-edit"></i></button>';
                    }},
                    { "data": "nombre_almacen" },
                    { "data": "direccion_almacen" },
                    { "data": "direccion_sucursal" },
                    { "data": "responsable" },
                    { "data": "descripcion" }
                ],
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "language": {
                    "url": "/home/guibis/data-table.json"
                },
                "order": [],
                "destroy": true
            });

            // Función para enviar datos del formulario
            function sendData_almacen(){
                $('.alerta_almacen').html(' <div class="notificacion_negativa">'+
                    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
                '</div>');
                var parametros = new FormData($('#add_almacen')[0]);
                $.ajax({
                    data: parametros,
                    url: 'jquery_administrativo/almacen.php',
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    beforesend: function(){
                    },
                    success: function(response){
                        console.log(response);
                        if (response =='error') {
                            $('.notificacion_agregar_sucursal').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
                        } else {
                            var info = JSON.parse(response);
                            if (info.noticia == 'insert_correct') {
                                            $('.alerta_almacen').html('<div class="alert alert-success background-success">'+
                                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                                '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                                '</button>'+
                                                '<strong>Almacen!</strong> Agregado Correctamente'+
                                            '</div>');
                                            tabla_productos.ajax.reload(); // Recargar los datos en la tabla
                                        }
                          if (info.noticia == 'error_insertar') {
                              $('.alerta_almacen').html('<div class="alert alert-danger background-danger">'+
                                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                  '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                  '</button>'+
                                  '<strong>Error!</strong>Error en el servidor'+
                              '</div>');
                          }
                        }
                    }
                });
            }


            $('#tabla_productos').on('click', '.eliminar_almacen', function(){
                var almacen = $(this).attr('almacen');
                var action = 'eliminar_almacen';
                $.ajax({
                    url: 'jquery_administrativo/almacen.php',
                    type: 'POST',
                    async: true,
                    data: {action: action, almacen: almacen},
                    success: function(response){
                        console.log(response);
                        if (response != 'error') {
                            var info = JSON.parse(response);
                            if (info.noticia == 'insert_correct') {
                                // Código para manejar inserción correcta
                                tabla_productos.ajax.reload(); // Recargar los datos en la tabla
                            }
                            if (info.noticia == 'error_insertar') {
                                // Código para manejar error al insertar
                            }
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });
            $('#tabla_productos').on('click', '.editar_almacen', function(){
                $('#modal_editar_almacen').modal();
                $(".alerta_editar_almacen").html('');
                var almacen = $(this).attr('almacen');
                var action = 'info_almacen';
                $.ajax({
                    url: 'jquery_administrativo/almacen.php',
                    type: 'POST',
                    async: true,
                    data: {action: action, almacen: almacen},
                    success: function(response){
                        console.log(response);
                        if (response != 'error') {
                            var info = JSON.parse(response);
                            $("#nombre_almacen_upload").val(info.nombre_almacen);
                            $("#responsable_upload").val(info.direccion_almacen);
                            $("#direccion_almacen_upload").val(info.direccion_sucursal);
                            $("#sucursal_upload").val(info.cod_sucursal);
                            $("#descripcion_upload").val(info.descripcion);
                            $("#id_almacen").val(info.id);
                        }
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            });

            // Función para editar_almacen
            function sendData_update_almacen(){
                $('.alerta_editar_almacen').html(' <div class="notificacion_negativa">'+
                    '<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>'+
                '</div>');
                var parametros = new FormData($('#update_almacen')[0]);
                $.ajax({
                    data: parametros,
                    url: 'jquery_administrativo/almacen.php',
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    beforesend: function(){
                    },
                    success: function(response){
                        console.log(response);
                        if (response =='error') {
                            $('.notificacion_agregar_sucursal').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>')
                        } else {
                            var info = JSON.parse(response);
                            if (info.noticia == 'insert_correct') {
                                            $('.alerta_editar_almacen').html('<div class="alert alert-success background-success">'+
                                                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                                '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                                '</button>'+
                                                '<strong>Almacen!</strong> Agregado Correctamente'+
                                            '</div>');
                                            tabla_productos.ajax.reload(); // Recargar los datos en la tabla
                                        }
                          if (info.noticia == 'error_insertar') {
                              $('.alerta_editar_almacen').html('<div class="alert alert-danger background-danger">'+
                                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                                  '<i class="icofont icofont-close-line-circled text-white"></i>'+
                                  '</button>'+
                                  '<strong>Error!</strong>Error en el servidor'+
                              '</div>');
                          }
                        }
                    }
                });
            }

              // ediat_alacen
            $('#update_almacen').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario por defecto
                sendData_update_almacen();
            });



            // Evento submit del formulario
            $('#add_almacen').on('submit', function(e) {
                e.preventDefault(); // Prevenir el envío del formulario por defecto
                sendData_almacen();
            });
        });

        (function() {
          $(function() {
            $('#boton_agregar_almacen').on('click', function() {
              $('#modal_agregar_almacen').modal();
              $("#nombre_almacen").val('');
              $("#responsable").val('');
              $("#direccion_almacen").val('');
              $("#descripcion").val('');
              $(".alerta_almacen").html('');

            });
          });
        })();


        </script>



    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
