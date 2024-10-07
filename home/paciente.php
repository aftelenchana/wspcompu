<?php

ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();

      if (empty($_SESSION['active'])) {

        header('location:/');

      }else {

      }


       $paciente = $_GET['codigo'];

       $query_consulta = mysqli_query($conection, "SELECT * FROM clientes
          WHERE  clientes.estatus = '1' AND clientes.id = '$paciente' ");
        $data_paciente = mysqli_fetch_array($query_consulta);
        $nombres_paciente = $data_paciente['nombres'];
        $secuencial = $data_paciente['secuencial'];
        $foto = $data_paciente['foto'];
        $url_img_upload_paciente = $data_paciente['url_img_upload'];
        $identificacion_paciente = $data_paciente['identificacion'];
        $fecha_nacimient_pacienteo = $data_paciente['fecha_nacimiento'];
        $genero_paciente = $data_paciente['genero'];
        $historial_medico = $data_paciente['historial_medico'];
        $alergias_paciente = $data_paciente['alergias'];
        $celular_paciente = $data_paciente['celular'];
        $telefono_paciente = $data_paciente['telefono'];
        $mail_paciente = $data_paciente['mail'];
        $direccion_paciente = $data_paciente['direccion'];
        $historial_medico = $data_paciente['historial_medico'];
        $estado_civil = $data_paciente['estado_civil'];

        $genero  = $data_paciente['genero'];
        $latitud   = $data_paciente['latitud'];
        $longitud  = $data_paciente['longitud'];


        $fecha_nac = new DateTime($fecha_nacimient_pacienteo);
          // Crear un objeto DateTime para la fecha actual
          $fecha_actual = new DateTime();
          // Calcular la diferencia entre la fecha de nacimiento y la fecha actual
          $diferencia = $fecha_actual->diff($fecha_nac);

          // Obtener años y meses
          $anios = $diferencia->y;
          $meses = $diferencia->m;

          $edad_actual = $anios . ' años con ' . $meses . ' meses';



  ?>




<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Paciente <?php echo $nombres_paciente ?></title>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="#" />
        <meta name="keywords" content="Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app" />
        <meta name="author" content="#" />
        <link rel="icon" href="/img/guibis.png" type="image/x-icon" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/dist/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/icofont/css/icofont.css" />
        <link rel="stylesheet" type="text/css" href="files/assets/icon/feather/css/feather.css" />
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
        <link rel="stylesheet" href="https://guibis.com/home/estiloshome/load.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.5.1/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin="" />

    </head>

    <body>

     <?php
     require 'scripts/cabezera_general.php';
     ?>


     <div class="pcoded-content">
         <div class="pcoded-inner-content">
             <div class="main-body">
               <br>
                 <div class="page-wrapper">
                     <div class="page-header">
                         <div class="row align-items-end">
                             <div class="col-lg-8">
                                 <div class="page-header-title">
                                     <div class="d-inline">
                                         <h4>Perfil de <?php echo $nombres_paciente ?> </h4>
                                     </div>
                                 </div>
                             </div>

                         </div>
                     </div>

                     <div class="page-body">
                         <div class="row">
                             <div class="col-lg-12">
                                 <div class="cover-profile">
                                     <div class="profile-bg-img">
                                         <img class="profile-bg-img img-fluid" src="files/assets/images/user-profile/bg-img1.jpg" alt="bg-img" />
                                         <div class="card-block user-info">
                                             <div class="col-md-12">
                                                 <div class="media-left">
                                                     <a href="#" class="profile-image">
                                                         <img class="user-img img-radius" src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $foto ?>" alt="user-img" />
                                                     </a>
                                                 </div>
                                                 <style media="screen">
                                                 .profile-image img{
                                                   max-width: 200px;
                                                 }

                                                 </style>
                                                 <div class="media-body row">
                                                     <div class="col-lg-12">
                                                         <div class="user-title">
                                                             <h2><?php echo $nombres_paciente ?></h2>
                                                             <span class="text-white">Paciente <?php echo $secuencial ?></span>
                                                         </div>
                                                     </div>
                                                     <div>
                                                         <div class="pull-right cover-btn">
                                                             <button type="button" class="btn btn-primary"><i class="fab fa-whatsapp-square"></i>Enviar Mensaje </button>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                         </div>

                         <div class="row">
                             <div class="col-lg-12">
                                 <div class="tab-header card">
                                     <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                                         <li class="nav-item">
                                             <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Información Personal</a>
                                             <div class="slide"></div>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#binfo" role="tab">Historia Clínica</a>
                                             <div class="slide"></div>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#contacts" role="tab">Ubicación</a>
                                             <div class="slide"></div>
                                         </li>
                                     </ul>
                                 </div>

                                 <div class="tab-content">
                                     <div class="tab-pane active" id="personal" role="tabpanel">
                                         <div class="card">
                                             <div class="card-header">
                                                 <h5 class="card-header-text">Sobre <?php echo $nombres_paciente ?></h5>
                                                 <button id="edit-btn" type="button" class="btn btn-sm btn-primary waves-effect waves-light f-right">
                                                     <i class="icofont icofont-edit"></i>
                                                 </button>
                                             </div>
                                             <div class="card-block">
                                                 <div class="view-info">
                                                     <div class="row">
                                                         <div class="col-lg-12">
                                                             <div class="general-info">
                                                                 <div class="row">
                                                                     <div class="col-lg-12 col-xl-6">
                                                                         <div class="table-responsive">
                                                                             <table class="table m-0">
                                                                                 <tbody>


                                                                                     <tr>
                                                                                         <th scope="row">
                                                                                             Nombres y Apellidos
                                                                                         </th>
                                                                                         <td><?php echo $nombres_paciente ?></td>
                                                                                     </tr>
                                                                                     <tr>
                                                                                         <th scope="row">
                                                                                             Genero
                                                                                         </th>
                                                                                         <td><?php echo $genero ?></td>
                                                                                     </tr>
                                                                                     <tr>
                                                                                         <th scope="row">
                                                                                             Fecha de Nacimiento
                                                                                         </th>
                                                                                         <td><?php echo $fecha_nacimient_pacienteo ?></td>
                                                                                     </tr>
                                                                                     <tr>
                                                                                         <th scope="row">
                                                                                             Estado Civil
                                                                                         </th>
                                                                                         <td><?php echo $estado_civil ?></td>
                                                                                     </tr>
                                                                                     <tr>
                                                                                         <th scope="row">
                                                                                             Dirección
                                                                                         </th>
                                                                                         <td><?php echo $direccion_paciente ?></td>
                                                                                     </tr>
                                                                                 </tbody>
                                                                             </table>
                                                                         </div>
                                                                     </div>

                                                                     <div class="col-lg-12 col-xl-6">
                                                                         <div class="table-responsive">
                                                                             <table class="table">
                                                                                 <tbody>
                                                                                     <tr>
                                                                                         <th scope="row">
                                                                                             Email
                                                                                         </th>
                                                                                         <td>
                                                                                            <?php echo $mail_paciente ?>
                                                                                         </td>
                                                                                     </tr>
                                                                                     <tr>
                                                                                         <th scope="row">
                                                                                             Número Celular
                                                                                         </th>
                                                                                         <td><?php echo $celular_paciente ?></td>
                                                                                     </tr>
                                                                                     <tr>
                                                                                         <th scope="row">
                                                                                             Teléfono
                                                                                         </th>
                                                                                         <td><?php echo $telefono_paciente ?></td>
                                                                                     </tr>
                                                                                     <tr>
                                                                                         <th scope="row">
                                                                                             Edad
                                                                                         </th>
                                                                                         <td><?php echo $edad_actual ?> Años</td>
                                                                                     </tr>

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
                                         <div class="row">
                                             <div class="col-lg-12">
                                                 <div class="card">
                                                     <div class="card-header">
                                                         <h5 class="card-header-text">Descripción</h5>

                                                     </div>
                                                     <div class="card-block user-desc">
                                                         <div class="view-desc">
                                                             <p>
                                                  <?php echo $historial_medico ?>
                                                             </p>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="tab-pane" id="binfo" role="tabpanel">
                                       hola mundo

                                         <?php
                                         $query_lista = mysqli_query($conection, "SELECT consultas_medicas.id as 'codigo_consulta',clientes.foto as 'foto_paciente', clientes.url_img_upload as 'url_img_paciente',
                                           clientes.nombres as 'nombres_paciente',clientes.secuencial as 'historia_clinica',clientes.mail as 'mail_paciente',clientes.celular,
                                            DATE_FORMAT(consultas_medicas.fecha, '%W  %d de %b %Y %h:%m:%s') as 'fecha_ingreso',clientes.id as 'id_cliente',consultas_medicas.talla,consultas_medicas.peso,
                                            consultas_medicas.presion_arterial,consultas_medicas.motivo_admision,consultas_medicas.diagnostico,consultas_medicas.recomendaciones,consultas_medicas.observaciones,
                                            consultas_medicas.qr_img,consultas_medicas.url_qr,consultas_medicas.video,consultas_medicas.url_video
                                             FROM consultas_medicas
                                           INNER JOIN clientes ON clientes.id = consultas_medicas.paciente
                                            WHERE consultas_medicas.iduser ='$iduser'  AND consultas_medicas.estatus = '1'
                                         ORDER BY `consultas_medicas`.`fecha` DESC ");

                                         $result_lista= mysqli_num_rows($query_lista);
                                       if ($result_lista > 0) {
                                             while ($data_lista=mysqli_fetch_array($query_lista)) {
                                               $video = $data_lista['video'];
                                               $url_video = $data_lista['url_video'];
                                               $codigo_consulta = $data_lista['codigo_consulta'];

                                          ?>
                                         <div class="row">
                                             <div class="col-lg-12">
                                                 <div class="card">
                                                     <div class="card-header">
                                                         <h5 class="card-header-text"><?php echo $data_lista['fecha_ingreso'] ?>-<?php echo $data_lista['codigo_consulta'] ?></h5>
                                                     </div>
                                                     <div class="card-block">
                                                       <div class="consulta-info">
                                                              <div class="consulta-detalle">
                                                                  <h6>Detalles del Paciente:</h6>
                                                                  <p><strong>Nombre:</strong> <?php echo $data_lista['nombres_paciente']; ?></p>
                                                                  <!-- Más detalles del paciente -->
                                                              </div>
                                                              <div class="consulta-medica">
                                                                  <h6>Información de la Consulta:</h6>
                                                                  <p><strong>Talla:</strong> <?php echo $data_lista['talla']; ?></p>
                                                                  <p><strong>Peso:</strong> <?php echo $data_lista['peso']; ?></p>
                                                                  <p><strong>Presión Arterial:</strong> <?php echo $data_lista['presion_arterial']; ?></p>
                                                                  <p><strong>Motivo de Admisión:</strong><?php echo $data_lista['motivo_admision']; ?></p>
                                                                  <p><strong>Diagnóstico:</strong> <?php echo $data_lista['diagnostico']; ?></p>
                                                                  <p><strong>Recomendaciones:</strong> <?php echo $data_lista['recomendaciones']; ?></p>
                                                                  <p><strong>Observaciones:</strong> <?php echo $data_lista['observaciones']; ?></p>
                                                                  <!-- Más información de la consulta -->
                                                              </div>
                                                              <!-- Otras secciones como videos, imágenes, etc. -->

                                                              <!-- Sección de Imágenes -->

                                                              <?php $query_imagenes = mysqli_query($conection,"SELECT * FROM img_consultas WHERE idconsulta = '$codigo_consulta'");
                                                                   $result_imagenes= mysqli_num_rows($query_imagenes);

                                                              ?>
                                                                <?php if ($result_imagenes>1): ?>

                                                              <div class="consulta-imagenes">
                                                                  <h6>Imágenes de la Consulta:</h6>
                                                                  <div class="imagenes-container">




                                                                <?php
                                                                $img0= 0;
                                                                while ($data_lista_img=mysqli_fetch_array($query_imagenes)) {
                                                                  $img0 =$img0+ 1;
                                                                 ?>
                                                                 <img src="<?php echo $data_lista_img['url']; ?>/home/img/uploads/<?php echo $data_lista_img['img']; ?>" alt="Imagen de Consulta">
                                                              <?php
                                                                  }
                                                               ?>
                                                             </div>
                                                         </div>

                                                              <?php endif; ?>



                                                                <?php if (!empty($data_lista['url_video'])): ?>
                                                                  <!-- Sección de Videos -->
                                                                  <div class="consulta-videos">
                                                                      <h6>Videos de la Consulta:</h6>
                                                                      <div class="videos-container">

                                                                              <video controls>
                                                                                  <source src="<?php echo $url_video ?>/home/img/videos/<?php echo $video ?>" type="video/mp4">
                                                                                  Tu navegador no soporta videos.
                                                                              </video>

                                                                      </div>
                                                                  </div>

                                                                <?php endif; ?>


                                                          </div>
                                                     </div>
                                                 </div>
                                             </div>
                                         </div>
                                         <?php
                                         }
                                         }
                                     ?>
                                     </div>

                                     <style media="screen">
                                     .consulta-info {
                                          display: grid;
                                          grid-template-columns: 1fr 1fr;
                                          gap: 20px;
                                        }

                                        .consulta-info > div {
                                          background-color: #f9f9f9;
                                          padding: 15px;
                                          border-radius: 5px;
                                          box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                                        }

                                        .consulta-info h6 {
                                          color: #333;
                                          font-size: 1.1em;
                                          margin-bottom: 10px;
                                        }

                                        .consulta-info p {
                                          color: #555;
                                          line-height: 1.5;
                                        }

                                        /* Estilos existentes */

                                        /* Sección de Imágenes */
                                        .consulta-imagenes h6,
                                        .consulta-videos h6 {
                                            margin-top: 20px;
                                            color: #333;
                                            font-size: 1.1em;
                                        }

                                        .imagenes-container img,
                                        .videos-container video {
                                            max-width: 100%;
                                            height: auto;
                                            border-radius: 5px;
                                            margin-bottom: 10px;
                                            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
                                        }

                                        /* Sección de Videos */
                                        .videos-container video {
                                            width: 100%; /* Ajusta el ancho del contenedor */
                                            margin-bottom: 20px;
                                        }


                                     </style>

                                     <div class="tab-pane" id="contacts" role="tabpanel">
                                         <div class="row">

                                           <div class="mapa_vizualizar" style="padding: 10px;margin: 15px;">
                                               <div id="myMap" style="height:200px"></div>

                                           </div>

                                         </div>
                                     </div>

                                     <div class="tab-pane" id="review" role="tabpanel">
                                         <div class="card">
                                             <div class="card-header">
                                                 <h5 class="card-header-text">Review</h5>
                                             </div>
                                             <div class="card-block">
                                                 <ul class="media-list">
                                                     <li class="media">
                                                         <div class="media-left">
                                                             <a href="#">
                                                                 <img class="media-object img-radius comment-img" src="../files/assets/images/avatar-1.jpg" alt="Generic placeholder image" />
                                                             </a>
                                                         </div>
                                                         <div class="media-body">
                                                             <h6 class="media-heading">Sortino media<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                             <div class="stars-example-css review-star">
                                                                 <i class="icofont icofont-star"></i>
                                                                 <i class="icofont icofont-star"></i>
                                                                 <i class="icofont icofont-star"></i>
                                                                 <i class="icofont icofont-star"></i>
                                                                 <i class="icofont icofont-star"></i>
                                                             </div>
                                                             <p class="m-b-0">
                                                                 Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus
                                                                 viverra turpis.
                                                             </p>
                                                             <div class="m-b-25">
                                                                 <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                             </div>
                                                             <hr />

                                                             <div class="media mt-2">
                                                                 <a class="media-left" href="#">
                                                                     <img class="media-object img-radius comment-img" src="../files/assets/images/avatar-2.jpg" alt="Generic placeholder image" />
                                                                 </a>
                                                                 <div class="media-body">
                                                                     <h6 class="media-heading">Larry heading <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                     <div class="stars-example-css review-star">
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                     </div>
                                                                     <p class="m-b-0">
                                                                         Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at,
                                                                         tempus viverra turpis.
                                                                     </p>
                                                                     <div class="m-b-25">
                                                                         <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                     </div>
                                                                     <hr />

                                                                     <div class="media mt-2">
                                                                         <div class="media-left">
                                                                             <a href="#">
                                                                                 <img class="media-object img-radius comment-img" src="../files/assets/images/avatar-3.jpg" alt="Generic placeholder image" />
                                                                             </a>
                                                                         </div>
                                                                         <div class="media-body">
                                                                             <h6 class="media-heading">Colleen Hurst <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                             <div class="stars-example-css review-star">
                                                                                 <i class="icofont icofont-star"></i>
                                                                                 <i class="icofont icofont-star"></i>
                                                                                 <i class="icofont icofont-star"></i>
                                                                                 <i class="icofont icofont-star"></i>
                                                                                 <i class="icofont icofont-star"></i>
                                                                             </div>
                                                                             <p class="m-b-0">
                                                                                 Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate
                                                                                 at, tempus viverra turpis.
                                                                             </p>
                                                                             <div class="m-b-25">
                                                                                 <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                             </div>
                                                                         </div>
                                                                         <hr />
                                                                     </div>
                                                                 </div>
                                                             </div>

                                                             <div class="media mt-2">
                                                                 <div class="media-left">
                                                                     <a href="#">
                                                                         <img class="media-object img-radius comment-img" src="../files/assets/images/avatar-1.jpg" alt="Generic placeholder image" />
                                                                     </a>
                                                                 </div>
                                                                 <div class="media-body">
                                                                     <h6 class="media-heading">Cedric Kelly<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                     <div class="stars-example-css review-star">
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                     </div>
                                                                     <p class="m-b-0">
                                                                         Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at,
                                                                         tempus viverra turpis.
                                                                     </p>
                                                                     <div class="m-b-25">
                                                                         <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                     </div>
                                                                     <hr />
                                                                 </div>
                                                             </div>
                                                             <div class="media mt-2">
                                                                 <a class="media-left" href="#">
                                                                     <img class="media-object img-radius comment-img" src="../files/assets/images/avatar-4.jpg" alt="Generic placeholder image" />
                                                                 </a>
                                                                 <div class="media-body">
                                                                     <h6 class="media-heading">Larry heading <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                     <div class="stars-example-css review-star">
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                     </div>
                                                                     <p class="m-b-0">
                                                                         Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at,
                                                                         tempus viverra turpis.
                                                                     </p>
                                                                     <div class="m-b-25">
                                                                         <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                     </div>
                                                                     <hr />

                                                                     <div class="media mt-2">
                                                                         <div class="media-left">
                                                                             <a href="#">
                                                                                 <img class="media-object img-radius comment-img" src="../files/assets/images/avatar-3.jpg" alt="Generic placeholder image" />
                                                                             </a>
                                                                         </div>
                                                                         <div class="media-body">
                                                                             <h6 class="media-heading">Colleen Hurst <span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                             <div class="stars-example-css review-star">
                                                                                 <i class="icofont icofont-star"></i>
                                                                                 <i class="icofont icofont-star"></i>
                                                                                 <i class="icofont icofont-star"></i>
                                                                                 <i class="icofont icofont-star"></i>
                                                                                 <i class="icofont icofont-star"></i>
                                                                             </div>
                                                                             <p class="m-b-0">
                                                                                 Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate
                                                                                 at, tempus viverra turpis.
                                                                             </p>
                                                                             <div class="m-b-25">
                                                                                 <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                             </div>
                                                                         </div>
                                                                         <hr />
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                             <div class="media mt-2">
                                                                 <div class="media-left">
                                                                     <a href="#">
                                                                         <img class="media-object img-radius comment-img" src="../files/assets/images/avatar-2.jpg" alt="Generic placeholder image" />
                                                                     </a>
                                                                 </div>
                                                                 <div class="media-body">
                                                                     <h6 class="media-heading">Mark Doe<span class="f-12 text-muted m-l-5">Just now</span></h6>
                                                                     <div class="stars-example-css review-star">
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                         <i class="icofont icofont-star"></i>
                                                                     </div>
                                                                     <p class="m-b-0">
                                                                         Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at,
                                                                         tempus viverra turpis.
                                                                     </p>
                                                                     <div class="m-b-25">
                                                                         <span><a href="#!" class="m-r-10 f-12">Reply</a></span><span><a href="#!" class="f-12">Edit</a> </span>
                                                                     </div>
                                                                     <hr />
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </li>
                                                 </ul>
                                                 <div class="input-group">
                                                     <input type="text" class="form-control" placeholder="Right addon" />
                                                     <div class="input-group-append">
                                                         <span class="input-group-text"><i class="icofont icofont-send-mail"></i></span>
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

             <div id="styleSelector"></div>
         </div>
     </div>








                </div>
            </div>
        </div>


        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <!-- Contenido del modal -->
              <div class="modal-body text-center">
                <div class="circle-icon">
                  <i class="fas fa-exclamation-triangle text-danger" style="font-size: 72px;"></i>
                </div>
                <p style="font-size: 24px;">Se produjo un error en el servidor. Intente nuevamente más tarde.</p>
              </div>
              <!-- Pie del modal -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
              </div>
            </div>
          </div>
        </div>

        <div class="modal fade" id="error_general" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <!-- Contenido del modal -->
              <div class="modal-body text-center">
                <div class="circle-icon">
                  <i class="fas fa-exclamation-triangle text-danger" style="font-size: 72px;"></i>
                </div>
                <p style="font-size: 24px;" class="mensaje_error_general">.</p>
              </div>
              <!-- Pie del modal -->
              <div class="modal-footer">
                <button type="button" class="btn btn-danger mobtn" data-dismiss="modal">Cerrar <i class="fas fa-times-circle"></i></button>
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
        <script src="https://unpkg.com/leaflet@1.5.1/dist/leaflet.js"
         integrity="sha512-GffPMF3RvMeYyc1LWMHtK8EbPv0iNZ8/oTtHPx9/cc2ILxQ+u905qIwdpULaqDkyBKgOaB57QTMg7ztg8Jm2Og=="
         crossorigin=""></script>
        <script src="jquery_empresa/proveedor.js"></script>
        <script type="text/javascript" src="jquery_empresa/clientes.js"></script>
        <script src="area_facturacion/busqueda_secuencia.js"></script>
        <script type="text/javascript">
            let myMap = L.map('myMap').setView([<?php echo $latitud ?>, <?php echo $longitud ?>], 13);

            L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(myMap);

            function updateMap(latitude, longitude) {
                myMap.panTo(new L.LatLng(latitude, longitude));
                L.marker([latitude, longitude]).addTo(myMap);
            }

            updateMap(<?php echo $latitud ?>, <?php echo $longitud ?>);
        </script>




    </body>

    <!-- Mirrored from demo.dashboardpack.com/adminty-html/default/menu-horizontal-static.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Sep 2023 12:44:18 GMT -->
</html>
