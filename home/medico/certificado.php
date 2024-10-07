<?php
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar
$iduser = $_GET['iduser'];
$codigo_unico = $_GET['codigo_unico'];


$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
$result_documentos = mysqli_fetch_array($query_doccumentos);
$regimen = $result_documentos['regimen'];
$contabilidad             = $result_documentos['contabilidad'];
$email_empresa_emisor     = $result_documentos['email'];
$celular_empresa_emisor   = $result_documentos['celular'];
$telefono_empresa_emisor  = $result_documentos['telefono'];
$direccion_emisor          = $result_documentos['direccion'];
$nombres                  = $result_documentos['nombres'];
$apellidos                = $result_documentos['apellidos'];
$numero_identificacion_emisor  = $result_documentos['numero_identidad'];
$contribuyente_especial   = $result_documentos['contribuyente_especial'];

$contabilidad            = $result_documentos['contabilidad'];
$img_facturacion         = $result_documentos['img_facturacion'];
$contabilidad         = $result_documentos['contabilidad'];
$regimen         = $result_documentos['regimen'];
$razon_social         = $result_documentos['razon_social'];

$facebook                = $result_documentos['facebook'];
$pagina_web                = $result_documentos['pagina_web'];
$instagram           = $result_documentos['instagram'];
$whatsapp             = $result_documentos['whatsapp'];
$url_img_upload             = $result_documentos['url_img_upload'];
$nombre_empresa      = $result_documentos['nombre_empresa'];

$protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url = $protocol . $domain;

function getRealIP(){
          if (isset($_SERVER["HTTP_CLIENT_IP"])){
              return $_SERVER["HTTP_CLIENT_IP"];
          }elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
              return $_SERVER["HTTP_X_FORWARDED_FOR"];
          }elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
          {
              return $_SERVER["HTTP_X_FORWARDED"];
          }elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
          {
              return $_SERVER["HTTP_FORWARDED_FOR"];
          }elseif (isset($_SERVER["HTTP_FORWARDED"]))
          {
              return $_SERVER["HTTP_FORWARDED"];
          }
          else{
              return $_SERVER["REMOTE_ADDR"];
          }

      }
      if ($url =='http://localhost') {
        $direccion_ip =  '186.42.10.32';
      }else {
        $direccion_ip = (getRealIP());
      }

      $datos = unserialize(file_get_contents('http://ip-api.com/php/'.$direccion_ip.''));

       $pais            = $datos['country'];
       $ciudad            = $datos['city'];
       $provincia         = $datos['regionName'];

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Receta </title>
  </head>
  <body>



    <style media="screen">

    .line_uno {
        flex-grow: 1;
        height: 1px;
        background-color: black;
        margin-top: -105px;
    }
    .cabezera{
      text-align: center;
      margin-top: -15px;
    }
    .cabezera img{
      width: 100px;
    }

    .negrita{
      font-weight: bold;
    }

    .bloque_gene_cabezera{
      width: 33%;
      display: inline-block;
      vertical-align: top; /* Añadir alineación vertical */
    }
    .negrita_cls{
      font-weight: bold;
    }
    .informacion_cita_medica{
      font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    .informacion_cita_medica tr,td{
      padding: 2px;
    }
    .bloque_gene_cabezera p {
      padding: 0px;
      margin: 0px;
    }

    </style>


    <div class="cabezera">
      <div class="bloque_gene_cabezera">
          <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_facturacion ?>" alt="">
      </div>


      <div class="bloque_gene_cabezera">
         <h2><?php echo $nombre_empresa ?></h2>
         <p> Telefonos: <?php echo $telefono_empresa_emisor ?> </p>
         <p> <?php echo $email_empresa_emisor ?> </p>
      </div>

      <div class="bloque_gene_cabezera">
        <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_facturacion ?>" alt="">
      </div>
    </div>



    <?php

    function numeroALetras($numero) {
      $numero = (int)$numero;
    $numerosEnLetras = array(
        1 => 'uno',
        2 => 'dos',
        3 => 'tres',
        4 => 'cuatro',
        5 => 'cinco',
        6 => 'seis',
        7 => 'siete',
        8 => 'ocho',
        9 => 'nueve',
        10 => 'diez',
        11 => 'once',
        12 => 'doce',
        13 => 'trece',
        14 => 'catorce',
        15 => 'quince',
        16 => 'dieciséis',
        17 => 'diecisiete',
        18 => 'dieciocho',
        19 => 'diecinueve',
        20 => 'veinte',
        21 => 'veintiuno',
        22 => 'veintidós',
        23 => 'veintitrés',
        24 => 'veinticuatro',
        25 => 'veinticinco',
        26 => 'veintiséis',
        27 => 'veintisiete',
        28 => 'veintiocho',
        29 => 'veintinueve',
        30 => 'treinta'
    );

    if (array_key_exists($numero, $numerosEnLetras)) {
        return $numerosEnLetras[$numero];
    } else {
        return "Número fuera de rango";
    }
}


    // Obtén la fecha actual en el formato deseado
$fecha_actual = date('d M Y');

// Mapea los meses al formato deseado
$meses = array(
    'Jan' => 'Enero',
    'Feb' => 'Febrero',
    'Mar' => 'Marzo',
    'Apr' => 'Abril',
    'May' => 'Mayo',
    'Jun' => 'Junio',
    'Jul' => 'Julio',
    'Aug' => 'Agosto',
    'Sep' => 'Septiembre',
    'Oct' => 'Octubre',
    'Nov' => 'Noviembre',
    'Dec' => 'Diciembre'
);

$mes = date('M');


// Reemplaza el mes en inglés por el mes en español
$fecha_actual = str_replace($mes, $meses[$mes], $fecha_actual);

// Formatea la fecha según el formato deseado
list($dia, $mes, $año) = explode(' ', $fecha_actual);
$fecha_formateada = "$dia de $mes del $año";

// Agrega la ciudad y la coma
$fecha_actual_con_ciudad = $ciudad . ', ' . $fecha_formateada;

$hora_actual = date('H:i');


    $query_consulta = mysqli_query($conection,"SELECT clientes.fecha_nacimiento,clientes.nombres,clientes.genero,
      clientes.identificacion,clientes.estado_civil,clientes.secuencial,consultas_medicas.medicamentos,
        consultas_medicas.definitivo,consultas_medicas.presuntivo,consultas_medicas.url_qr,
        consultas_medicas.qr_img,consultas_medicas.id as 'codigo_consulta',clientes.direccion,
        clientes.celular,consultas_medicas.contingencia,consultas_medicas.actividad,consultas_medicas.entidad,
        consultas_medicas.dias_descanso,consultas_medicas.diagnostico
       FROM `consultas_medicas`
      INNER JOIN clientes ON clientes.id = consultas_medicas.paciente
      WHERE consultas_medicas.estatus = '1' AND consultas_medicas.codigo_unico = '$codigo_unico' ");
      $data_consulta =mysqli_fetch_array($query_consulta);

      $fecha_nacimiento  = $data_consulta['fecha_nacimiento'];
      $nombres_paciente  = $data_consulta['nombres'];
      $genero            = $data_consulta['genero'];
      $identificacion_paciente  = $data_consulta['identificacion'];
      $secuencial          = $data_consulta['secuencial'];
      $estado_civil        = $data_consulta['estado_civil'];
      $direccion_paciente  = $data_consulta['direccion'];
      $celular_paciente    = $data_consulta['celular'];
      $contingencia    = $data_consulta['contingencia'];
      $actividad    = $data_consulta['actividad'];
      $entidad    = $data_consulta['entidad'];
      $dias_descanso    = $data_consulta['dias_descanso'];


      $codigo_consulta    = $data_consulta['codigo_consulta'];
      $diagnostico        = $data_consulta['diagnostico'];

      $url_qr = $data_consulta['url_qr'];
      $qr_img = $data_consulta['qr_img'];
      $filename = $url_qr.'/home/img/qr/'.$qr_img;

      $definitivos    = $data_consulta['definitivo'];
      $presuntivos    = $data_consulta['presuntivo'];
      $definitivos    = json_decode($definitivos, true);
      $presuntivos    = json_decode($presuntivos, true);
      $medicamentos  = $data_consulta['medicamentos'];
      $medicamentos = json_decode($medicamentos, true);

      $fecha_nac = new DateTime($fecha_nacimiento);
        // Crear un objeto DateTime para la fecha actual
        $fecha_actual = new DateTime();
        // Calcular la diferencia entre la fecha de nacimiento y la fecha actual
        $diferencia = $fecha_actual->diff($fecha_nac);

        // Obtener años y meses
        $anios = $diferencia->y;
        $meses = $diferencia->m;

     ?>

     <style media="screen">
       .titulo_certificado_medico{
         text-align: center;
         font-weight: bold;
         margin-top: -120px;
       }
       .fecha_titulo{
         text-align: right;
       }
     </style>



     <div class="titulo_certificado_medico">
       <div class="fecha_titulo">
         <p> <?php echo $fecha_actual_con_ciudad ?> </p>
       </div>
       <h3>CERTIFICADO MÉDICO</h3>
     </div>

     <style media="screen">
       .cuerpo_certificado{
          margin-top: -40px;
          text-align: justify;
       }
     </style>


     <div class="cuerpo_certificado">
       <p> Certifico que el o la paciente, <span class="negrita" ><?php echo $nombres_paciente ?> </span> con cédula de ciudadania No <span class="negrita" > <?php echo $identificacion_paciente ?> </span> ,
       con historia clínica <span class="negrita"><?php echo $secuencial ?> </span> con dirección domiciliaria <span class="negrita"> <?php echo $direccion_paciente ?></span>
     con número telefónico <span class="negrita" > <?php echo $celular_paciente ?></span>, fue antendido el dia <span class="negrita" ><?php echo $fecha_formateada ?></span>,
   en la unidad médica <span class="negrita" ><?php echo $nombre_empresa ?> </span> ubicada en <span class="negrita" ><?php echo $direccion_emisor ?></span> </p>
     </div>
     <style media="screen">
     .certi_diagnostico h3{
       padding: 0px;
       margin: 0px;
     }
       .certi_diagnostico{
         text-align: left;
         padding: 0px;
         margin: 0px;
       }
       .certi_diagnostico p{
         padding: 0px;
         margin: 0px;
       }
     </style>

     <div class="certi_diagnostico">
       <h3 class="negrita" >DIAGNOSTICO <?php echo $diagnostico ?></h3>
       <?php if ($diagnostico == 'definitivo'): ?>
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

       <?php if ($diagnostico == 'presuntivo'): ?>
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

     </div>
     <div class="certi_diagnostico">
       <h3 class="negrita" >TIPO DE CONTIGENCIA</h3>
       <p><?php echo $contingencia ?></p>

     </div>

     <div class="certi_diagnostico">
       <h3 class="negrita" >ACTIVIDAD LABORAL</h3>
       <p><?php echo $actividad ?></p>

     </div>
     <div class="certi_diagnostico">
       <h3 class="negrita" >Entidad</h3>
       <p><?php echo $entidad ?></p>
     </div>

     <div class="recomendacion_e">
       <?php
       $dias_descanso_en_letras = numeroALetras($dias_descanso);

        ?>
       <p>Se recomienda reposo por <span class="negrita" ><?php echo $dias_descanso ?> (<?php echo $dias_descanso_en_letras ?>) </span> dias, a partir de la fecha de atención </p>

       <p><span class="negrita">Desde</span> <?php echo $dia ?> (<?php echo numeroALetras($dia) ?>) / <?php echo $mes ?> / <?php echo $año ?>

         <?php
         $fecha_actual->modify("+$dias_descanso days");
         // Mapea los meses al formato deseado
          $meses = array(
              'Jan' => 'Enero',
              'Feb' => 'Febrero',
              'Mar' => 'Marzo',
              'Apr' => 'Abril',
              'May' => 'Mayo',
              'Jun' => 'Junio',
              'Jul' => 'Julio',
              'Aug' => 'Agosto',
              'Sep' => 'Septiembre',
              'Oct' => 'Octubre',
              'Nov' => 'Noviembre',
              'Dec' => 'Diciembre'
          );
         // Obtén el día, mes y año de la fecha resultante
          $dia = $fecha_actual->format('d');
          $mes_ingles = $fecha_actual->format('M');
          $año = $fecha_actual->format('Y');
          // Reemplaza el mes en inglés por el mes en español
          $mes = $meses[$mes_ingles];

          // Formatea la fecha según el formato deseado
          $fecha_formateada = "$dia / $mes / $año";

          ?>


          <span class="negrita">Hasta</span> <?php echo $dia ?> (<?php echo numeroALetras($dia) ?>) / <?php echo $mes ?> / <?php echo $año ?>  </p>
     </div>
     <br>
     <style media="screen">
       .atentanente{
         text-align: left;
       }
       .atentanente p {
         padding: 0px;
         margin: 0px;
       }
     </style>

     <div class="atentanente">
       <p class="negrita">Atentamente</p>
       <br><br><br><br><br>
       <p><?php echo $razon_social ?></p>
       <p>Medicina General - <?php echo $nombre_empresa ?></p>
       <p>Cédula: <?php echo $numero_identificacion_emisor ?></p>
       <p>Email: <?php echo $email_empresa_emisor ?> </p>

     </div>


  </body>
</html>
