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


if ($_POST['action'] == 'agregar_metodo_pago') {
   $codigo_factura = $_POST['codigo_factura'];
   $formaPago = $_POST['formaPago'];
   $cantidad_metodo_pago = $_POST['cantidad_metodo_pago'];
    $code_sucursal = $_POST['sucursal_facturacion'];





    $query_verificador_existencia_sucursal = mysqli_query($conection, "SELECT * FROM sucursales WHERE  sucursales.id = '$code_sucursal'");
    $data_sucursal =mysqli_fetch_array($query_verificador_existencia_sucursal);

    $direccion_sucursal        = $data_sucursal['direccion_sucursal'];

    $estableciminento_f  = str_pad($data_sucursal['establecimiento'], 3, "0", STR_PAD_LEFT);
    $punto_emision_f  = str_pad($data_sucursal['punto_emision'], 3, "0", STR_PAD_LEFT);

    $fecha_actual = date("d-m-Y");
    $fecha =  str_replace("-","/",date("d-m-Y",strtotime($fecha_actual." - 0 hours")));


    //codigo para sacar la secuencia del usuario

    $establecimiento_sinceros        = $data_sucursal['establecimiento'];
    $punto_emision_sinceros        = $data_sucursal['punto_emision'];


   $query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
   'compra_total', SUM(((comprobantes.iva_frontend))) AS 'iva_general',
   SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(comprobantes.descuento) AS 'descuento_total'
   FROM `comprobantes`
   WHERE comprobantes.id_emisor = '$iduser'  AND comprobantes.secuencial = '$codigo_factura'");
   $data_lista_t=mysqli_fetch_array($query_lista_t);

   $total_real_factura = number_format(($data_lista_t['compra_total']+$data_lista_t['iva_general']-$data_lista_t['descuento_total']),2);



   $query_forma_pago = mysqli_query($conection,"SELECT SUM(((formas_pago_facturacion.cantidad_metodo_pago))) as 'cantidad_metodo_pago'
     FROM formas_pago_facturacion  WHERE formas_pago_facturacion.iduser ='$iduser' AND formas_pago_facturacion.codigo_factura = '$codigo_factura'");
    $data_forma_pago = mysqli_fetch_array($query_forma_pago);
        $cantidad_metodo_pago_base  = $data_forma_pago['cantidad_metodo_pago'];



    if ($cantidad_metodo_pago_base != 0 || !empty($cantidad_metodo_pago_base)) {

      $cantidad_metodo_pago_base = $cantidad_metodo_pago_base+$cantidad_metodo_pago;


      if ($cantidad_metodo_pago_base <= $total_real_factura) {



        $query_insert=mysqli_query($conection,"INSERT INTO formas_pago_facturacion (iduser,codigo_factura, formaPago,cantidad_metodo_pago,sucursal_facturacion,establecimiento,punto_emision)
       VALUES('$iduser','$codigo_factura', '$formaPago', '$cantidad_metodo_pago','$code_sucursal','$establecimiento_sinceros','$punto_emision_sinceros') ");

     }else {
       $arrayName = array('noticia' =>'sobrepasa_total','cantidad_metodo_pago_base' =>$cantidad_metodo_pago_base,'total_real_factura' =>$total_real_factura);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     exit;
     }

    }else {
      $query_insert=mysqli_query($conection,"INSERT INTO formas_pago_facturacion (iduser,codigo_factura, formaPago,cantidad_metodo_pago,sucursal_facturacion,establecimiento,punto_emision)
     VALUES('$iduser','$codigo_factura', '$formaPago', '$cantidad_metodo_pago','$code_sucursal','$establecimiento_sinceros','$punto_emision_sinceros') ");

    }


  if ($query_insert) {

    $query_forma_pago = mysqli_query($conection, "SELECT * FROM formas_pago_facturacion WHERE formas_pago_facturacion.iduser ='$iduser'  AND formas_pago_facturacion.codigo_factura = '$codigo_factura'
      		AND formas_pago_facturacion.establecimiento = '$establecimiento_sinceros' AND formas_pago_facturacion.punto_emision = '$punto_emision_sinceros'
    ORDER BY `formas_pago_facturacion`.`fecha` DESC ");

  $resultados = array();

  while ($row = mysqli_fetch_assoc($query_forma_pago)) {
      $resultados[] = $row;
  }
    echo json_encode($resultados,JSON_UNESCAPED_UNICODE);

  }else {
    $arrayName = array('noticia' =>'error_servidor');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }

 }

if ($_POST['action'] == 'eliminar_metodo_pago') {
     $pago = $_POST['pago'];

     $query_eliminar_pago = mysqli_query($conection,"DELETE FROM formas_pago_facturacion WHERE formas_pago_facturacion.id ='$pago'");
     if ($query_eliminar_pago) {
       $arrayName = array('respuesta' =>'eliminado_correctamente','pago' =>$pago);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }else {
     $arrayName = array('respuesta' =>'error_eliminar_producto');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }

 }


 ?>
