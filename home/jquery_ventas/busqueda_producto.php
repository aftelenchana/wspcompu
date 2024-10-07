<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");

use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
include "../../coneccion.php";
session_start();
$iduser= $_SESSION['id'];
$query = mysqli_query($conection, "SELECT usuarios.email, usuarios.nombres, usuarios.apellidos,usuarios.mi_leben FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$email = $result['email'];
$nombres = $result['nombres'];
$apellidos = $result['apellidos'];
$mi_leben = $result['mi_leben'];

$id_producto = $_POST['id_producto'];
$id_comprador = $_POST['id_comprador'];
$query_producto = mysqli_query($conection, "SELECT
  producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,producto_venta.id_usuario,
  producto_venta.foto,producto_venta.porcentaje,producto_venta.qr,usuarios.nombre_empresa,
  usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp,usuarios.tiktok,usuarios.img_logo,usuarios.id,
   producto_venta.fecha_producto,producto_venta.identificador_trabajo,producto_venta.fecha_sorteo,producto_venta.hora_sorteo,
   producto_venta.fecha_evento,producto_venta.hora_evento,producto_venta.tipo_servicio,producto_venta.cantidad_entradas,
   producto_venta.cantidad_boletos,usuarios.id as 'id_user',producto_venta.ganancias_totales,producto_venta.forma,producto_venta.marca,
   producto_venta.peso,usuarios.nombres as 'nombre_usuario', usuarios.apellidos as 'apellidos_usuarios',provincia.nombre as 'provincia',ciudad.nombre as 'ciudad',
   subcategorias.nombre as 'subcategorias',categorias.nombre as 'categorias',usuarios.mi_leben
  FROM producto_venta
 INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
 INNER JOIN provincia ON producto_venta.provincia = provincia.id
 INNER JOIN ciudad ON producto_venta.ciudad = ciudad.id
 INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
 INNER JOIN categorias ON producto_venta.categorias = categorias.id
    WHERE idproducto = $id_producto
    AND producto_venta.estatus = 1");
    $data_producto = mysqli_fetch_array($query_producto);
      $img_producto =  $data_producto['foto'];
      $id_usuario_producto =  $data_producto['id_usuario'];
      if ($id_usuario_producto!=$iduser ) {
        echo "ERROR DE PRIVACIDAD";
        exit;
      }

      $query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $id_comprador");
      $result = mysqli_fetch_array($query);
      $email_usuario = $result['email'];
      $email = $result['email'];
      $nombres = $result['nombres'];
      $apellidos = $result['apellidos'];
      $mi_leben = $result['mi_leben'];
      echo '
      <div class="img_resultado">
        <img src="/home/img/uploads/'.$img_producto.'" alt="">
      </div>
      <div class="tabla_resultados">
        <h4>Información del Producto</h4>
        <table>
          <tr>
            <td>Nombre</td>
            <td>'.$data_producto['nombre'].'</td>
          </tr>
          <tr>
            <td>Precio</td>
            <td>$'.$data_producto['precio'].'</td>
          </tr>
        </table>
      </div>

      <div class="resultado_comprador">
        <h4>Información del Comprador</h4>
        <table>
          <tr>
            <td>Nombres:</td>
            <td>'.$result['nombres'].' '.$result['apellidos'].'</td>
          </tr>
          <tr>
            <td>Cedula de Identidad</td>
            <td>'.$result['numero_identidad'].'</td>
          </tr>
          <tr>
            <td>Fecha-Cuenta</td>
            <td>'.$result['fecha_creacion'].'</td>
          </tr>
        </table>
      </div>


      ';
 ?>
