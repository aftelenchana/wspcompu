<?php

ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar
      session_start();
      if (empty($_SESSION['active'])) {
        header('location:/');
      }

  ?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Historial Consultas</title>
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
        <link rel="stylesheet" href="estilos/modal.css?v=2">
        <link rel="stylesheet" href="estilos/correccion_tabla.css">
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
        <link rel="stylesheet" href="https://guibis.com/home/estilos/guibis.css?v=2">

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
                                                  <h5>Ingresos  </h5>
                                              </div>
                                              <div class="card-block">
                                                <div class="dt-responsive table-responsive">
                                                  <table id="tabla_clientes" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                      <tr>
                                                        <th>Acciones</th>
                                                        <th>Código</th>
                                                        <th>Estado</th>
                                                        <th>Imagen Paciente</th>
                                                        <th>Nombres y Apellidos</th>
                                                        <th>Historia Clinica</th>
                                                        <th>Email</th>
                                                        <th>Celular</th>
                                                        <th>Fecha de Ingreso</th>
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
                  </div>

              </div>

                </div>
            </div>
        </div>



                    <div class="modal fade" id="modal_agregar_cliente" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg"> <!-- Aquí se añade la clase modal-lg -->

                    <div class="modal-content">
                      <div class="card-header con-marca-de-agua con-marca-de-agua-inferior text-white" style="background-color: #263238;">
                        <h5 class="modal-title" id="proveedorModalLabel">Agregar Paciente</h5>
                      </div>
                      <div class="modal-body">

                        <form action=""  id="add_cliente" >
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nombres del Paciente</label>
                            <input type="text" class="form-control" id="nombres"  name="nombres" aria-describedby="emailHelp" placeholder="Nombres del Paciente">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Email del Paciente</label>
                            <input type="email" name="mail_user" class="form-control"  id="email" placeholder="Ingresa el Email del Paciente">
                          </div>

                          <div class="form-group">
                            <label for="exampleInputPassword1">Ingrese el Celular del Cliente</label>
                            <input type="number" name="celular" class="form-control"  id="celular" placeholder="Ingresa el celular del Paciente">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Ingrese el Teléfono del Cliente</label>
                            <input type="number" name="telefono" class="form-control"  id="celular" placeholder="Ingresa el teléfono del Paciente">
                          </div>

                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label for="exampleInputPassword1">Identificación del Paciente</label>
                                <input type="text" name="identificacion" class="form-control" required id="identificacion" placeholder="Identificación del Cliente">
                              </div>

                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label for="exampleFormControlSelect1">Tipo de Identificación</label>
                                <select class="form-control" name="tipo_identificacion" required id="tipo_identificacion">
                                  <option value="04">RUC</option>
                                  <option value="05">CEDULA</option>
                                  <option value="06">PASAPORTE</option>
                                  <option value="07">VENTA A CONSUMIDOR FINAL</option>
                                  <option value="08">IDENTIFICACION DEL EXTERIOR</option>
                                </select>
                              </div>
                            </div>
                          </div>


                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label for="exampleInputPassword1">Ingrese la Provincia</label>
                                <input type="text" name="provincia" class="form-control"  id="provincia" placeholder="Ingresa la Provincia">
                              </div>
                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label for="exampleInputPassword1">Ingrese el Canton</label>
                                <input type="text" name="ciudad" class="form-control"  id="ciudad" placeholder="Ingresa el Canton">
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col">
                              <div class="form-group">
                                <label for="exampleInputPassword1">Ingrese la Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" class="form-control"  id="fecha_nacimiento">
                              </div>

                            </div>
                            <div class="col">
                              <div class="form-group">
                                <label for="exampleFormControlSelect1">Genero</label>
                                <select class="form-control" name="genero" required id="genero">
                                  <option value="Masculino">Masculino</option>
                                  <option value="Femenino">Femenino</option>
                                </select>
                              </div>
                            </div>
                          </div>


                          <div class="form-group">
                            <label for="exampleFormControlSelect1">Estado Civil</label>
                            <select class="form-control" name="estado_civil" required id="estado_civil">
                              <option value="Casado">Casado</option>
                              <option value="Soltero">Soltero</option>
                              <option value="Divorsiado">Divorsiado</option>
                              <option value="Unido">Unido</option>
                              <option value="Viudo">Viudo</option>
                            </select>
                          </div>


                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Dirección del Paciente</label>
                            <textarea class="form-control" name="direccion"  id="direccion" rows="3"></textarea>
                          </div>

                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Descripción Médica <i class="fas fa-microphone"></i></label>
                            <textarea class="form-control" name="historial_medico"  id="historial_medico" rows="3"></textarea>
                          </div>

                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Alergias</label>
                            <textarea class="form-control" name="alergias"  id="alergias" rows="3"></textarea>
                          </div>

                          <div class="form-group">
                            <label for="exampleFormControlTextarea1">Actividad Económica </label>
                            <textarea class="form-control" name="actividad_economica"  id="actividad_economica" rows="3"></textarea>
                          </div>

                          <div class="form-group">
                              <label for="exampleFormControlFile1">Ingresa una Imagen</label>
                              <input type="file" name="foto" class="form-control-file" accept="image/png, .jpeg, .jpg" id="exampleFormControlFile1">
                          </div>

                            <div class="modal-footer">
                              <input type="hidden" name="action" value="agregar_clientes" required>
                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                              <button type="submit" class="btn btn-primary">Agregar Paciente <i class="fas fa-plus"></i></button>
                              <button type="button"  class="btn btn-warning" onclick="limpiarFormulario()">Limpiar</button>
                              <button type="button"  class="btn btn-info" id="btn_clientesdictado_clientes">Iniciar dictado <i class="fas fa-microphone"></i></button>
                            </div>
                            <div class="noticia_agregar_pacientes">

                            </div>
                          </form>
                      </div>
                    </div>
                  </div>
                </div>


                    <div class="modal fade" id="modal_editar_cliente" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg"> <!-- Aquí se añade la clase modal-lg -->
                      <div class="modal-content">
                        <div class="card-header con-marca-de-agua con-marca-de-agua-inferior text-white" style="background-color: #263238;">
                          <h5 class="modal-title" id="proveedorModalLabel">Editar Paciente <span id="paciente_name" ></span> </h5>
                        </div>
                          <div class="modal-body">
                              <form action="" id="update_cliente">
                                <div class="img_edit_noticia text-center"></div>
                                <div class="mb-3">
                                  <label for="exampleFormControlFile1" class="form-label">Agregue una imagen</label>
                                  <input type="file" class="form-control " name="foto" accept="image/png, .jpeg, .jpg" id="exampleFormControlFile1">
                                </div>
                                  <div class="form-group">
                                      <label for="exampleInputEmail1">Nombres del Cliente</label>
                                      <input type="text" class="form-control" id="nombres_update" name="nombres" aria-describedby="emailHelp" placeholder="Nombres del Cliente" />
                                  </div>
                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Email del Cliente</label>
                                      <input type="email" name="mail_user" class="form-control" id="email_update" placeholder="Ingresa el Email del Cliente" />
                                  </div>

                                  <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                          <label for="exampleInputPassword1">Ingrese el Celular del Cliente</label>
                                          <input type="number" name="celular" class="form-control" id="celular_update" placeholder="Ingresa el celular del Cliente" />
                                      </div>

                                    </div>
                                    <div class="col">
                                      <div class="form-group">
                                          <label for="exampleInputPassword1">Ingrese el Teléfono del Cliente</label>
                                          <input type="number" name="telefono" class="form-control" id="telefono_update" placeholder="Ingresa el teléfono del Cliente" />
                                      </div>
                                    </div>
                                  </div>

                                  <div class="form-group">
                                    <label for="exampleFormControlSelect1">Estado Civil</label>
                                    <select class="form-control" name="estado_civil" required id="estado_civil_update">
                                      <option value="Casado">Casado</option>
                                      <option value="Soltero">Soltero</option>
                                      <option value="Divorsiado">Divorsiado</option>
                                      <option value="Unido">Unido</option>
                                      <option value="Viudo">Viudo</option>
                                    </select>
                                  </div>

                                  <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                          <label for="exampleInputPassword1">Identificación del Cliente</label>
                                          <input type="text" name="identificacion" class="form-control" required id="identificacion_update" placeholder="Identificación del Cliente" />
                                      </div>

                                    </div>
                                    <div class="col">
                                      <div class="form-group">
                                          <label for="exampleFormControlSelect1">Tipo de Identificación</label>
                                          <select class="form-control" name="tipo_identificacion" required id="tipo_identificacion_update">
                                              <option value="04">RUC</option>
                                              <option value="05">CEDULA</option>
                                              <option value="06">PASAPORTE</option>
                                              <option value="07">VENTA A CONSUMIDOR FINAL</option>
                                              <option value="08">IDENTIFICACION DEL EXTERIOR</option>
                                          </select>
                                      </div>
                                    </div>
                                  </div>


                                  <div class="row">
                                    <div class="col">
                                      <div class="form-group">
                                        <label for="exampleInputPassword1">Ingrese la Fecha de Nacimiento</label>
                                        <input type="date" name="fecha_nacimiento" class="form-control"  id="fecha_nacimiento_update">
                                      </div>

                                    </div>
                                    <div class="col">
                                      <div class="form-group">
                                        <label for="exampleFormControlSelect1">Genero</label>
                                        <select class="form-control" name="genero" required id="genero_update">
                                          <option value="Masculino">Masculino</option>
                                          <option value="Femenino">Femenino</option>
                                        </select>
                                      </div>
                                    </div>
                                  </div>

                                  <div class="row">
                                      <div class="col">
                                          <div class="form-group">
                                              <label for="exampleInputPassword1">Ingrese la Provincia</label>
                                              <input type="text" name="provincia" class="form-control" id="provincia_update" placeholder="Ingresa la Provincia" />
                                          </div>
                                      </div>
                                      <div class="col">
                                          <div class="form-group">
                                              <label for="exampleInputPassword1">Ingrese el Canton</label>
                                              <input type="text" name="ciudad" class="form-control" id="ciudad_update" placeholder="Ingresa el Canton" />
                                          </div>
                                      </div>
                                  </div>

                                  <div class="form-group">
                                      <label for="exampleInputPassword1">Dirección del Cliente</label>
                                      <input type="text" name="direccion" class="form-control" id="direccion_update" placeholder="Ingresa la Dirección" />
                                  </div>


                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Descripción Médica <i class="fas fa-microphone"></i></label>
                                    <textarea class="form-control" name="historial_medico"  id="historial_medico_update" rows="3"></textarea>
                                  </div>

                                  <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Alergias</label>
                                    <textarea class="form-control" name="alergias"  id="alergias_update" rows="3"></textarea>
                                  </div>



                                  <div class="form-group">
                                      <label for="exampleFormControlTextarea1">Actividad Económica</label>
                                      <textarea class="form-control" name="actividad_economica" id="actividad_economica_update" rows="3"></textarea>
                                  </div>

                                  <div class="modal-footer">
                                    <input type="hidden" name="id_cliente" id="id_cliente" value="">
                                      <input type="hidden" name="action" value="editar_clientes" required />
                                      <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                      <button type="submit" class="btn btn-primary">Editar Paciente</button>
                                  </div>
                                  <div class="noticia_editar_clientes"></div>
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
        <script type="text/javascript" src="medico/ingresos.js?v=4"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
    </body>
</html>
