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
        <title>Facturas Generadas</title>

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
                            <br>


                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                              <div class="card-header table-card-header">
                                                  <h5>Facturas Autorizadas</h5>
                                              </div>
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                    <table id="tabla_facturas" class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>PDF</th>
                                                                <th>XML</th>
                                                                <th>Secuencial</th>
                                                                <th>Estado</th>
                                                                <th>Valor</th>
                                                                <th>Fecha</th>
                                                                <th>Receptor</th>
                                                                <th>Reenviar Facturas</th>
                                                                <th>Nota de Crédito</th>
                                                                <th>Guia de Remisión</th>
                                                                <th>Repetir Factura</th>
                                                                <th>Clave de Acceso</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                          <?php


                                                          $query_lista = mysqli_query($conection," SELECT comprobante_factura_final.fecha,comprobante_factura_final.codigo_factura,comprobante_factura_final.nombres_receptor,
                                                            comprobante_factura_final.cedula_receptor,comprobante_factura_final.email_receptor,comprobante_factura_final.clave_acceso,comprobante_factura_final.descripcion,
                                                            comprobante_factura_final.id_producto,comprobante_factura_final.total,comprobante_factura_final.id,comprobante_factura_final.estado,comprobante_factura_final.url_file_upload,
                                                            comprobante_factura_final.secuencia,comprobante_factura_final.codigo_comprobante
                                                             FROM comprobante_factura_final
                                                            WHERE comprobante_factura_final.id_emisor = '$iduser'
                                                              AND (comprobante_factura_final.secuencia != '00000000' || comprobante_factura_final.secuencia IS NOT NULL)
                                                              AND comprobante = 'factura'
                                                      ORDER BY `comprobante_factura_final`.`fecha` desc");
                                                              $result_lista= mysqli_num_rows($query_lista);
                                                            if ($result_lista > 0) {
                                                                  while ($data_lista=mysqli_fetch_array($query_lista)) {
                                                           ?>
                                                           <tr>
                                                             <td class="" data-titulo="Pdf"> <a download href="<?php echo $data_lista['url_file_upload']; ?>/home/facturacion/facturacionphp/comprobantes/pdf/<?php echo $data_lista['clave_acceso'];?>.pdf"><img src="img/reacciones/pdf.png" width="45px" alt=""></a>  </td>
                                                             <td class="" data-titulo="Xml"> <a download href="<?php echo $data_lista['url_file_upload']; ?>/home/facturacion/facturacionphp/comprobantes/autorizados/<?php echo $data_lista['clave_acceso'];?>.xml"><img src="img/reacciones/xml.png" width="45px" alt=""></a>  </td>
                                                             <td class="" data-titulo="Valor"><?php echo $data_lista['secuencia'];?></td>
                                                             <td class="" data-titulo="Estado"> <a href="detalles_factura?detalles_factura=<?php echo $data_lista['clave_acceso'];?>&ininterno=<?php echo $data_lista['id']?>"><?php echo $data_lista['estado'];?></a> </td>
                                                             <td class="" data-titulo="Valor">$<?php echo $data_lista['total'];?></td>
                                                             <td class="" data-titulo="Fecha"> <a href="detalles_factura?detalles_factura=<?php echo $data_lista['clave_acceso'];?>&ininterno=<?php echo $data_lista['id']?>"><?php echo $data_lista['fecha'];?></a> </td>
                                                             <td class="" data-titulo="Receptor"><?php echo $data_lista['nombres_receptor']; ?>  </td>
                                                             <td class="<?php echo $data_lista['clave_acceso']; ?>" data-titulo="Reenviar Factura"> <img clave_acceso="<?php echo $data_lista['clave_acceso'];?>" codigo_factura="<?php echo $data_lista['id']?>" class="boton_reenviar_facturas" src="img/reacciones/reenvio.png" width="45px" alt=""></td>
                                                             <td class="" data-titulo="Nota de Crédito"> <a href="notas_dredito?factura=<?php echo $data_lista['clave_acceso'];?>">Realizar Nota de Crédito </a> </td>
                                                             <td class="" data-titulo="Guia de Remisión"> <a href="guia_remision?factura=<?php echo $data_lista['clave_acceso'];?>">Guia Remisión </a> </td>
                                                             <td class="" data-titulo="Reperir Factura">
                                                               <?php if (!empty($data_lista['codigo_comprobante'])): ?>
                                                                 <a href="facturacion_in?factura=<?php echo $data_lista['codigo_comprobante'];?>">Repetir Factura </a>
                                                               <?php endif; ?>

                                                              </td>
                                                              <td class="" data-titulo="Clave de Acceso"><?php echo $data_lista['clave_acceso'];?> </td>

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
        <div class="modal fade modal_reenvio_facturas" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Reenvio de Factura <span class="identificador_factura" style="font-size: 11px;"></span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form  class="" method="post" name="reenviar_facturas" id="reenviar_facturas" onsubmit="event.preventDefault(); sendData_reenviar_facturas();">
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Ingrese el destinatario 1</label>
                        <input type="email" class="form-control" name="destinatario1" value="" required aria-describedby="emailHelp" placeholder="Ingrese el destinatario 1">
                      </div>

                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Ingrese el destinatario 2</label>
                        <input type="email" class="form-control" name="destinatario2" value=""   aria-describedby="emailHelp" placeholder="Ingrese el destinatario 2">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Ingrese el destinatario 3</label>
                        <input type="email" class="form-control" name="destinatario3" value=""  aria-describedby="emailHelp" placeholder="Ingrese el destinatario 3">
                      </div>

                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Ingrese el destinatario 4</label>
                        <input type="email" class="form-control" name="destinatario4" value=""   aria-describedby="emailHelp" placeholder="Ingrese el destinatario 4">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Ingrese el destinatario 5</label>
                        <input type="email" class="form-control" name="destinatario5" value=""  aria-describedby="emailHelp" placeholder="Ingrese el destinatario 5">
                      </div>

                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label for="exampleInputEmail1">Ingrese el destinatario 6</label>
                        <input type="email" class="form-control" name="destinatario6" value=""   aria-describedby="emailHelp" placeholder="Ingrese el destinatario 6">
                      </div>
                    </div>
                  </div>
               <div class="modal-footer">
                 <input type="hidden" name="action" value="reenviar_factura">
                 <input type="hidden" name="factura" id="factura_codigo" value="">
                 <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                 <button type="submit" class="btn btn-primary">Reenviar Facturas</button>
               </div>
               <div class="notificacion_reenviar_facturas">

               </div>
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
        <script type="text/javascript" src="jquery_administrativo/reenvio_facturas.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
          $('#tabla_facturas').DataTable({
              "dom": 'Bfrtip',
              "buttons": [
                  'copy', 'csv', 'excel', 'pdf', 'print'
              ],
              "language": {
                  "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
              },
              "order": [],
              "destroy": true
          });
        });

        </script>
        <script type="text/javascript">
          (function(){
            $(function(){
              $('.boton_reenviar_facturas').on('click',function(){
                var codigo_factura = $(this).attr('codigo_factura');
                var clave_acceso = $(this).attr('clave_acceso');
                  $(".identificador_factura").html(clave_acceso);

                    $("#factura_codigo").val(codigo_factura);
                $('.modal_reenvio_facturas').modal();
              });


            });

          }());
        </script>

    </body>
</html>
