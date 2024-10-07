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



            $sql_facturas = mysqli_query($conection,"SELECT COUNT(*) as  facturas  FROM
            comprobante_factura_final WHERE comprobante_factura_final.id_emisor  = '$iduser' AND (comprobante_factura_final.secuencia != '00000000' || comprobante_factura_final.secuencia IS NOT NULL)
            AND comprobante ='factura' AND estado ='COMPLETADO'");
          $result_facturas = mysqli_fetch_array($sql_facturas);
          $total_facturas = $result_facturas['facturas'];


          $sql_notas_credito = mysqli_query($conection,"SELECT COUNT(*) as  notas_credito  FROM
          comprobante_factura_final WHERE comprobante_factura_final.id_emisor  = '$iduser' AND comprobante ='nota_credito' AND estado ='COMPLETADO'");
          $result_notas_creditos = mysqli_fetch_array($sql_notas_credito);
          $total_notas_creditos = $result_notas_creditos['notas_credito'];


          $sql_notas_guis_remision = mysqli_query($conection,"SELECT COUNT(*) as  guia_remision  FROM
          comprobante_factura_final WHERE comprobante_factura_final.id_emisor  = '$iduser' AND comprobante ='guia_remision' AND estado ='COMPLETADO'");
          $result_guia_remision = mysqli_fetch_array($sql_notas_guis_remision);
          $total_result_guia_remision = $result_guia_remision['guia_remision'];


          $sql_notas_retenciones = mysqli_query($conection,"SELECT COUNT(*) as  retenciones  FROM
          comprobante_factura_final WHERE comprobante_factura_final.id_emisor  = '$iduser' AND comprobante ='retenciones' AND estado ='COMPLETADO'");
          $result_retenciones = mysqli_fetch_array($sql_notas_retenciones);
          $total_result_retenciones = $result_retenciones['retenciones'];



          $sql_notas_venta = mysqli_query($conection,"SELECT COUNT(*) as  tikets  FROM
          tikets WHERE tikets.id_emisor  = '$iduser' ");
          $result_notas_venta = mysqli_fetch_array($sql_notas_venta);
          $total_result_notas_venta = $result_notas_venta['tikets'];


          $query_suma_ventas = mysqli_query($conection,"SELECT SUM(((comprobante_factura_final.total))) as 'compra_total'
          FROM `comprobante_factura_final`
          WHERE comprobante_factura_final.id_emisor = '$iduser'");
          $data_lista_venta =mysqli_fetch_array($query_suma_ventas);
          $compra_total = round(($data_lista_venta['compra_total']),2);



          //NOTAS DE VENTA



          $query_suma_notas = mysqli_query($conection,"SELECT SUM(((tikets.total))) as 'compra_nota_total'
          FROM `tikets`
          WHERE tikets.id_emisor = '$iduser'");
          $data_notas =mysqli_fetch_array($query_suma_notas);
          $compra_total_notas = round(($data_notas['compra_nota_total']),2);


          $sql_productos = mysqli_query($conection,"SELECT COUNT(*) as  productos_subidos  FROM
          producto_venta WHERE producto_venta.id_usuario  = '$iduser' AND producto_venta.estatus = '1'");
          $result_productos = mysqli_fetch_array($sql_productos);
          $productos_subidos = $result_productos['productos_subidos'];



          $sql_productos = mysqli_query($conection,"SELECT COUNT(*) as  clientes_subidos  FROM
          clientes WHERE clientes.iduser  = '$iduser' AND clientes.estatus = '1'");
          $result_clientes = mysqli_fetch_array($sql_productos);
          $clientes_subidos = $result_clientes['clientes_subidos'];

          //CODIGO PARA VENTAS DIARIAS

          $fecha_actual = date("Y-m-d");
          $fecha_inicio = date('d-m-Y H:i:s', strtotime('midnight'));
          $fecha_fin = date('d-m-Y H:i:s', strtotime('tomorrow midnight'));

          //CODIGO PARA FACTURAS



      $query_ganancias_por_dia = mysqli_query($conection,"SELECT SUM(((comprobante_factura_final.total))) as 'ganancias_diarias'
      FROM `comprobante_factura_final`
      WHERE comprobante_factura_final.id_emisor = '$iduser' AND  comprobante_factura_final.fecha >= '$fecha_inicio' AND comprobante_factura_final.fecha < '$fecha_fin'");
      $data_lista_ganancias_dia =mysqli_fetch_array($query_ganancias_por_dia);
      $ganancias_dia_facturas = round(($data_lista_ganancias_dia['ganancias_diarias']),2);



      // Obtén el valor del parámetro 'mes' de la URL

      $mes = isset($_GET['mes']) ? intval($_GET['mes']) : 0;

      // Define el rango de fechas correspondiente al mes seleccionado

      if ($mes > 0 && $mes <= 12) {
        $primer_dia = date('Y-m-01', strtotime("{$mes}/01/" . date('Y')));
        $ultimo_dia = date('Y-m-t', strtotime("{$mes}/01/" . date('Y')));
      } else {
        // Sino se seleccionó un mes válido, muestra las ventas totales de todos los meses
        $primer_dia = '1900-01-01'; // Fecha muy antigua
        $ultimo_dia = '9999-12-31'; // Fecha muy futura
      }



      // Consulta SQL para obtener las ventas totales del mes seleccionado

      $query_suma_ventas_mes = mysqli_query($conection, "SELECT SUM(total) AS compra_total_mes
      FROM comprobante_factura_final
      WHERE id_emisor = '$iduser' AND fecha >= '$primer_dia' AND fecha <= '$ultimo_dia'");
      $data_venta_mes = mysqli_fetch_array($query_suma_ventas_mes);
      $compra_total_mes = round($data_venta_mes['compra_total_mes'], 2);

      //Obtener estadística por día.

      $mesActual = date('m');

      $anoActual = date('Y');

      // Consulta para facturas por día

      $sql_ventas_diarias_factura = mysqli_query($conection, "SELECT DAY(fecha) AS dia, SUM(total) as total_dia
      FROM comprobante_factura_final
      WHERE MONTH(fecha) = '$mesActual' AND YEAR(fecha) = '$anoActual' AND id_emisor = '$iduser'
      GROUP BY DAY(fecha)");


      // Convertir el resultado a un arreglo asociativo

      $ventasDiariasFactura = [];
      while ($row = mysqli_fetch_assoc($sql_ventas_diarias_factura)) {
          $ventasDiariasFactura[$row['dia']] = $row['total_dia'];
      }

      // Consulta para notas de venta por día

      $sql_ventas_diarias_nota = mysqli_query($conection, "SELECT DAY(fecha) AS dia, SUM(total) as total_dia
      FROM tikets
      WHERE MONTH(fecha) = '$mesActual' AND YEAR(fecha) = '$anoActual' AND id_emisor = '$iduser'
      GROUP BY DAY(fecha)");
      $ventasDiariasNota = [];
      while ($row = mysqli_fetch_assoc($sql_ventas_diarias_nota)) {
          $ventasDiariasNota[$row['dia']] = $row['total_dia'];
      }

             ?>
                    <div class="pcoded-wrapper">
                        <div class="pcoded-content">
                            <div class="pcoded-inner-content">
                                <div class="main-body">
                                    <div class="page-wrapper">
                                        <div class="page-body m-t-50">
                                            <div class="row">
                                                <div class="col-xl-3 col-md-6">
                                                    <div class="card bg-c-yellow update-card">
                                                        <div class="card-block">
                                                            <div class="row align-items-end">
                                                                <div class="col-8">
                                                                    <h4 class="text-white"><?php echo $total_facturas ?></h4>
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
                                                                    <h4 class="text-white">$<?php echo number_format(($compra_total+$compra_total_notas ),2)?></h4>
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
                                                                    <h4 class="text-white"><?php echo $clientes_subidos ?></h4>
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
                                                                    <h4 class="text-white"><?php echo $productos_subidos ?></h4>
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
                                                                    <h4 class="text-white"><?php echo $total_result_retenciones ?></h4>
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
                                                                    <h4 class="text-white"><?php echo $total_notas_creditos ?></h4>
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
                                                                    <h4 class="text-white">$<?php echo $total_result_guia_remision?></h4>
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
                                                                    <h4 class="text-white"><?php echo $total_result_notas_venta ?></h4>
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





                                                <div class="col-xl-3 col-md-12">
                                                    <div class="card user-card2">
                                                        <div class="card-block text-center">
                                                            <h6 class="m-b-15">Reporte de Ventas</h6>
                                                            <div class="risk-rate">
                                                                <span><b></b></span>
                                                            </div>
                                                            <h6 class="m-b-10 m-t-10">Balance</h6>
                                                            <div class="card-header">
                                                              <div class="formulario_elegir_ganancias">
                                                                <div class="form-group">
                                                                  <label for="exampleFormControlSelect1">Elije el tipo de Reporte</label>
                                                                  <select class="form-control" id="tipo_reporte">
                                                                    <option>General</option>
                                                                    <option>Diario</option>
                                                                    <option>Fecha</option>
                                                                  </select>
                                                                </div>
                                                              </div>
                                                            </div>
                                                        </div>
                                                        <div class="boton_generador_documentos_pdf">
                                                            <a class="btn btn-warning btn-block p-t-15 p-b-15" href="pdf/generar_reporte_ventas_restaurant_general">Reporte General</a>

                                                        </div>

                                                    </div>
                                                </div>




                                                <div class="col-md-4 connectedSortable">
                                                    <div class="card card-dark">
                                                        <div class="card-header">
                                                            <h3 class="card-title"><i class="fa-brands fa-sellsy"></i> Análisis de Documentos Generados</h3>
                                                        </div>
                                                        <div class="card-body">
                                                            <canvas id="myPieChart" width="400" height="200"></canvas>
                                                        </div>
                                                    </div>

                                                    <!-- Tarjeta para el gráfico Donut -->

                                                </div>
                                                <div class="col-md-5 col-12 connectedSortable">
                          <div class="card card-dark">
                              <div class="card-header">
                                  <h3 class="card-title">
                                  <i class="fas fa-chart-bar"></i> Ventas diarias del mes de <?php echo setlocale(LC_TIME, 'es_ES.UTF-8') ? ucfirst(strftime('%B del %Y')) : date('m-Y'); ?></h3>
                              </div>
                              <div class="card-body">
                                  <canvas id="ventasDiariasChart" height="200"></canvas>
                              </div>
                          </div>
                      </div>


                                            </div>

                                            <div class="row">
                                              <div class="col connectedSortable">
                                                  <div class="card card-dark">
                                                      <div class="card-header border-0">
                                                          <h3 class="card-title">
                                                              <i class="far fa-calendar-alt"></i>
                                                              Calendario Ventas Diarias
                                                          </h3>

                                                      </div>
                                                      <!-- /.card-header -->
                                                      <div class="card-body pt-0">
                                                          <!-- The calendar -->
                                                          <div id="calendar" style="width: 100%"></div>
                                                      </div>
                                                      <!-- /.card-body -->
                                                  </div>
                                              </div>
                                              <div class="col">
                                                <div class="card card-dark">
                                                    <div class="card-header">
                                                        <h3 class="card-title"><i class="fa-solid fa-chart-simple"></i> Ventas totales Facturas vs Notas de venta</h3>
                                                    </div>
                                                    <div class="card-body">
                                                        <canvas id="ventasTotalesChart" width="400" height="200"></canvas>
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


        <div class="modal fade" id="miModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Detalles de las Ganancias</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Fecha: <span id="modalFecha"></span><br>
                        Ventas Totales: $<span id="modalGanancias"></span><br>
                        # Facturas: <span id="factur_total_dia"></span><br>
                        # Notas de Venta: <span id="nota_venta_tatal_dia"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
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



        <script type="text/javascript">

          (function() {
            $(function() {
              $('#boton_permanente').on('click', function() {
                $('#modal_activacion_cuenta_wsp').modal();
              });
            });
          })();

        </script>



        <script type="text/javascript">
        $(document).ready(function(){
$("#tipo_reporte").change(function(){
  var tipo_reporte = $("#tipo_reporte").val();
    console.log(tipo_reporte);
    if (tipo_reporte =='General') {
      $(".boton_generador_documentos_pdf").html('<a class="btn btn-warning btn-block p-t-15 p-b-15" href="pdf/generar_reporte_ventas_restaurant_general">Reporte General</a>');
    }
    if (tipo_reporte =='Diario') {
            $(".boton_generador_documentos_pdf").html('<a class="btn btn-warning btn-block p-t-15 p-b-15" href="pdf/generar_reporte_ventas_restaurant_diario">Reporte Diario</a>');
    }
    if (tipo_reporte =='Fecha') {
      $(".boton_generador_documentos_pdf").html('<div class="formulario_respuesta_fechas">'+
        '<form class="" action="pdf/generar_reporte_ventas_restaurant_fecha.php" method="get">'+
          '<div class="form-group" style="padding: 4px;">'+
          '<label for="exampleFormControlInput1">Elije una Fecha</label>'+
          '<input type="date" required name="fecha1" class="form-control" id="exampleFormControlInput1">'+
        '</div>'+
        '<div class="form-group" style="padding: 4px;">'+
        '<label for="exampleFormControlInput1">Elije una Segunda Fecha</label>'+
        '<input type="date" required name="fecha2" class="form-control" id="exampleFormControlInput1">'+
      '</div>'+
      '<button   type="submit" class="btn btn-warning btn-block p-t-15 p-b-15" >Generar Reporte</button>'+
        '</form>'+
      '</div>');
    }




});

});


        </script>




        <script>
        //ventas diarias por mes en curso.
          document.addEventListener('DOMContentLoaded', function() {
          let etiquetasDias = [];
          let datosFacturas = [];
          let datosNotas = [];
          // Genera etiquetas y datos del 1 al número de días del mes actual
          for (let i = 1; i <= new Date(new Date().getFullYear(), new Date().getMonth()+1, 0).getDate(); i++) {
              etiquetasDias.push(i);
              datosFacturas.push(<?php echo json_encode($ventasDiariasFactura); ?>[i] || 0);
              datosNotas.push(<?php echo json_encode($ventasDiariasNota); ?>[i] || 0);
          }
          let ctx = document.getElementById('ventasDiariasChart').getContext('2d');
          let ventasDiariasChart = new Chart(ctx, {
              type: 'line',
              data: {
                  labels: etiquetasDias,
                  datasets: [
                      {
                          label: 'Ventas Facturas',
                          data: datosFacturas,
                          backgroundColor: 'rgba(75, 192, 192, 0.2)',
                          borderColor: 'rgba(75, 192, 192, 1)',
                          borderWidth: 1,
                          fill: false
                      },
                      {
                          label: 'Ventas Notas',
                          data: datosNotas,
                          backgroundColor: 'rgba(255, 99, 132, 0.2)',
                          borderColor: 'rgba(255, 99, 132, 1)',
                          borderWidth: 1,
                          fill: false
                      }
                  ]
              },
              options: {
                  scales: {
                      x: {
                          beginAtZero: true,
                          title: {
                              display: true,
                              text: 'Día del Mes'
                          }
                      },
                      y: {
                          beginAtZero: true,
                          title: {
                              display: true,
                              text: 'Ventas Totales'
                          }
                      }
                  }
              }
          });
      });
        </script>
        <script>
          //Pie Facturas Creadas / Retenciones / Guías de Remisión / Notas de Crédito / Notas de Ventas
        let ctx = document.getElementById('myPieChart').getContext('2d');
      let myChart = new Chart(ctx, {
          type: 'pie',
          data: {
              labels: ['Facturas Creadas', 'Retenciones', 'Guías de Remisión', 'Notas de Crédito', 'Notas de Ventas'],
              datasets: [{
                  data: [
                      <?php echo $total_facturas; ?>,
                      <?php echo $total_result_retenciones; ?>,
                      <?php echo $total_result_guia_remision; ?>,
                      <?php echo $total_notas_creditos; ?>,
                      <?php echo $total_result_notas_venta; ?>
                  ],
                  backgroundColor: [
                      '#007BFF',  // Azul
                      '#2ECC71',  // Verde Esmeralda
                      '#E74C3C',  // Rojo
                      '#8E44AD',  // Morado
                      '#E67E22'   // Naranja
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,
              legend: {
                  display: true,
                  position: 'right'
              }
          }
      });
      </script>
        <script>
            //Ventas totales facturas vs notas
      document.addEventListener('DOMContentLoaded', function() {
          // Datos de ventas (de PHP a JS)
          let ventasFacturas = <?php echo $compra_total; ?>;
          let ventasNotas = <?php echo $compra_total_notas; ?>;
          // Configuración de la gráfica
          let ctx = document.getElementById('ventasTotalesChart').getContext('2d');
          let ventasTotalesChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: ['Ventas de Facturas', 'Ventas de Notas'],
                  datasets: [{
                      label: 'Ventas totales en $',
                      data: [ventasFacturas, ventasNotas],
                      backgroundColor: [
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(255, 99, 132, 0.2)'
                      ],
                      borderColor: [
                          'rgba(75, 192, 192, 1)',
                          'rgba(255, 99, 132, 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });
      });
        </script>

          <script>
            //calendario parte 1
      $(document).ready(function() {
          var initialLocaleCode = 'es';
          var calendarEl = document.getElementById('calendar');
          var calendar = new FullCalendar.Calendar(calendarEl, {
              themeSystem: 'bootstrap', // Establece el sistema de temas a 'bootstrap'
              locale: initialLocaleCode,
              headerToolbar: {
                  left: 'prev,next today',
                  center: 'title',
                  right: ''
              }
          });
          calendar.render();
      });
        </script>
        <script type="text/javascript">
          //calendario parte 2
      $(document).ready(function() {
          var initialLocaleCode = 'es';
          var calendarEl = document.getElementById('calendar');

          var calendar = new FullCalendar.Calendar(calendarEl, {
              themeSystem: 'bootstrap',
              locale: initialLocaleCode,
              headerToolbar: {
                  left: 'prev,next today',
                  center: 'title',
                  right: ''
              },
              eventSources: [{
                  url: 'scripts/clicselldialy.php',
                  method: 'POST',
                  extraParams: {
                      fecha_analisis: 'all'
                  },
                  failure: function() {
                      alert('Hubo un error al obtener los eventos.');
                  },
                  color: '#007BFF',
                  textColor: '#000000'
              }]
          });

          calendar.render();
          $(document).on('click', '.fc-day', function() {
              var fecha_analisis = $(this).attr('data-date');
              $("#modalFecha").html(fecha_analisis);
              $('#miModal').modal();

              $.ajax({
                  type: "post",
                  url: 'scripts/clicselldialy.php',
                  data: {fecha_analisis: fecha_analisis },
                  success: function(response) {
                      if (response == 'error') {
                          $('.alert_general').html('<p class="alerta_negativa">Error al Editar el Contraseña</p>');
                      } else {
                          var info = JSON.parse(response);
                          $("#modalGanancias").html(info.total);
                          $("#factur_total_dia").html(info.total_facturas);
                          $("#nota_venta_tatal_dia").html(info.total_result_notas_venta);
                      }
                  }
              });
          });
      });
        </script>

        <script>
          $(function() {
              $(".connectedSortable").sortable({
                  connectWith: ".connectedSortable",
                  handle: ".card-header",
                  cancel: ".card-tools",
                  placeholder: "sortable-placeholder"
              }).disableSelection();
          });
      </script>


    </body>
</html>
