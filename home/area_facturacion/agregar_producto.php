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


if ($_POST['action'] == 'agregar_producto') {
   $id_producto = $_POST['id_producto'];
   $codigo_factura = $_POST['codigo_factura'];
   $sucursal_facturacion = $_POST['sucursal_facturacion'];


   if ($sucursal_facturacion == '' || $sucursal_facturacion == '0') {
     $arrayName = array('noticia' =>'error_sin_sucursal');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    exit;
   }



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

    $cantidad_producto = 1;


    if ($tipo_ambiente == '2') {
    $iva = (12)/100;
    $complementoiva = 1- $iva;
  }else {
    $iva = 0;
    $complementoiva = 1- $iva;
  }

  $cantidad_descuento = '';


  if ($cantidad_descuento == '') {
    $cantidad_descuento='0';
    // code...
  }

  if ($id_producto != '' || $id_producto != '0') {

     }else {
       $foto = 'img_producto.png';
     }


  $iva_cantidad          = round((($valor_unidad*$cantidad_producto))*$iva,2);
  $iva_frontend          = round((($valor_unidad*$cantidad_producto)-$cantidad_descuento)*$iva,2);
  $subtotal_frontend = ($cantidad_producto*$valor_unidad)-$cantidad_descuento ;
  $precio_neto           = round($cantidad_producto*$valor_unidad,2) ;
  $precio_p_incluido_iva =$valor_unidad + $valor_unidad*(1-$complementoiva);

  $precio_p_incluido_iva = round($precio_p_incluido_iva,2);


     $query_insert=mysqli_query($conection,"INSERT INTO comprobantes (id_emisor,nombre_producto, descripcion_producto, valor_unidad,cantidad_producto,tipo_ambiente,codigos_impuestos,detalle_extra,precio_neto,iva_producto,precio_p_incluido_iva,id_producto,descuento,iva_frontend,subtotal_frontend,imagen,secuencial,estado_f,sucursal_facturacion)
    VALUES('$iduser','$nombre_producto', '$descripcion', '$valor_unidad','$cantidad_producto','$tipo_ambiente','$codigos_impuestos','','$precio_neto','$iva_cantidad','$precio_p_incluido_iva','$id_producto','$cantidad_descuento','$iva_frontend','$subtotal_frontend','$foto','$codigo_factura','PROCESO','$sucursal_facturacion') ");


  if ($query_insert) {

    $query_producto = mysqli_query($conection, "SELECT * FROM comprobantes WHERE comprobantes.id_emisor ='$iduser'  AND comprobantes.secuencial = '$codigo_factura'
    ORDER BY `comprobantes`.`fecha` DESC ");

  // Inicializar un arreglo para almacenar los resultados
  $resultados = array();

  // Recorrer los registros y agregarlos al arreglo
  while ($row = mysqli_fetch_assoc($query_producto)) {
      $resultados[] = $row;
  }


    echo json_encode($resultados,JSON_UNESCAPED_UNICODE);

  }else {
    $arrayName = array('noticia' =>'error_servidor');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }

 }

if ($_POST['action'] == 'agregar_produto_sin_registrar') {

    $codigo_factura       = $_POST['codigo_factura'];
    $sucursal_facturacion       = $_POST['sucursal_facturacion'];


    if ($sucursal_facturacion == '' || $sucursal_facturacion == '0') {
      $arrayName = array('noticia' =>'error_sin_sucursal');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     exit;
    }

  $descripcion       = $_POST['descripcion_producto'];
  $cantidad_producto       = $_POST['cantidad_producto'];
  $valor_unidad       = $_POST['valor_unidad'];
  $tipo_ambiente       = $_POST['tipo_ambiente'];
  $codigos_impuestos       = $_POST['codigos_impuestos'];
  $nombre_producto       = $_POST['nombre_producto'];
  $id_producto       = $_POST['id_producto_2'];

      if ($tipo_ambiente == '2') {
        $iva = (12)/100;
        $complementoiva = 1- $iva;
      }else {
        $iva = 0;
        $complementoiva = 1- $iva;
      }

      $cantidad_descuento = '';


      if ($cantidad_descuento == '') {
        $cantidad_descuento='0';
        // code...
      }


     $foto = 'img_producto.png';



      $iva_cantidad          = round((($valor_unidad*$cantidad_producto))*$iva,3);
      $iva_frontend          = round((($valor_unidad*$cantidad_producto)-$cantidad_descuento)*$iva,3);
      $subtotal_frontend = ($cantidad_producto*$valor_unidad)-$cantidad_descuento ;
      $precio_neto           = round($cantidad_producto*$valor_unidad,3) ;
      $precio_p_incluido_iva =$valor_unidad + $valor_unidad*(1-$complementoiva);


   $query_insert=mysqli_query($conection,"INSERT INTO comprobantes (id_emisor,nombre_producto, descripcion_producto, valor_unidad,cantidad_producto,tipo_ambiente,codigos_impuestos,detalle_extra,precio_neto,iva_producto,precio_p_incluido_iva,id_producto,descuento,iva_frontend,subtotal_frontend,imagen,secuencial,estado_f,sucursal_facturacion)
  VALUES('$iduser','$nombre_producto', '$descripcion', '$valor_unidad','$cantidad_producto','$tipo_ambiente','$codigos_impuestos','','$precio_neto','$iva_cantidad','$precio_p_incluido_iva','$id_producto','$cantidad_descuento','$iva_frontend','$subtotal_frontend','$foto','$codigo_factura','PROCESO','$sucursal_facturacion') ");


    if ($query_insert) {

      $query_producto = mysqli_query($conection, "SELECT * FROM comprobantes WHERE comprobantes.id_emisor ='$iduser'  AND comprobantes.secuencial = '$codigo_factura'
      ORDER BY `comprobantes`.`fecha` DESC ");

    // Inicializar un arreglo para almacenar los resultados
    $resultados = array();

    // Recorrer los registros y agregarlos al arreglo
    while ($row = mysqli_fetch_assoc($query_producto)) {
        $resultados[] = $row;
    }


      echo json_encode($resultados,JSON_UNESCAPED_UNICODE);

    }else {
      $arrayName = array('noticia' =>'error_servidor');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }


 }


 ?>
