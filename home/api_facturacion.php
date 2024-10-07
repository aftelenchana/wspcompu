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
        <title>Api de Facturación</title>

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
        <link rel="stylesheet" type="text/css" href="files/assets/pages/prism/prism.css" />

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
                                                  <h5>Api de Facturación de Guibis.com</h5>
                                              </div>
                                              <?php
                                               $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;
                                               ?>
                                               <style media="screen">
                                                 .contenedor_parrafos_principales{
                                                   text-align: justify;
                                                   padding: 10px;
                                                   margin: 10px;
                                                 }
                                               </style>


                                               <div class="contenedor_parrafos_principales">
                                                 <p>Hola <?php echo $nombres ?> nos encanta saber que eres parte de nuestra Familia de Desarrollo y para esto te presentamos la api de Facturación de <a target="_blank" href="https://guibis.com">guibis.com</a>,
                                                 para esto te presentamos algunos parámetros importantes que debes tener en cuenta a la hora de enlazarte con tu sistema con url: <?php echo $url2 ?>  </p>
                                               </div>

                                               <div class="card">

                                                   <div class="card-block">
                                                       <p>Te presento el JSON que debes de formar para poder utilizar tu API REST el cual se conecta a  <strong><?php echo $url2 ?>/home/facturacion/facturacionphp/controladores/ctr_venta_api</strong> .</p>
                                                       <h6 class="m-t-20 f-w-600">Usage:</h6>
                                                       <pre>
                                                   <code class="language-markup">
                                                     {
                                                        "key":"<?php echo $id_desarrolador ?>",
                                                        "code_sucursal":"3",
                                                        "numero_cedula_receptor":"<?php echo $numero_identidad ?>",
                                                        "nombres_receptor":"<?php echo $nombres ?> <?php echo $apellidos ?>",
                                                        "tipo_identificacion":"05",
                                                        "direccion_receptor":"<?php echo $direccion ?>",
                                                        "correo":"<?php echo $email_user ?>",
                                                        "celular_receptor":"<?php echo $celular_user ?>",
                                                        "regimen":"RIMPE",
                                                        "contabilidad":"SI",
                                                        "efectivo":"100",
                                                        "vuelto":"50",
                                                        "productos":[
                                                           {
                                                               "cantidad_producto":"1",
                                                               "descripcion":"prieba Api ",
                                                               "codigo_producto":"8865",
                                                               "precio":"1",
                                                               "nombre":"prueba Api",
                                                               "porcentaje_descuento":"0",
                                                               "tipo_ambiente":"2",
                                                               "codigos_impuestos":"2",
                                                               "nota_extra1":"ejemplo de nota_extra1",
                                                               "nota_extra2":"ejemplo de nota_extra2"

                                                           }
                                                        ],
                                                        "formas_pago":[
                                                           {
                                                               "codigo_forma_pago":"15",
                                                               "cantidad_metodo_pago":"1.12"
                                                           }

                                                        ]

                                                        }
                                                   </code>
                                               </pre>
                                                   </div>
                                               </div>
                                               <div class="contenedor_parrafos_principales">
                                                 <p>A continuación te presento algunas tablas que se ocupa para los códigos que se ocupa para poder formar el JSON</p>


                                                 <div class="row">
                                                   <div class="col">
                                                     <dt>Campo formas_pago (Formas de Pago)</dt>
                                                     <dd>El campo de formas_pago de iva  infiere a siguiente tabla </dd>
                                                     <div class="">
                                                       <div class="row">
                                                         <div class="col">
                                                           <table class="table table-responsive">
                                                             <thead>
                                                               <tr>
                                                                 <th scope="col">Formas de Pago </th>
                                                                 <th scope="col">Código</th>
                                                               </tr>
                                                             </thead>
                                                             <tbody>
                                                               <tr>
                                                                 <td>SIN UTILIZACION DEL SISTEMA FINANCIERO</td>
                                                                 <td>01</td>
                                                               </tr>
                                                               <tr>
                                                                 <td>COMPENSACIÓN DE DEUDAS</td>
                                                                 <td>15</td>
                                                               </tr>
                                                               <tr>
                                                                 <td>TARJETA DE DÉBITO </td>
                                                                 <td>16</td>
                                                               </tr>
                                                               <tr>
                                                                 <td>DINERO ELECTRÓNICO</td>
                                                                 <td>17</td>
                                                               </tr>
                                                               <tr>
                                                                 <td>TARJETA PREPAGO </td>
                                                                 <td>18</td>
                                                               </tr>
                                                               <tr>
                                                                 <td>TARJETA DE CRÉDITO</td>
                                                                 <td>19</td>
                                                               </tr>
                                                               <tr>
                                                                 <td>OTROS CON UTILIZACION DEL SISTEMA FINANCIERO</td>
                                                                 <td>20</td>
                                                               </tr>
                                                               <tr>
                                                                 <td>ENDOSO DE TÍTULOS</td>
                                                                 <td>21</td>
                                                               </tr>
                                                             </tbody>
                                                           </table>
                                                         </div>
                                                       </div>
                                                     </div>

                                                   </div>
                                                   <div class="col">
                                                     <div class="">
                                                      <dt>Campo tipo_identificacion (Tipo de Identificación)</dt>
                                                      <dd>El campo de Identificación de iva  infiere a siguiente tabla </dd>
                                                      <div class="">
                                                        <div class="row">
                                                          <div class="col">
                                                            <table class="table table-responsive">
                                                              <thead>
                                                                <tr>
                                                                  <th scope="col">Nombre </th>
                                                                  <th scope="col">Código</th>
                                                                </tr>
                                                              </thead>
                                                              <tbody>
                                                                <tr>
                                                                  <td>RUC</td>
                                                                  <td>04</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>CEDULA</td>
                                                                  <td>05</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>PASAPORTE</td>
                                                                  <td>06</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>VENTA A CONSUMIDOR FINAL</td>
                                                                  <td>07</td>
                                                                </tr>
                                                                <tr>
                                                                  <td>IDENTIFICACION DELEXTERIOR</td>
                                                                  <td>08</td>
                                                                </tr>
                                                              </tbody>
                                                            </table>
                                                          </div>
                                                        </div>

                                                      </div>
                                                    </div>


                                                   </div>

                                                    </div>


                                                    <div class="row">
                                                      <div class="col">
                                                        <div class="">
                                                              <dt>Campo codigos_impuestos (Código Tarifa de los impuestos)</dt>
                                                              <dd>El campo de codigos_impuestos de iva  infiere a siguiente tabla </dd>
                                                              <div class="">
                                                                <div class="row">
                                                                  <div class="col">
                                                                    <table class="table table-responsive">
                                                                      <thead>
                                                                        <tr>
                                                                          <th scope="col">Impuesto</th>
                                                                          <th scope="col">Código</th>
                                                                        </tr>
                                                                      </thead>
                                                                      <tbody>
                                                                        <tr>
                                                                          <td>IVA</td>
                                                                          <td>2</td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td>ICE</td>
                                                                          <td>3</td>
                                                                        </tr>
                                                                        <tr>
                                                                          <td>IRBPNR</td>
                                                                          <td>5</td>
                                                                        </tr>
                                                                      </tbody>
                                                                    </table>
                                                                  </div>
                                                                </div>

                                                              </div>
                                                            </div>

                                                          </div>
                                                          <div class="col">
                                                            <div class="">
                                                                <dt>Campo iva (Porcentaje de Iva) </dt>
                                                                <dd>El campo de código de iva  infiere a siguiente tabla </dd>
                                                                <div class="">
                                                                  <div class="row">
                                                                    <div class="col">
                                                                      <table class="table table-responsive">
                                                                        <thead>
                                                                          <tr>
                                                                            <th scope="col">Porcentaje Iva </th>
                                                                            <th scope="col">Código</th>
                                                                          </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                          <tr>
                                                                            <td>0%</td>
                                                                            <td>0</td>
                                                                          </tr>
                                                                          <tr>
                                                                            <td>12%</td>
                                                                            <td>2</td>
                                                                          </tr>
                                                                          <tr>
                                                                            <td>No Objeto de Impuestos</td>
                                                                            <td>6</td>
                                                                          </tr>
                                                                          <tr>
                                                                            <td>Excento de Iva</td>
                                                                            <td>7</td>
                                                                          </tr>
                                                                        </tbody>
                                                                      </table>
                                                                    </div>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                          </div>
                                                        </div>

                                                      </div>

                                                      <div class="card">

                                                          <div class="card-block">
                                                              <p>Si estas ocupando la API con PHP te puede servir el siguiente código con  <strong>CURL.</p>
                                                              <h6 class="m-t-20 f-w-600">Usage:</h6>
                                                              <pre>
                                                          <code class="language-markup">

                                                            $url = '<?php echo $url2 ?>/home/facturacion/facturacionphp/controladores/ctr_venta_api';
                                                             $ch = curl_init($url);
                                                               $productos =array(
                                                               "cantidad_producto":"1",
                                                               "descripcion":"prieba Api ",
                                                               "codigo_producto":"8865",
                                                               "precio":"1",
                                                               "nombre":"prueba Api",
                                                               "porcentaje_descuento":"0",
                                                               "tipo_ambiente":"2",
                                                               "codigos_impuestos":"2",
                                                               "nota_extra1":"ejemplo de nota_extra1",
                                                               "nota_extra2":"ejemplo de nota_extra2"
                                                               );
                                                               $formas_pago =array(
                                                               "codigo_forma_pago":"15",
                                                               "cantidad_metodo_pago":"1.12"
                                                               );
                                                               "key":"<?php echo $id_desarrolador ?>",
                                                               "code_sucursal":"3",
                                                               "numero_cedula_receptor":"<?php echo $numero_identidad ?>",
                                                               "nombres_receptor":"<?php echo $nombres ?> <?php echo $apellidos ?>",
                                                               "tipo_identificacion":"05",
                                                               "direccion_receptor":"<?php echo $direccion ?>",
                                                               "correo":"<?php echo $email_user ?>",
                                                               "celular_receptor":"<?php echo $celular_user ?>",
                                                               "regimen":"RIMPE",
                                                               "contabilidad":"SI",
                                                               "efectivo":"100",
                                                               "vuelto":"50",
                                                               'productos'=>[$productos],
                                                               'formas_pago'=>[$formas_pago]
                                                               ));
                                                             curl_setopt($ch, CURLOPT_POSTFIELDS, $datos_guibis);
                                                             curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
                                                             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                                             $result = curl_exec($ch);
                                                             var_dump($result);
                                                             curl_close($ch);

                                                          </code>
                                                      </pre>
                                                          </div>
                                                      </div>

                                                    </div>
                                               </div>
                                          </div>
                                          <div class="row">
                                            <div class="col" style="text-align: center;">
                                              <iframe  width="90%" height="315" src="https://www.youtube.com/embed/yrye6rQalrY?si=X8aa3p2ZNUW-fkRA" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>

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
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script type="text/javascript" src="files/assets/pages/prism/custom-prism.js"></script>






    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
