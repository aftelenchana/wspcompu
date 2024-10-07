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

    </style>


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

    <div class="line_uno"></div>
    <br>

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

    <div class="informacion_cita_medica">
      <table>
         <tbody>
             <tr>
                 <td><span class="negrita_cls" >FECHA CITA</span>  <?php echo $fecha_actual_con_ciudad ?> </td>
                 <td><span class="negrita_cls" >HORA DE IMPRESION</span> <?php echo $hora_actual ?></td>
                 <td><span class="negrita_cls" >CODIGO CONSULTA</span> <?php echo $codigo_consulta ?></td>
             </tr>
             <tr>
                 <td><span class="negrita_cls" >PACIENTE</span> <?php echo $nombres_paciente ?></td>
                  <td><span class="negrita_cls" >EDAD</span> <?php echo $anios ?> años con <?php echo $meses ?> meses</td>
                  <td><span class="negrita_cls" >GENERO</span> <?php echo $genero ?></td>
             </tr>
             <tr>
               <td><span class="negrita_cls" >IDENTIFICACION</span> <?php echo $identificacion_paciente ?></td>
                <td><span class="negrita_cls" >HC</span> <?php echo $secuencial ?></td>
                <td><span class="negrita_cls" >ESTADO CIVIL</span> <?php echo $estado_civil ?></td>

             </tr>
         </tbody>
     </table>

    </div>
    <br><br><br><br><br><br>
    <div class="line_uno"></div>
    <style media="screen">
      .informacion_medicamentos{
        margin-top: -90px;
        font-size: 12px;
        text-align: center;
      }
      .informacion_medicamentos tr,td{
        text-align: center;

      }
    </style>
    <div class="informacion_medicamentos">
      <?php
      echo '<table >';
      echo '<thead>';
      echo '<tr>';
      echo '<th>Medicamento</th>';
      echo '<th>Dosis</th>';
      echo '<th>Observación</th>';
      echo '</tr>';
      echo '</thead>';
      echo '<tbody>';

      // Recorrer el array de medicamentos
      foreach ($medicamentos as $medicamento) {
          // Extraer los datos de cada medicamento
          $farmaco = htmlspecialchars($medicamento['farmaco']);
          $dosis = htmlspecialchars($medicamento['dosis']);
          $observacion = htmlspecialchars($medicamento['observacion']);

          $partes = explode(' - ', $farmaco);

            $nombre = $partes[0];      // Amoxicilina
            $composicion = $partes[1];       // Pedrito
            $nombre_comercial = $partes[2]; // Hecha de azucar
            $codigo = $partes[3];      // 13448

          // Imprimir una fila en la tabla
          echo '<tr>';
          echo "<td>$nombre-$composicion-$nombre_comercial</td>";
          echo "<td>$dosis</td>";
          echo "<td>$observacion</td>";
          echo '</tr>';
      }

      // Cerrar la tabla HTML
      echo '</tbody>';
      echo '</table>';


       ?>
    </div>

    <br><br><br><br><br><br>
    <div class="line_uno"></div>

    <style media="screen">
      .informacion_medicamentos_diagnosticos{
        margin-top: -70px;
        font-size: 12px;
        text-align: center;
      }
      .informacion_medicamentos_diagnosticos tr,td{
        text-align: center;
      }

      .cuadro_medio_grande {
        height: 130px;
      }


      .cuadro_bajo {
        display: table-cell; /* Asegura que la celda se comporte como una celda de tabla */
        vertical-align: bottom; /* Alinea el contenido en la parte inferior */
          justify-content: flex-end; /* Empuja el contenido hacia abajo */
      }


    </style>

    <div class="informacion_medicamentos_diagnosticos">
      <table border="1">
        <thead>
          <tr>
            <th>DIAGNOSTICO</th>
            <th>DATOS DEL PRESCRIPTOR</th>
          </tr>
        </thead>
        <tbody>
          <tr class="cuadro_medio_grande">
            <td class="cuadro_medio_grande">
              <h3>DEFINITIVOS</h3>

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


            <h3>PRESUNTIVOS</h3>

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


            </td>
            <td class="cuadro_medio_grande cuadro_bajo">

              <div class="align-bottom">
                Dr(a):<?php echo $razon_social ?>
              </div>


            </td>
          </tr>

        </tbody>

      </table>

    </div>

    <style media="screen">
      .qr_consulta{
        text-align: left;
        page-break-after: 5px;
        margin: 5px;
      }
      .qr_consulta img{
        width: 150px;
      }
    </style>


    <div class="qr_consulta">
      <img src="<?php echo $filename ?>" alt="">
    </div>


  </body>
</html>
