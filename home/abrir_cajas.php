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
        <title>Abrir Cajas</title>

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
                                      <div class="card-block">
                                          <div class="card product-detail-page">
                                            <div class="">
                                              <div class="card-block">
                                                <?php
                                                    $query_abriri_cero = mysqli_query($conection,"SELECT * FROM `caja` WHERE caja.id_user = '$iduser' AND caja.IDROLPUNTOVENTA='ADMIN'");
                                                    $result_list_cero= mysqli_num_rows($query_abriri_cero);
                                                    ?>
                                                    <?php if ($result_list_cero == 0): ?>
                                                        <div class="container mt-3">
                                                            <form action="" method="post" name="add_iniciar_caja" id="add_iniciar_caja" onsubmit="event.preventDefault(); sendDataedit_iniciar_caja();">
                                                                <div class="mb-3">
                                                                    <label for="inicio_caja" class="form-label">Ingrese el Monto de Apertura</label>
                                                                    <input type="number" step="0.001" class="form-control" required id="inicio_caja" name="inicio_caja" placeholder="Monto de Apertura">
                                                                </div>
                                                                <input type="hidden" name="action" value="abrir_caja">
                                                                <button type="submit" class="btn btn-primary">Abrir Caja</button>
                                                                <div class="alerta_iniciar_caja2 mt-3"></div>
                                                            </form>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php
                                                    $query_sensor_caja = mysqli_query($conection,"SELECT * FROM `caja` WHERE caja.id_user = '$iduser' AND caja.IDROLPUNTOVENTA='ADMIN' ORDER BY caja.id DESC LIMIT 1");
                                                    $result_list_sensor_caja= mysqli_num_rows($query_sensor_caja);
                                                    if ($result_list_sensor_caja>0) {
                                                        $resultados_sensor_caja  = mysqli_fetch_array($query_sensor_caja);
                                                        $estado_ultima_caja =  $resultados_sensor_caja['estado'];
                                                    }
                                                    ?>

                                                    <?php if ($estado_ultima_caja == 'ABIERTO'): ?>
                                                        <?php
                                                        mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                                        $query_factura3 = mysqli_query($conection,"SELECT caja.id_user,caja.fecha_abrir_caja,caja.fecha_cierre_caja,caja.entrada_caja,
                                                            caja.estado,caja.subtotal_factura,caja.iva_factura,caja.total_factura,caja.subtotal_tiket,caja.iva_tiket,
                                                            caja.total_tiket,caja.ganancias_caja,caja.importe_caja,caja.fecha_cierre,caja.id,
                                                            DATE_FORMAT(caja.fecha_abrir_caja, '%W  %d de %b %Y | %H:%i:%s') as 'fecha_nombre' FROM `caja` WHERE caja.id_user = '$iduser' AND caja.estado = 'ABIERTO' AND caja.IDROLPUNTOVENTA='ADMIN' ORDER BY caja.id DESC");
                                                        $resultados  = mysqli_fetch_array($query_factura3);
                                                        $hora_caja_abierta = $resultados['fecha_abrir_caja'];
                                                        $fecha_nombre = $resultados['fecha_nombre'];
                                                        $entrada_caja = $resultados['entrada_caja'];
                                                        $id_caja = $resultados['id'];
                                                        $query_ganancias_factura = mysqli_query($conection,"SELECT SUM(comprobante_factura_final.subtotal) as 'subtotal',SUM(comprobante_factura_final.iva) as 'iva',SUM(comprobante_factura_final.total) as 'total'
                                                        FROM comprobante_factura_final WHERE comprobante_factura_final.id_emisor = '$iduser' AND comprobante_factura_final.fecha >= '$hora_caja_abierta' AND comprobante_factura_final.IDROLPUNTOVENTA='ADMIN'");
                                                        $result_ganancia_factura = mysqli_fetch_array($query_ganancias_factura);
                                                        $subtotal_factura = $result_ganancia_factura['subtotal'];
                                                        $iva_factura = $result_ganancia_factura['iva'];
                                                        $total_factura = $result_ganancia_factura['total'];
                                                        if ($total_factura == '') {
                                                            $total_factura= 0.00;
                                                        }
                                                        $query_ganancias_tiket = mysqli_query($conection,"SELECT SUM(tikets.subtotal) as 'subtotal',SUM(tikets.iva) as 'iva',SUM(tikets.total) as 'total'
                                                        FROM tikets WHERE tikets.id_emisor = '$iduser' AND tikets.fecha >= '$hora_caja_abierta' AND tikets.IDROLPUNTOVENTA='ADMIN'");
                                                        $result_ganancia_tiket = mysqli_fetch_array($query_ganancias_tiket);
                                                        $subtotal_tiket = $result_ganancia_tiket['subtotal'];
                                                        $iva_tiket = $result_ganancia_tiket['iva'];
                                                        $total_tiket = $result_ganancia_tiket['total'];
                                                        if ($total_tiket == '') {
                                                            $total_tiket= 0.00;
                                                        }
                                                        ?>
                                                        <div class="container mt-3">
                                                            <form action="" method="post" name="add_cerrar_caja" id="add_cerrar_caja" onsubmit="event.preventDefault(); sendDatacerrar_caja();">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Tienes una Caja Abierta el <?php echo $fecha_nombre ?></label>
                                                                    <input type="hidden" name="hora_caja_abierta" value="<?php echo $hora_caja_abierta ?>">
                                                                    <input type="hidden" name="action" value="cerrar_caja">
                                                                    <input type="hidden" name="id_caja" value="<?php echo $id_caja ?>">
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-12">
                                                                        <div class="table-responsive">
                                                                            <table class="table table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th>Entrada de Caja</th>
                                                                                        <th>Entrada de Facturas</th>
                                                                                        <th>Ganancias Tikets</th>
                                                                                        <th>Entrada Total Caja</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td>$<?php echo number_format($entrada_caja, 2) ?></td>
                                                                                        <td>$<?php echo number_format($total_factura, 2) ?></td>
                                                                                        <td>$<?php echo number_format($total_tiket, 2); ?></td>
                                                                                        <td>$<?php echo number_format(($total_tiket + $total_factura + $entrada_caja), 2); ?></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Cerrar Caja</button>
                                                                <div class="alerta_cerrar_caja mt-3"></div>
                                                            </form>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if ($estado_ultima_caja == 'CERRADO'): ?>
                                                        <div class="container mt-3">
                                                            <form action="" method="post" name="add_iniciar_caja" id="add_iniciar_caja" onsubmit="event.preventDefault(); sendDataedit_iniciar_caja();">
                                                                <div class="mb-3">
                                                                    <label for="inicio_caja" class="form-label">Ingrese el Monto de Apertura</label>
                                                                    <input type="number" step="0.001" class="form-control" required id="inicio_caja" name="inicio_caja" placeholder="Monto de Apertura">
                                                                </div>
                                                                <input type="hidden" name="action" value="abrir_caja">
                                                                <button type="submit" class="btn btn-primary">Abrir Caja</button>
                                                                <div class="alerta_iniciar_caja2 mt-3"></div>
                                                            </form>
                                                        </div>
                                                    <?php endif; ?>






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
        </div>


        <script type="text/javascript" src="files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>

        <script src="files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/buttons.flash.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/vfs_fonts.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/buttons.colVis.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="files/assets/pages/data-table/js/dataTables.bootstrap4.min.js"></script>
        <script src="files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

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
        <script src="jquery_administrativo/caja.js"></script>

    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
