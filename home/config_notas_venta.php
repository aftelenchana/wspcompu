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
<html lang="en">
    <head>
        <title>Configurar Notas Venta</title>
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

     $query_secuencial = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = $iduser ORDER BY fecha DESC LIMIT 1");
      $result_secuencial = mysqli_fetch_array($query_secuencial);
      if ($result_secuencial) {
      $secuencial = $result_secuencial['codigo_factura'];
      $secuencial = $secuencial +1;
      // code...
      }else {
      $secuencial =1;
      }
     require 'scripts/loader.php';

     require 'scripts/iconos.php';




          $query_notas_venta = mysqli_query($conection, "SELECT * FROM  parametros_notas_venta   WHERE  parametros_notas_venta.iduser  = $iduser");
           $data_notas_venta = mysqli_fetch_array($query_notas_venta);

           if ($data_notas_venta) {
             $inicio_secuencial = $data_notas_venta['inicio_secuencial'];

             if (!empty($inicio_secuencial)) {
               $inicio_secuencial = $data_notas_venta['inicio_secuencial'];
               $inicio_secuencial = $inicio_secuencial +1;
             }else {
               $inicio_secuencial =1;
             }


             $final_secuencial = $data_notas_venta['final_secuencial'];


             if (!empty($final_secuencial)) {
               $final_secuencial = $data_notas_venta['final_secuencial'];
               $final_secuencial = $final_secuencial +1;
             }else {
               $final_secuencial =1;
             }
             $nombre_imprenta  = $data_notas_venta['nombre_imprenta'];
             $nombre_propietario = $data_notas_venta['nombre_propietario'];
             $ruc_imprenta = $data_notas_venta['ruc_imprenta'];
             $numero_autorizacion = $data_notas_venta['numero_autorizacion'];
             $fecha_emision = $data_notas_venta['fecha_emision'];
             $numero_venta_autorizada = $data_notas_venta['numero_venta_autorizada'];
             $fecha_limite_validez = $data_notas_venta['fecha_limite_validez'];
           }else {
             $inicio_secuencial = 'NO CONFIGURADO';
             $final_secuencial =  'NO CONFIGURADO';
             $nombre_imprenta  =  'NO CONFIGURADO';
             $nombre_propietario =  'NO CONFIGURADO';
             $ruc_imprenta =  'NO CONFIGURADO';
             $numero_autorizacion =  'NO CONFIGURADO';
             $fecha_emision =  'NO CONFIGURADO';
             $numero_venta_autorizada =  'NO CONFIGURADO';
             $fecha_limite_validez =  'NO CONFIGURADO';
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
                                                  <h5>Agrega los Parámetros para la Facturación</h5>
                                              </div>
                                              <style media="screen">
                                                .estilos_parametros{
                                                  padding: 10px;
                                                  margin: 10px;
                                                }
                                              </style>
                                              <div class="row estilos_parametros">
                                                <div class="col">
                                                  <form method="post" name="add_establecimiento" id="add_establecimiento" onsubmit="event.preventDefault(); sendData_add_establecimiento();">
                                                      <h3>Establecimiento</h3>
                                                      <?php if ($estableciminento != ''): ?>
                                                          <div id="existencia_establecimiento" class="">
                                                              <div class="alert alert-success">
                                                                  <div class="mb-3">
                                                                      <label for="establecimineto_ju" class="form-label">Establecimiento</label>
                                                                      <input type="text" class="form-control" value="00<?php echo $estableciminento ?>" readonly id="establecimineto_ju">
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      <?php endif; ?>
                                                      <div class="mb-3">
                                                          <label for="exampleFormControlSelect1" class="form-label">Establecimiento</label>
                                                          <select class="form-control" name="establecimiento" id="exampleFormControlSelect1">
                                                              <option value="1">1</option>
                                                              <option value="2">2</option>
                                                              <option value="3">3</option>
                                                              <option value="4">4</option>
                                                              <option value="5">5</option>
                                                              <option value="6">6</option>
                                                              <option value="7">7</option>
                                                              <option value="8">8</option>
                                                              <option value="9">9</option>
                                                              <option value="10">10</option>
                                                          </select>
                                                      </div>
                                                      <div class="modal-footer">
                                                          <button type="submit" class="btn btn-primary">Guardar Establecimiento</button>
                                                      </div>
                                                      <input type="hidden" name="action" value="agregar_establecimiento">
                                                      <div class="notificacion_general_establecimiento mt-4"></div>
                                                  </form>


                                                </div>
                                                <div class="col">
                                                  <form method="post" name="agregar_punto_acceso" id="agregar_punto_acceso" onsubmit="event.preventDefault(); sendData_punto_emision();">
                                                      <h3>Emision</h3>
                                                      <?php if ($punto_emision != ''): ?>
                                                          <div id="existencia_punto_emision" class="">
                                                              <div class="alert alert-success">
                                                                  <div class="mb-3">
                                                                      <label for="punto_emision" class="form-label">Punto de Emisión</label>
                                                                      <input type="text" class="form-control" value="00<?php echo $punto_emision ?>" readonly id="punto_emision">
                                                                  </div>
                                                              </div>
                                                          </div>
                                                      <?php endif; ?>
                                                      <div class="mb-3">
                                                          <label for="exampleFormControlSelect1" class="form-label">Agrega el punto de Emisión</label>
                                                          <select class="form-control" name="punto_emision" id="exampleFormControlSelect1">
                                                              <option value="1">1</option>
                                                              <option value="2">2</option>
                                                              <option value="3">3</option>
                                                              <option value="4">4</option>
                                                              <option value="5">5</option>
                                                              <option value="6">6</option>
                                                              <option value="7">7</option>
                                                              <option value="8">8</option>
                                                              <option value="9">9</option>
                                                              <option value="10">10</option>
                                                          </select>
                                                      </div>
                                                      <input type="hidden" name="action" value="agregar_punto_emision">
                                                      <div class="modal-footer">
                                                          <button type="submit" class="btn btn-primary">Guardar Punto de Emisión</button>
                                                      </div>
                                                      <div class="notificacion_general_f notificacion_punto_emision mt-4"></div>
                                                  </form>
                                                </div>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>


                              <div class="page-body">
                                <h3>Actualizar Datos para las Notas de Venta</h3>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <style media="screen">
                                            .estilos_parametros {
                                                padding: 10px;
                                                margin: 10px;
                                            }
                                        </style>
                                        <div class=" estilos_parametros">
                                            <form method="post" name="secuencia_inicial" id="data_notas_venta" onsubmit="event.preventDefault(); sendData_notas_venta();">
                                                <div class="form-group row mb-3">
                                                    <label for="nuevoSecuencialInput" class="col-sm-4 col-form-label text-right">Agrega el inicio del Secuencial</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" name="inicio_secuencial" required value="<?php echo $inicio_secuencial ?>" placeholder="Ingrese el nuevo Secuencial" class="form-control" id="nuevoSecuencialInput">
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-3">
                                                    <label for="nuevoSecuencialInput" class="col-sm-4 col-form-label text-right">Agrega el Final del Secuencial</label>
                                                    <div class="col-sm-8">
                                                        <input type="number" value="<?php echo $final_secuencial ?>"  name="final_secuencial" required placeholder="Ingrese el Final del Secuencial" class="form-control" id="nuevoSecuencialInput">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="nuevoSecuencialInput" class="col-sm-4 col-form-label text-right">Nombre de la Imprenta</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" value="<?php echo $nombre_imprenta ?>"  name="nombre_imprenta" required placeholder="Ingrese el nombre de la Empresa" class="form-control" id="nuevoSecuencialInput">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="nuevoSecuencialInput" class="col-sm-4 col-form-label text-right">Nombre del Propietario</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" value="<?php echo $nombre_propietario ?>"  name="nombre_propietario" required placeholder="Ingrese el nombre del propiertario" class="form-control" id="nombre_propiertario">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="nuevoSecuencialInput" class="col-sm-4 col-form-label text-right">Ruc de la Imprenta</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" value="<?php echo $ruc_imprenta ?>" name="ruc_imprenta" required placeholder="Ingrese el Ruc de la Empresa" class="form-control" id="ruc_imprenta">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="nuevoSecuencialInput"  class="col-sm-4 col-form-label text-right">Número de Autorización</label>
                                                    <div class="col-sm-8">
                                                        <input type="text" value="<?php echo $numero_autorizacion ?>"  name="numero_autorizacion" required placeholder="Ingrese el nombre de la Empresa" class="form-control" id="nuevoSecuencialInput">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label for="nuevoSecuencialInput" class="col-sm-4 col-form-label text-right">Fecha de Emisión</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="fecha_emision" required value="<?php echo $fecha_emision ?>"  class="form-control" id="nuevoSecuencialInput">
                                                    </div>
                                                </div>

                                                <div class="form-group row mb-3">
                                                    <label for="nuevoSecuencialInput" class="col-sm-4 col-form-label text-right">Fecha Límite de Validez</label>
                                                    <div class="col-sm-8">
                                                        <input type="date" name="fecha_limite_validez" required value="<?php echo $fecha_limite_validez ?>"  class="form-control" id="fecha_limite_validez">
                                                    </div>
                                                </div>

                                                <input type="hidden" name="action" value="agregar_datos_notas_venta">
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Actualizar Datos</button>
                                                </div>
                                                <div class="notificacion_general_notas_venta mt-4"></div>
                                            </form>
                                        </div>
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
                                                                                <form method="post" name="add_direccion" id="add_direccion" onsubmit="event.preventDefault(); sendData_direccion();">
                                                                                <span class="d-block mb-3 h5">Agrege su Dirección</span>
                                                                                <?php if ($direccion == ''): ?>
                                                                                    <div class="existencia_direxion mb-3">
                                                                                        <div class="alert alert-danger" role="alert">No has subido tu Dirección!</div>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                                <?php if ($direccion != ''): ?>
                                                                                    <div class="existencia_direxion mb-3">
                                                                                        <div class="alert alert-success" role="alert"><?php echo $direccion ?></div>
                                                                                    </div>
                                                                                <?php endif; ?>
                                                                                <div class="mb-3">
                                                                                    <label for="direccionTextarea" class="form-label">Ingresa la Dirección</label>
                                                                                    <textarea class="form-control" name="direccion_u" id="direccionTextarea" rows="3" required></textarea>
                                                                                </div>
                                                                                <input type="hidden" name="action" value="agregar_direccion">
                                                                                <div class="modal-footer">

                                                                                    <button type="submit" class="btn btn-primary">Agrega tu dirección</button>
                                                                                </div>
                                                                                <div class="notificacion_general_f notificacion_direccion mt-4"></div>
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
        <script src="java/cuenta_notas_venta.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>


    </body>
</html>
