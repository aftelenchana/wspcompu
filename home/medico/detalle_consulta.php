<?php
 require 'QR/phpqrcode/qrlib.php';
ob_start();

include "../coneccion.php";

  mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();

      if (empty($_SESSION['active'])) {

        header('location:/');

      }

       $codigo_unico = $_GET['codigo'];

       $query_verificador_consulta = mysqli_query($conection,"SELECT *
    FROM `consultas_medicas`
    WHERE consultas_medicas.estatus = '1' AND consultas_medicas.codigo_unico = '$codigo_unico' ");




          $data_consulta =mysqli_fetch_array($query_verificador_consulta);
          $paciente = $data_consulta['paciente'];

       $query_paciente = mysqli_query($conection, "SELECT * FROM clientes
          WHERE  clientes.estatus = '1' AND clientes.id = '$paciente' ");
        $data_paciente = mysqli_fetch_array($query_paciente);
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
        $fecha_nacimiento  = $data_paciente['fecha_nacimiento'];
        $fecha_nacimiento_obj = new DateTime($fecha_nacimiento);
        $fecha_actual = new DateTime();
        $diferencia = $fecha_actual->diff($fecha_nacimiento_obj);
        $edad = $diferencia->y;

        //



  ?>




<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Consulta  <?php echo $nombres_paciente ?></title>

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
        <link rel="stylesheet" href="https://guibis.com/home/estilos/guibis.css?v=2">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet">

    </head>

    <body>

     <?php
     require 'scripts/cabezera_general.php';
      //CODIGO PARA GENERAR EL QR Y ADEMAS INSERTAR SI ES QUE NO ESTA EN LA TABLA , EL CODIGO UNICO E INICIAR LA CONSULTA

      //PRIMERO verificamos si es que esta en la base de datos o no para luego GENERAr EL CODIGO UNICO
       $query_verificador_consulta = mysqli_query($conection,"SELECT *
    FROM `consultas_medicas`
    WHERE consultas_medicas.iduser = '$iduser' AND consultas_medicas.estatus = '1' AND consultas_medicas.paciente = '$paciente'
    AND consultas_medicas.codigo_unico = '$codigo_unico'  ");

    $result_consulta= mysqli_num_rows($query_verificador_consulta);


      $data_consulta =mysqli_fetch_array($query_verificador_consulta);
      $estado = $data_consulta['estado'];

      if ($estado == 'FINALIZADO') {
        $estado_habilitacion = 'disabled';
      }else {
        $estado_habilitacion = '';
      }


      $url_qr = $data_consulta['url_qr'];
      $qr_img = $data_consulta['qr_img'];
      $fecha_inicio  = $data_consulta['fecha'];
      $filename = $url_qr.'/home/img/qr/'.$qr_img;

      $temperatura = $data_consulta['temperatura'];
      $peso = $data_consulta['peso'];
      $talla = $data_consulta['talla'];
      $imc = $data_consulta['imc'];
      $presion_arterial = $data_consulta['presion_arterial'];
      $pulso = $data_consulta['pulso'];
      $frecuencia_respiratoria = $data_consulta['frecuencia_respiratoria'];
      $saturacion_oxigeno = $data_consulta['saturacion_oxigeno'];
      $perimetro_cefalico = $data_consulta['perimetro_cefalico'];
      $perimetro_toracico = $data_consulta['perimetro_toracico'];
      $perimetro_abdominal = $data_consulta['perimetro_abdominal'];
      $perimetro_inguinal = $data_consulta['perimetro_inguinal'];

      $idantro        = $data_consulta['idantro'];
      $rolantro       = $data_consulta['rolantro'];
      $idantecedentes = $data_consulta['idantecedentes'];
      $rolantecedentes= $data_consulta['rolantecedentes'];
      $idanam         = $data_consulta['idanam'];
      $rolanam        = $data_consulta['rolanam'];
      $idreceta       = $data_consulta['idreceta'];
      $rolreceta      = $data_consulta['rolreceta'];
      $iddocumento    = $data_consulta['iddocumento'];
      $roldocumento   = $data_consulta['roldocumento'];


      function informacion_recursos_humanos_accionado($usuario, $rol, $conection) {
          if (!empty($usuario)) {
              if ($rol == 'cuenta_empresa') {
                  $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE id = $usuario");
              } else {
                  $query = mysqli_query($conection, "SELECT * FROM recursos_humanos WHERE id = $usuario");
              }

              if ($result = mysqli_fetch_array($query)) {
                  $nombres = $result['nombres'];
                  $apellidos = isset($result['apellidos']) ? $result['apellidos'] : '';
                  return $nombres . ' ' . $apellidos . '-' . $rol;
              } else {
                  return 'No se ha encontrado información';
              }
          } else {
              return 'No se ha asignado responsabilidad';
          }
      }


      // Uso de la función para los diferentes campos
    $responsable_antropometria = informacion_recursos_humanos_accionado($idantro, $rolantro, $conection);
    $responsable_antecedentes = informacion_recursos_humanos_accionado($idantecedentes, $rolantecedentes, $conection);
    $responsable_anamnesis = informacion_recursos_humanos_accionado($idanam, $rolanam, $conection);
    $responsable_receta = informacion_recursos_humanos_accionado($idreceta, $rolreceta, $conection);
    $responsable_documento = informacion_recursos_humanos_accionado($iddocumento, $roldocumento, $conection);
      //Anamnesis
      function convertToChecked($value) {
          return ($value === 'on') ? 'checked' : '';
      }

     ?>

     <style media="screen">
       .informacion_responsabilidad{
         padding: 3px;
         margin: 3px;
         font-weight: bold;
       }
     </style>


     <div class="pcoded-content">
         <div class="pcoded-inner-content">
             <div class="main-body">
               <br>
                 <div class="page-wrapper" style="padding: 0px;">

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
                                                             <span class="text-white">Paciente <?php echo $secuencial ?> <?php echo $estado ?> - <?php echo $fecha_inicio ?></span>
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
                                             <a class="nav-link active" data-toggle="tab" href="#personal" role="tab">Signos Vitales/Antropometría</a>
                                             <div class="slide"></div>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#review" role="tab">Antecedentes</a>
                                             <div class="slide"></div>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#binfo" role="tab">Anamnesis</a>
                                             <div class="slide"></div>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#contacts" role="tab">Receta</a>
                                             <div class="slide"></div>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#documento_medico" role="tab">Documento</a>
                                             <div class="slide"></div>
                                         </li>
                                         <li class="nav-item">
                                             <a class="nav-link" data-toggle="tab" href="#compartir_consulta" role="tab">Compartir Consulta</a>
                                             <div class="slide"></div>
                                         </li>

                                     </ul>
                                 </div>

                                 <div class="tab-content">


                                   <div class="tab-pane" id="compartir_consulta" role="tabpanel">
                                     <div class="card">
                                         <div class="card-block">
                                           <style media="screen">
                                             .qr_img_consulta{
                                               text-align: center;
                                             }
                                           </style>

                                           <div class="qr_img_consulta">
                                             <img src="<?php echo $filename ?>" alt="">
                                           </div>
                                         </div>
                                     </div>
                                   </div>



                                     <div class="tab-pane active" id="personal" role="tabpanel">
                                       <div class="card">
                                           <div class="card-block">
                                             <form method="post" name="antropometria" id="antropometria" onsubmit="event.preventDefault(); sendData_antropometria();">

                                               <div class="row">
                                                 <div class="col">
                                                   <div class="mb-3">
                                                     <label class="label-guibis-sm">Nombre del Paciente</label>
                                                     <input type="text" maxlength="120" name="nombre_paciente" class="form-control input-guibis-sm" readonly id="nombre_paciente" value="<?php echo $nombres_paciente ?>" placeholder="Nombre del Paciente">
                                                   </div>
                                                 </div>
                                                 <div class="col">
                                                   <div class="mb-3">
                                                     <label class="label-guibis-sm">Historia Clínica</label>
                                                     <input type="text" maxlength="120" name="secuencial" class="form-control input-guibis-sm" readonly id="secuencial" value="<?php echo $secuencial ?>" placeholder="Secuencial">
                                                   </div>
                                                 </div>
                                                 <div class="col">
                                                   <div class="mb-3">
                                                     <label class="label-guibis-sm">Edad</label>
                                                     <input type="text"  name="edad" class="form-control input-guibis-sm" readonly id="edad" value="<?php echo $edad ?>" placeholder="Edad">
                                                   </div>
                                                 </div>
                                               </div>

                                               <div class="row">
                                                 <div class="col">
                                                   <div class="mb-3">
                                                       <label class="label-guibis-sm">Temperatura(T) °C</label>
                                                       <input type="number" step="0.01" name="temperatura" value="<?php echo $temperatura ?>" class="form-control input-guibis-sm"  id="temperatura" placeholder="Temperatura Paciente" oninput="calcularTemperatura()">
                                                   </div>
                                                 </div>
                                                 <div class="col">
                                                      <div id="temp-alert"></div>
                                                 </div>
                                               </div>


                                               <div class="row">
                                                 <div class="col">
                                                   <div class="mb-3">
                                                        <label class="label-guibis-sm">Peso (kg)</label>
                                                        <input type="text"  value="<?php echo $peso ?>" name="peso" class="form-control input-guibis-sm" id="peso" placeholder="Peso del Paciente" oninput="calcularIMC()">
                                                    </div>
                                                 </div>
                                                 <div class="col">
                                                   <div class="mb-3">
                                                       <label class="label-guibis-sm">Talla (cm)</label>
                                                       <input type="text" value="<?php echo $talla ?>" name="talla" class="form-control input-guibis-sm" id="talla" placeholder="Talla del Paciente" oninput="calcularIMC()">
                                                   </div>
                                                 </div>
                                               </div>
                                               <div class="row">
                                                 <div class="col">
                                                   <div class="mb-3">
                                                       <label class="label-guibis-sm">IMC (kg/m²)</label>
                                                       <input type="text" value="<?php echo $imc ?>" name="imc" class="form-control input-guibis-sm" id="imc" placeholder="Índice de Masa Corporal" readonly>
                                                   </div>

                                                 </div>
                                                 <div class="col">
                                                    <div id="imc-alert" class="mt-3"></div>
                                                 </div>
                                               </div>
                                               <div class="row">
                                                 <div class="col">
                                                   <div class="mb-3">
                                                      <label class="label-guibis-sm">Tensión Arterial (mmHg)</label>
                                                      <input type="text" <?php echo $presion_arterial ?> name="presion_arterial" class="form-control input-guibis-sm" id="presion_arterial" placeholder="Presión Arterial" oninput="calcularPresionArterial()">
                                                  </div>

                                                 </div>
                                                 <div class="col">
                                                        <div id="presion-alert"></div>
                                                 </div>
                                               </div>

                                                <div class="row">
                                                  <div class="col">
                                                    <div class="mb-3">
                                                        <label class="label-guibis-sm">Pulso</label>
                                                        <input type="text" value="<?php echo $pulso ?>" name="pulso" class="form-control input-guibis-sm" id="pulso" placeholder="Pulso" oninput="calcularPulso()">
                                                    </div>
                                                  </div>
                                                  <div class="col">
                                                    <div id="pulso-alert"></div>
                                                  </div>
                                                </div>
                                                <div class="row">
                                                  <div class="col">
                                                    <div class="mb-3">
                                                        <label class="label-guibis-sm">Frecuencia Respiratoria</label>
                                                        <input type="text" <?php echo $frecuencia_respiratoria ?> name="frecuencia_respiratoria" class="form-control input-guibis-sm" id="frecuencia_respiratoria" placeholder="Frecuencia Respiratoria" oninput="calcularFrecuenciaRespiratoria()">
                                                    </div>
                                                  </div>
                                                  <div class="col">
                                                    <div id="frecuencia-alert"></div>
                                                  </div>
                                                </div>

                                                <div class="row">
                                                  <div class="col">
                                                    <div class="mb-3">
                                                        <label class="label-guibis-sm">Saturación de Oxígeno</label>
                                                        <input type="text" value="<?php echo $saturacion_oxigeno ?>" name="saturacion_oxigeno" class="form-control input-guibis-sm" id="saturacion_oxigeno" placeholder="Saturación de Oxígeno" oninput="calcularSaturacionOxigeno()">
                                                    </div>
                                                  </div>
                                                  <div class="col">
                                                    <div id="saturacion-alert"></div>
                                                  </div>
                                                </div>

                                               <div class="mb-3">
                                                 <label class="label-guibis-sm">Perímetro Cefálico</label>
                                                 <textarea class="form-control input-guibis-sm" name="perimetro_cefalico" id="motivo_admision" rows="3"> <?php echo $perimetro_cefalico ?></textarea>
                                               </div>
                                               <div class="mb-3">
                                                 <label for="descripcion" class="form-label">Périmetro Torácico</label>
                                                 <textarea class="form-control input-guibis-sm"   name="perimetro_toracico" id="diagnostico" rows="3"><?php echo $perimetro_toracico ?></textarea>
                                               </div>

                                               <div class="mb-3">
                                                 <label for="descripcion" class="form-label">Périmetro Abdominal</label>
                                                 <textarea class="form-control input-guibis-sm"   name="perimetro_abdominal" id="diagnostico" rows="3"><?php echo $perimetro_abdominal ?></textarea>
                                               </div>

                                               <div class="mb-3">
                                                 <label class="label-guibis-sm">Périmetro Inguinal</label>
                                                 <textarea class="form-control input-guibis-sm"  name="perimetro_inguinal" id="recomendaciones" rows="3"><?php echo $perimetro_inguinal ?></textarea>
                                               </div>


                                               <div class="mb-3">
                                                 <label class="label-guibis-sm">Agregue Imagenes</label>
                                                 <input type="file" class="form-control input-guibis-sm" name="lista[]"  multiple id="lista"  accept="image/png, .jpeg, .jpg" >
                                               </div>

                                               <style media="screen">
                                                 #miniaturas_productos img{
                                                   width: 10%;
                                                   display: inline-block;

                                                 }
                                               </style>

                                               <div class="row">
                                                  <span class="conte_img_pr" id="salida_imagenes_contenedor">
                                                    <output id="miniaturas_productos"></output>
                                                   </span>
                                                </div>


                                                <div class="mb-3">
                                                  <label class="label-guibis-sm">Subir Video</label>
                                                  <div class="input-group mb-3">
                                                      <div class="input-group-prepend">
                                                          <span class="input-group-text">Subir Video</span>
                                                      </div>
                                                      <div class="custom-file">
                                                          <input type="file" class="custom-file-input" accept="video/*" name="video_explicativo" id="inputGroupFile01">
                                                          <label class="custom-file-label" for="inputGroupFile01">Agregar Video</label>
                                                      </div>
                                                  </div>
                                              </div>

                                                 <div class="contenedor_boton_enviar">
                                                   <button type="submit" <?php echo $estado_habilitacion ?> class="btn btn-primary">Enviar Antropometría <i class="fas fa-plus"></i></button>

                                                 </div>
                                                 <style media="screen">
                                                   .contenedor_boton_enviar{
                                                     text-align: center;
                                                   }
                                                 </style>
                                                   <input type="hidden" name="action" value="antropometria">
                                                   <input type="hidden" name="paciente" id="paciente" value="<?php echo $paciente ?>">
                                                   <input type="hidden" name="codigo_unico" value="<?php echo $codigo_unico ?>">

                                                 <div class="alerta_antropometria"></div>
                                               </form>
                                           </div>
                                           <p class="informacion_responsabilidad" ><?php echo $responsable_antropometria  ?></p>
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
                                       <div class="card">
                                           <div class="card-block">
                                             <form method="post" name="anammesis_alex" id="anammesis_alex" onsubmit="event.preventDefault(); sendData_anammesis_alex();">
                                               <div class="row">
                                                 <?php
                                                 $motivo_consultar = $data_consulta['motivo_consultar'];
                                                 $problema_actual = $data_consulta['problema_actual'];
                                                 $antecedentes_personal_txt = $data_consulta['antecedentes_personal_txt'];
                                                 $antecedentes_familiares_text = $data_consulta['antecedentes_familiares_text'];
                                                 $revision_organos_sistemas = $data_consulta['revision_organos_sistemas'];
                                                 $examen_fisico_regional = $data_consulta['examen_fisico_regional'];

                                                  ?>
                                                 <div class="col">
                                                   <div class="mb-3">
                                                     <label for="descripcion" class="form-label">Motivo de la Consultar</label>
                                                     <textarea class="form-control input-guibis-sm"  name="motivo_consultar" id="motivo_consultar" rows="8"><?php echo $motivo_consultar ?></textarea>
                                                   </div>

                                                   <div class="mb-3">
                                                     <label class="label-guibis-sm">Enfermedad:Problema Actual</label>
                                                     <textarea class="form-control input-guibis-sm"   name="problema_actual" id="problema_actual" rows="6"><?php echo $problema_actual ?></textarea>
                                                   </div>
                                                 </div>
                                                 <div class="col">

                                                   <div class="mb-3">
                                                     <label class="label-guibis-sm">Antecedentes Personal</label>
                                                     <textarea class="form-control input-guibis-sm"  name="antecedentes_personal_txt" id="antecedentes_personal_txt" rows="8"><?php echo $antecedentes_personal_txt ?></textarea>
                                                   </div>

                                                   <div class="mb-3">
                                                     <label class="label-guibis-sm">Antecedentes Familiar</label>
                                                     <textarea class="form-control input-guibis-sm"  name="antecedentes_familiares_text" id="antecedentes_familiares_text" rows="6"> <?php echo $antecedentes_personal_txt ?></textarea>
                                                   </div>

                                                 </div>
                                                 <div class="col">
                                                   <div class="mb-3">
                                                     <label class="label-guibis-sm">Revisión de Organos y Sistemas</label>
                                                     <textarea class="form-control input-guibis-sm"   name="revision_organos_sistemas" id="revision_organos_sistemas" rows="10"><?php echo $revision_organos_sistemas ?></textarea>
                                                   </div>

                                                   <div class="mb-3">
                                                     <label class="label-guibis-sm">Examen Físico Regional</label>
                                                     <textarea class="form-control input-guibis-sm"   name="examen_fisico_regional" id="examen_fisico_regional" rows="10"><?php echo $examen_fisico_regional ?></textarea>
                                                   </div>

                                                 </div>
                                               </div>

                                                 <div class="contenedor_boton_enviar">
                                                   <button type="submit" <?php echo $estado_habilitacion ?> class="btn btn-primary">Agregar Anamnesis <i class="fas fa-plus"></i></button>

                                                 </div>

                                                   <input type="hidden" name="action" value="ingreso_anamnesis">
                                                   <input type="hidden" name="paciente" id="paciente" value="<?php echo $paciente ?>">
                                                   <input type="hidden" name="codigo_unico" id="codigo_unico" value="<?php echo $codigo_unico ?>">

                                                 <div class="alerta_anamesis"></div>
                                               </form>
                                           </div>
                                           <p class="informacion_responsabilidad" ><?php echo $responsable_anamnesis   ?></p>
                                       </div>
                                     </div>

                                     <div class="tab-pane" id="documento_medico" role="tabpanel">
                                       <div class="card">
                                           <div class="card-block">
                                             <form method="post" name="documento" id="documento" onsubmit="event.preventDefault(); sendData_documento();" style="padding: 10px;">
                                               <div class="row">
                                                 <?php
                                                 $dias_descanso = $data_consulta['dias_descanso'];
                                                 $entidad = $data_consulta['entidad'];
                                                 $contingencia = $data_consulta['contingencia'];
                                                 $actividad = $data_consulta['actividad'];
                                                 $diagnostico = $data_consulta['diagnostico'];
                                                 $observacion_descanso = $data_consulta['observacion_descanso'];
                                                 $solicitud_revision = $data_consulta['solicitud_revision'];
                                                 $autorizacion_imagenes = $data_consulta['autorizacion_imagenes'];
                                                 $autorizacion_laboratorio = $data_consulta['autorizacion_laboratorio'];
                                                 $interconsulta = $data_consulta['interconsulta'];
                                                 $proc_interconsulta = $data_consulta['proc_interconsulta'];
                                                 $motivo_documento = $data_consulta['motivo_documento'];

                                                  ?>
                                          <div class="col-md-6 mb-3">
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Documentos (Pdf)</label>
                                                  <input class="form-control input-guibis-sm" name="pdf"  accept="application/pdf" type="file" id="pdf">
                                              </div>
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Días Descanso</label>
                                                  <input type="number" required class="form-control input-guibis-sm" name="dias_descanso" id="dias_descanso" value="<?php echo $dias_descanso ?>">
                                              </div>
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Entidad</label>
                                                  <input type="text" class="form-control input-guibis-sm" value="<?php echo $entidad ?>" name="entidad" id="entidad">
                                              </div>
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Tipo de Contingencia</label>
                                                  <input type="text" class="form-control input-guibis-sm" value="<?php echo $contingencia ?>" name="contingencia" id="contingencia">
                                              </div>
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Actividad Laboral</label>
                                                  <input type="text" class="form-control input-guibis-sm" value="<?php echo $actividad ?>" name="actividad" id="actividad">
                                              </div>
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Diagnosticos a usar</label><br>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="diagnostico" id="definitivo" value="definitivo">
                                                      <label class="form-check-label" for="definitivo">Definitivo</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="diagnostico" id="presuntivo" value="presuntivo" checked>
                                                      <label class="form-check-label" for="presuntivo">Presuntivo</label>
                                                  </div>
                                              </div>
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Obsr. Descanso</label>
                                                  <textarea class="form-control input-guibis-sm"  name="observacion_descanso" id="observacion_descanso" rows="3"><?php echo $observacion_descanso ?></textarea>
                                              </div>
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Solicitud de Revisión</label>
                                                  <textarea class="form-control input-guibis-sm" name="solicitud_revision" id="solicitud_revision" rows="3"><?php echo $solicitud_revision ?></textarea>
                                              </div>
                                          </div>
                                          <div class="col-md-6 mb-3">
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Autorización Imágenes</label>
                                                  <input type="text" class="form-control input-guibis-sm" value="<?php echo $autorizacion_imagenes ?>" name="autorizacion_imagenes" id="autorizacion_imagenes">
                                              </div>
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Autorización Laboratorio</label>
                                                  <input type="text" class="form-control input-guibis-sm" value="<?php echo $autorizacion_laboratorio ?>" name="autorizacion_laboratorio" id="autorizacion_laboratorio">
                                              </div>
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Interconsulta?</label><br>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="interconsulta" id="interconsulta-si" value="si">
                                                      <label class="form-check-label" for="interconsulta-si">Sí</label>
                                                  </div>
                                                  <div class="form-check form-check-inline">
                                                      <input class="form-check-input" type="radio" name="interconsulta" id="interconsulta-no" value="no" checked>
                                                      <label class="form-check-label" for="interconsulta-no">No</label>
                                                  </div>
                                              </div>
                                              <div class="mb-3">
                                                  <label class="label-guibis-sm">Buscar Procedimiento Interconsulta</label>
                                                  <input type="text" class="form-control input-guibis-sm" value="<?php echo $proc_interconsulta ?>" name="proc_interconsulta" id="proc_interconsulta">
                                              </div>
                                              <div class="mb-3">
                                                  <label for="motivo" class="form-label">Motivo</label>
                                                  <textarea class="form-control" name="motivo_documento" <?php echo $motivo_documento ?> id="motivo" rows="3"></textarea>
                                              </div>
                                          </div>
                                      </div>

                                                 <div class="contenedor_boton_enviar">
                                                   <button type="submit" class="btn btn-primary">Procesar Documento <i class="fas fa-plus"></i></button>

                                                 </div>

                                                   <input type="hidden" name="action" value="ingresar_documento">
                                                   <input type="hidden" name="paciente" id="paciente" value="<?php echo $paciente ?>">
                                                   <input type="hidden" name="codigo_unico" value="<?php echo $codigo_unico ?>">

                                                 <div class="alerta_documento"></div>
                                               </form>
                                           </div>
                                           <p class="informacion_responsabilidad" ><?php echo $responsable_documento    ?></p>
                                       </div>
                                     </div>



                                     <div class="tab-pane" id="contacts" role="tabpanel">
                                       <style media="screen">
                                       .select2-container .select2-selection--single .select2-selection__rendered {
                                      /* display: block; */
                                       padding-left: 0px !important;
                                       padding-right: 0px !important;
                                      overflow: hidden !important;
                                      text-overflow: ellipsis !important;
                                      /* white-space: nowrap; */
                                      }
                                      .select2-container--default .select2-selection--single .select2-selection__rendered {
                                        	/*background-color: #fff !important;*/
                                        	padding: 0px !important;
                                        }
                                      </style>

                                       <div class="card">
                                           <div class="card-block">
                                             <style media="screen">
                                             .autocomplete-list {
                                                 position: absolute;
                                                 z-index: 1050; /* Bootstrap modal z-index for higher stacking */
                                                 width: 40%;
                                                 background-color: #fff;
                                                 max-height: 200px;
                                                 overflow-y: auto;
                                                 box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
                                                 border-radius: 0.25rem;
                                                 font-size: 12px;
                                             }

                                             .autocomplete-list div {

                                                 cursor: pointer;
                                             }

                                             .autocomplete-list div:hover {
                                                 background-color: #e9ecef; /* Bootstrap secondary color for hover effect */
                                             }

                                             </style>
                                             <form method="post" name="receta" id="receta" onsubmit="event.preventDefault(); sendData_receta();" style="padding: 10px;">
                                               <div class=" mt-5">
                                                    <div class="row">
                                                      <div class="col-md-6">
                                                          <label class="label-guibis-sm">Definitivos</label>
                                                          <?php
                                                          $definitivos    = $data_consulta['definitivo'];
                                                          $presuntivos    = $data_consulta['presuntivo'];
                                                          $definitivos    = json_decode($definitivos, true);
                                                          $presuntivos    = json_decode($presuntivos, true);
                                                          $medicamentos  = $data_consulta['medicamentos'];
                                                          $medicamentos = json_decode($medicamentos, true);
                                                           ?>

                                                          <?php if ($estado == 'FINALIZADO'): ?>
                                                            <?php




                                                            foreach ($definitivos as $definitivo) {
                                                             // Extraer los datos de cada medicamento
                                                             $checked = $definitivo['checked'];
                                                             $id = $definitivo['id'];
                                                             if ($id != '0') {
                                                             ?>
                                                             <p style="padding: 0px;margin: 0px;" ><?php echo $id ?></p>
                                                             <?php
                                                             }
                                                           }
                                                          ?>

                                                          <?php endif; ?>

                                                          <?php if ($estado == 'INICIADO'): ?>

                                                        <?php
                                                        for ($i = 0; $i < 4; $i++) {
                                                            echo '<div class="d-flex align-items-center mb-3">
                                                                    <input class="form-check-input me-2 input-guibis-sm" type="checkbox" name="definitivo_checked[]" >
                                                                    <select class="form-control input-guibis-sm paramtero_select2" id="' . ($i + 1) . '" name="definitivo_id[]">
                                                                        <option value="0">Ninguna</option>';
                                                            $query_proveedor = mysqli_query($conection, "SELECT * FROM cie10 WHERE cie10.estatus = 1");
                                                            while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                                                                echo '<option value="' . $proveedor['id'] . '">' . $proveedor['codigo'] . '- ' . $proveedor['nombre'] . '</option>';
                                                            }
                                                            echo '</select>
                                                                              <button type="button" id="' . ($i + 1) . '" class="btn btn-warning btn-sm reset-button"><i class="fas fa-times"></i></button>
                                                                </div>';
                                                        }
                                                         ?>
                                                          <?php endif; ?>


                                                      </div>
                                                      <div class="col-md-6">
                                                          <label class="label-guibis-sm">Presuntivos</label>

                                                          <?php if ($estado == 'FINALIZADO'): ?>
                                                            <?php
                                                            foreach ($presuntivos as $presuntivo) {
                                                             // Extraer los datos de cada medicamento
                                                             $checked = $presuntivo['checked'];
                                                             $id = $presuntivo['id'];
                                                             if ($id != '0') {
                                                             ?>

                                                             <p style="padding: 0px;margin: 0px;" ><?php echo $id ?></p>

                                                             <?php
                                                             }
                                                           }
                                                          ?>

                                                          <?php endif; ?>

                                                          <?php if ($estado == 'INICIADO'): ?>
                                                            <?php
                                                            for ($i = 0; $i < 4; $i++) {
                                                                echo '<div class="d-flex align-items-center mb-3">
                                                                        <input class="form-check-input me-2 input-guibis-sm" type="checkbox" name="presuntivo_checked[]" >
                                                                        <select class="form-control input-guibis-sm paramtero_select2" id="resuntivo_' . ($i + 1) . '" name="presuntivo_id[]">
                                                                            <option value="0">Ninguna</option>';
                                                                $query_proveedor = mysqli_query($conection, "SELECT * FROM cie10 WHERE cie10.estatus = 1");
                                                                while ($proveedor = mysqli_fetch_array($query_proveedor)) {
                                                                    echo '<option value="' . $proveedor['id'] . '">' . $proveedor['codigo'] . '- ' . $proveedor['nombre'] . '</option>';
                                                                }
                                                                echo '</select>
                                                                        <button type="button" id="' . ($i + 1) . '" class="btn btn-warning btn-sm reset-button_presuntivo"><i class="fas fa-times"></i></button>
                                                                    </div>';
                                                            }
                                                            ?>

                                                          <?php endif; ?>



                                                      </div>
                                                    </div>
                                                    <table class="table mt-4">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">Fármaco</th>
                                                                <th scope="col">Cantidad</th>
                                                                <th scope="col">Dosis</th>
                                                                <th scope="col">Frecuencia</th>
                                                                <th scope="col">Duración</th>
                                                                <th scope="col">Observación</th>
                                                                <th scope="col">Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="farmacos-tbody">

                                                          <?php if ($estado == 'INICIADO'): ?>
                                                            <?php
                                                                 for ($i = 0; $i < 5; $i++) {
                                                                     echo '<tr id="fila_' . ($i + 1) . '">
                                                                             <td>
                                                                                 <input type="text" class="form-control input-guibis-sm medicamento-input" name="farmaco[]" id="medicamento_' . ($i + 1) . '" data-index="' . ($i + 1) . '" value="" oninput="showAutocomplete(this)">
                                                                                 <div class="autocomplete-list" id="autocomplete-list_' . ($i + 1) . '"></div>
                                                                             </td>
                                                                             <td><input type="number" class="form-control input-guibis-sm" id="cantidad_' . ($i + 1) . '" value="" name="cantidad[]"></td>
                                                                             <td><input type="number" class="form-control input-guibis-sm" id="dosis_' . ($i + 1) . '" value=""name="dosis[]"></td>
                                                                             <td>
                                                                                 <select class="form-control input-guibis-sm" id="frecuencia_' . ($i + 1) . '" name="frecuencia[]">
                                                                                     <option selected>Una vez al día</option>
                                                                                     <option value="Cada 12 horas">Cada 12 horas</option>
                                                                                     <option value="Cada 8 horas">Cada 8 horas</option>
                                                                                     <option value="Cada 6 horas">Cada 6 horas</option>
                                                                                     <option value="Cada 4 horas">Cada 4 horas</option>
                                                                                     <option value="Cada semana">Cada semana</option>
                                                                                     <option value="Por Razones Necesarias">Por Razones Necesarias</option>
                                                                                     <option value="Hora de Sueño">Hora de Sueño</option>
                                                                                 </select>
                                                                             </td>
                                                                             <td><input type="text" class="form-control input-guibis-sm" id="duracion_' . ($i + 1) . '" value="" name="duracion[]"></td>
                                                                             <td><input type="text" class="form-control input-guibis-sm" id="instrucciones_' . ($i + 1) . '" value="" name="observacion[]"></td>
                                                                             <td><button type="button" class="btn btn-warning btn-sm reset_button_farmaco" data-index="' . ($i + 1) . '"><i class="fas fa-times"></i></button></td>
                                                                         </tr>';
                                                                 }
                                                                 ?>
                                                          <?php endif; ?>

                                                          <?php if ($estado == 'FINALIZADO'): ?>
                                                            <?php

                                                              $i = 0;
                                                                 foreach ($medicamentos as $medicamento) {
                                                                   $farmaco = htmlspecialchars($medicamento['farmaco']);
                                                                   $dosis = htmlspecialchars($medicamento['dosis']);
                                                                   $observacion = htmlspecialchars($medicamento['observacion']);
                                                                   $cantidad = htmlspecialchars($medicamento['cantidad']);
                                                                   $duracion = htmlspecialchars($medicamento['duracion']);
                                                                     echo '<tr id="fila_' . ($i + 1) . '">
                                                                             <td>
                                                                                 <input type="text" readonly value="'.$farmaco.'" class="form-control input-guibis-sm medicamento-input" name="farmaco[]" id="medicamento_' . ($i + 1) . '" data-index="' . ($i + 1) . '" ">
                                                                                 <div class="autocomplete-list" id="autocomplete-list_' . ($i + 1) . '"></div>
                                                                             </td>
                                                                             <td><input type="number" readonly class="form-control input-guibis-sm" id="cantidad_' . ($i + 1) . '" value="'.$cantidad.'" name="cantidad[]"></td>
                                                                             <td><input type="number" readonly class="form-control input-guibis-sm" id="dosis_' . ($i + 1) . '" value="'.$dosis.'" name="dosis[]"></td>
                                                                             <td>
                                                                                 <select class="form-control input-guibis-sm" id="frecuencia_' . ($i + 1) . '" name="frecuencia[]">
                                                                                     <option selected>'.$dosis.'</option>
                                                                                 </select>
                                                                             </td>
                                                                             <td><input type="text" readonly class="form-control input-guibis-sm" id="duracion_' . ($i + 1) . '" value="'.$duracion.'" name="duracion[]"></td>
                                                                             <td><input type="text" readonly class="form-control input-guibis-sm" id="instrucciones_' . ($i + 1) . '" value="'.$observacion.'" name="observacion[]"></td>
                                                                         </tr>';

                                                                         $i = $i + 1;
                                                                 }
                                                                 ?>
                                                          <?php endif; ?>



                                                        </tbody>
                                                    </table>
                                                </div>
                                                 <div class="contenedor_boton_enviar">

                                                   <?php if ($estado == 'FINALIZADO'): ?>
                                                     <a class="btn btn-danger"  href="medico/recetas/<?php echo $codigo_unico ?>.pdf" download>Descargar Receta <i class="fas fa-file-pdf"></i> </a>
                                                   <?php endif; ?>


                                                   <?php if ($estado == 'INICIADO'): ?>
                                                     <button type="submit" <?php echo $estado_habilitacion ?> class="btn btn-primary">Agregar Receta <i class="fas fa-calendar-plus"></i></button>
                                                   <?php endif; ?>



                                                 </div>

                                                   <input type="hidden" name="action" value="agregar_receta">
                                                   <input type="hidden" name="paciente" id="paciente" value="<?php echo $paciente ?>">
                                                   <input type="hidden" name="codigo_unico" value="<?php echo $codigo_unico ?>">

                                                 <div class="alerta_receta"></div>
                                               </form>
                                           </div>
                                              <p class="informacion_responsabilidad" ><?php echo $responsable_receta   ?></p>
                                       </div>


                                     </div>

                                     <div class="tab-pane" id="review" role="tabpanel">
                                       <div class="card">
                                           <div class="card-block">
                                             <form method="post" name="antecedentes_alex" id="antecedentes_alex" onsubmit="event.preventDefault(); sendData_antecedentes_ales();" style="padding: 10px;">

                                               <div class="row">
                                                  <!-- Antecedentes Patológicos Personales -->
                                                  <div class="col-md-6 mb-4">
                                                      <h4>Antecedentes Patológicos Personales</h4>
                                                      <div class="row">
                                                        <?php

                                                        $query_verificador_antecedentes = mysqli_query($conection,"SELECT *
                                                        FROM `antecedentes_medicos`
                                                        WHERE antecedentes_medicos.iduser = '$iduser' AND antecedentes_medicos.estatus = '1' AND antecedentes_medicos.paciente = '$paciente' ");

                                                        $result_antecedentes= mysqli_num_rows($query_verificador_antecedentes);
                                                        if ($result_antecedentes > 0) {
                                                           $data_antecedentes =mysqli_fetch_array($query_verificador_antecedentes);


                                                             $cardiopatia = convertToChecked($data_antecedentes['cardiopatia']);
                                                             $hipertension = convertToChecked($data_antecedentes['hipertension']);
                                                             $vascular = convertToChecked($data_antecedentes['vascular']);
                                                             $endocrino = convertToChecked($data_antecedentes['endocrino']);
                                                             $cancer = convertToChecked($data_antecedentes['cancer']);
                                                             $tuberculosis = convertToChecked($data_antecedentes['tuberculosis']);
                                                             $mental = convertToChecked($data_antecedentes['mental']);
                                                             $infecciosa = convertToChecked($data_antecedentes['infecciosa']);
                                                             $malformacion = convertToChecked($data_antecedentes['malformacion']);
                                                             $otro = convertToChecked($data_antecedentes['otro']);
                                                             $cardiopatia_f = convertToChecked($data_antecedentes['cardiopatia_f']);
                                                             $hipertension_f = convertToChecked($data_antecedentes['hipertension_f']);
                                                             $vascular_f = convertToChecked($data_antecedentes['vascular_f']);
                                                             $endocrino_f = convertToChecked($data_antecedentes['endocrino_f']);
                                                             $cancer_f = convertToChecked($data_antecedentes['cancer_f']);
                                                             $tuberculosis_f = convertToChecked($data_antecedentes['tuberculosis_f']);
                                                             $mental_f = convertToChecked($data_antecedentes['mental_f']);
                                                             $infecciosa_f = convertToChecked($data_antecedentes['infecciosa_f']);
                                                             $malformacion_f = convertToChecked($data_antecedentes['malformacion_f']);
                                                             $otro_f = convertToChecked($data_antecedentes['otro_f']);
                                                        }

                                                         ?>
                                                          <div class="col-md-6">
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="cardiopatia" <?php echo $cardiopatia ?> type="checkbox" id="cardiopatia-personal">
                                                                  <label class="form-check-label" for="cardiopatia-personal">Cardiopatía</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="hipertension" <?php echo $hipertension ?> type="checkbox" id="hipertension-personal" >
                                                                  <label class="form-check-label" for="hipertension-personal">Hipertensión</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="vascular"  <?php echo $vascular ?> type="checkbox" id="vascular-personal">
                                                                  <label class="form-check-label" for="vascular-personal">Enf. C. Vascular</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="endocrino" <?php echo $endocrino ?> type="checkbox" id="endocrino-personal">
                                                                  <label class="form-check-label" for="endocrino-personal">Endócrino Metabólico</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="cancer" <?php echo $cancer ?> type="checkbox" id="cancer-personal">
                                                                  <label class="form-check-label" for="cancer-personal">Cáncer</label>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="tuberculosis" <?php echo $tuberculosis ?> type="checkbox" id="tuberculosis-personal">
                                                                  <label class="form-check-label" for="tuberculosis-personal">Tuberculosis</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="mental" <?php echo $mental ?> type="checkbox" id="mental-personal">
                                                                  <label class="form-check-label" for="mental-personal">Enf. Mental</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="infecciosa" <?php echo $infecciosa ?> type="checkbox" id="infecciosa-personal">
                                                                  <label class="form-check-label" for="infecciosa-personal">Enf. Infecciosa</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="malformacion" <?php echo $malformacion ?> type="checkbox" id="malformacion-personal">
                                                                  <label class="form-check-label" for="malformacion-personal">Mal Formación</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="otro" type="checkbox" <?php echo $otro ?> id="otro-personal" >
                                                                  <label class="form-check-label" for="otro-personal">Otro</label>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>

                                                  <!-- Antecedentes Patológicos Familiares -->
                                                  <div class="col-md-6 mb-4">
                                                      <h4>Antecedentes Patológicos Familiares</h4>
                                                      <div class="row">
                                                          <div class="col-md-6">
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="cardiopatia_f" <?php echo $cardiopatia_f ?> type="checkbox" id="cardiopatia-familiar">
                                                                  <label class="form-check-label" for="cardiopatia-familiar">Cardiopatía</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="hipertension_f" <?php echo $hipertension_f ?> type="checkbox" id="hipertension-familiar">
                                                                  <label class="form-check-label" for="hipertension-familiar">Hipertensión</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="vascular_f" <?php echo $vascular_f ?> type="checkbox" id="vascular-familiar">
                                                                  <label class="form-check-label" for="vascular-familiar">Enf. C. Vascular</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input"  name="endocrino_f" <?php echo $endocrino_f ?>  type="checkbox" id="endocrino-familiar">
                                                                  <label class="form-check-label" for="endocrino-familiar">Endócrino Metabólico</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="cancer_f" <?php echo $cancer_f ?> type="checkbox" id="cancer-familiar">
                                                                  <label class="form-check-label" for="cancer-familiar">Cáncer</label>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="tuberculosis_f" <?php echo $tuberculosis_f ?> type="checkbox" id="tuberculosis-familiar">
                                                                  <label class="form-check-label" for="tuberculosis-familiar">Tuberculosis</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="mental_f" <?php echo $mental_f ?> type="checkbox" id="mental-familiar">
                                                                  <label class="form-check-label" for="mental-familiar">Enf. Mental</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="infecciosa_f" <?php echo $infecciosa_f ?> type="checkbox" id="infecciosa-familiar">
                                                                  <label class="form-check-label" for="infecciosa-familiar">Enf. Infecciosa</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="malformacion_f" <?php echo $malformacion_f ?> type="checkbox" id="malformacion-familiar">
                                                                  <label class="form-check-label" for="malformacion-familiar">Mal Formación</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="otro_f" <?php echo $otro_f ?>  type="checkbox" id="otro-familiar">
                                                                  <label class="form-check-label" for="otro-familiar">Otro</label>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>

                                              <div class="row">
                                                  <!-- Revisión Actual de Órganos y Sistemas -->
                                                  <div class="col-md-6 mb-4">
                                                      <h4>Revisión Actual de Órganos y Sistemas</h4>
                                                      <div class="row">
                                                        <?php
                                                        //examenes y demas
                                                        $piel = convertToChecked($data_consulta['piel']);
                                                        $sentidos = convertToChecked($data_consulta['sentidos']);
                                                        $respiratorio = convertToChecked($data_consulta['respiratorio']);
                                                        $cardio = convertToChecked($data_consulta['cardio']);
                                                        $digestivo = convertToChecked($data_consulta['digestivo']);
                                                        $genito = convertToChecked($data_consulta['genito']);
                                                        $musculo = convertToChecked($data_consulta['musculo']);
                                                        $endocrino = convertToChecked($data_consulta['endocrino']);
                                                        $hemo = convertToChecked($data_consulta['hemo']);
                                                        $nervioso = convertToChecked($data_consulta['nervioso']);

                                                         ?>
                                                          <div class="col-md-6">
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="piel" <?php echo $piel ?> type="checkbox" id="piel-anexos">
                                                                  <label class="form-check-label" for="piel-anexos">Piel - Anexos</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="sentidos" <?php echo $sentidos ?>   type="checkbox" id="sentidos">
                                                                  <label class="form-check-label" for="sentidos">Órganos de los Sentidos</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="respiratorio" <?php echo $respiratorio ?>  type="checkbox" id="respiratorio">
                                                                  <label class="form-check-label" for="respiratorio">Respiratorio</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="cardio" <?php echo $cardio ?>  type="checkbox" id="cardio-vascular" >
                                                                  <label class="form-check-label" for="cardio-vascular">Cardio-Vascular</label>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="digestivo" <?php echo $digestivo ?>  type="checkbox" id="digestivo" >
                                                                  <label class="form-check-label" for="digestivo">Digestivo</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="genito" <?php echo $genito ?>  type="checkbox" id="genito-urinario" >
                                                                  <label class="form-check-label" for="genito-urinario">Genito-Urinario</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="musculo" <?php echo $musculo ?>  type="checkbox" id="musculo-esqueletico">
                                                                  <label class="form-check-label" for="musculo-esqueletico">Músculo-Esquelético</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="endocrino" <?php echo $endocrino ?>  type="checkbox" id="endocrino">
                                                                  <label class="form-check-label" for="endocrino">Endocrino</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="hemo" <?php echo $hemo ?>  type="checkbox" id="hemo-linfatico">
                                                                  <label class="form-check-label" for="hemo-linfatico">Hemo-Linfático</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="nervioso" <?php echo $nervioso ?>  type="checkbox" id="nervioso">
                                                                  <label class="form-check-label" for="nervioso">Nervioso</label>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>

                                                  <!-- Examen Físico -->
                                                  <div class="col-md-6 mb-4">
                                                      <h4>Examen Físico</h4>
                                                      <div class="row">
                                                        <?php
                                                        $efpiel = convertToChecked($data_consulta['efpiel']);
                                                        $efojos = convertToChecked($data_consulta['efojos']);
                                                        $efoidosOidos = convertToChecked($data_consulta['efoidosOidos']);
                                                        $efbocafaringe = convertToChecked($data_consulta['efbocafaringe']);
                                                        $cuello = convertToChecked($data_consulta['cuello']);
                                                        $efrespiratorio = convertToChecked($data_consulta['efrespiratorio']);
                                                        $efcardio = convertToChecked($data_consulta['efcardio']);
                                                        $efabdomen = convertToChecked($data_consulta['efabdomen']);
                                                        $efgenito = convertToChecked($data_consulta['efgenito']);
                                                        $efextremidades = convertToChecked($data_consulta['efextremidades']);
                                                        $efneurologico = convertToChecked($data_consulta['efneurologico']);

                                                         ?>
                                                          <div class="col-md-6">
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="efpiel" <?php echo $efpiel ?>  type="checkbox" id="piel-faneras">
                                                                  <label class="form-check-label" for="piel-faneras">Piel - Faneras</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="efojos" <?php echo $efojos ?>  type="checkbox" id="ojos">
                                                                  <label class="form-check-label" for="ojos">Ojos</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="efoidosOidos" <?php echo $efoidosOidos ?>  type="checkbox" id="oidos-nariz">
                                                                  <label class="form-check-label" for="oidos-nariz">Oídos - Nariz</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="efbocafaringe" <?php echo $efbocafaringe ?>  type="checkbox" id="boca-faringe">
                                                                  <label class="form-check-label" for="boca-faringe">Boca - Faringe</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="cuello" <?php echo $cuello ?>  type="checkbox" id="cuello">
                                                                  <label class="form-check-label" for="cuello">Cuello</label>
                                                              </div>
                                                          </div>
                                                          <div class="col-md-6">
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="efrespiratorio" <?php echo $efrespiratorio ?>  type="checkbox" id="respiratorio-fisico">
                                                                  <label class="form-check-label" for="respiratorio-fisico">Respiratorio</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="efcardio" <?php echo $efcardio ?>  type="checkbox" id="cardio-vascular-fisico" >
                                                                  <label class="form-check-label" for="cardio-vascular-fisico">Cardio-Vascular</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="efabdomen" <?php echo $efabdomen ?>  type="checkbox" id="abdomen">
                                                                  <label class="form-check-label" for="abdomen">Abdomen</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="efgenito" <?php echo $efgenito ?>  type="checkbox" id="genito-urinario-fisico">
                                                                  <label class="form-check-label" for="genito-urinario-fisico">Genito-Urinario</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="efextremidades" <?php echo $efextremidades ?>  type="checkbox" id="extremidades">
                                                                  <label class="form-check-label" for="extremidades">Extremidades</label>
                                                              </div>
                                                              <div class="form-check">
                                                                  <input class="form-check-input" name="efneurologico" <?php echo $efneurologico ?>  type="checkbox" id="neurologico">
                                                                  <label class="form-check-label" for="neurologico">Neurológico</label>
                                                              </div>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>

                                                 <div class="contenedor_boton_enviar">
                                                   <button type="submit" <?php echo $estado_habilitacion ?> class="btn btn-primary">Agregar Antecedentes <i class="fas fa-plus"></i></button>
                                                 </div>

                                                   <input type="hidden" name="action" value="ingreso_antecedentes">
                                                   <input type="hidden" name="paciente" id="paciente" value="<?php echo $paciente ?>">
                                                   <input type="hidden" name="codigo_unico" value="<?php echo $codigo_unico ?>">

                                                 <div class="alerta_antecedentes"></div>
                                               </form>
                                           </div>
                                              <p class="informacion_responsabilidad" ><?php echo $responsable_antecedentes   ?></p>
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
        <script src="medico/init_consulta.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    </body>

</html>
