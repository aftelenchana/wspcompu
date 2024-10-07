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
       $codigo_cuenta = $_GET['cod'];
  ?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Detalle Cuentas por Cobrar ID:<?php echo $codigo_cuenta ?></title>
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
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
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

     $query_suma_pago = mysqli_query($conection,"SELECT SUM(((historial_pago_cuentas_cobrar.cantidad_deposito))) as 'total_pago_actual'
     FROM `historial_pago_cuentas_cobrar`
     WHERE historial_pago_cuentas_cobrar.cuenta_cobrar = '$codigo_cuenta'");
     $data_suma =mysqli_fetch_array($query_suma_pago);
     if (empty($data_suma['total_pago_actual'])) {
       $total_pagado = 0;
     }else {
       $total_pagado = round(($data_suma['total_pago_actual']),2);
     }



     mysqli_query($conection,"SET lc_time_names = 'es_ES'");
     $query_detalle_cuentas_cobrar = mysqli_query($conection," SELECT cuentas_por_cobrar.id,clientes.nombres as 'nombres_cliente',clientes.mail as 'email_cliente',
       cuentas_por_cobrar.fecha,DATE_FORMAT(cuentas_por_cobrar.fecha, '%W %d de %b %Y %h:%i:%s') AS 'fecha',cuentas_por_cobrar.fecha_inicio,cuentas_por_cobrar.fecha_final,
       cuentas_por_cobrar.descripcion,cuentas_por_cobrar.total,cuentas_por_cobrar.monto_inicial,comprobante_factura_final.clave_acceso,cuentas_por_cobrar.codigo_factura,
       comprobante_factura_final.id as 'codigo_factura',cuentas_por_cobrar.estado_financiero
        FROM cuentas_por_cobrar
        INNER JOIN clientes ON clientes.id = cuentas_por_cobrar.id_cliente
        INNER JOIN comprobante_factura_final ON  comprobante_factura_final.id =  cuentas_por_cobrar.codigo_factura
         WHERE cuentas_por_cobrar.iduser = '$iduser'
             AND cuentas_por_cobrar.estatus = '1' AND cuentas_por_cobrar.id = '$codigo_cuenta' ");
             $data_cuenta_cobrar = mysqli_fetch_array($query_detalle_cuentas_cobrar);

             $factura = $data_cuenta_cobrar['clave_acceso'];

             //de qui empezamos a sacar la informacion
             if ($ambito_area == 'prueba') {
               $ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$factura.'.xml';

             }else {
               $ruta_factura = 'facturacion/facturacionphp/comprobantes/no_firmados/'.$factura.'.xml';
             }
             $acceso_factura = simplexml_load_file($ruta_factura);
              $codDocModificado                = $acceso_factura->infoTributaria->codDoc;

                             //para crear el numero dl documento necesito de 4 partes
                              $estab                       = $acceso_factura->infoTributaria->estab;
                              $ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
                              $secuencial                  = $acceso_factura->infoTributaria->secuencial;
                              $numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';

              ?>
              <br>
              <div class="pcoded-content">
                  <div class="pcoded-inner-content">
                      <div class="main-body">
                          <div class="page-wrapper">
                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                                  <main role="main" class="container">
                                                      <div class="row">
                                                          <div class="col-12">
                                                            <style media="screen">
                                                              .conte_cod_cuenta_titu{
                                                                padding: 9px;
                                                                margin: 5px;
                                                                text-align: center;
                                                              }
                                                            </style>
                                                            <div class="conte_cod_cuenta_titu">
                                                                        <h5>Detalle de la cuenta por cobrar <?php echo $numDocModificado ?></h5>
                                                            </div>

                                                              <div class="table-responsive">
                                                                  <table class="table table-bordered">
                                                                      <thead>
                                                                          <tr>
                                                                              <th>Código</th>
                                                                              <th>Factura</th>
                                                                              <th>Valor a Pagar</th>
                                                                              <th>Monto Inicial</th>
                                                                              <th>Valor Pagado</th>
                                                                              <th>Valor Faltante</th>
                                                                              <th>PDF</th>
                                                                              <th>Cliente</th>
                                                                              <th>Email Cliente</th>
                                                                              <th>Fecha Registro</th>
                                                                              <th>Fecha Inicio</th>
                                                                              <th>Fecha Final</th>
                                                                              <th>Estado Financiero</th>
                                                                          </tr>
                                                                      </thead>
                                                                      <tbody>
                                                                          <tr>
                                                                              <td><?php echo $codigo_cuenta ?></td>
                                                                              <td> <a href="detalles_factura?detalles_factura=<?php echo $factura ?>&ininterno=<?php echo $data_cuenta_cobrar['codigo_factura'] ?>"><?php echo $numDocModificado ?></a> </td>
                                                                              <td>$<?php echo number_format($data_cuenta_cobrar['total'],2) ?> </td>
                                                                              <td>$<?php echo number_format($data_cuenta_cobrar['monto_inicial'],2) ?> </td>
                                                                              <td>$<?php echo number_format(($total_pagado+$data_cuenta_cobrar['monto_inicial']),2) ?> </td>
                                                                              <td>$<?php echo (($data_cuenta_cobrar['total'])-($data_cuenta_cobrar['monto_inicial']+$total_pagado)) ?> </td>
                                                                              <td class="" data-titulo="Pdf"> <a download href="facturacion/facturacionphp/comprobantes/pdf/<?php echo $data_cuenta_cobrar['clave_acceso'];?>.pdf"><img src="https://facturacion.guibis.com/home/img/reacciones/pdf.png" width="45px" alt=""></a>  </td>
                                                                              <td><?php echo $data_cuenta_cobrar['nombres_cliente'] ?> </td>
                                                                              <td><?php echo $data_cuenta_cobrar['email_cliente'] ?> </td>
                                                                              <td><?php echo mb_strtoupper($data_cuenta_cobrar['fecha']) ?> </td>
                                                                              <td><?php echo $data_cuenta_cobrar['fecha_inicio'] ?> </td>
                                                                              <td><?php echo $data_cuenta_cobrar['fecha_final'] ?> </td>
                                                                              <td><?php echo $data_cuenta_cobrar['estado_financiero'] ?> </td>
                                                                          </tr>
                                                                      </tbody>
                                                                  </table>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </main>




                                              <div class="card-header table-card-header">
                                                  <h5>Historial de Pagos de la Cuenta por Cobrar de la Factura <?php echo $numDocModificado ?></h5>

                                                               <button type="button" class="btn btn-primary" id="boton_agregar_cuentas_cobrar" name="button">Agregar Pago <i class="fas fa-plus"></i></button>
                                              </div>
                                              <div class="card-block">
                                                  <div class="dt-responsive table-responsive">
                                                    <table id="tabla_pagos_cuenta_cobrar" class="table table-striped table-bordered nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th>Acciones</th>
                                                                <th>Cantidad</th>
                                                                <th>Descripción</th>
                                                                <th>Fecha</th>
                                                                <th>Estado Financiero</th>
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



                <div class="modal fade" id="modal_agregar_pago_cuentas_cobrar" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="proveedorModalLabel">Agregar Pago a la Cuenta <?php echo $numDocModificado ?></h5>
                        <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                      </div>
                      <div class="modal-body">

                        <form action=""  id="add_pago_cuentas_cobrar" >
                            <div class="mb-3">
                              <label for="nombre_producto" class="form-label">Cantidad de Depósito</label>
                              <input type="text" maxlength="120" step="0.0001" name="cantidad_deposito" class="form-control" id="cantidad_deposito" placeholder="Cantidad del depósito">
                            </div>

                            <div class="mb-3">
                              <label for="descripcion" class="form-label">Agregue una Descripción</label>
                              <textarea class="form-control" maxlength="120"  name="descripcion" id="descripcion" rows="3"></textarea>
                            </div>

                            <div class="modal-footer">
                              <input type="hidden" name="action" value="agregar_depostito_cuentas_cobrar_facturacion">
                              <input type="hidden" name="codigo_cuenta_cobrar" value="<?php echo $codigo_cuenta ?>">
                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                              <button type="submit" class="btn btn-primary">Agregar Pago</button>
                            </div>
                            <div class="alerta_agregar_cuenta_cobrar"></div>
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
        <script type="text/javascript" src="jquery_administrativo/pagos_cuentas_cobrar.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script type="text/javascript">
        (function() {
        $(function() {
        $('#boton_agregar_cuentas_cobrar').on('click', function() {
          $('#modal_agregar_pago_cuentas_cobrar').modal();
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
</html>
