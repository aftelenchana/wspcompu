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
        <title>Configurar Facturación</title>
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
                                                  <h5>Agrega los Parámetros para la Facturación</h5>
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
                                                  <form method="post" name="add_contabilidad" id="add_contabilidad" onsubmit="event.preventDefault(); sendData_add_contabilidad();">
                                                    <h3>Lleva Contabilidad</h3>
                                                    <?php if ($contabilidad != ''): ?>
                                                        <div class="mb-3">
                                                            <label for="contabilidad_li" class="form-label">Lleva Contabilidad</label>
                                                            <input type="text" class="form-control" value="<?php echo $contabilidad ?>" readonly id="contabilidad_li" placeholder="Contabilidad">
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="mb-3">
                                                        <label for="exampleFormControlSelect1" class="form-label">Agrega el punto de Emisión</label>
                                                        <select class="form-control" name="contabilidad" id="exampleFormControlSelect1">
                                                            <option value="SI">SI</option>
                                                            <option value="NO">NO</option>
                                                        </select>
                                                    </div>
                                                    <input type="hidden" name="action" value="agregar_contabilidad">
                                                    <div class="modal-footer">

                                                        <button type="submit" class="btn btn-primary">Guardar Contabilidad</button>
                                                    </div>
                                                    <div class="notificacion_general_f notificacion_contabilidad mt-4"></div>
                                                </form>

                                                </div>
                                                <div class="col">
                                                  <form method="post" name="add_regimen" id="add_regimen" onsubmit="event.preventDefault(); sendData_add_regimen();">
                                                      <h3>Regimen</h3>
                                                      <?php if ($regimen != ''): ?>
                                                          <div class="mb-3">
                                                              <label for="regimen_li" class="form-label">Regimen</label>
                                                              <input type="text" class="form-control" value="<?php echo $regimen ?>" readonly id="regimen_li" placeholder="Regimen">
                                                          </div>
                                                      <?php endif; ?>
                                                      <div class="mb-3">
                                                          <label for="regimenSelect" class="form-label">Agrega el punto de Emisión</label>
                                                          <select class="form-control" name="regimen" id="regimenSelect">
                                                              <option value="REGIMEN GENERAL">REGIMEN GENERAL</option>
                                                              <option value="RIMPE NEGOCIO POPULAR">RIMPE NEGOCIO POPULAR</option>
                                                              <option value="RIMPE-EMPRENDEDOR">RIMPE-EMPRENDEDOR</option>
                                                          </select>
                                                      </div>
                                                      <input type="hidden" name="action" value="agregar_regimen">
                                                      <div class="modal-footer">

                                                          <button type="submit" class="btn btn-primary">Guardar Contabilidad</button>
                                                      </div>
                                                      <div class="notificacion_general_f notificacion_regimen mt-4"></div>
                                                  </form>
                                                </div>
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
                                                  <form method="post" name="add_firma_electronica" id="add_firma_electronica" onsubmit="event.preventDefault(); sendData_add_firma_electronica();">
                                                      <h3>Agregar Firma Electrónica</h3>
                                                      <?php if ($firma_electronica == ''): ?>
                                                          <div id="existencia_archivo" class="mb-3">
                                                              <div class="existencia_claves">
                                                                  <div class="alert alert-danger" role="alert">No tienes ninguna firma!</div>
                                                              </div>
                                                          </div>
                                                      <?php endif; ?>
                                                      <?php if ($firma_electronica != ''): ?>
                                                          <div id="existencia_archivo" class="mb-3">
                                                              <div class="existencia_claves">
                                                                  <div class="alert alert-success" role="alert">Ya tienes una firma con Fecha de Caducidad <?php echo $fecha_caducidad_firma ?> !</div>
                                                              </div>
                                                          </div>


                                                          <h3>Agregar Clave </h3>
                                                          <?php if ($codigo_sri==''): ?>
                                                            <div id="existencia_clave" class="">
                                                              <div class="existencia_firma_fg">
                                                                    <div class="alert alert-danger" role="alert">No se encuentra ninguna clave!</div>
                                                              </div>
                                                            </div>
                                                          <?php endif; ?>


                                                          <?php if ($codigo_sri!=''): ?>
                                                            <div id="existencia_clave" class="">
                                                              <div class="existencia_firma_fg">
                                                                  <div class="alert alert-success" role="alert">Ya tienes subida tu clave!</div>
                                                              </div>
                                                            </div>
                                                          <?php endif; ?>
                                                          <a class="btn btn-success" download href="facturacion/facturacionphp/controladores/firmas_electronicas/<?php echo $firma_electronica ?>">Descargar Firma</a>
                                                      <?php endif; ?>

                                                      <div class="mb-3">
                                                          <label for="exampleFormControlFile1" class="form-label">Agrega tu firma Electrónica</label>
                                                          <input type="file" class="form-control-file" id="exampleFormControlFile1" name="firma_electronocia" accept=".p12" required>
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="exampleFormControlInput1">Ingrese la Clave</label>
                                                        <input type="text"  name="codigo_sri" class="form-control" id="exampleFormControlInput1" placeholder="Ingresa Tu clave">
                                                      </div>
                                                      <input type="hidden" name="action" value="agregar_firma_electronica">
                                                      <div class="modal-footer">
                                                          <button type="submit" class="btn btn-primary">Agregar tu firma Electrónica</button>
                                                      </div>
                                                      <div class="notificacion_agregar_firma_electronica mt-4"></div>
                                                  </form>
                                                </div>
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
                                                  <form method="post" name="agregar_contribuyente_especial" id="agregar_contribuyente_especial" onsubmit="event.preventDefault(); sendData_add_contribuyente_especial();">
                                                      <h3>Contribuyente Especial</h3>
                                                      <?php if ($contribuyente_especial == 'NO'): ?>
                                                          <div class="mb-3">
                                                              <label for="regimen_li" class="form-label">Contribuyente Especial</label>
                                                              <input type="text" class="form-control" value="<?php echo $contribuyente_especial ?>" readonly id="regimen_li">
                                                          </div>
                                                          <div class="resultado_guardar_contribuyente"></div>
                                                      <?php endif; ?>
                                                      <?php if ($contribuyente_especial == 'SI'): ?>
                                                          <div class="mb-3">
                                                              <label for="contribuyente_aq" class="form-label">Contribuyente Especial</label>
                                                              <input type="text" class="form-control" value="<?php echo $contribuyente_especial ?>" readonly id="contribuyente_aq">
                                                          </div>
                                                          <div class="resultado_guardar_contribuyente">
                                                              <div class="mb-3">
                                                                  <label for="resolcuicin_contrniyebte_esoefal" class="form-label">Resolución de Contribuyente</label>
                                                                  <textarea class="form-control" readonly id="resolcuicin_contrniyebte_esoefal" rows="3"><?php echo $resolucion_contribuyente_especial ?></textarea>
                                                              </div>
                                                          </div>
                                                      <?php endif; ?>


                                                      <div class="mb-3">
                                                          <label for="contribuyente_especial_hg" class="form-label">Eres contribuyente Especial</label>
                                                          <select class="form-control" name="contribuyente_especial" id="contribuyente_especial_hg">
                                                              <option value="NO">NO</option>
                                                              <option value="SI">SI</option>
                                                          </select>
                                                      </div>
                                                      <div class="resultado_si_contribuyente"></div>
                                                      <input type="hidden" name="action" value="agregar_contribuyente_l">
                                                      <div class="modal-footer">

                                                          <button type="submit" class="btn btn-primary">Agregar Contribuyente Especial</button>
                                                      </div>
                                                      <div class="notificacion_resultador_contribuyente mt-4"></div>
                                                  </form>


                                                </div>
                                                <div class="col">
                                                  <form method="post" name="agregar_retencion" id="agregar_retencion" onsubmit="event.preventDefault(); sendData_agregar_retencion();">
                                                      <h3>Agente de Retención</h3>
                                                      <?php if ($agente_retencion == 'NO'): ?>
                                                          <div class="mb-3">
                                                              <label for="agente_retencion" class="form-label">Agente de Retención</label>
                                                              <input type="text" class="form-control" value="<?php echo $agente_retencion ?>" readonly id="agente_retencion">
                                                          </div>
                                                          <div class="resultado_guardar_resolucion"></div>
                                                      <?php endif; ?>
                                                      <?php if ($agente_retencion == 'SI'): ?>
                                                          <div class="mb-3">
                                                              <label for="regimen_li" class="form-label">Agente de Retención</label>
                                                              <input type="text" class="form-control" value="<?php echo $agente_retencion ?>" readonly id="regimen_li">
                                                          </div>
                                                          <div class="resultado_guardar_resolucion">
                                                              <div class="mb-3">
                                                                  <label for="exampleFormControlTextarea1" class="form-label">Resolución de Retención</label>
                                                                  <textarea class="form-control" readonly id="exampleFormControlTextarea1" rows="3"><?php echo $resolucion_retencion ?></textarea>
                                                              </div>
                                                          </div>
                                                      <?php endif; ?>
                                                      <div class="mb-3">
                                                          <label for="agente_retencion_hgf" class="form-label">Eres Agente de Retención</label>
                                                          <select class="form-control" name="agrente_retencion" id="agente_retencion_hgf">
                                                              <option value="NO">NO</option>
                                                              <option value="SI">SI</option>
                                                          </select>
                                                      </div>
                                                      <div class="resultado_si_resolucion"></div>
                                                      <input type="hidden" name="action" value="agregar_retencion">
                                                      <div class="modal-footer">

                                                          <button type="submit" class="btn btn-primary">Agregar Agente de Retención</button>
                                                      </div>
                                                      <div class="notificacion_resultador_retencion mt-4"></div>
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
