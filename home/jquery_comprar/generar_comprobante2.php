<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar



if ($_POST['action'] == 'buscar_producto') {
  $busqueda = $_POST['busqueda'];
  $query_opciones = mysqli_query($conection,"SELECT * FROM producto_venta WHERE (producto_venta.nombre like '%$busqueda%') AND producto_venta.id_usuario= '$iduser'   AND producto_venta.estatus = 1");
  while ($producto = mysqli_fetch_array($query_opciones)) {
    echo '<option  producto="'.$producto['idproducto'].'" value="'.$producto['idproducto'].'">'.$producto['nombre'].'</option>';

  }
}

if ($_POST['action'] == 'buscar_usuarios') {
  $busqueda = $_POST['usuarios'];
  $query_opciones = mysqli_query($conection,"SELECT * FROM clientes WHERE (clientes.identificacion like '%$busqueda%' OR clientes.mail like '%$busqueda%')   AND clientes.iduser = '$iduser' AND clientes.estatus = '1'
  GROUP BY clientes.identificacion ");
  while ($producto = mysqli_fetch_array($query_opciones)) {
    if ($producto > 0) {
      echo '<option  usuarios="'.$producto['identificacion'].'" value="'.$producto['identificacion'].'">'.$producto['nombres'].' '.$producto['identificacion'].'</option>';
    }else {
      echo '<option  usuarios="" value=""> SIN RESULTADOS</option>';

    }
  }
}
 ?>
