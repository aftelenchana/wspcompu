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




 if ($_POST['action'] == 'consultar_datos') {

   $query_consulta = mysqli_query($conection, "SELECT * FROM historial_pago_cuentas_cobrar
      WHERE historial_pago_cuentas_cobrar.iduser ='$iduser'  AND historial_pago_cuentas_cobrar.estatus = '1'
   ORDER BY `historial_pago_cuentas_cobrar`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }



 if ($_POST['action'] == 'info_almacen') {
      $almacen       = $_POST['almacen'];

   $query_consulta = mysqli_query($conection, "SELECT almecenes.id,almecenes.nombre_almacen,almecenes.direccion_almacen,
     almecenes.sucursal,almecenes.descripcion,sucursales.direccion_sucursal,sucursales.id as 'cod_sucursal',almecenes.responsable,
     sucursales.id as 'cod_sucursal' FROM almecenes
     INNER JOIN sucursales ON sucursales.id = almecenes.sucursal
      WHERE almecenes.iduser ='$iduser'  AND almecenes.estatus = '1' AND almecenes.id = '$almacen'
   ORDER BY `almecenes`.`fecha` DESC ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }



 if ($_POST['action'] == 'editar_almacen') {
    $id_almacen       = $_POST['id_almacen'];

   $nombre_almacen       = $_POST['nombre_almacen'];
   $direccion_almacen    = $_POST['direccion_almacen'];
   $sucursal             = $_POST['sucursal'];
   $descripcion          = $_POST['descripcion'];
   $responsable          = $_POST['responsable'];

  $query_update =mysqli_query($conection,"UPDATE almecenes SET nombre_almacen= '$nombre_almacen',direccion_almacen= '$direccion_almacen',
    sucursal= '$sucursal',descripcion= '$descripcion',responsable= '$responsable'  WHERE id='$id_almacen' ");

   if ($query_update) {
     $arrayName = array('noticia' =>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }






 if ($_POST['action'] == 'agregar_depostito_cuentas_cobrar_facturacion') {

   $cantidad_deposito        = strtoupper($_POST['cantidad_deposito']);
   $codigo_cuenta_cobrar        = strtoupper($_POST['codigo_cuenta_cobrar']);
   $descripcion        = strtoupper($_POST['descripcion']);


   $query_suma_pago = mysqli_query($conection,"SELECT SUM(((historial_pago_cuentas_cobrar.cantidad_deposito))) as 'total_pago_actual'
   FROM `historial_pago_cuentas_cobrar`
   WHERE historial_pago_cuentas_cobrar.cuenta_cobrar = '$codigo_cuenta_cobrar'");
   $data_suma =mysqli_fetch_array($query_suma_pago);
   if (empty($data_suma['total_pago_actual'])) {
     $total_pagado = 0;
   }else {
     $total_pagado = round(($data_suma['total_pago_actual']),2);
   }

   //echo "este es el valor pagado $total_pagado";




       $query_cuenta_cobrar = mysqli_query($conection,"SELECT *
       FROM `cuentas_por_cobrar`
       WHERE cuentas_por_cobrar.id  = '$codigo_cuenta_cobrar'");

       $data_cuenta =mysqli_fetch_array($query_cuenta_cobrar);
       $total            = $data_cuenta['total'];
       $monto_inicial    = $data_cuenta['monto_inicial'];

       $faltante = $total - $total_pagado-$monto_inicial;

      // echo "este es el total $total";

      // echo "este es el faltante $faltante";
      // exit;

       if ($cantidad_deposito<=$faltante) {

       }else {
         $arrayName = array('noticia' =>'valor_no_valido');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             exit;
       }


         $nuevo_valor =  $total- ($total_pagado+$cantidad_deposito+$monto_inicial);



           if ($nuevo_valor <= '0') {
             $estado_financiero = 'COMPLETO';
             // code...
           }else {
             $estado_financiero = 'INCOMPLETO';
           }




               $query_update=mysqli_query($conection,"UPDATE cuentas_por_cobrar SET estado_financiero='$estado_financiero'  WHERE id='$codigo_cuenta_cobrar' ");


               $query_insert=mysqli_query($conection,"INSERT INTO historial_pago_cuentas_cobrar (iduser,cuenta_cobrar,cantidad_deposito,descripcion,estado_financiero)
                                             VALUES('$iduser','$codigo_cuenta_cobrar','$cantidad_deposito','$descripcion','PAGADO') ");
   if ($query_insert) {


     $arrayName = array('noticia' =>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }



 if ($_POST['action'] == 'eliminar_almacen') {
   $almacen             = $_POST['almacen'];

   $query_delete=mysqli_query($conection,"UPDATE almecenes SET estatus= 0  WHERE id='$almacen' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','almacen'=> $almacen);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
