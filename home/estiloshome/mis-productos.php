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
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  	<meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php if (empty($_GET['pagina'])) {
    	$pagina = 1;
    }else {
    	$pagina = $_GET['pagina'];
    }

     ?>

     <?php if (empty($_GET['pagina'])){?>
        <title>Mis Productos</title>
     <?php }?>
     <?php if (!empty($_GET['pagina'])){?>
        <title>Mis Productos Pag  <?php echo $_GET['pagina']; ?></title>
    <?php }?>
    <link rel="icon" href="/img/guibis.png">
  	<link href="https://fonts.googleapis.com/css2?family=Do+Hyeon&display=swap" rel="stylesheet">
  	<link rel="stylesheet" href="estiloshome/estilos_paginador.css">
    <link rel="stylesheet" href="estiloshome/modal_acciones_mis_productos.css">
    <link rel="stylesheet" href="estiloshome/prueba_cuadro.css">
    <link rel="stylesheet" href="estiloshome/correcciones1.css">
  	<link rel="stylesheet" href="emergencia/emergencia.css">
    <link rel="stylesheet" href="prueba_estilos/home.css">
    <link rel="stylesheet" href="jquery/foto_general.css">
    <link rel="stylesheet" href="jquery/foto_general2.css">
    <link rel="stylesheet" href="correcciones/index.css">
    <link rel="stylesheet" href="correcciones/pie_pagina.css">
    <link rel="stylesheet" href="/home/estiloshome/sin_resultados.css">
    <link rel="stylesheet" href="estiloshome/load.css">
  </head>
  <body>

    <script type="text/javascript" src="jquery/mostrar_productos_acciones.js"></script>


        </script>
        <?php include "scripts/menu.php" ?>
        <div class="modal_ver_comprar modal_principal">
          <div class="bodyModal_ver_comprar modal_secundario">

          </div>
        </div>
      <div class="modal_add_servicios modal_principal">
        <div class="bodyModal_add_servicios modal_secundario">
        </div>
      </div>

      <div class="modal_add_servicios_empre modal_principal">
        <div class="bodyModal_add_servicios_empre modal_secundario">
        </div>
      </div>

      <div class="modal_add_cuenta_digital modal_principal">
        <div class="bodyModal_add_cuenta_digital modal_secundario">
        </div>
      </div>
      <div class="modal_ver_producto modal_principal">
        <div class="bodyModal_ver_producto modal_secundario">
        </div>
      </div>

      <div class="modal_editar_producto modal_principal">
        <div class="bodyModal_editar_producto modal_secundario">

        </div>
      </div>

      <div class="modal_boletos_electronicos modal_principal">
        <div class="bodyModal_boletos_electronicos modal_secundario">

        </div>
      </div>

      <div class="modal_add_entradas_eventos modal_principal">
        <div class="bodyModal_add_entradas_eventos modal_secundario">

        </div>
      </div>

      <div class="modal_eliminar_producto modal_principal">
        <div class="bodyModal_eliminar_producto modal_secundario">


        </div>
      </div>


      <div class="tutu_product">
        <h3>Agrega tus productos y tus servicios</h3>
      </div>

<div class="servicios_totales">
  <div class="agrergar_producto_tienda">
    <div class="content_producto">
    <h4>Agrega un nuevo producto</h4>
    <p>Agrega un producto a tu tienda, llena la informacion completa para que tus clientes te encuentren, y te compren de una manera segura</p><br>
    <a  href="elegir_categoria"> Agregar un nuevo producto <img src="img/reacciones/etiqueta.png" alt=""> </a><br>
    </div>
  </div>
  <div class="agrergar_servicio_tienda">
    <h4>Agregar un Evento de Racaudacion</h4>
    <p>Crea un evento de recaudación para que las personas te donen y aparezcan en el perfil de cada recaudación, este es un servicio Electrónico.</p><br>
    <a class="add_evento_recaudacion" usuario="<?php echo $iduser; ?>" href="#"> Agregar un evento de Recaudación.  <img src="img/reacciones/dar-dinero.png" alt=""></a><br>
  </div>

</div>



<div class="servicios_totales">
  <div class="agrergar_servicio_tienda">
    <h4>Agregar una Suscripción </h4>
    <p>Aquí tienes una opción para tus servicios por suscripción, ingresa los datos necesarios y ponte en contacto con nuestros desarrolladores para que te ayuden a conectarte mediante nuestra API REST para tener toda la información. </p><br>
    <a class="add_suscripcion" usuario="<?php echo $iduser; ?>" href="#">Agregar una Suscripción <img src="img/reacciones/suscripcion.png" alt="img/reacciones/suscripcion.png"></a><br>
  </div>
  <div class="agrergar_servicio_tienda">
    <h4>Crear un evento y entradas</h4>
    <p>Agrega un evento deprotivo, artisitico, cultural y vende las entradas por este medio, entradas descargables con codigo QR  de una manera facil y segura,entradas descargables con codigo QR  de una manera facil y segura segura.</p><br>
    <a class="add_entradas_digitales"  href="#"> Agregar un nuevo Evento <img src="img/reacciones/servicios.png" alt=""></a><br>
  </div>
</div>

<div class="tipos_enlaces" style="text-align: center;width: 50%;margin: 0 auto;">
  <div class="clase1" style="display: inline-block;background: #9EEA8B;padding: 5px;border-radius: 5px;margin: 1px;width: 40%;">
    <a href="mis-productos">Mis Productos</a>
  </div>
  <div class="clase1" style="display: inline-block;background: #7AD7EB;padding: 5px;border-radius: 5px;margin: 1px;width: 40%;">
    <a href="mis-eventos-recaudables">Eventos Recaudables</a>
  </div>
</div>
<div class="tipos_enlaces" style="text-align: center;width: 50%;margin: 0 auto;">
  <div class="clase1" style="display: inline-block;background: #9EEA8B;padding: 5px;border-radius: 5px;margin: 1px;width: 40%;">
    <a href="mis-servicio-suscripcion">Mis servicios de Suscripción </a>
  </div>
</div>










<div class="total_comerse">
<?php
$sql_registe = mysqli_query($conection,"SELECT COUNT(*) as  total_registro FROM producto_venta WHERE estatus = 1 and id_usuario=$iduser and  identificador_trabajo='producto'");
$result_register = mysqli_fetch_array($sql_registe);
$total_registro = $result_register['total_registro'];
$por_pagina = 15;
if (empty($_GET['pagina'])) {
	$pagina = 1;
}else {
	$pagina = $_GET['pagina'];
}
$desde = ($pagina-1)*$por_pagina;
$total_paginas = ceil($total_registro/$por_pagina);

$id_user           =  $_SESSION['id'];
$query_lista = mysqli_query($conection,"SELECT * FROM producto_venta where estatus = 1 and id_usuario=$iduser AND identificador_trabajo='producto' ORDER BY idproducto DESC LIMIT $desde,$por_pagina");
$result_lista= mysqli_num_rows($query_lista);
if ($result_lista > 0) {
      while ($data_lista=mysqli_fetch_array($query_lista)) {
        $foto = 'img/uploads/'.$data_lista['foto'];
?>
<div class="producto_vista row<?php echo $data_lista['idproducto'] ?>" >
            <div class="tabla_producto">
              <table>
                <tr class="img_producto">
                  <td class="fila_img_producto"> <a href="producto?idp=<?php echo $data_lista['idproducto']; ?>"> <img src="<?php echo "$foto"; ?>" alt=""></a> </td>
                </tr>
                <tr class="nomnre_producto_j">
                  <td class="fila_nombre_producto"> <a href="producto?idp=<?php echo $data_lista['idproducto']; ?>"> <?php echo $data_lista['nombre']; ?></a> </td>
                </tr>
                <tr class="precio_columna">
                  <td class="fila_precio">$<?php echo $data_lista['precio']; ?></td>
                </tr>
                <tr class=" acciones">
                  <td> <a class="ver_producto" producto="<?php echo $data_lista['idproducto']; ?>" href="#">Ver <img src="img/reacciones/ver.png" alt=""> </a> </td>
                </tr>

                <tr class=" acciones">
                  <td> <a class="eliminar_producto" producto="<?php echo $data_lista['idproducto']; ?>" href="#">Eliminar <img src="img/reacciones/borrar2.png" alt=""> </a> </td>
                </tr>
              </table>
            </div>
</div>



<?php
     }
   }

 ?>

</div>


<?php if ($total_registro == 0): ?>
  <div class="contene_sin_resultados">
    <div  class="texto_sin_resultados">
      <p>No existe Resultados </p>
    </div>
    <div class="img_sin_resultados">
      <img src="/home/img/reacciones/sin-contenido.png" alt="">
    </div>
  </div>
<?php endif; ?>
<div class="paginador">
 <ul>
   <?php
   if ($pagina != 1) {
     // code...

    ?>
   <li> <a href="?pagina=<?php echo 1; ?>">|<</a></li>

   <li> <a href="?pagina=<?php echo $pagina-1; ?>"><<</a></li>
   <?php
 }

 ?>
<li> <a href=""><?php echo "$pagina"; ?> </a></li>
 <?php


   if ($pagina != $total_paginas) {
    ?>
   <li> <a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>

   <li> <a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
   <?php 	} ?>
 </ul>
</div>
    <?php
        require "scripts/footer.php";

     ?>




 <script type="text/javascript" src="jquery/jquery.min.js"></script>
  <script type="text/javascript" src="jquery/home.js"></script>
  <script type="text/javascript" src="jquery/mis_productos.js"></script>
    <script type="text/javascript" src="jquery/mostrar_productos_acciones.js"></script>
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js"></script>
  <script src="main.js"></script>



  </body>
</html>
