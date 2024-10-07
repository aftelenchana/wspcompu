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
        <title>Inventario General</title>

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
                                                  <h5>Iventario General </h5>
                                              </div>
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                      <table id="tabla_productos" class="table table-striped table-bordered nowrap">
                                                          <thead>
                                                              <tr>
                                                                <th>Imagen</th>
                                                                <th>Acción</th>
                                                                <th>Cantidad</th>
                                                                <th>Motivo</th>
                                                                <th>Fecha</th>
                                                                <th>Cantidad Estandar</th>
                                                                <th>Detalles</th>
                                                                <th>Archivo Generado</th>
                                                              </tr>
                                                          </thead>
                                                          <tbody>
                                                            <?php
                                                            //PAGINADOR

                                                            mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                                            $query_lista = mysqli_query($conection,"SELECT producto_venta.foto,inventario.accion,producto_venta.idproducto,inventario.motivo,DATE_FORMAT(inventario.fecha, '%W  %d de %b %Y %H:%m') as 'fecha_inventario',
                                                            inventario.cantidad_new,inventario.detalles_extras,inventario.cantidad,inventario.codigo_ingreso,inventario.url_upload,inventario.codigo_ingreso FROM inventario
                                                      INNER JOIN producto_venta ON producto_venta.idproducto = inventario.idproducto
                                                      INNER JOIN comprobantes ON  comprobantes.secuencial = inventario.codigo_ingreso
                                                      WHERE  inventario.iduser = '$iduser' ORDER BY inventario.id DESC");
                                                            $result_lista= mysqli_num_rows($query_lista);
                                                              if ($result_lista > 0) {
                                                                    while ($data_producto=mysqli_fetch_array($query_lista)) {
                                                                      $foto = 'img/uploads/'.$data_producto['foto'];
                                                                        $codigo_ingreso = $data_producto['codigo_ingreso'];
                                                             ?>
                                                             <tr>
                                                               <td class="" data-titulo="Imagen"><img src="<?php echo "$foto"; ?>" width="100px;" alt=""></td>
                                                               <td class="" data-titulo="Acción"><?php echo $data_producto['accion']; ?></td>
                                                               <td class="" data-titulo="Cantidad"><?php echo $data_producto['cantidad']; ?></td>
                                                               <td class="" data-titulo="Motivo"><?php echo $data_producto['motivo']; ?>  </td>
                                                               <td class="" data-titulo="Fecha"><?php echo mb_strtoupper( $data_producto['fecha_inventario']); ?>  </td>
                                                               <td class="" data-titulo="Cantidad Estandar"><?php echo $data_producto['cantidad_new']; ?>  </td>
                                                               <td class="" data-titulo="Detalles">
                                                                 <?php if ($data_producto['detalles_extras'] == 'TICKET'): ?>
                                                                   Nota de Venta

                                                                 <?php endif; ?>
                                                                 <?php if ($data_producto['detalles_extras'] == 'FACTURA'): ?>
                                                                   Factura Electrónica

                                                                 <?php endif; ?>

                                                               </td>
                                                               <td class="" data-titulo="Archivo Generado">
                                                                 <?php if ($data_producto['accion'] == 'DISMINUIR'): ?>
                                                                   <?php if ($data_producto['detalles_extras'] == 'TICKET'): ?>
                                                                     <?php
                                                                       $query_tiket = mysqli_query($conection,"SELECT * FROM `tikets` WHERE tikets.secuencia  = '$codigo_ingreso'");
                                                                       $data_tiket  =mysqli_fetch_array($query_tiket);
                                                                      ?>
                                                                         <a download href="<?php echo $data_producto['url_upload'] ?>/home/facturacion/facturacionphp/comprobantes/tikets/<?php echo $data_tiket['clave_acceso'];?>.pdf"><img src="img/reacciones/pdf.png" width="45px" alt=""></a>

                                                                   <?php endif; ?>

                                                                   <?php if ($data_producto['detalles_extras'] == 'FACTURA'): ?>
                                                                     <a download href="<?php echo $data_producto['url_upload']?>/home/facturacion/facturacionphp/comprobantes/pdf/<?php echo $data_producto['codigo_ingreso'];?>.pdf"><img src="https://guibis.com/home/img/reacciones/pdf.png" width="45px" alt=""></a>

                                                                   <?php endif; ?>

                                                                 <?php endif; ?>


                                                                </td>

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
                                  <div class="row">
                                    <div class="col" style="text-align: center;">
                                      <iframe width="90%" height="315" src="https://www.youtube.com/embed/b2rDMNGGgWw?si=gboWaGXIGVv5Bgpr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                                    </div>
                                    <div class="col" style="text-align: center;">
                                      <iframe width="90%" height="315" src="https://www.youtube.com/embed/0fhow0seZkQ?si=g5IDlfnjOqsiN2CA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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
          <script src="area_facturacion/busqueda_secuencia.js"></script>

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
</html>
