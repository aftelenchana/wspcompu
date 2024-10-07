<?php

// Reportar todos los errores de PHP (ver el manual de PHP para más niveles de errores)
error_reporting(E_ALL);

// Habilitar la visualización de errores
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);



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

 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Receta </title>
  </head>
  <body>


    <style media="screen">


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


    }

    .cabezera_zquierda{
      width: 49%;
      display: inline-block;
      vertical-align: top; /* Añadir alineación vertical */
    }

    .cabezera_derecha{
      width: 49%;
      display: inline-block;
      vertical-align: top; /* Añadir alineación vertical */
    }


    .negrita_cls{
      font-weight: bold;
    }
    .informacion_cita_medica{
      font-size: 12px;
      margin-top: -50px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }
    .informacion_cita_medica tr,td{
      padding: 2px;
    }

    hr {
        border: none; /* Elimina el borde predeterminado */
        height: 2px; /* Grosor de 2px */
        background-color: black; /* Color negro */
        border-radius: 2px; /* Bordes redondeados opcionales */
        margin-top: -50px;
    }

    </style>

    <?php

    // Obtén la fecha actual en el formato deseado
$fecha_actual = date('d/M/Y');

// Mapea los meses al formato deseado
$meses = array(
    'Jan' => 'Ene',
    'Feb' => 'Feb',
    'Mar' => 'Mar',
    'Apr' => 'Abr',
    'May' => 'May',
    'Jun' => 'Jun',
    'Jul' => 'Jul',
    'Aug' => 'Ago',
    'Sep' => 'Sep',
    'Oct' => 'Oct',
    'Nov' => 'Nov',
    'Dec' => 'Dic'
);

$mes = date('M');
$fecha_actual = str_replace($mes, $meses[$mes], $fecha_actual);

// Agrega la ciudad
$ciudad = 'Quito'; // Reemplaza con tu ciudad
$fecha_actual_con_ciudad = $ciudad . ' ' . $fecha_actual;
$hora_actual = date('H:i');


    $query_consulta = mysqli_query($conection,"SELECT clientes.fecha_nacimiento,clientes.nombres,clientes.genero,
      clientes.identificacion,clientes.estado_civil,clientes.secuencial,consultas_medicas.medicamentos,
        consultas_medicas.definitivo,consultas_medicas.presuntivo,consultas_medicas.url_qr,
        consultas_medicas.qr_img,consultas_medicas.id as 'codigo_consulta'
       FROM `consultas_medicas`
      INNER JOIN clientes ON clientes.id = consultas_medicas.paciente
      WHERE consultas_medicas.estatus = '1' AND consultas_medicas.codigo_unico = '$codigo_unico' ");
      $data_consulta =mysqli_fetch_array($query_consulta);

      $fecha_nacimiento  = $data_consulta['fecha_nacimiento'];
      $nombres_paciente  = $data_consulta['nombres'];
      $genero            = $data_consulta['genero'];
      $identificacion_paciente  = $data_consulta['identificacion'];
      $secuencial  = $data_consulta['secuencial'];
      $estado_civil  = $data_consulta['estado_civil'];

      $definitivos    = $data_consulta['definitivo'];
      $presuntivos    = $data_consulta['presuntivo'];
      $codigo_consulta    = $data_consulta['codigo_consulta'];

      $url_qr = $data_consulta['url_qr'];
      $qr_img = $data_consulta['qr_img'];
      $filename = $url_qr.'/home/img/qr/'.$qr_img;

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



    <div class="contenedor_general_cabezeras">
      <style media="screen">
        .cabezera_zquierda {
        /*   background:  #ff9e89 ;*/
        }
      </style>

      <div class="cabezera_zquierda">
        <div class="cabezera">
          <div class="bloque_gene_cabezera">
              <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_facturacion ?>" alt="">
          </div>


          <div class="bloque_gene_cabezera">
             <h2><?php echo $nombre_empresa ?></h2>
          </div>

          <div class="bloque_gene_cabezera">
            <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_facturacion ?>" alt="">
          </div>
        </div>
        <hr>
        <br><br>
        <br>

        <div class="informacion_cita_medica">
          <table>
             <tbody>
                 <tr>
                     <td><span class="negrita_cls" >PACIENTE</span> <?php echo $nombres_paciente ?></td>
                 </tr>
                 <tr>
                   <td><span class="negrita_cls" >IDENTIFICACION</span> <?php echo $identificacion_paciente ?></td>
                   <td><span class="negrita_cls" >HC</span> <?php echo $secuencial ?></td>
                   <td><span class="negrita_cls" >EDAD</span> <?php echo $anios ?> años con <?php echo $meses ?> meses</td>
                 </tr>
                 <tr>
                   <td><span class="negrita_cls" >FECHA</span> <?php echo $fecha_actual_con_ciudad ?></td>
                 </tr>
             </tbody>
         </table>

        </div>

        <style media="screen">
          .diagnosticos_c_10{
            text-align: left;
          }
        </style>
        <br>


        <div class="diagnosticos_c_10">
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

        </div>
        <style media="screen">
          .rp{
            text-align: left;
          }
        </style>

        <p class="rp" >Rp/</p>


        <div class="list_medicamentos">
            <ol>
            <?php

            function numeroALetras($numero) {
              // Array separado para enteros y decimales
              $numerosEnterosEnLetras = array(
                  1 => 'una',
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
                  30 => 'treinta',
                  31 => 'treinta y uno',
                  32 => 'treinta y dos',
                  33 => 'treinta y tres',
                  34 => 'treinta y cuatro',
                  35 => 'treinta y cinco',
                  100 => 'cien'
              );

              $numerosDecimalesEnLetras = array(
                  '0.5' => 'medio',
                  '1.5' => 'una y medio',
                  '2.5' => 'dos y medio',
                  '3.5' => 'tres y medio',
                  '4.5' => 'cuatro y medio',
                  '5.5' => 'cinco y medio'
              );

              // Convertir número a cadena para poder detectar el punto o la coma
              $numeroStr = strval($numero);

              // Verificar si el número tiene un punto o una coma (indica que es decimal)
              if (strpos($numeroStr, '.') !== false || strpos($numeroStr, ',') !== false) {
                  // Convertir el número con punto decimal a cadena para buscar en el array
                  $numeroDecimal = str_replace(',', '.', $numeroStr); // Reemplazar coma por punto si existe

                  // Buscar el número decimal en el array de decimales
                  if (array_key_exists($numeroDecimal, $numerosDecimalesEnLetras)) {
                      return $numerosDecimalesEnLetras[$numeroDecimal];
                  }
              } else {
                  // Buscar el número en el array de enteros
                  $numeroEntero = (int)$numero;
                  if (array_key_exists($numeroEntero, $numerosEnterosEnLetras)) {
                      return $numerosEnterosEnLetras[$numeroEntero];
                  }
              }

              // Si el número no se encuentra en el rango
              return "Número fuera de rango";
          }



        foreach ($medicamentos as $medicamento) {
          // Extraer y sanitizar los datos de cada medicamento
          $farmaco = isset($medicamento['farmaco']) ? htmlspecialchars($medicamento['farmaco']) : '';
          $dosis = isset($medicamento['dosis']) ? htmlspecialchars($medicamento['dosis']) : '';
          $observacion = isset($medicamento['observacion']) ? htmlspecialchars($medicamento['observacion']) : '';
          $cantidad = isset($medicamento['cantidad']) ? htmlspecialchars($medicamento['cantidad']) : '';
          $frecuencia = isset($medicamento['frecuencia']) ? htmlspecialchars($medicamento['frecuencia']) : '';
          $duracion = isset($medicamento['duracion']) ? htmlspecialchars($medicamento['duracion']) : '';

          // Verificar si el campo 'farmaco' tiene contenido
          if (!empty($farmaco)) {
              $partes = explode('?', $farmaco);

              // Asignar valores si existen en $partes, de lo contrario asignar una cadena vacía
              $nombre_comercial = isset($partes[0]) ? $partes[0] : '';
              $concentracion = isset($partes[1]) ? $partes[1] : '';
              $farmacos_genericos = isset($partes[2]) ? $partes[2] : '';
              $presentacion = isset($partes[3]) ? $partes[3] : '';
              $via_administracion = isset($partes[4]) ? $partes[4] : '';

              // Verificar que 'nombre_comercial' no esté vacío
              if (!empty($nombre_comercial)) {
                  $cantidad_letras = mb_strtoupper(numeroALetras($cantidad));
                  echo '<li>' . $nombre_comercial . ' ' . $concentracion . ' (' . $farmacos_genericos . ') ' . $presentacion . ' ' . $via_administracion . ' ' . $cantidad . ' (' . $cantidad_letras . ')</li>';
              }
          }
      }

             ?>
             </ol>

        </div>




      </div>

      <style media="screen">
        .cabezera_derecha{
          /*background: #c1c1c1;*/
        }
      </style>
      <div class="cabezera_derecha">
        <div class="cabezera">
          <div class="bloque_gene_cabezera">
              <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_facturacion ?>" alt="">
          </div>


          <div class="bloque_gene_cabezera">
             <h2><?php echo $nombre_empresa ?></h2>
          </div>

          <div class="bloque_gene_cabezera">
            <img src="<?php echo $url_img_upload ?>/home/img/uploads/<?php echo $img_facturacion ?>" alt="">
          </div>
        </div>
        <hr>
        <br><br>
        <br>


        <div class="informacion_cita_medica">
          <table>
            <tbody>
                <tr>
                    <td><span class="negrita_cls" >PACIENTE</span> <?php echo $nombres_paciente ?></td>
                </tr>
                <tr>
                  <td><span class="negrita_cls" >IDENTIFICACION</span> <?php echo $identificacion_paciente ?></td>
                  <td><span class="negrita_cls" >HC</span> <?php echo $secuencial ?></td>
                  <td><span class="negrita_cls" >EDAD</span> <?php echo $anios ?> años con <?php echo $meses ?> meses</td>
                </tr>
                <tr>
                  <td><span class="negrita_cls" >FECHA</span> <?php echo $fecha_actual_con_ciudad ?></td>
                </tr>
            </tbody>
         </table>

        </div>

        <br>

  <p class="rp" >PRESCRIPCION:/</p>


        <div class="lista_indicaciones">
          <ol>



            <?php
            foreach ($medicamentos as $medicamento) {
                // Extraer y sanitizar los datos de cada medicamento
                $farmaco = isset($medicamento['farmaco']) ? mb_strtoupper(htmlspecialchars($medicamento['farmaco'])) : '';
                $dosis = isset($medicamento['dosis']) ? mb_strtoupper(htmlspecialchars($medicamento['dosis'])) : '';
                $observacion = isset($medicamento['observacion']) ? mb_strtoupper(htmlspecialchars($medicamento['observacion'])) : '';
                $cantidad = isset($medicamento['cantidad']) ? mb_strtoupper(htmlspecialchars($medicamento['cantidad'])) : '';
                $frecuencia = isset($medicamento['frecuencia']) ? mb_strtoupper(htmlspecialchars($medicamento['frecuencia'])) : '';
                $duracion = isset($medicamento['duracion']) ? mb_strtoupper(htmlspecialchars($medicamento['duracion'])) : '';

                // Verificar si el campo 'farmaco' tiene contenido
                if (!empty($farmaco)) {
                    $partes = explode('?', $farmaco);

                    // Asignar valores si existen en $partes, de lo contrario asignar una cadena vacía
                    $nombre_comercial = isset($partes[0]) ? $partes[0] : '';
                    $concentracion = isset($partes[1]) ? $partes[1] : '';
                    $farmacos_genericos = isset($partes[2]) ? $partes[2] : '';
                    $presentacion = isset($partes[3]) ? $partes[3] : '';
                    $via_administracion = isset($partes[4]) ? $partes[4] : '';

                    // Verificar que 'nombre_comercial' no esté vacío
                    if (!empty($nombre_comercial)) {

                      //echo "esta es la docis que vamos a ver $dosis transformamos a numeros";
                        $dosis_letras = mb_strtoupper(numeroALetras($dosis));
                        echo '<li>' . $nombre_comercial . ' ' . $concentracion . ' ' . $dosis_letras . ' ' . $presentacion . ' ' . $via_administracion . ' ' . $frecuencia . ' POR ' . $duracion . ' ' . $observacion . '</li>';
                    }
                }
            }


             ?>
      </ol>
        </div>
      </div>
    </div>
  </body>
</html>
