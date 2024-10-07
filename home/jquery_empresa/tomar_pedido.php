<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include_once '../../crud_2020_ajax/bd/conexion.php';
include "../../coneccion.php";
 require '../QR/phpqrcode/qrlib.php';
$objeto = new Conexion();
$conexion = $objeto->Conectar();

$opcion               = (isset($_POST['opcion'])) ? $_POST['opcion'] : '';
$nombre_producto      = (isset($_POST['nombre_producto'])) ? $_POST['nombre_producto'] : '';
$foto      = (isset($_POST['foto'])) ? $_POST['foto'] : '';
$descripcion_producto = (isset($_POST['descripcion_producto'])) ? $_POST['descripcion_producto'] : '';
$valor_unidad         = (isset($_POST['valor_unidad'])) ? $_POST['valor_unidad'] : '';
$cantidad_producto    = (isset($_POST['cantidad_producto'])) ? $_POST['cantidad_producto'] : '';
$tipo_ambiente        = (isset($_POST['tipo_ambiente'])) ? $_POST['tipo_ambiente'] : '';
$codigos_impuestos    = (isset($_POST['codigos_impuestos'])) ? $_POST['codigos_impuestos'] : '';
$detalle_extra        = (isset($_POST['detalle_extra'])) ? $_POST['detalle_extra'] : '';
$idproducto           = (isset($_POST['detalle_extra'])) ? $_POST['idproducto'] : '';
$codigo_qr           = (isset($_REQUEST['codigo'])) ? $_REQUEST['codigo'] : '';
$cantidad_descuento           = (isset($_REQUEST['cantidad_descuento'])) ? $_REQUEST['cantidad_descuento'] : '0';

$pedido_generado           = (isset($_REQUEST['pedido_generado'])) ? $_REQUEST['pedido_generado'] : '';
$codigo_mesa           = (isset($_REQUEST['pedido_generado'])) ? $_REQUEST['codigo_mesa'] : '';



switch($opcion){
    case 1:
        if ($tipo_ambiente == '2') {
          $iva = (12)/100;
          $complementoiva = 1- $iva;
        }else {
          $iva = 0;
          $complementoiva = 1- $iva;
        }
        if ($cantidad_descuento == '') {
          $cantidad_descuento='0';
          // code...
        }
        $iva_cantidad          = round((($valor_unidad*$cantidad_producto))*$iva,3);
        $iva_frontend          = round((($valor_unidad*$cantidad_producto)-$cantidad_descuento)*$iva,3);
        $subtotal_frontend = ($cantidad_producto*$valor_unidad)-$cantidad_descuento ;
        $precio_neto           = round($cantidad_producto*$valor_unidad,3) ;
        $precio_p_incluido_iva =$valor_unidad + $valor_unidad*(1-$complementoiva);

        if ($idproducto != '' || $idproducto != '0') {

        }else {
          $foto = 'img_producto.png';
        }

         $query_verificador_estado = mysqli_query($conection, "SELECT * FROM  pedidos_restaurant  WHERE  pedidos_restaurant.id_emisor  = $iduser AND pedidos_restaurant.IDROLPUNTOVENTA='ADMIN' ORDER BY id DESC LIMIT 1");
         $result_verificador_estado = mysqli_fetch_array($query_verificador_estado);

        if ($result_verificador_estado) {
          $estado_pedido = $result_verificador_estado['estado_pedido'];
          if ($estado_pedido == 'INICIADO') {
              $secuencial = $result_verificador_estado['secuencial'];
          }else {
            $secuencial = $result_verificador_estado['secuencial'];
              $secuencial = $secuencial +1;
            // code...
          }


        }else {


             $secuencial =1;
        }


        $consulta = "INSERT INTO pedidos_restaurant (id_emisor,nombre_producto, descripcion_producto, valor_unidad,cantidad_producto,tipo_ambiente,codigos_impuestos,detalle_extra,precio_neto,iva_producto,precio_p_incluido_iva,id_producto,descuento,iva_frontend,subtotal_frontend,imagen,secuencial)
        VALUES('$iduser','$nombre_producto', '$descripcion_producto', '$valor_unidad','$cantidad_producto','$tipo_ambiente','$codigos_impuestos','$detalle_extra','$precio_neto','$iva_cantidad','$precio_p_incluido_iva','$idproducto','$cantidad_descuento','$iva_frontend','$subtotal_frontend','$foto','$secuencial') ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM pedidos_restaurant WHERE  estado_pedido ='INICIADO' AND id_emisor = '$iduser' ORDER BY id  DESC LIMIT 1";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 2:
        $consulta = "UPDATE usuarios SET username='$username', first_name='$first_name', last_name='$last_name', gender='$gender', password='$password', status='$status' WHERE user_id='$user_id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();

        $consulta = "SELECT * FROM usuarios WHERE user_id='$user_id' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 3:
        $id_fila  = (isset($_POST['id_fila'])) ? $_POST['id_fila'] : '';
        $consulta = "DELETE FROM comprobantes WHERE id='$id_fila' ";
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 4:
        $consulta = "SELECT * FROM pedidos_restaurant WHERE id_emisor ='$iduser' AND pedidos_restaurant.estado_pedido ='INICIADO' AND pedidos_restaurant.IDROLPUNTOVENTA='ADMIN'  ORDER BY id DESC" ;
        $resultado = $conexion->prepare($consulta);
        $resultado->execute();
        $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 77:
       $consulta = "SELECT * FROM producto_venta ORDER BY id DESC LIMIT 1";
       $resultado = $conexion->prepare($consulta);
       $resultado->execute();
       $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
        break;
    case 8:
      $consulta = "DELETE FROM pedidos_restaurant WHERE id_emisor='$iduser' AND pedidos_restaurant.estado_pedido ='INICIADO' AND pedidos_restaurant.IDROLPUNTOVENTA='ADMIN'  ";
      $resultado = $conexion->prepare($consulta);
      $resultado->execute();
      $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
      $consulta = "SELECT * FROM pedidos_restaurant WHERE id_emisor='$iduser'";
      $resultado = $conexion->prepare($consulta);
      $resultado->execute();
      $data=$resultado->fetchAll(PDO::FETCH_ASSOC);
      break;
      //ESTA ES LA INTANCIA DONDE SE ENVIA LOS PEDIDOS
      case 10:


      $img_nombre = 'guibis'.md5(date('d-m-Y H:m:s'));
      $qr_img = $img_nombre.'.png';
      $contenido = md5(date('d-m-Y H:m:s').$iduser);

      $direccion = '../img/qr/';
      $filename = $direccion.$qr_img;
      $tamanio = 7;
      $level = 'H';
      $frameSize = 5;
      $contenido = $contenido;
      QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);



      $consulta = "UPDATE pedidos_restaurant SET estado_pedido='ENVIADO',qr_imagen = '$qr_img',qr_contenido='$contenido',codigo_mesa = '$codigo_mesa'  WHERE id_emisor='$iduser' AND secuencial = '$pedido_generado' AND pedidos_restaurant.IDROLPUNTOVENTA='ADMIN' ";
      $resultado = $conexion->prepare($consulta);
      $resultado->execute();

      $consulta = "SELECT * FROM pedidos_restaurant WHERE id_emisor='$iduser' AND estado_pedido ='INICIADO' ORDER BY id DESC ";
      $resultado = $conexion->prepare($consulta);
      $resultado->execute();
      $data=$resultado->fetchAll(PDO::FETCH_ASSOC);

      break;

}

print json_encode($data, JSON_UNESCAPED_UNICODE);//envio el array final el formato json a AJAX
$conexion=null;
