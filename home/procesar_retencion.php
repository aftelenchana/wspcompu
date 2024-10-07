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
       $codigo = $_GET['codigo'];

       $query_comprobacion_existencia = mysqli_query($conection,"SELECT * FROM compras_facturacion WHERE compras_facturacion.id ='$codigo' ");
       $data_existencia = mysqli_fetch_array($query_comprobacion_existencia);
       $xml = $data_existencia['xml'];
       $url = $data_existencia['url'];




               //INFORMACION DE LA CONFIGURACION
               $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
               $result_configuracion = mysqli_fetch_array($query_configuracioin);
               $ambito_area          =  $result_configuracion['ambito'];

               //de qui empezamos a sacar la informacion
               if ($ambito_area == 'prueba') {
                 $ruta_factura = 'C:\\xampp\\htdocs\\home\\archivos\\compras\\'.$xml;

               }else {
                 $ruta_factura = ''.$url.'/home/archivos/compras/'.$xml;
               }
               $acceso_factura = simplexml_load_file($ruta_factura);
                $codDocModificado                = $acceso_factura->infoTributaria->codDoc;

                               //para crear el numero dl documento necesito de 4 partes
                                $estab                       = $acceso_factura->infoTributaria->estab;
                                $ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
                                $secuencial                  = $acceso_factura->infoTributaria->secuencial;
                                $numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';
                                $claveAcceso                  = $acceso_factura->infoTributaria->claveAcceso;





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
        <title>Procesar Retención de la factura: <?php echo $numDocModificado ?></title>

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
        <link rel="stylesheet" type="text/css" href="estilos/facturacion.css" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.0/css/select2.min.css" rel="stylesheet" />

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

                                                    <a download href="archivos/compras_autorizadas/<?php echo $xml ?>"> <img width="50px;" src="https://guibis.com/home/img/reacciones/xml.png" alt=""> </a>
                                              </div>
                                              <div class="card-block">
                                                <div class="container-fluid">
                                                <div class="card card-success">
                                                <div class="card-block">
                                                    <div class="card product-detail-page">
                                                      <div class="">
                                                        <div class="card-block">
                                                          <form method="post" name="procesar_retencion" id="procesar_retencion" onsubmit="event.preventDefault(); sendData_procesar_retencion();">
                                                            <div class="row">
                                                                <div class="col" style="width: 50%;">
                                                                  <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Conceptos de Retención</label>
                                                                    <select class="select-custom proceso_retencion" name="proceso_retencion" id="proceso_retencion" required>
                                                                    </select>
                                                                  </div>
                                                                </div>
                                                                <div class="col" style="width: 50%;">
                                                                  <div class="form-group">
                                                                    <label for="exampleFormControlSelect1">Porcentaje Retención</label>
                                                                    <select class="select-custom" name="porcentajes_retencion" id="porcentajes_retencion" required>
                                                                    </select>
                                                                  </div>
                                                                </div>
                                                              </div>


                                                              <div class="row">
                                                                  <div class="col" style="width: 50%;">
                                                                    <div class="form-group">
                                                                      <label for="exampleFormControlSelect1">Tabla 4 ATS Código Sutento</label>
                                                                      <select class="select-custom proceso_retencion" name="tabla_4_ats" id="tabla_4_ats" required>
                                                                      </select>
                                                                    </div>
                                                                  </div>
                                                                  <div class="col" style="width: 50%;">
                                                                    <div class="form-group">
                                                                      <label for="exampleFormControlSelect1">Tabla 5 ATSCódigo del Documento del Sustento</label>
                                                                      <select class="select-custom" name="tabla_5_ats" id="tabla_5_ats" required>
                                                                      </select>
                                                                    </div>
                                                                  </div>
                                                                </div>


                                                                <div class="row">
                                                                    <div class="col" style="width: 50%;">
                                                                      <div class="form-group">
                                                                        <label for="exampleFormControlSelect1">Impuesto a Retener</label>
                                                                        <select class="select-custom" name="impuesto_retener"  required>
                                                                          <option value="2">IVA</option>
                                                                          <option value="1">RENTA</option>
                                                                          <option value="6">ISD</option>
                                                                        </select>
                                                                      </div>
                                                                    </div>
                                                                  </div>



                                                        <input type="hidden" name="action" value="procesar_retencion">
                                                        <input type="hidden" name="clave_acceso_factura" value="<?php echo $claveAcceso ?>">
                                                        <input type="hidden" name="codigo_compra" value="<?php echo $codigo ?>">
                                                        <button type="submit" class="btn btn-primary">Procesa Retención</button>
                                                        <div class="notificacion_procesar_retencion"></div>
                                                    </form>
                                                        </div>
                                                      </div>
                                                    </div>
                                                </div>


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
        <script src="documentos/retencion.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.0/js/select2.min.js"></script>




    </body>
</html>
