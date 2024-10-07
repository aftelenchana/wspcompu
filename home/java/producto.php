<?php
session_start();
  include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
if ($_POST['action'] == 'infoproducto') {
$producto = $_POST['producto'];
  $query = mysqli_query($conection, "SELECT
    producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,
    producto_venta.foto,producto_venta.porcentaje,producto_venta.qr,usuarios.nombre_empresa,
    usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp,usuarios.tiktok,usuarios.img_logo,usuarios.id,
     producto_venta.fecha_producto,producto_venta.identificador_trabajo,producto_venta.fecha_sorteo,producto_venta.hora_sorteo,
     producto_venta.fecha_evento,producto_venta.hora_evento,producto_venta.tipo_servicio,producto_venta.cantidad_entradas,
     producto_venta.cantidad_boletos,usuarios.id as 'ide',producto_venta.ganancias_totales,producto_venta.forma,producto_venta.marca,
     producto_venta.peso,usuarios.nombres as 'nombre_usuario', usuarios.apellidos as 'apellidos_usuarios',provincia.nombre as 'provincia',ciudad.nombre as 'ciudad',
     subcategorias.nombre as 'subcategorias'
    FROM producto_venta
   INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
   INNER JOIN provincia ON producto_venta.provincia = provincia.id
   INNER JOIN ciudad ON producto_venta.ciudad = ciudad.id
   INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
      WHERE idproducto = $producto
      AND producto_venta.estatus = 1");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
    exit;

  // code...
}
 ?>
