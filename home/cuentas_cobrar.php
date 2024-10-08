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
        <title>Cuentas por Cobrar</title>
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
                                                  <h5>Cuentas por Cobrar</h5>
                                              </div>
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                    <table id="tabla_facturas" class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Código</th>
                                                                <th>Cliente</th>
                                                                <th>Correo</th>
                                                                <th>Fecha Registro</th>
                                                                <th>Fecha Inicio</th>
                                                                <th>Fecha Final</th>
                                                                <th>Valor Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?php

                                                          $sql_registe = mysqli_query($conection,"SELECT COUNT(*) as total_registro
                                    FROM cuentas_por_cobrar
                                    WHERE cuentas_por_cobrar.iduser = '$iduser'
                                      AND cuentas_por_cobrar.estatus = '1' ");
                                                          $result_register = mysqli_fetch_array($sql_registe);
                                                          $total_registro = $result_register['total_registro'];
                                                          $por_pagina = 20;
                                                          if (empty($_GET['pagina'])) {
                                                            $pagina = 1;
                                                          }else {
                                                            $pagina = $_GET['pagina'];
                                                          }
                                                          $desde = ($pagina-1)*$por_pagina;
                                                          $total_paginas = ceil($total_registro/$por_pagina);
                                                          mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                                          $query_lista = mysqli_query($conection," SELECT cuentas_por_cobrar.id,clientes.nombres as 'nombres_cliente',clientes.mail as 'email_cliente',
                                                            cuentas_por_cobrar.fecha,DATE_FORMAT(cuentas_por_cobrar.fecha, '%W %d de %b %Y %h:%i:%s') AS 'fecha',cuentas_por_cobrar.fecha_inicio,cuentas_por_cobrar.fecha_final,
                                                            cuentas_por_cobrar.descripcion,cuentas_por_cobrar.total
                                                             FROM cuentas_por_cobrar
                                                             INNER JOIN clientes ON clientes.id = cuentas_por_cobrar.id_cliente
                                                              WHERE cuentas_por_cobrar.iduser = '$iduser'
                                                                  AND cuentas_por_cobrar.estatus = '1'
                                                      ORDER BY `cuentas_por_cobrar`.`fecha` desc LIMIT $desde,$por_pagina");
                                                              $result_lista= mysqli_num_rows($query_lista);
                                                            if ($result_lista > 0) {
                                                                  while ($data_lista=mysqli_fetch_array($query_lista)) {
                                                                    //codigo para sacar informacion del cliente

                                                           ?>
                                                           <tr>
                                                             <td><a href="detalle_cuenta_cobrar?cod=<?php echo $data_lista['id'] ?>"><?php echo $data_lista['id'] ?> </a> </td>
                                                             <td> <?php echo $data_lista['nombres_cliente'] ?></td>
                                                             <td> <?php echo $data_lista['email_cliente'] ?></td>
                                                             <td><a href="detalle_cuenta_cobrar?cod=<?php echo $data_lista['id'] ?>"><?php echo mb_strtoupper($data_lista['fecha']);?></a> </td>
                                                             <td><?php echo $data_lista['fecha_inicio'];?></td>
                                                             <td><?php echo $data_lista['fecha_final']; ?>  </td>
                                                             <td>$<?php echo number_format($data_lista['total'],2); ?>  </td>
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
          $('#tabla_facturas').DataTable({
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
        });

        </script>

    </body>
</html>
