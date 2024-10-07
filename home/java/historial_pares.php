<?php
require "../../../coneccion.php" ;
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
  session_start();
 $numero_identidad= $_SESSION['numero_identidad'];
 echo "$numero_identidad";
   if (empty($_SESSION['active'])) {
     header('location:/zapateria3/');
   }
   $query_cortado = mysqli_query($conection,"SELECT * FROM `trabajadores_zapateria` WHERE cedula = $numero_identidad ");
   $result_cortado  =mysqli_fetch_array($query_cortado);
   $nombres_cortador = $result_cortado['nombres'];
   $apellidos_cortador = $result_cortado['apellidos'];
   $foto_cortador = $result_cortado['foto'];
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Area  Armado GBS</title>
    <link rel="shortcut icon" href="img/favicon.png">
    <link rel="stylesheet" href="/home/prueba_estilos/mostrar_foto.css">
    <link rel="stylesheet" href="/home/correcciones/index.css">
    <link rel="stylesheet" href="/estilos/pie_pagina.css">
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/estilos/estilos-generales.css">
    <link rel="stylesheet" href="/home/estiloshome/estilos_contador.css">
      <link rel="stylesheet" href="/home/emergencia/emergencia.css">
    <link rel="stylesheet" href="/correcciones/index.css">
      <link rel="stylesheet" href="/home/estiloshome/load.css">
      <link rel="stylesheet" href="../estilos/cortado.css">
        <link rel="stylesheet" href="/home/estiloshome/modal_index.css">
  </head>
  <body>
      <?php require "../php/menu.php" ?>
      <div class="modal_vista_general modal_principal">
        <div class="bodyModal_vista_general modal_secundario">
        </div>
      </div>
      <div class="">
        <h3 style="text-align: center;font-size: 35px;">Area Armado GBS</h3>
      </div>
      <div style="text-align: center;border-radius: 100%;" class="img_perfil_sd">
        <img style="width: 120px;margin: 0 auto;text-align: center;border-radius: 100%;" src="/tablero/control/img/trabajadores_zapateria/<?php echo $foto_cortador ?>" alt="">
      </div>
      <div class="historial">
        <p style="margin: 20px;padding: 10px;text-align: center;">Hola <span style="color: #232F3E;font-weight: bold;font-size: 20px;"><?php echo "$nombres_cortador"; echo " "; echo "$apellidos_cortador"; ?></span> Bienvenido al Area de Cortado
          en el  Sistema de Guibis, trabajemos juntos para crecer juntos.
         </p>
      </div>
      <div style="text-align: center;border: solid 1px #c1c1c1;width: 50%;margin: 0 auto;padding: 8px;border-collapse: collapse;" class="">
        <a style="border: solid 1px #c1c1c1;padding: 8px;background: #DAF7A6;" href="historial_docenas.php">Historial Docenas</a>
        <a style="border: solid 1px #c1c1c1;padding: 8px;background: #DAF7A6;" href="historial_pares.php">Historial Pares</a>
      </div>
              <br>

      <div class="contendio_pedidos">
        <table>
          <tr class="titu_table">
            <td>ID</td>
            <td>Nombre</td>
            <td>Estado</td>
            <td>Cantidad</td>
            <td>Imagen</td>
            <td>Piezas</td>
            <td>Fecha Inicio</td>
            <td>Codigo Qr</td>
            <td>Acciones</td>
          </tr>
          <?php
          //PAGINADOR
          $sql_registe = mysqli_query($conection,"SELECT COUNT(*) as  total_registro FROM  `ventas`
INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
INNER JOIN factores_calzado ON factores_calzado.id_producto = ventas.idp
INNER JOIN proceso_fabricacion_zapatos ON proceso_fabricacion_zapatos.id_venta=ventas.id
WHERE producto_venta.subcategorias = 11 AND proceso_fabricacion_zapatos.estado_preparado ='No Iniciada' AND ventas.estado = 'Iniciada' ");
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

            $query_lista = mysqli_query($conection,"SELECT  proceso_fabricacion_zapatos.id as 'id_proceso',producto_venta.nombre as 'nombre_producto',ventas.cantidad_producto,producto_venta.foto,
              factores_calzado.piezas,proceso_fabricacion_zapatos.resp_preparado,ventas.fecha,ventas.qr_venta,
              proceso_fabricacion_zapatos.estado_armado,ventas.id as 'ventas_id'  FROM `ventas`
INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
INNER JOIN factores_calzado ON factores_calzado.id_producto = ventas.idp
INNER JOIN proceso_fabricacion_zapatos ON proceso_fabricacion_zapatos.id_venta=ventas.id
WHERE  resp_armado='$numero_identidad'
       ORDER BY ventas.fecha ASC LIMIT $desde,$por_pagina");
            $result_lista= mysqli_num_rows($query_lista);
            if ($result_lista > 0) {
                  while ($data_lista=mysqli_fetch_array($query_lista)) {
                  $proceso =  $data_lista['id_proceso'];
                  $estado_armado =  $data_lista['estado_armado']
              ?>
          <tr>
            <td class="hgf" data-titulo="Venta:"> <a href="#"><?php echo $data_lista['ventas_id']; ?></a> </td>
            <td data-titulo="Producto:"><?php echo $data_lista['nombre_producto']; ?></td>
            <td data-titulo="Estado:"><?php echo $data_lista['estado_armado']; ?></td>
            <td data-titulo="Cantidad:"><?php echo $data_lista['cantidad_producto']; ?></td>
            <td data-titulo="Imagen:"> <img src="/home/img/uploads/<?php echo $data_lista['foto']; ?>" width="70px;" alt=""> </td>
            <td data-titulo="Piezas:"><?php echo $data_lista['piezas']; ?></td>
            <td data-titulo="Fecha Inicio:"><?php echo $data_lista['fecha']; ?></td>
            <td data-titulo="Codigo Qr:"> <a href="/home/img/qr_ventas/<?php echo $data_lista['qr_venta']; ?>" download>Descargar Qr</a> </td>
            <td data-titulo="Proceso:">
              <p>
              <?php if ($estado_armado == 'No Iniciada'): ?>
                  <a style="display: block;background: #FFC300;" class="validar_proceso" proceso="<?php echo $data_lista['ventas_id']; ?>"  href="">Validar Proceso </a>
                <?php endif; ?>
                <?php if ($estado_armado == 'Iniciada'): ?>
                  <a style="background: #2A9723;padding: 6px;" href="armado2.php?idproceso=<?php echo $data_lista['ventas_id']; ?>">Ver Proceso</a>
                <?php endif; ?>
                <?php if ($estado_armado == 'Finalizada'): ?>
                  <a style="background: #2A9723;padding: 6px;" href="armado2.php?idproceso=<?php echo $data_lista['ventas_id']; ?>">Ver Proceso</a>
                <?php endif; ?>
              </p>

            </td>
          </tr>
          <?php
          }
        }
      ?>

        </table>

      </div>

  </body>
  <script type="text/javascript" src="/home/jquery/jquery.min.js"></script>
  <script src="/home/jquery/simplyCountdown.min.js"></script>
  <script src="/home/java/cambio_img.js"></script>
  	<script src="https://kit.fontawesome.com/2c36e9b7b1.js"></script>
  	<script src="/home/main.js"></script>
    <script src="java/armado.js"></script>
    <script src="java/armado_interno.js"></script>
</html>
