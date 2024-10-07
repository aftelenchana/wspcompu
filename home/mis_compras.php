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

        <link rel="stylesheet" href="estilos-importante/cuenta-bancaria.css?v=3">
        <link rel="stylesheet" href="estilos-importante/cuenta.css?v=2">

        <link rel="stylesheet" href="estilos/categorias.css">
        <link rel="stylesheet" href="/css/pie_pagina.css?v=2">

        <link rel="stylesheet" href="estiloshome/cuenta_bancaria.css?v=5">
        <link rel="stylesheet" href="estiloshome/estilos_paginador.css">
        <link rel="stylesheet" href="estiloshome/load.css">
        <link rel="stylesheet" href="estilos/tabla_front.css">

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



              $query = mysqli_query($conection, "SELECT * FROM `saldo_total_leben`
               INNER JOIN usuarios ON saldo_total_leben.idusuario = usuarios.id
               WHERE usuarios.id = $iduser ");
               $result_bq_r = mysqli_fetch_array($query);
               $qr_bancario =  $result_bq_r['qr_bancario'];

              $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
              $result = mysqli_fetch_array($query);
              $email_usuario = $result['email'];
              $nombres_usuario = $result['nombres'];
              $apellidos_usuario = $result['apellidos'];
              $cuenta_bancaria = $result['banco_pichincha'];
              $banco_guayaquil = $result['banco_guayaquil'];
              $banco_produbanco = $result['banco_produbanco'];
              $banco_pacifico = $result['banco_pacifico'];
              $camara_comercio_ambato = $result['camara_comercio_ambato'];
              $mushuc_runa = $result['mushuc_runa'];
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


                                            <div class="container mt-4">
                            <div class="row justify-content-center">
                                <div class="col">
                                    <div class="text-center mb-3">
                                        <a href="/home/active-token">
                                            <img class="imagen_token_seguridad" src="https://guibis.com/home/img/qr_bancario/<?php echo $qr_bancario ?>" alt="QR Bancario" class="img-fluid" >
                                        </a>
                                    </div>
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive"> <!-- Clase table-responsive agregada aquí -->
                                                <table class="table table-striped">
                                                    <tbody>
                                                        <tr>
                                                            <td><i class="fas fa-user"></i> Nombre: <?php echo $result['nombres'] . " " . $result['apellidos']; ?></td>
                                                            <td><i class="fas fa-wallet"></i> Saldo Total: <span class="saldo_total">$<?php echo round($result_bq_r['cantidad'], 2) ?></span></td>
                                                            <td><i class="fas fa-envelope"></i> Email: <?php echo $result['email']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><i class="fas fa-id-card"></i> Cédula: <?php echo $result['numero_identidad']; ?></td>
                                                            <td><i class="fas fa-mobile-alt"></i> Celular: <?php echo $result['celular']; ?></td>
                                                            <td><i class="fas fa-phone"></i> Teléfono: <?php echo $result['telefono']; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                                        <!-- Contenedor Principal -->

                                        <div class="histo_banca ">
                                          <div class="container py-5">
                                            <!-- Primera fila de acciones -->
                                            <div class="row row-cols-1 row-cols-md-2 g-4 mb-4">
                                              <!-- Acción Activar Token -->
                                              <div class="col">
                                                <a href="/home/active-token" class="card h-100 text-center text-decoration-none shadow-sm">
                                                  <div class="card-body">
                                                    <i class="fas fa-qrcode fa-3x mb-3" style="color: #FFC107;"></i>
                                                    <h5 class="card-title mb-0">Activar Token</h5>
                                                  </div>
                                                </a>
                                              </div>
                                              <!-- Acción Créditos Directos -->
                                              <div class="col">
                                                <a href="creditos" class="card h-100 text-center text-decoration-none shadow-sm">
                                                  <div class="card-body">
                                                    <i class="fas fa-wallet fa-3x mb-3" style="color: #4CAF50;"></i>
                                                    <h5 class="card-title mb-0">Créditos Directos</h5>
                                                  </div>
                                                </a>
                                              </div>
                                            </div>
                                            <!-- Segunda fila de acciones -->
                                            <div class="row row-cols-1 row-cols-md-2 g-4">
                                              <!-- Acción Historial de Depósitos -->
                                              <div class="col">
                                                <a href="historial-depositos" class="card h-100 text-center text-decoration-none shadow-sm">
                                                  <div class="card-body">
                                                    <i class="fas fa-file-invoice-dollar fa-3x mb-3" style="color: #FFC107;"></i>
                                                    <h5 class="card-title mb-0">Historial Depósitos</h5>
                                                  </div>
                                                </a>
                                              </div>
                                              <!-- Acción Historial de Retiros -->
                                              <div class="col">
                                                <a href="historial-retiros" class="card h-100 text-center text-decoration-none shadow-sm">
                                                  <div class="card-body">
                                                    <i class="fas fa-hand-holding-usd fa-3x mb-3" style="color: #4CAF50;"></i>
                                                    <h5 class="card-title mb-0">Historial Retiros</h5>
                                                  </div>
                                                </a>
                                              </div>
                                            </div>
                                          </div>

                                        </div>



                                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                         <div class="modal-dialog" role="document">
                                           <div class="modal-content">
                                             <div class="modal-header">
                                               <h5 class="modal-title" id="exampleModalLongTitle">Reportar un Problema de la venta </h5>
                                               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                 <span aria-hidden="true">&times;</span>
                                               </button>
                                             </div>
                                             <div class="modal-body respuesta_reporte_problemas">


                                             </div>

                                           </div>
                                         </div>
                                       </div>



                                        <div class="contenedor_fgt">
                                          <div class="histial_bancario_general" style="padding: 15px;">
                                            <div class="">
                                              <table>
                                                <tr class="titu_table">
                                                  <td>Código</td>
                                                  <td>Fecha</td>
                                                  <td>Producto</td>
                                                  <td>Cantidad</td>
                                                  <td>Precio</td>
                                                  <td>Compra</td>
                                                  <td>Entrega</td>
                                                  <td>Reportar</td>
                                                  <td>Detalles</td>
                                                </tr>
                                                <?php

                                                $sql_registe = mysqli_query($conection,"SELECT COUNT(*) as  total_registro   FROM ventas  INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
                                                WHERE id_comprador = $iduser ORDER BY ventas.fecha DESC");


                                                $result_register = mysqli_fetch_array($sql_registe);
                                                $total_registro = $result_register['total_registro'];
                                                $por_pagina = 25;
                                                if (empty($_GET['pagina'])) {
                                                  $pagina = 1;
                                                }else {
                                                  $pagina = $_GET['pagina'];
                                                }
                                                $desde = ($pagina-1)*$por_pagina;
                                                $total_paginas = ceil($total_registro/$por_pagina);



                                                mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                                $query_lista = mysqli_query($conection,"SELECT ventas.id as 'idcompra', producto_venta.idproducto as 'idproducto', producto_venta.qr, producto_venta.nombre,
                                                  ventas.id_comprador,   DATE_FORMAT(ventas.fecha, '%W  %d de %b %Y %H:%i:%s') as 'feha_compra',ventas.metodo_pago,producto_venta.precio,ventas.cantidad_producto,
                                                  ventas.estado_financiero,ventas.estado_fisico,ventas.estado,producto_venta.foto,ventas.precio_compra
                                          FROM ventas  INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
                                          WHERE id_comprador = $iduser ORDER BY ventas.fecha DESC LIMIT  $desde,$por_pagina");

                                                $result_lista= mysqli_num_rows($query_lista);
                                                if ($result_lista > 0) {
                                                      while ($data_lista=mysqli_fetch_array($query_lista)) {
                                                          $qr = 'img/qr/'.$data_lista['qr'];


                                                 ?>
                                                 <tr>
                                                   <td data-titulo="Códigp"><?php echo ($data_lista['idcompra']);?></td>
                                                   <td data-titulo="Fecha"><?php echo mb_strtoupper($data_lista['feha_compra']);?></td>
                                                   <td data-titulo="Producto"><a href="producto?codigo=<?php echo ($data_lista['idproducto']);?>"> <img style="width: 80px;" src="img/uploads/<?php echo $data_lista['foto']; ?>" alt=""> </a> </td>
                                                   <td data-titulo="Cantidad"><?php echo $data_lista['cantidad_producto'];  ?></td>
                                                   <td data-titulo="Monto"> $ <?php echo number_format($data_lista['precio_compra'],2); ?></td>
                                                   <td class="estado_venta_<?php echo str_replace(" ","",$data_lista['estado']) ?> " data-titulo="Compra">  <?php echo $data_lista['estado']; ?></td>
                                                   <td class="entrga_venta<?php echo $data_lista['id'];?> estado_<?php echo str_replace(" ","",$data_lista['estado_fisico']) ?>" data-titulo="Entrega">  <?php echo $data_lista['estado_fisico']; ?></td>
                                                   <td data-titulo="Reportar">
                                                    <a class="btn btn-warning solicitar_entrega_historial" venta="<?php echo $data_lista['idcompra']; ?>" href="#">Reportar un Problema</a>
                                                   </td>
                                                   <td data-titulo="Mas Detalles"> <a href="detalles-compracompra=<?php echo $data_lista['idcompra']; ?>">Detalles</a> </td>
                                                   </tr>
                                                 <?php
                                               }
                                             }

                                             ?>
                                              </table>
                                            </div>
                                          </div>
                                        </div>


                                          <div class="paginador">
                                            <ul>
                                              <?php
                                              if ($pagina != 1) {
                                                // code...

                                               ?>
                                              <li> <a href="?pagina=<?php echo 1; ?>">|<</a></li>
                                              <li> <a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
                                              <?php
                                            }
                                              for ($i=1; $i <= $total_paginas; $i++) {
                                                if ($i == $pagina ) {
                                                  echo '<li class="paginaactual">'.$i.'</li>';
                                                }else {
                                                  echo '<li> <a href="?pagina='.$i.'">'.$i.'</a></li>';
                                                }
                                              }
                                              if ($pagina != $total_paginas) {
                                               ?>
                                              <li> <a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
                                              <li> <a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
                                              <?php 	} ?>
                                            </ul>
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
        <script src="https://kit.fontawesome.com/2c36e9b7b1.js"></script>
        <script src="https://guibis.com/home/main.js"></script>
        <script src="/js/categorias.js"></script>

        <script type="text/javascript" src="jquery_bancario/depositos.js"></script>
        <script type="text/javascript" src="jquery_bancario/mi-leben.js"></script>
        <script type="text/javascript" src="jquery_historial_compra/historial.js"></script>





    </body>

</html>
