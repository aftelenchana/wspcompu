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
        <title>Recursos Humanos</title>

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
        <link rel="stylesheet" href="https://guibis.com/home/estilos/modal.css">
        <link rel="stylesheet" href="https://guibis.com/home/estilos/guibis.css?v=2">
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
                                                  <h5>Recursos Humanos </h5>  <button type="button" class="btn btn-primary" id="boton_agregar_cliente" name="button">Agregar Recursos Humanos <i class="fas fa-plus"></i></button>
                                              </div>
                                              <div class="card-block">
                                                <div class="dt-responsive table-responsive">
                                                  <table id="tabla_clientes" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                      <tr>
                                                        <th>Acciones</th>
                                                        <th>Foto</th>
                                                        <th>Nombres</th>
                                                        <th>Identificación</th>
                                                        <th>Celular</th>
                                                        <th>Telefono</th>
                                                        <th>Email</th>
                                                        <th>Documento</th>
                                                        <th>Generar Tarjeta</th>
                                                        <th>Sensor</th>
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
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header header_guibis" style="background-color: #263238;">
                <h5 class="modal-title" id="proveedorModalLabel">Agregar Usuarios</h5>
                <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
              </div>
              <div class="modal-body">
                <form action=""  id="add_cliente" >
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label class="label-guibis-sm" >Identificación</label>
                        <input type="text" name="identificacion" class="form-control input-guibis-sm ocupar_api_sacar_informacion" required id="identificacion" placeholder="Identificación">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label class="label-guibis-sm" >Tipo de Identificación</label>
                        <select class="form-control input-guibis-sm" name="tipo_identificacion" required id="tipo_identificacion">
                          <option value="04">RUC</option>
                          <option value="05">CEDULA</option>
                          <option value="06">PASAPORTE</option>
                          <option value="07">VENTA A CONSUMIDOR FINAL</option>
                          <option value="08">IDENTIFICACION DEL EXTERIOR</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label-guibis-sm" >Nombres y Apelliods</label>
                    <input type="text" class="form-control input-guibis-sm resultado_nombres_consumo_api" id="nombres"  name="nombres" aria-describedby="emailHelp" placeholder="Nombres y Apellidos">
                  </div>
                  <div class="form-group">
                    <label class="label-guibis-sm" >Email</label>
                    <input type="email" name="mail_user" class="form-control input-guibis-sm"  id="email" placeholder="Ingresa el Email">
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label class="label-guibis-sm" >Celular</label>
                        <input type="number" name="celular" class="form-control input-guibis-sm"  id="celular" placeholder="Ingresa el celular">
                      </div>

                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label class="label-guibis-sm" >Teléfono</label>
                        <input type="number" name="telefono" class="form-control input-guibis-sm"  id="celular" placeholder="Ingresa el teléfono">
                      </div>
                    </div>
                  </div>


                  <div class="row">
                    <div class="col">
                      <div class="mb-3">
                        <label class="label-guibis-sm" >Elija la Categoria </label>
                        <select class="form-control input-guibis-sm" name="categoria_recursos_humanos" id="categoria_recursos_humanos">
                          <?php
                          $query_categoria_recursos_humanos = mysqli_query($conection, "SELECT * FROM categoria_recursos_humanos WHERE  categoria_recursos_humanos.iduser= '$iduser'   AND categoria_recursos_humanos.estatus = 1");
                          while ($data_categoria_recursos_humanos = mysqli_fetch_array($query_categoria_recursos_humanos)) {
                            echo '<option  value="' . $data_categoria_recursos_humanos['id'] . '">' . $data_categoria_recursos_humanos['nombre'] . '</option>';
                          }
                          ?>
                        </select>
                      </div>

                    </div>
                    <div class="col">
                      <div class="generador_lineas_distribucion">
                      </div>
                    </div>
                  </div>



                  <div class="form-group">
                    <label class="label-guibis-sm" >Tipo</label>
                    <select class="form-control input-guibis-sm" name="tipo_cliente" required id="tipo_cliente">
                      <option value="NATURAL">NATURAL</option>
                      <option value="JURIDICO">JURIDICO</option>
                    </select>
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label class="label-guibis-sm" >Ingrese la Provincia</label>
                        <input type="text" name="provincia" class="form-control input-guibis-sm"  id="provincia" placeholder="Ingresa la Provincia">
                      </div>
                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label class="label-guibis-sm" >Ingrese el Canton</label>
                        <input type="text" name="ciudad" class="form-control input-guibis-sm"  id="ciudad" placeholder="Ingresa el Canton">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label-guibis-sm" >Ingrese la Parroquia</label>
                    <input type="text" name="parroquia" class="form-control parroquia_ty input-guibis-sm"  id="parroquia_ty" placeholder="Ingresa la Parroquia">
                  </div>
                  <div class="form-group">
                    <label class="label-guibis-sm" >Dirección</label>
                    <input type="text" name="direccion" class="form-control input-guibis-sm"  id="direccion" placeholder="Ingresa la Dirección">
                  </div>

                  <div class="form-group">
                      <label class="label-guibis-sm" >Agrega una Imagen(png, .jpeg, .jpg)</label>
                      <input type="file" name="foto" class="form-control-file" accept="image/png, .jpeg, .jpg"   id="foto_subida">
                  </div>
                  <div class="form-group">
                      <label class="label-guibis-sm" >Ingresa un archivo(PDF)</label>
                      <input type="file" name="pdf"  accept="application/pdf"  class="form-control input-guibis-sm" id="pdf_archivo">
                  </div>
                  <div class="form-group">
                    <label class="label-guibis-sm" >Descripción</label>
                    <textarea class="form-control input-guibis-sm" name="actividad_economica"  id="actividad_economica" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label class="label-guibis-sm" >Cargas Familiares</label>
                    <input type="number" name="cargas_familiares" class="form-control input-guibis-sm"  id="cargas_familiares" placeholder="Cargas Familiares">
                  </div>
                  <div class="row">
                    <div class="col">
                      <div class="form-group">
                        <label class="label-guibis-sm" >Fecha Inicio</label>
                        <input type="date" name="fecha_inicio" class="form-control input-guibis-sm"  id="fecha_inicio" placeholder="Fecha Inicio">
                      </div>

                    </div>
                    <div class="col">
                      <div class="form-group">
                        <label class="label-guibis-sm" >Fecha Final</label>
                        <input type="date" name="fecha_final" class="form-control input-guibis-sm"  id="fecha_final" placeholder="Fecha Final">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="label-guibis-sm" >Fecha Corte de Pago</label>
                    <input type="date" name="fecha_corte" class="form-control input-guibis-sm"  id="fecha_corte" placeholder="Fecha Corte">
                  </div>

                    <div class="modal-footer">
                      <input type="hidden" name="action" value="agregar_recursos_humanos" required>
                      <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                      <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                    </div>
                    <div class="noticia_agregar_clientes">

                    </div>
                  </form>
              </div>
            </div>
          </div>
        </div>



        <div class="modal fade" id="modal_editar_cliente" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
              <div class="modal-content">
                  <div class="modal-header header_guibis" style="background-color: #263238;">
                      <h5 class="modal-title" id="proveedorModalLabel">Editar Usuario</h5>
                      <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                  </div>
                  <div class="modal-body">
                      <form action="" id="update_cliente">
                        <style media="screen">
                        .contenedor_salida_imagen_editar{
                          text-align: center;
                        }

                        </style>

                        <div class="contenedor_salida_imagen_editar">

                        </div>
                        <div class="form-group">
                            <label class="label-guibis-sm" >Ingresa una Imagen de Perfil</label>
                            <input type="file" name="foto" accept="image/png,image/jpeg"   class="form-control-file" id="exampleFormControlFile1">
                        </div>
                          <div class="form-group">
                              <label class="label-guibis-sm" >Nombres y Apellidos</label>
                              <input type="text" class="form-control input-guibis-sm" id="nombres_update" name="nombres" aria-describedby="emailHelp" placeholder="Nombres y Apellidos" />
                          </div>
                          <div class="form-group">
                              <label class="label-guibis-sm" >Email del Cliente</label>
                              <input type="email" name="mail_user" class="form-control input-guibis-sm" id="email_update" placeholder="Ingresa el Email" />
                          </div>

                          <div class="form-group">
                              <label class="label-guibis-sm" >Ingrese el Celular</label>
                              <input type="number" name="celular" class="form-control input-guibis-sm" id="celular_update" placeholder="Ingresa el celular" />
                          </div>
                          <div class="form-group">
                              <label class="label-guibis-sm" >Ingrese el Teléfono</label>
                              <input type="number" name="telefono" class="form-control input-guibis-sm" id="telefono_update" placeholder="Ingresa el teléfono" />
                          </div>
                          <div class="form-group">
                              <label class="label-guibis-sm" >Tipo de Identificación</label>
                              <select class="form-control input-guibis-sm" name="tipo_identificacion" required id="tipo_identificacion_update">
                                  <option value="04">RUC</option>
                                  <option value="05">CEDULA</option>
                                  <option value="06">PASAPORTE</option>
                                  <option value="07">VENTA A CONSUMIDOR FINAL</option>
                                  <option value="08">IDENTIFICACION DEL EXTERIOR</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label class="label-guibis-sm" >Identificación</label>
                              <input type="text" name="identificacion" class="form-control input-guibis-sm" required id="identificacion_update" placeholder="Identificación" />
                          </div>
                          <div class="form-group">
                              <label class="label-guibis-sm" >Tipo</label>
                              <select class="form-control input-guibis-sm" name="tipo_cliente" required id="tipo_cliente_update">
                                  <option value="NATURAL">NATURAL</option>
                                  <option value="JURIDICO">JURIDICO</option>
                              </select>
                          </div>
                          <div class="row">
                              <div class="col">
                                  <div class="form-group">
                                      <label class="label-guibis-sm" >Ingrese la Provincia</label>
                                      <input type="text" name="provincia" class="form-control input-guibis-sm" id="provincia_update" placeholder="Ingresa la Provincia" />
                                  </div>
                              </div>
                              <div class="col">
                                  <div class="form-group">
                                      <label class="label-guibis-sm" >Ingrese el Canton</label>
                                      <input type="text" name="ciudad" class="form-control input-guibis-sm" id="ciudad_update" placeholder="Ingresa el Canton" />
                                  </div>
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="label-guibis-sm" >Ingrese la Parroquia</label>
                              <input type="text" name="parroquia" class="form-control parroquia_ty" id="parroquia_update" placeholder="Ingresa la Parroquia" />
                          </div>
                          <div class="form-group">
                              <label class="label-guibis-sm" >Dirección del Cliente</label>
                              <input type="text" name="direccion" class="form-control input-guibis-sm" id="direccion_update" placeholder="Ingresa la Dirección" />
                          </div>

                          <div class="form-group">
                              <label class="label-guibis-sm" >Descripción</label>
                              <textarea class="form-control input-guibis-sm" name="actividad_economica" id="actividad_economica_update" rows="3"></textarea>
                          </div>

                          <div class="mb-3">
                            <label class="label-guibis-sm" >Elija la Categoria </label>
                            <select class="form-control input-guibis-sm" name="categoria_recursos_humanos" id="categoria_recursos_humanos_update">
                              <?php
                              $query_categoria_recursos_humanos = mysqli_query($conection, "SELECT * FROM categoria_recursos_humanos WHERE  categoria_recursos_humanos.iduser= '$iduser'   AND categoria_recursos_humanos.estatus = 1");
                              while ($data_categoria_recursos_humanos = mysqli_fetch_array($query_categoria_recursos_humanos)) {
                                echo '<option  value="' . $data_categoria_recursos_humanos['id'] . '">' . $data_categoria_recursos_humanos['nombre'] . '/ ' . $data_categoria_recursos_humanos['descripcion'] . '</option>';
                              }
                              ?>
                            </select>
                          </div>
                      <div class="form-group">
                            <label class="label-guibis-sm" >Cargas Familiares</label>
                            <input type="number" name="cargas_familiares" class="form-control input-guibis-sm"  id="cargas_familiares_update" placeholder="Ingresa las Cargas Familiares">
                          </div>

                          <div class="modal-footer">
                            <input type="hidden" name="id_cliente" id="id_cliente" value="">
                              <input type="hidden" name="action" value="editar_recursos_humanos" required />
                              <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                              <button type="submit" class="btn btn-primary">Editar Usuario</button>
                          </div>
                          <div class="noticia_editar_clientes"></div>
                      </form>
                  </div>
              </div>
          </div>
      </div>

                      <div class="modal fade" id="modal_generar_tajeta" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header header_guibis" style="background-color: #263238;">
                                    <h5 class="modal-title" id="proveedorModalLabel">GENERAR TARJETA DE PRESENTACIÓN</h5>
                                    <button type="button" class="btn-danger" data-dismiss="modal"><i class="fas fa-times-circle"></i>  </button>
                                </div>
                                <div class="modal-body">
                                  <style>
                                    #tarjeta-presentacion {
                                        max-width: 350px;
                                        margin: auto;
                                        border: 1px solid #ddd;
                                        padding: 20px;
                                        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                                        border-radius: 10px;
                                    }
                                    #tarjeta-presentacion .imagen_foto {
                                        width: 250px;
                                        height: auto;
                                        border-radius: 5px;
                                        margin: 0 auto;
                                    }
                                    #tarjeta-presentacion .qr {
                                        width: 100px;
                                        height: auto;
                                        border-radius: 5px;
                                    }
                                    .tarjeta-body {
                                        text-align: center;
                                    }
                                    #tarjeta-presentacion {
                                          background-image: linear-gradient(to bottom, rgba(255, 255, 255, 0.7), rgba(255, 255, 255, 0.7)), url('<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_logo ?>');
                                          background-size: cover;
                                          background-position: center;
                                      }
                                  </style>

                                    <div id="tarjeta-presentacion" class="bg-light container py-5">
                                        <div class="tarjeta-body">
                                          <div class="conte_imagen_salida_tarjeta">

                                          </div>
                                            <h4 style="font-weight: bold;" class="fw-bold nombres_apellidos_tarjeta"></h4>
                                            <p style="padding: 0px;margin: 0px;" class="fw-bold">Identificación: <span class="fw-normal identificacion_tarjeta"></span></p>
                                            <p style="padding: 0px;margin: 0px;" class="fw-bold">Celular: <span class="fw-normal celular_tarjeta">+XX XXXXXXXXX</span></p>
                                            <p style="padding: 0px;margin: 0px;" class="fw-bold">Correo: <span class="fw-normal correo_tarjeta">correo@example.com</span></p>
                                            <p style="padding: 0px;margin: 0px;" class="fw-bold">Cargo: <span class="fw-normal cargo_tarjeta">correo@example.com</span></p>
                                            <div class="conte_qr_salida_tarjeta">

                                            </div>
                                            <p style="padding: 0px;margin: 0px;font-weight: bold;"class="fw-bold"><?php echo $nombre_empresa ?></p>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
                                        <button type="button" id="descargar-tarjeta" nombre_tarjeta ="Alex Fernando Telenchana" class="btn btn-primary genarate_name_tarjeta">Descargar como imagen</button>
                                    </div>
                                    <div class="noticia_generar_tarjeta"></div>

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
        <script type="text/javascript" src="medico/recursos_humanos.js?v=7"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script src="apis/api_sri.js?v=3"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>


                <script type="text/javascript">
                    function openPdfViewer(fileName) {
                        var url = "vizualizar_factura?archivo=" + encodeURIComponent(fileName);
                        var width = 800;
                        var height = 600;
                        var left = (window.screen.width / 2) - (width / 2);
                        var top = (window.screen.height / 2) - (height / 2);
                        var windowFeatures = "resizable=yes, scrollbars=yes, status=yes, width=" + width + ", height=" + height + ", top=" + top + ", left=" + left;
                        window.open(url, "popUp", windowFeatures);
                    }
                </script>


    </body>
</html>
