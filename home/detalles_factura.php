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
       $factura = $_GET['detalles_factura'];

       $query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM comprobante_factura_final WHERE comprobante_factura_final.clave_acceso ='$factura' ");
       $data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
       $ininterno = $data_existencia['id'];
       $url_file_upload = $data_existencia['url_file_upload'];






              $iduser= $_SESSION['id'];
              $query_config = mysqli_query($conection, "SELECT * FROM configuraciones");
               $result_config = mysqli_fetch_array($query_config);
               if (!empty($result_config['foto_representativa'])) {
                 $foto_representativa = $result_config['foto_representativa'];
               }else {
                 $foto_representativa ='subir.png';
               }

               $id_user= $_SESSION['id'];
               $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $id_user");
               $result = mysqli_fetch_array($query);
               $mi_leben = $result['mi_leben'];
               $nombres_user = $result['nombres'];

               //INFORMACION DE LA CONFIGURACION
               $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
               $result_configuracion = mysqli_fetch_array($query_configuracioin);
               $ambito_area          =  $result_configuracion['ambito'];

               //de qui empezamos a sacar la informacion
               if ($ambito_area == 'prueba') {
                 $ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$factura.'.xml';

               }else {
                 $ruta_factura = ''.$url_file_upload.'/home/facturacion/facturacionphp/comprobantes/no_firmados/'.$factura.'.xml';
               }
               $ruta_factura = ''.$url_file_upload.'/home/facturacion/facturacionphp/comprobantes/no_firmados/'.$factura.'.xml';
               $acceso_factura = simplexml_load_file($ruta_factura);
                $codDocModificado                = $acceso_factura->infoTributaria->codDoc;

                               //para crear el numero dl documento necesito de 4 partes
                                $estab                       = $acceso_factura->infoTributaria->estab;
                                $ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
                                $secuencial                  = $acceso_factura->infoTributaria->secuencial;
                                $numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';





                           //informacion del comprador
                             $identificacion_comprador             = $acceso_factura->infoFactura->identificacionComprador;
                             $tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;
                             $razon_social_comprador                = $acceso_factura->infoFactura->razonSocialComprador;
                             $obligadoContabilidad                = $acceso_factura->infoFactura->obligadoContabilidad;
                             $fechaEmision                = $acceso_factura->infoFactura->fechaEmision;
                             $totalSinImpuestos_general                = $acceso_factura->infoFactura->totalSinImpuestos;
                             $totalDescuento_general                = $acceso_factura->infoFactura->totalDescuento;
                             $dirEstablecimiento                = $acceso_factura->infoFactura->dirEstablecimiento;
                             $importeTotal                = $acceso_factura->infoFactura->importeTotal;


  ?>




<!DOCTYPE html>
<html lang="es">

    <head>
        <title>Factura: <?php echo $numDocModificado ?></title>

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
        <link rel="stylesheet" href="estilos/modal.css?v=2">

    </head>

    <body>

     <?php
     require 'scripts/loader.php';


                  require 'scripts/iconos.php';


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
                                                  <h5>Factura: <?php echo $numDocModificado ?>
                                              </div>
                                              <div class="card-block">
                                                <div class="container-fluid">
                                                <div class="card card-success">
                                                  <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
                                                      <div class="mb-2 flex-fill">
                                                          <button class="btn btn-dark btn-sm w-100" onclick="descargarArchivos()">Descargar
                                                              <i class="fas fa-download"></i>
                                                          </button>
                                                      </div>
                                                      <div class="mb-2 flex-fill">
                                                          <button type="button" class="btn btn-success btn-sm w-100 boton_reenviar_facturas" name="button">
                                                              <strong>Reenviar de Facturas <i class="fas fa-radiation"></i></strong>
                                                          </button>
                                                      </div>
                                                      <div class="mb-2 flex-fill">
                                                          <button type="button" class="btn btn-info btn-sm w-100 boton_agregar_cuentas_pagar" name="button">
                                                              <strong>Agregar Cuentas por Cobrar <i class="fas fa-wallet"></i></strong>
                                                          </button>
                                                      </div>
                                                      <div class="mb-2 flex-fill">
                                                          <button type="button" class="btn btn-warning btn-sm w-100" id="boton_anular_factura" name="button">
                                                              <strong>Anular Factura <i class="fas fa-radiation"></i></strong>
                                                          </button>
                                                      </div>

                                                      <div class="mb-2 flex-fill">
                                                          <button type="button" class="btn text-white  btn-sm w-100" id="error_sutorizacion" style="background-color: #263238;" name="button">
                                                              <strong>Errores de Autorización <i class="fas fa-bug"></i></strong>
                                                          </button>
                                                      </div>
                                                  </div>

                                                  <style media="screen">
                                                  @media (max-width: 768px) {
                                                        .flex-fill {
                                                            flex: 0 0 50%;
                                                            max-width: 50%;
                                                        }
                                                      }
                                                  </style>



                                                       <!-- Modal -->
                                                       <div class="modal fade" id="modal_anular_factura" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                         <div class="modal-dialog" role="document">
                                                           <div class="modal-content">
                                                             <div class="card-header con-marca-de-agua con-marca-de-agua-inferior text-white" style="background-color: #263238;">
                                                               <h5 class="modal-title" id="proveedorModalLabel">Anular Esta Factura</h5>
                                                             </div>

                                                             <div class="modal-body">
                                                               <form  class="" method="post" name="generar_nota_credito_final" id="generar_nota_credito_final" onsubmit="event.preventDefault(); sendData_generar_nota_credito_final();">
                                                                  <input type="hidden" name="action" value="agregar_transportista">
                                                                  <p>Anulación de Factura.</p>
                                                                  <div class="form-group">
                                                                    <label for="exampleInputEmail1">Ingrese el motivo de la anulación 4</label>
                                                                    <input type="text" class="form-control" name="razon_modficiacion" value="Error al enviar"   aria-describedby="emailHelp" placeholder="Ingrese el motivo 4">
                                                                  </div>

                                                                  <div class="mb-3 " >
                                                                      <label for="banco_compra" class="form-label">Elige la Sucursal</label>
                                                                      <select class="form-control" name="sucursal_facturacion" id="sucursal_facturacion">
                                                                        <?php
                                                                        $secuencial = str_pad($data_sucursal['secuencial'], 9, "0", STR_PAD_LEFT);
                                                                         $query_sucursal = mysqli_query($conection, "SELECT * FROM  sucursales  WHERE  sucursales.iduser ='$iduser'  AND sucursales.estatus = '1' ");
                                                                          while ($data_sucursal = mysqli_fetch_array($query_sucursal)) {
                                                                          $estableciminento = str_pad($data_sucursal['establecimiento'], 3, "0", STR_PAD_LEFT);
                                                                          $punto_emision = str_pad($data_sucursal['punto_emision'], 3, "0", STR_PAD_LEFT);
                                                                          echo '<option  value="'.$data_sucursal['id'].'">('.$data_sucursal['direccion_sucursal'].')- '.$estableciminento.'-'.$punto_emision.'</option>';
                                                                        }
                                                                         ?>
                                                                      </select>
                                                                  </div>

                                                                  <div class="mb-3">
                                                                    <label for="elejir_tarifa_iva" class="form-label">Tipo de Anulación</label>
                                                                    <select class="form-control" name="tipo_anulacion" id="tipo_anulacion">
                                                                      <option value="con_sri">Se Realiza mediante una nota de Crédito hacia el SRI</option>
                                                                      <option value="sin_sri">Internamente sin acción del SRI</option>
                                                                    </select>
                                                                  </div>

                                                                  <div class="modal-footer">
                                                                    <input type="hidden" name="action" value="anular_factura">
                                                                    <input type="hidden" name="nomnto_modificacion" value="<?php echo $importeTotal ?>">
                                                                        <input type="hidden" name="clave_acceso_factura" value="<?php echo $factura ?>">
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                                                    <button type="submit" class="btn btn-primary"> <i class="fas fa-ban"></i> Anular Esta Factura</button>
                                                                  </div>
                                                                  <div class="notificacion_envio_nota_credito_rtd">

                                                                  </div>
                                                                </form>
                                                           </div>
                                                         </div>
                                                       </div>
                                                     </div>


                                                     <!-- Modal -->
                                                     <div class="modal fade" id="modal_error_autorizacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                                                       <div class="modal-dialog" role="document">
                                                         <div class="modal-content">
                                                           <div class="card-header con-marca-de-agua con-marca-de-agua-inferior text-white" style="background-color: #263238;">
                                                             <h5 class="modal-title" id="proveedorModalLabel">Errores de Autorización de la Factura</h5>
                                                           </div>

                                                           <div class="modal-body">
                                                             <form  class="" method="post" name="correccion_error_autorizacion" id="correccion_error_autorizacion" onsubmit="event.preventDefault(); sendData_corregir_error_autorizacion();">
                                                                <input type="hidden" name="action" value="agregar_transportista">
                                                                <p>Te presentamos diferentes Esenarios que se presentan y te tenemos la solución.</p>
                                                                <div class="mb-3">
                                                                  <label for="elejir_tarifa_iva" class="form-label">Errores de Autorización</label>
                                                                  <select class="form-control" name="tipo_error_autorizacion" id="tipo_error_autorizacion">
                                                                    <option value="no_autorizado_anula_actural_se_genera_mismo_secuencial">No se Autorizo se genera una factura con el mismo secuencial y reemplaza a esta Factura</option>
                                                                  </select>
                                                                </div>

                                                                <div class="modal-footer">
                                                                  <input type="hidden" name="action" value="anular_factura">
                                                                      <input type="hidden" name="clave_acceso_factura" value="<?php echo $factura ?>">
                                                                  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                                                  <button type="submit" class="btn btn-primary">Corregir Error</button>
                                                                </div>
                                                                <div class="notificacion_correccion_errores">

                                                                </div>
                                                              </form>
                                                         </div>
                                                       </div>
                                                     </div>
                                                   </div>




                                                     <embed src="<?php echo $url_file_upload ?>/home/facturacion/facturacionphp/comprobantes/pdf/<?php echo $factura ?>.pdf" type="application/pdf" width="100%" height="600px">

                                                <div class="col formulario_nota_ informacion_factura">


                                              <div class="row totulo">
                                                      <div class="col">
                                                        <h5>Información de la Factura</h5>
                                                        <?php

                                                         ?>
                                                      </div></div>
                                                      <div class="row">
                                                    <!-- left column -->
                                                    <div class="col-md-6">
                                                  <div class="table-responsive">
                                                      <table class="table table-bordered">
                                                          <tbody>
                                                                            <tr>
                                                                                <td>Fecha Emisión</td>
                                                                                <td><?php echo $fechaEmision ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Establecimiento</td>
                                                                                <td><?php echo $dirEstablecimiento ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Tipo de identificación Coprador</td>
                                                                                <td><?php echo $tipo_identificacion_comprador ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Identificación del Comprador</td>
                                                                                <td><?php echo $identificacion_comprador ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Razón social del comprador</td>
                                                                                <td><?php echo $razon_social_comprador ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                              <td>Establecimiento</td>
                                                                              <td><?php echo $dirEstablecimiento ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Total sin Impuestos</td>
                                                                                <td>$<?php echo ($totalSinImpuestos_general) ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Descuentos</td>
                                                                                <td>$<?php echo $totalDescuento_general ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Importe Total</td>
                                                                                <td>$<?php echo $importeTotal ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>



                                                        <?php
                                                         $conte_variable_detalles= $acceso_factura->detalles->detalle;
                                                        $uig = 0;
                                                        $base_if = 1;
                                                        foreach($conte_variable_detalles as $Item){
                                                             //var_dump($acceso_factura->detalles->detalle[$uig]);
                                                            $conte_variable_detalles= $acceso_factura->detalles->detalle[$uig]->descripcion;
                                                            $codigoPrincipal= $acceso_factura->detalles->detalle[$uig]->codigoPrincipal;
                                                            $cantidad= $acceso_factura->detalles->detalle[$uig]->cantidad;



                                                            $impuestos= $acceso_factura->detalles->detalle[$uig]->impuestos->impuesto;
                                                           //CODIGO PARA DETALLES
                                                           $codigo= $acceso_factura->detalles->detalle[$uig]->impuestos->impuesto->codigo;
                                                           $codigoPorcentaje= $acceso_factura->detalles->detalle[$uig]->impuestos->impuesto->codigoPorcentaje;
                                                           $tarifa= $acceso_factura->detalles->detalle[$uig]->impuestos->impuesto->tarifa;
                                                           $baseImponible= $acceso_factura->detalles->detalle[$uig]->impuestos->impuesto->baseImponible;
                                                           $valor= $acceso_factura->detalles->detalle[$uig]->impuestos->impuesto->valor;
                                                            $uig =$uig +1;
                                                            $base_if =$base_if+1;
                                                         ?>
                                              <div class="col-md-6">
                                                              <?php if ($codigoPrincipal != '' || $codigoPrincipal != '0'): ?>
                                                                <a href="ver_producto.php?producto=<?php echo $codigoPrincipal ?>"><h4>Código: <?php echo $codigoPrincipal ?></h4></a>
                                                              <?php endif; ?>
                                                              <?php if ($codigoPrincipal == '' || $codigoPrincipal == '0'): ?>
                                                                <h4><?php echo $codigoPrincipal ?></h4>
                                                              <?php endif; ?>
                                                              <div class="table-responsive">
                                                      <table class="table table-bordered">
                                                          <tbody>
                                                                            <tr>
                                                                                <td>Cántidad </td>
                                                                                <td><?php echo $cantidad ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Detalle:</td>
                                                                                <td><?php echo $conte_variable_detalles ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Código:</td>
                                                                                <td><?php echo $codigo ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Código Porcentaje:</td>
                                                                                <td><?php echo $codigoPorcentaje ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Tarifa:</td>
                                                                                <td><?php echo $tarifa ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Base Imponible:</td>
                                                                                <td>$<?php echo $baseImponible ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Impuesto:</td>
                                                                                <td>$<?php echo $valor ?></td>
                                                                            </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>


                                                         <?php
                                                         }
                                                     ?>
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
        </div>
        <div class="modal fade modal_reenvio_facturas" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Reenvio de Factura <span style="font-size: 13px;" class="identificador_factura"><?php echo $factura ?></span> </h5>
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
                 <input type="hidden" name="factura" id="factura_codigo" value="<?php echo $ininterno ?>">
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



        <div class="modal fade agregar_cuentas_por_pagar" id="" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Agregar Cuentas por Cobrar de <span style="font-size: 13px;" class="identificador_factura"><?php echo $factura ?></span> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form  class="" method="post" name="agregar_cuentas_pagar" id="agregar_cuentas_pagar" onsubmit="event.preventDefault(); sendData_agregar_cuentas_pagar();">
                  <div class="mb-3">
                    <label for="precio_sin_impuestos" class="form-label">Indique el Valor inicial si es el Caso</label>
                    <input  type="number" step="0.00001" class="form-control" name="valor_inicial" id="valor_inicial" placeholder="Ingrese el valor">
                    <small class="form-text text-muted">Es el valor inicial con el que el cliente inicia el credito</small>
                  </div>

                  <div class="mb-3">
                    <label for="elejir_tarifa_iva" class="form-label">Agregar  plan de cuotas</label>
                    <select oninput="insercion_cuetas()" class="form-control" name="agregar_plan_cuotas" id="agregar_plan_cuotas">
                      <option value="NO">NO</option>
                      <option value="SI">SI</option>
                    </select>
                  </div>
                  <div class="resultado_plan_cuentas">

                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="mb-3">
                        <label for="precio_sin_impuestos" class="form-label">Fecha de Inicio</label>
                        <input  type="date" required  class="form-control" name="fecha_inicio" id="fecha_inicio">
                      </div>
                    </div>
                    <div class="col">
                      <div class="mb-3">
                        <label for="precio_sin_impuestos" class="form-label">Fecha Final</label>
                        <input  type="date" required  class="form-control" name="fecha_final" id="fecha_inicio">
                      </div>
                    </div>

                  </div>

                  <div class="mb-3">
                    <label for="descripcion" class="form-label">Agregue una descripción</label>
                    <textarea class="form-control" maxlength="120"  name="descripcion" id="descripcion" rows="3"></textarea>
                  </div>

               <div class="modal-footer">
                 <input type="hidden" name="action" value="agregar_cuentas_cobrar">
                 <input type="hidden" name="factura_codigo" id="factura_codigo" value="<?php echo $ininterno ?>">
                 <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                 <button type="submit" class="btn btn-primary">Agregar a Cuentas por Pagar</button>
               </div>
               <div class="notificacion_cuentas_cobrar">

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
        <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script src="jquery_administrativo/cuentas_cobrar.js"></script>
        <script src="jquery_empresa/detalles_factura.js" charset="utf-8"></script>
        <script type="text/javascript" src="jquery_facturacion/reenvio.js"></script>
        <script src="java/notas_creditos.js"></script>
        <script src="java/detalles_factura.js"></script>

        <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
        <script>
          var url = 'facturacion/facturacionphp/comprobantes/pdf/<?php echo $factura ?>.pdf';

          PDFJS.getDocument(url).promise.then(function (pdf) {
            pdf.getPage(1).then(function (page) {
              var scale = 1.5;
              var viewport = page.getViewport({ scale: scale });

              var canvas = document.createElement('canvas');
              var context = canvas.getContext('2d');
              canvas.height = viewport.height;
              canvas.width = viewport.width;

              var renderContext = {
                canvasContext: context,
                viewport: viewport,
              };

              document.getElementById('pdfContainer').appendChild(canvas);

              page.render(renderContext);
            });
          });
        </script>


        <script type="text/javascript">
          (function(){
            $(function(){
              $('#boton_anular_factura').on('click',function(){
                $('#modal_anular_factura').modal();
              });


            });

          }());

          (function(){
            $(function(){
              $('#error_sutorizacion').on('click',function(){
                $('#modal_error_autorizacion').modal();
              });


            });

          }());
        </script>

        <script>
          function descargarArchivos() {
            var enlace1 = document.createElement('a');
            enlace1.href = '<?php echo $url_file_upload ?>/home/facturacion/facturacionphp/comprobantes/pdf/<?php echo $factura ?>.pdf';
            enlace1.download = '<?php echo $factura ?>.pdf';
            enlace1.click();

            var enlace2 = document.createElement('a');
            enlace2.href = '<?php echo $url_file_upload ?>/home/facturacion/facturacionphp/comprobantes/autorizados/<?php echo $factura ?>.xml';
            enlace2.download = '<?php echo $factura ?>.xml';
            enlace2.click();
          }
        </script>
        <script type="text/javascript">
          (function(){
            $(function(){
              $('.boton_reenviar_facturas').on('click',function(){
                var clave_acceso = $(this).attr('clave_acceso');
                  $(".identificador_factura").html(clave_acceso);
                $('.modal_reenvio_facturas').modal();
              });


            });

          }());
        </script>
        <script type="text/javascript">
          (function(){
            $(function(){
              $('.boton_agregar_cuentas_pagar').on('click',function(){
                var clave_acceso = $(this).attr('clave_acceso');
                  $(".identificador_factura").html(clave_acceso);
                $('.agregar_cuentas_por_pagar').modal();
              });


            });

          }());
        </script>


    </body>
</html>
