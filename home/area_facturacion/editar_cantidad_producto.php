<?php

require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones

session_start();



 require '../QR/phpqrcode/qrlib.php';
 include "../../coneccion.php";
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }

    if ($_SESSION['rol'] == 'Mesero') {
    include "../sessiones/session_cuenta_mesero.php";

    }

    if ($_SESSION['rol'] == 'Cocina') {
    include "../sessiones/session_cuenta_cocina.php";
    }


if ($_POST['action'] == 'editar_cantidad_producto') {
  $cantidad_producto = $_POST['valor'];
  $idItem = $_POST['idItem'];
  $porcentaje_descuento = $_POST['porcentaje_descuento'];

  if ($cantidad_producto === '0' || $cantidad_producto === '' || strtolower($cantidad_producto) === 'nan') {
      $arrayName = array('noticia' => 'cero_no_valida');
      echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
      exit;
  }


   $query_comprobante = mysqli_query($conection, "SELECT * FROM comprobantes WHERE  comprobantes.id = '$idItem'
   ORDER BY `comprobantes`.`fecha` DESC ");
  $data_comprobante = mysqli_fetch_array($query_comprobante);
  $id_producto = $data_comprobante['id_producto'];

   $query_producto = mysqli_query($conection,"SELECT producto_venta.idproducto,producto_venta.precio,producto_venta.precio_costo,producto_venta.nombre,producto_venta.valor_unidad_final_con_impuestps,
     producto_venta.descripcion,producto_venta.tipo_ambiente,producto_venta.codigos_impuestos,producto_venta.foto
     FROM producto_venta WHERE producto_venta.idproducto ='$id_producto'");
    $data_producto = mysqli_fetch_array($query_producto);

    $valor_unidad_final_con_impuestps = $data_producto['valor_unidad_final_con_impuestps'];
    $valor_unidad       = $data_producto['precio'];
    $precio_costo = $data_producto['precio_costo'];
    $nombre_producto       = $data_producto['nombre'];
    $descripcion       = $data_producto['descripcion'];

    $codigos_impuestos       = $data_producto['codigos_impuestos'];
    $tipo_ambiente       = $data_producto['tipo_ambiente'];
    $foto       = $data_producto['foto'];


    if (empty($porcentaje_descuento)) {
      $porcentaje_descuento = 0;
    }

    $cantidad_descuento =round(($valor_unidad*$cantidad_producto*$porcentaje_descuento/100),2);


    if ($tipo_ambiente == '2') {
    $iva = (12)/100;
    $complementoiva = 1- $iva;
  }else {
    $iva = 0;
    $complementoiva = 1- $iva;
  }

  if ($id_producto != '' || $id_producto != '0') {

     }else {
       $foto = 'img_producto.png';
     }


  $iva_cantidad          = round((($valor_unidad*$cantidad_producto))*$iva,3);
  $iva_frontend          = round((($valor_unidad*$cantidad_producto)-$cantidad_descuento)*$iva,3);
  $subtotal_frontend = ($cantidad_producto*$valor_unidad)-$cantidad_descuento ;
  $precio_neto           = round($cantidad_producto*$valor_unidad,3) ;
  $precio_p_incluido_iva =$valor_unidad + $valor_unidad*(1-$complementoiva);


     $query_edit=mysqli_query($conection,"UPDATE comprobantes SET
       cantidad_producto = '$cantidad_producto', precio_neto = '$precio_neto',iva_producto = $iva_cantidad
       ,precio_p_incluido_iva = '$precio_p_incluido_iva',iva_frontend = '$iva_frontend', subtotal_frontend = '$subtotal_frontend',descuento='$cantidad_descuento',
       porcentaje_descuento='$porcentaje_descuento'
                WHERE id = $idItem");


  if ($query_edit) {
    $query_comprobante = mysqli_query($conection, "SELECT * FROM comprobantes WHERE comprobantes.id_emisor ='$iduser'  AND comprobantes.id = '$idItem'
    ORDER BY `comprobantes`.`fecha` DESC ");
   $data_comprobante = mysqli_fetch_array($query_comprobante);
     $valor_unidad       = $data_comprobante['valor_unidad'];
     $cantidad_producto       = $data_comprobante['cantidad_producto'];
     $precio_neto       = $data_comprobante['precio_neto'];
     $iva_producto       = $data_comprobante['iva_producto'];
     $precio_p_incluido_iva       = $data_comprobante['precio_p_incluido_iva'];
     $iva_frontend       = $data_comprobante['iva_frontend'];
     $subtotal_frontend       = $data_comprobante['subtotal_frontend'];

   $arrayName = array('noticia' =>'editado_correctamente','valor_unidad' =>$valor_unidad,'cantidad_producto' =>$cantidad_producto,'precio_neto' =>$precio_neto,'iva_producto' =>$iva_producto,'precio_p_incluido_iva' =>$precio_p_incluido_iva,
   'iva_frontend' =>$iva_frontend,'subtotal_frontend' =>$subtotal_frontend,'cantidad' =>$cantidad_producto,'idItem' =>$idItem,'porcentaje_descuento' =>$porcentaje_descuento,'cantidad_descuento' =>$cantidad_descuento);
 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

  }else {
    $arrayName = array('noticia' =>'error_servidor');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }







 }


 ?>
