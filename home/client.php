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
    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:14 GMT -->
    <head>
        <title>Clientes</title>

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
    </head>

    <body>

     <?php
     require 'scripts/loader.php';


                  require 'scripts/iconos.php';


              ?>
                    <div class="pcoded-wrapper">
                        <div class="pcoded-content">
                            <div class="pcoded-inner-content">
                                <div class="main-body">
                                    <div class="page-wrapper">
                                        <div class="page-body m-t-50">
                                            <div class="row">

                                              <div class="page-body">
                                                  <div class="row">
                                                      <div class="">
                                                          <div class="card">

                                                              <div class="card-block">
                                                                  <div class="dt-responsive table-responsive">
                                                                      <table id="cbtn-selectors" class="table table-striped table-bordered nowrap">
                                                                          <thead>
                                                                              <tr>
                                                                                  <th>Código</th>
                                                                                  <th>Nombres</th>
                                                                                  <th>Identificación</th>
                                                                                  <th>Celular</th>
                                                                                  <th>Fecha Registro</th>
                                                                                  <th>Imagen</th>
                                                                                  <th>Acciones</th>
                                                                              </tr>
                                                                          </thead>
                                                                          <tbody>
                                                                            <?php

                                                                            $sql_registe = mysqli_query($conection,"SELECT COUNT(*) as  total_registro   FROM `clientes`
                                                                              WHERE clientes.iduser = '$iduser' AND clientes.estatus = '1'");
                                                                            $result_register = mysqli_fetch_array($sql_registe);
                                                                            $total_registro = $result_register['total_registro'];
                                                                            $por_pagina = 25;
                                                                            if (empty($_GET['pagina'])) {
                                                                              $pagina = 1;
                                                                            }else {
                                                                              $pagina = $_GET['pagina'];
                                                                            }
                                                                            $desde = ($pagina-1)*$por_pagina;
                                                                            $total_paginas = ceil($total_registro/$por_pagina);


                                                                           mysqli_query($conection,"SET lc_time_names = 'es_ES'");
                                                                            $query_lista = mysqli_query($conection,"SELECT clientes.id,DATE_FORMAT(clientes.fecha, '%W  %d de %b %Y %H:%i:%s') as 'fecha_f',clientes.foto,clientes.nombres,clientes.identificacion,
                                                                            clientes.celular
                                                                        FROM `clientes`
                                                                        WHERE clientes.iduser = '$iduser' AND clientes.estatus = '1'
                                                                        ORDER BY `clientes`.`fecha` DESC LIMIT $desde,$por_pagina");
                                                                                $result_lista= mysqli_num_rows($query_lista);
                                                                              if ($result_lista > 0) {
                                                                                    while ($data_lista=mysqli_fetch_array($query_lista)) {
                                                                                      $imagen =$data_lista['foto'];
                                                                             ?>
                                                                             <tr id="fila_cliente<?php echo $data_lista['id'];?>" >
                                                                               <td data-titulo="Código"><?php echo $data_lista['id'];?></td>
                                                                               <td data-titulo="Nombres"> <a href="perfil_cliente.php?cliente=<?php echo $data_lista['id'];?>"><?php echo $data_lista['nombres'];?> </a> </td>
                                                                               <td class="" data-titulo="Identificación"> <a href="perfil_cliente.php?cliente=<?php echo $data_lista['id'];?>"><?php echo $data_lista['identificacion'];?></a> </td>
                                                                               <td class="" data-titulo="Celular"> <?php echo $data_lista['celular'];?> </td>
                                                                               <td data-titulo="Fecha Registro"><?php echo mb_strtoupper($data_lista['fecha_f']); ?>  </td>
                                                                               <td data-titulo="Imagen"> <a href="perfil_cliente.php?cliente=<?php echo $data_lista['id'];?>"><img src="img/clientes/<?php echo $imagen ?>" width="55px" alt=""> </a> </td>
                                                                               <td data-titulo="Eliminar "> <button type="button" cliente ='<?php echo $data_lista['id'] ?>' class="btn btn-danger eliminar_cliente prut<?php echo $data_lista['id'];?>"  name="button">  <i class="fas fa-trash-alt"></i></button> </td>
                                                                             </tr>
                                                                                     <?php
                                                                                     }
                                                                                     }
                                                                                 ?>
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
                                    <div id="styleSelector"></div>
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

        <script src="files/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="files/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="files/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/dataTables.buttons.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/buttons.flash.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/jszip.min.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/vfs_fonts.js"></script>
        <script src="files/assets/pages/data-table/extensions/buttons/js/buttons.colVis.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="files/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="files/assets/pages/data-table/js/dataTables.bootstrap4.min.js"></script>
        <script src="files/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="files/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

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
        <script type="text/javascript" src="jquery_empresa/clientes.js"></script>

    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
