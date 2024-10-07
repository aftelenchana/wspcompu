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


 if ($_POST['action'] == 'agregar_cuentas_cobrar') {
   $agregar_plan_cuotas       = $_POST['agregar_plan_cuotas'];
   $valor_inicial             = $_POST['valor_inicial'];

   $numero_cuotas           = (isset($_REQUEST['numero_cuotas'])) ? $_REQUEST['numero_cuotas'] : '';

   $fecha_inicio              = $_POST['fecha_inicio'];
   $fecha_final               = $_POST['fecha_final'];
   $descripcion               = $_POST['descripcion'];
   $factura_codigo            = $_POST['factura_codigo'];

   //Código para sacar la información del Cliente

   $query_consulta_factura = mysqli_query($conection, "SELECT * FROM comprobante_factura_final
      WHERE comprobante_factura_final.id ='$factura_codigo' ");
$data_factura = mysqli_fetch_array($query_consulta_factura);
$id_receptor = $data_factura['id_receptor'];
$cedula_receptor = $data_factura['cedula_receptor'];
$total = $data_factura['total'];

//codigo para tener en cuanta que el monto inicial no tiene que ser mkayor al total de la factura

if ($valor_inicial > $valor_inicial) {
  $arrayName = array('noticia'=>'valor_inicial_exedente');
  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  exit;
}


//Información para saber si la factura ya esta en cuentas por cobrar
$query_existencia = mysqli_query($conection, "SELECT * FROM cuentas_por_cobrar
   WHERE cuentas_por_cobrar.codigo_factura ='$factura_codigo' ");
$data_existencia = mysqli_fetch_array($query_existencia);

if ($data_existencia) {
  //$arrayName = array('noticia'=>'factura_procesada');
  //echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  //exit;
  // code...
}

//sacar informacion del cliente para que se centralize el id del cliente
 if (empty($id_receptor)) {
   $query_consulta_cliente = mysqli_query($conection, "SELECT * FROM clientes
      WHERE clientes.identificacion ='$cedula_receptor' ORDER BY clientes.id DESC ");
   $data_cliente = mysqli_fetch_array($query_consulta_cliente);
   $id_receptor = $data_cliente['id'];
 }




   $query_insert=mysqli_query($conection,"INSERT INTO  cuentas_por_cobrar(iduser,id_cliente,cedula_receptor,fecha_inicio,fecha_final,descripcion,codigo_factura,numero_cuotas,monto_inicial,agregar_plan_cuotas,total)
                                 VALUES('$iduser','$id_receptor','$cedula_receptor','$fecha_inicio','$fecha_final','$descripcion','$factura_codigo','$numero_cuotas','$valor_inicial','$agregar_plan_cuotas','$total') ");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'info_sucursal') {
      $sucursal       = $_POST['sucursal'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM sucursales
         WHERE sucursales.iduser ='$iduser'  AND sucursales.estatus = '1' AND sucursales.id = '$sucursal' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'editar_sucursal') {
    $id_sucursal       = $_POST['id_sucursal'];

   $direccion_sucursal       = $_POST['direccion_sucursal'];


  $query_update =mysqli_query($conection,"UPDATE sucursales SET direccion_sucursal= '$direccion_sucursal'  WHERE id='$id_sucursal' ");

   if ($query_update) {
     $arrayName = array('noticia' =>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }













 ?>
