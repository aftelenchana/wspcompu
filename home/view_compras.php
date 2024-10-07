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
        <title>Mis Compras</title>

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
                                                  <h5>Mis Compras</h5>
                                              </div>
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                      <table id="tabla_productos" class="table table-striped table-bordered nowrap">
                                                          <thead>
                                                              <tr>
                                                                <th>ID</th>
                                                                <th>XML</th>
                                                                <th>Monto</th>
                                                                <th>Identificación Emisor</th>
                                                                <th>Fecha Emisión</th>
                                                                <th>Fecha Registro</th>
                                                                <th>Razón Social Emisor</th>
                                                                <th>Detalles</th>
                                                                <th>Banco</th>
                                                                <th>Tipo Movimiento</th>
                                                                <th>Configurar Productos</th>
                                                                <th>Retención</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                            <?php
                                                            mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                                            $query_lista = mysqli_query($conection,"SELECT *FROM `compras_facturacion`
                                                      WHERE compras_facturacion.iduser  = '$iduser'
                                                        ORDER BY `compras_facturacion`.`id` DESC");
                                                        $result_lista= mysqli_num_rows($query_lista);
                                                      if ($result_lista > 0) {
                                                            while ($data_lista=mysqli_fetch_array($query_lista)) {
                                                              $cuenta_bancaria = $data_lista['banco'];
                                                              $identificacion_proveedor = $data_lista['identificacion_emisor'];;
                                                             ?>
                                                             <tr>
                                                               <td class=""><?php echo $data_lista['id'];?></td>
                                                               <td class=""> <a download href="archivos/compras/<?php echo $data_lista['xml'];?>"><img src="img/reacciones/xml.png" width="45px" alt=""></a>  </td>
                                                               <td class="">$<?php echo $data_lista['monto'];?></td>
                                                               <td class="">
                                                               <?php
                                                               $query_sensor = mysqli_query($conection,"SELECT * FROM proveedor WHERE  proveedor.identificacion = '$identificacion_proveedor' AND proveedor.iduser = '$iduser' ");
                                                               $result__sensor= mysqli_num_rows($query_sensor);
                                                            ?>

                                                               <?php if ($result__sensor==0): ?>
                                                                 <button  type="button" factura = "<?php echo $data_lista['xml'] ?>"  class="agregar_proveedor btn btn-outline-secondary"><?php echo $identificacion_proveedor ;?> no existe agrega el proveedor.</button>

                                                               <?php endif; ?>
                                                               <?php if ($result__sensor > 0): ?>
                                                                 <button disabled type="button" class="btn btn-info"><?php echo $identificacion_proveedor ;?> ya esta en tu lista. </button>
                                                               <?php endif; ?>



                                                             </td>
                                                               <td class=""><?php echo $data_lista['fecha_emision_factura'];?></td>
                                                                <td class=""><?php echo $data_lista['fecha_registro'];?></td>
                                                               <td class=""><?php echo $data_lista['razon_social_emisor'];?></td>
                                                               <td class=""><?php echo $data_lista['descripcion'];?></td>
                                                               <td class="">

                                                                 <?php if ($data_lista['banco'] != ''): ?>
                                                                   <?php   $query_banco = mysqli_query($conection,"SELECT * FROM cuentas_bancarias_factu WHERE  cuentas_bancarias_factu.iduser= '$iduser'   AND cuentas_bancarias_factu.id = $cuenta_bancaria");
                                                                    $bancos = mysqli_fetch_array($query_banco);
                                                                   ?>
                                                                   <?php echo $bancos['nombre_cuenta'];?> <?php '/' ?> <?php echo $bancos['numero_cuenta'];?>
                                                                 </td>

                                                                 <?php endif; ?>

                                                               <td class=""><?php echo $data_lista['tipo_movimiento'];?></td>
                                                               <td class=""> <a href="config_product?idfac=<?php echo $data_lista['id'] ?>">Configurar <?php echo $data_lista['productos'];?> productos</a> </td>
                                                               <td><a href="procesar_retencion?codigo=<?php echo $data_lista['id'];?>">Realizar Retencion</a></td>
                                                             </tr>
                                                                      <?php
                                                                      }
                                                                      }
                                                                  ?>
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


        <div class="modal fade" id="proveedorModal" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="proveedorModalLabel">Agregar Proveedor</h5>
                <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
              </div>
              <div class="modal-body">
                <form method="post" name="agregar_proveedor" id="agregar_proveedor" onsubmit="event.preventDefault(); sendDataedit_nuevo_proveedor();">
                  <div class="mb-3">
                    <label for="razon_social_proveedor" class="form-label">Razón Social del Proveedor</label>
                    <input type="text" class="form-control" name="razon_social_proveedor" required id="razon_social_proveedor" placeholder="Agrega la razón social de Transportista">
                  </div>
                  <div class="mb-3">
                    <label for="tipo_identificacion_proveedor" class="form-label">Tipo de Identificación del Proveedor</label>
                    <select class="form-control" required name="tipo_identificacion_proveedor" id="tipo_identificacion_proveedor">
                      <option value="04">RUC</option>
                      <option value="05">Cédula</option>
                      <option value="06">Pasaporte</option>
                      <option value="07">Otro</option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="identificacion_proveedor" class="form-label">Identificación del Proveedor</label>
                    <input type="number" class="form-control" required id="identificacion_proveedor" name="identificacion_proveedor" placeholder="Identificación del Proveedor">
                  </div>
                  <div class="mb-3">
                    <label for="direccion_proveedro" class="form-label">Dirección del Proveedor</label>
                    <input type="text" class="form-control" required id="direccion_proveedro" name="direccion_proveedro" placeholder="Dirección del Proveedor">
                  </div>
                  <div class="mb-3">
                    <label for="celular_proveedor" class="form-label">Celular del Proveedor</label>
                    <input type="text" class="form-control" required id="celular_proveedor" name="celular_proveedor" placeholder="Celular del Proveedor">
                  </div>
                  <div class="mb-3">
                    <label for="email_proveedor" class="form-label">Email del Proveedor</label>
                    <input type="email" class="form-control" required id="email_proveedor" name="email_proveedor" placeholder="Email del Proveedor">
                  </div>
                  <div class="mb-3">
                    <label for="foto" class="form-label">Imagen del Proveedor</label>
                    <input type="file"  accept="image/png, .jpeg, .jpg" class="form-control" name="foto" id="foto">
                  </div>
                  <div class="mb-3">
                    <label for="descripcion_proveedor" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion_proveedor" id="descripcion_proveedor" rows="3"></textarea>
                  </div>
                  <input type="hidden" name="action" value="agregar_proveedor">
                  <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                  <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
                  <div class="alerta_nuevoproveedor"></div>
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
        <script src="jquery_empresa/proveedor.js"></script>
        <script type="text/javascript" src="jquery_empresa/clientes.js"></script>


        <script type="text/javascript">
          (function(){
            $(function(){
              $('.agregar_proveedor').on('click',function(){
                $('#proveedorModal').modal();
                var factura = $(this).attr('factura');
                var action = 'buscar_proveedor';
                console.log(factura);
                $.ajax({
                  type:"post",
                  url:"jquery_empresa/proveedor.php",
                  data: {action:action,factura:factura},
                  success:function(response){
                    console.log(response);
                    var info = JSON.parse(response);
                    $("#direccion_proveedro").val(info.dirMatriz);
                    $("#tipo_identificacion_proveedor").val('04');
                    $("#identificacion_proveedor").val(info.ruc_emisor);
                    $("#razon_social_proveedor").val(info.razon_social_emisor);
                    $("#descripcion_producto").val(info.descripcion);

                  }
                })
              });


            });

          }());
        </script>

        <script>
        $(document).ready(function() {
            $('#tabla_productos').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                language: {
                    url: "/home/guibis/data-table.json"
                },
                order: []
            });
        });

</script>

    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
