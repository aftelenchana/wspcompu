<?php
ob_start();
include "../coneccion.php";
mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar
session_start();


if (empty($_SESSION['active'])) {
    header('location:/');
} else {
    // Asumimos que la sesión está activa y tenemos la información del dominio
    $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';
    $domain = $_SERVER['HTTP_HOST'];

    $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  url_admin  = '$domain'");
    $result_documentos = mysqli_fetch_array($query_doccumentos);

    if ($result_documentos) {
        $url_img_upload = $result_documentos['url_img_upload'];
        $img_facturacion = $result_documentos['img_facturacion'];

        // Asegúrate de que esta ruta sea correcta y corresponda con la estructura de tu sistema de archivos
        $img_sistema = $url_img_upload.'/home/img/uploads/'.$img_facturacion;
    } else {
        // Si no hay resultados, tal vez quieras definir una imagen por defecto
      $img_sistema = '/img/guibis.png';
    }
}

?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Home </title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#" />
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app" />
        <meta name="author" content="#" />
        <link rel="icon" href="<?php echo $img_sistema ?>" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/feather/css/feather.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/pages/prism/prism.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/style.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/jquery.mCustomScrollbar.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/css/pcoded-horizontal.min.css" />
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">


        <link rel="stylesheet" href="/css/producto.css">
        <!-- FullCalendar CSS -->
      <link rel="stylesheet" href="fullcalendar/main.css">
    </head>

    <body>

     <?php
    require 'scripts/cabezera_general.php';




             ?>
                    <div class="pcoded-wrapper">
                        <div class="pcoded-content">
                            <div class="pcoded-inner-content">
                                <div class="main-body">
                                    <div class="page-wrapper">
                                        <div class="page-body m-t-50">

                                          <div class="row">
                                            <iframe src="https://web.whatsapp.com/" width="100%" height="500px"></iframe>

                                          </div>


                                            <div class="row">
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card bg-c-yellow update-card">
                                                        <div class="card-block">
                                                            <div class="row align-items-end">
                                                                <div class="col-8">
                                                                    <h4 class="text-white"><?php echo "0" ?></h4>
                                                                    <h6 class="text-white m-b-0">Facturas Creadas</h6>
                                                                </div>
                                                                <div class="col-4 text-right">
                                                                    <canvas id="update-chart-1" height="50"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Uitima Factura : 2:15 am</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card bg-c-green update-card">
                                                        <div class="card-block">
                                                            <div class="row align-items-end">
                                                                <div class="col-8">
                                                                    <h4 class="text-white">$<?php echo "0"?></h4>
                                                                    <h6 class="text-white m-b-0">Total Ventas</h6>
                                                                </div>
                                                                <div class="col-4 text-right">
                                                                    <canvas id="update-chart-2" height="50"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Ultima Venta : 2:15 am</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card bg-c-pink update-card">
                                                        <div class="card-block">
                                                            <div class="row align-items-end">
                                                                <div class="col-8">
                                                                    <h4 class="text-white"><?php echo "0" ?></h4>
                                                                    <h6 class="text-white m-b-0">Clientes</h6>
                                                                </div>
                                                                <div class="col-4 text-right">
                                                                    <canvas id="update-chart-3" height="50"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Ultimo Cliente : 2:15 am</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card bg-c-lite-green update-card">
                                                        <div class="card-block">
                                                            <div class="row align-items-end">
                                                                <div class="col-8">
                                                                    <h4 class="text-white"><?php echo "0"?></h4>
                                                                    <h6 class="text-white m-b-0">Productos</h6>
                                                                </div>
                                                                <div class="col-4 text-right">
                                                                    <canvas id="update-chart-4" height="50"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Ultimo Producto : 2:15 am</p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card bg-c-lite-green update-card">
                                                        <div class="card-block">
                                                            <div class="row align-items-end">
                                                                <div class="col-8">
                                                                    <h4 class="text-white"><?php echo "0" ?></h4>
                                                                    <h6 class="text-white m-b-0">Retenciones</h6>
                                                                </div>
                                                                <div class="col-4 text-right">
                                                                    <canvas id="update-chart-4" height="50"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Ultima Retención : 2:15 am</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card bg-c-pink update-card">
                                                        <div class="card-block">
                                                            <div class="row align-items-end">
                                                                <div class="col-8">
                                                                    <h4 class="text-white"><?php echo "0" ?></h4>
                                                                    <h6 class="text-white m-b-0">Notas de Crédito</h6>
                                                                </div>
                                                                <div class="col-4 text-right">
                                                                    <canvas id="update-chart-3" height="50"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Ultima Nota de Crédito : 2:15 am</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card bg-c-green update-card">
                                                        <div class="card-block">
                                                            <div class="row align-items-end">
                                                                <div class="col-8">
                                                                    <h4 class="text-white">$<?php echo "0" ?></h4>
                                                                    <h6 class="text-white m-b-0">Guías de Remisión</h6>
                                                                </div>
                                                                <div class="col-4 text-right">
                                                                    <canvas id="update-chart-2" height="50"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Ultima Guía : 2:15 am</p>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card bg-c-yellow update-card">
                                                        <div class="card-block">
                                                            <div class="row align-items-end">
                                                                <div class="col-8">
                                                                    <h4 class="text-white"><?php echo "0" ?></h4>
                                                                    <h6 class="text-white m-b-0">Tikets de Venta</h6>
                                                                </div>
                                                                <div class="col-4 text-right">
                                                                    <canvas id="update-chart-1" height="50"></canvas>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card-footer">
                                                            <p class="text-white m-b-0"><i class="feather icon-clock text-white f-14 m-r-10"></i>Uitimo Tiket : 2:15 am</p>
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








        <div class="modal fade" id="modal_activacion_cuenta_wsp" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  ">
              <div class="card-header con-marca-de-agua con-marca-de-agua-inferior text-white" style="background-color: #263238;">
                <h5 class="modal-title" id="proveedorModalLabel">Sistema de Envio de mensajes de <a  style="color: #fff;" href="https://guibis.com">guibis.com</a> </h5>
              </div>
              <div class="modal-body text-center">
                <h2 class="mb-4">Tu cuenta de envio de mensajes esta lista para ser  activada</h2>
                <div class="row">
                  <div class="col _elegir_cuenta _cuenta_empresa">
                    <a href="servicio_suscripcion?codigo=5136" class="d-block p-4 text-decoration-none">
                      <img src="https://guibis.com/home/img/reacciones/guibis_wsp.png" width="30%" alt="">
                      <h3 class="mt-3">Tu Cuenta Empresa de Administrador</h3>
                      <p>Te damos la gracias por ser parte de guibis.com y para ello tienes un paquete de envio de mensajeria de tus documentos electrónicos y notificaciones de tu cuenta totalmente gratis .</p>
                    </a>
                  </div>
                </div>
              </div>

              <style media="screen">
              .modal-body a {
                color: #333; /* Cambia esto al color deseado */
                transition: transform 0.2s ease-in-out;
                }

                .modal-body a:hover {
                transform: scale(1.05);
                color: #0056b3; /* Cambia esto al color que desees para el hover */
                }

              </style>
              <form  class="" method="post" name="comprar_articulo_inicial" id="comprar_articulo_inicial" onsubmit="event.preventDefault(); sendData_comprar_articulo();">
                  <div class="modal-footer">
                    <input type="hidden" name="action" value="activar_paquete">
                    <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Ver mas tarde <i class="fas fa-times-circle"></i></button>
                    <button type="submit" class="btn btn-primary">Activar Paquete</button>
                  </div>
              </form>
              <div class="notificacion_compra_articulo"></div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="modal_activacion_cuenta_wsp_cuenta_usuario" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content  ">
              <div class="card-header con-marca-de-agua con-marca-de-agua-inferior text-white" style="background-color: #263238;">
                <h5 class="modal-title" id="proveedorModalLabel">Sistema de Envio de mensajes de <a  style="color: #fff;" href="https://guibis.com">guibis.com</a> </h5>
              </div>
              <div class="modal-body text-center">
                <h2 class="mb-4">El sistema de envios de tus documentos generados para potenciar tu empesa ya esta aquí.</h2>
                <div class="row">
                  <div class="col _elegir_cuenta _cuenta_empresa">
                    <a href="servicio_suscripcion?codigo=5136" class="d-block p-4 text-decoration-none">
                      <img src="https://guibis.com/home/img/reacciones/guibis_wsp.png" width="30%" alt="">
                      <h3 class="mt-3">Tu Cuenta Empresa de Usuario</h3>
                      <p>Te damos la gracias por ser parte de este desarrollo, te presentamos envio de notificaciones de tu cuenta y el envio de tus docuemntos electrónicos generados a tus clientes, puedes seguir este
                        enlace para poder realizar la compra.</p>
                    </a>
                  </div>
                </div>
              </div>

              <style media="screen">
              .modal-body a {
                color: #333; /* Cambia esto al color deseado */
                transition: transform 0.2s ease-in-out;
                }

                .modal-body a:hover {
                transform: scale(1.05);
                color: #0056b3; /* Cambia esto al color que desees para el hover */
                }

              </style>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Ver mas tarde <i class="fas fa-times-circle"></i></button>
              </div>
            </div>
          </div>
        </div>



        <script type="text/javascript" src="files/bower_components/jquery/dist/jquery.min.js"></script>
        <script type="text/javascript" src="files/bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script type="text/javascript" src="files/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script type="text/javascript" src="files/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="files/bower_components/jquery-slimscroll/jquery.slimscroll.js"></script>

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
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script src="fullcalendar/main.js"></script>
        <script src='fullcalendar/locales/es.js'></script>









    </body>
</html>
