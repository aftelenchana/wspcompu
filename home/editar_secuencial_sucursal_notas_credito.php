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

       $sucursal_facturacion = $_GET['codigo_sucursal'];


  ?>




<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Secuencial Notas de Crédito</title>
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


     		  $query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$sucursal_facturacion'");
     			$data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);

     			$direccion_sucursal        = $data_sucursal['direccion_sucursal'];

     			$estableciminento_f  = str_pad($data_sucursal['establecimiento'], 3, "0", STR_PAD_LEFT);
     			$punto_emision_f  = str_pad($data_sucursal['punto_emision'], 3, "0", STR_PAD_LEFT);

     			$fecha_actual = date("d-m-Y");
     			$fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));


     			//codigo para sacar la secuencia del usuario

     			$establecimiento_sinceros        = $data_sucursal['establecimiento'];
     			$punto_emision_sinceros        = $data_sucursal['punto_emision'];

          $query_secuencia = mysqli_query($conection, "SELECT * FROM  comprobante_nota_credito  WHERE  comprobante_nota_credito.id_emisor  = '$iduser' AND comprobante_nota_credito.punto_emision ='$punto_emision_sinceros'
      			AND comprobante_nota_credito.establecimiento ='$establecimiento_sinceros' ORDER BY id DESC");
      		 $result_secuencia = mysqli_fetch_array($query_secuencia);
      		 if ($result_secuencia) {
      			 $secuencial = $result_secuencia['secuencia'];
      			 $secuencial = $secuencial +1;
      			 // code...
      		 }else {
      			 $secuencial =1;
      		 }
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
                                                  <h5>Editar la Secuencia para <?php echo $direccion_sucursal ?> con Punto de Emisión <?php echo $punto_emision_f ?>
                                                  y Establecimiento <?php echo $estableciminento_f ?> </h5>
                                              </div>
                                              <style media="screen">
                                                .estilos_parametros{
                                                  padding: 10px;
                                                  margin: 10px;
                                                }
                                              </style>



                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <div class="page-body">
                                  <div class="row">
                                      <div class="col-sm-12">
                                          <div class="card">
                                              <style media="screen">
                                                .estilos_parametros{
                                                  padding: 10px;
                                                  margin: 10px;
                                                }
                                              </style>
                                              <div class="row estilos_parametros">
                                                <div class="col">
                                                  <form method="post" name="reset_secuencial" id="reset_secuencial" onsubmit="event.preventDefault(); sendData_reset_secuencial();">
                                                      <div class="exitencia_secuencial mb-3">
                                                          <div class="alert alert-warning" role="alert">SECUENCIAL ACTUAL (<?php echo $secuencial ?>)</div>
                                                      </div>
                                                      <div class="mb-3">
                                                          <label for="nuevoSecuencialInput" class="form-label">Agrega el nuevo Secuencial para Notas de Crédito</label>
                                                          <input type="number" name="nuevo_secuencial" required placeholder="Ingrese el nuevo Secuencial" class="form-control" id="nuevoSecuencialInput">
                                                      </div>
                                                      <input type="hidden" name="action" value="agregar_secuencial_notas_credito">
                                                      <div class="modal-footer">
                                                        <input type="hidden" name="codigo_sucursal" value="<?php echo $sucursal_facturacion ?>">
                                                        <button type="submit" class="btn btn-primary">Edita tu Secuencial para notas de Crédito</button>
                                                      </div>
                                                      <div class="notificacion_general_reset_secuencial mt-4"></div>
                                                  </form>


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
        <script src="jquery_empresa/proveedor.js"></script>
        <script type="text/javascript" src="jquery_empresa/clientes.js"></script>
        <script src="java/cuenta.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>


    </body>

</html>
