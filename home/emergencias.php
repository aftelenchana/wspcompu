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
        <title>Emergencias</title>

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
        <link rel="stylesheet" href="https://guibis.com/home/estilos/guibis.css?v=2">
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">


    </head>

    <body>

     <?php
     require 'scripts/cabezera_general.php';

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
                                                  <h5>Emergencias </h5>
                                              </div>
                                              <div class="card-block">
                                                <div class="dt-responsive table-responsive">
                                                  <table id="tabla_facturas_emergencias" class="table table-striped table-bordered nowrap">
                                                      <thead>
                                                          <tr>
                                                              <th>Código</th>
                                                              <th>Estado</th>
                                                              <th>Nombres</th>
                                                              <th>Celular</th>
                                                              <th>Email</th>
                                                              <th>Mensaje</th>
                                                              <th>Mapa</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                        <?php
                                                        $query_lista = mysqli_query($conection," SELECT *
                                                           FROM emergencias

                                                    ORDER BY `emergencias`.`fecha` desc");
                                                            $result_lista= mysqli_num_rows($query_lista);
                                                          if ($result_lista > 0) {
                                                                while ($data_lista=mysqli_fetch_array($query_lista)) {
                                                         ?>
                                                         <tr>
                                                           <td> <?php echo $data_lista['id'] ?>  </td>
                                                           <td> <?php echo $data_lista['estado'] ?>  </td>
                                                           <td> <?php echo $data_lista['nombres'] ?>  </td>
                                                           <td> <?php echo $data_lista['celular'] ?>  </td>
                                                           <td> <?php echo $data_lista['email'] ?>  </td>
                                                           <td> <?php echo $data_lista['mensaje'] ?>  </td>
                                                           <td>
                                                             <?php if (!empty($data_lista['latitud'])): ?>
                                                               <a href="mapa_trayectoria_emergencia?codigo=<?php echo $data_lista['id'] ?>" class="btn btn-primary">
                                                                   <i class="fas fa-map-marker-alt"></i> Vizualizar Mapa
                                                               </a>

                                                             <?php endif; ?>
                                                           </td>

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
        <script type="text/javascript" src="medico/enfermedades.js?v=2"></script>
        <script type="text/javascript">
        $(document).ready(function() {
          $('#tabla_facturas_emergencias').DataTable({
              "dom": 'Bfrtip',
              "buttons": [
                  'copy', 'csv', 'excel', 'pdf', 'print'
              ],
              "language": {
                  "url": "/home/guibis/data-table.json"
              },
              "order": [],
              "destroy": true
          });
        });

        </script>

    </body>
</html>
