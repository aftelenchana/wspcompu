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
        <title>Nota de Crédito</title>
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
        <link rel="stylesheet" type="text/css" href="files/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/data-table/css/buttons.dataTables.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
        <link rel="stylesheet" href="estiloshome/notas_credito.css?v=1">




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
                                                  <h5>Facturas Autorizadas</h5>
                                                  <div class="mb-3 elejir_banco_deposito" id="elejir_banco_deposito" >
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
                                              </div>

                                              <div class="card-block">

                                                <!-- form start -->

                                      <?php if (!empty($_GET)): ?>
                                        <div class="row informacion_nota_jgh">
                                            <div class="col formulario_nota_ dfdfdfdfdfdfdf">

                                                <form class="" method="post" name="generar_informacion_nota_credito" id="generar_informacion_nota_credito" onsubmit="event.preventDefault(); sendData_generar_informacion_nota_credito();">
                                                    <div class="form-group">
                                                        <label for="exampleFormControlInput1"><i class="fas fa-window-maximize"></i>Factura Número de Autorización.</label>
                                                        <input type="text" class="form-control" name="xml_nota_credito" value="<?php echo $_GET['factura'] ?>" id="exampleFormControlInput1" readonly placeholder="" />
                                                        <input type="hidden" name="estado_factura" value="digital" />
                                                        <small id="emailHelp" class="form-text text-muted">Primero Verifica la información de la factura.</small>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-square-caret-right"></i> Continuar</button>
                                                    <div class="alerta_primer_modal_hgtr"></div>
                                                </form>
                                            </div>
                                        </div>

                                      <?php endif; ?>

                                      <?php if (empty($_GET)): ?>
                                        <div class="row informacion_nota_jgh">
                                              <div class="col formulario_nota_ dfdfdfdfdfdfdf">
                                                  <form class="" method="post" name="generar_informacion_nota_credito" id="generar_informacion_nota_credito" onsubmit="event.preventDefault(); sendData_generar_informacion_nota_credito();">
                                                      <div class="form-group">
                                                          <label for="exampleFormControlFile1">Añade el Archivo <i class="bi bi-filetype-xml" style="font-size: 4rem; color: green;"></i> de la Factura</label>
                                                          <div class="d-flex justify-content-center align-items-center">
                                                              <span class="btn btn-success fileinput-button" id="fileButton">
                                                                  <i class="fa-solid fa-cloud-arrow-up"></i>
                                                                  <span>Subir Archivo XML</span>
                                                              </span>
                                                              <!-- El input de archivo está oculto -->
                                                              <input type="file" name="xml_nota_credito" required id="exampleFormControlFile1" style="display: none;" accept=".xml" />
                                                              <!-- Aquí se mostrará el nombre del archivo -->
                                                              <span id="fileName" class="ml-2"></span>
                                                          </div>
                                                          <input type="hidden" name="estado_factura" value="fisico" />
                                                      </div>
                                                      <button type="submit" class="btn btn-primary"><i class="fa-solid fa-square-caret-right"></i> Continuar</button>
                                                      <div class="alerta_primer_modal_hgtr"></div>
                                                  </form>
                                              </div>
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
        <script src="java/notas_creditos.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script src="area_facturacion/recordar_sucursal.js"></script>
        <script type="text/javascript">
        document.getElementById('fileButton').addEventListener('click', function() {
            var fileInput = document.getElementById('exampleFormControlFile1');
            fileInput.click();
        });
        document.getElementById('exampleFormControlFile1').addEventListener('change', function() {
            var fileNameSpan = document.getElementById('fileName');
            if (this.files && this.files.length > 0) {
                fileNameSpan.textContent = this.files[0].name;
            } else {
                fileNameSpan.textContent = '';
            }

        });

        </script>
        </script>

    </body>
</html>
