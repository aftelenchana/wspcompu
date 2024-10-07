<?php
include "../../coneccion.php";
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");
require '../QR/phpqrcode/qrlib.php';
use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
session_start();
$iduser= $_SESSION['id'];

// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
$query = mysqli_query($conection, "SELECT usuarios.email, usuarios.nombres, usuarios.apellidos,usuarios.password FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$nombres = $result['nombres'];
$apellidos = $result['apellidos'];
if ($_POST['action'] == 'insertar_porcentaje') {
  $idproducto= $_POST['idproducto'];
  $porcentaje_hotmart= $_POST['porcentaje_hotmart'];
  $query_producto = mysqli_query($conection, "SELECT * FROM producto_venta WHERE idproducto = $idproducto");
  $result_producto = mysqli_fetch_array($query_producto);
  $id_usuario = $result_producto['id_usuario'];
  $estado_hotmart = $result_producto['estado_hotmart'];
  if ($iduser != $id_usuario) {
    $arrayName = array('noticia' =>'error_privacidad');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }else {
    if ($estado_hotmart == 'Activo') {
      $arrayName = array('noticia' =>'ya_accionado');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }else {
      // code...
      $query_update=mysqli_query($conection,"UPDATE producto_venta SET porcen_hotmart='$porcentaje_hotmart',estado_hotmart='Activo' WHERE idproducto = '$idproducto' AND id_usuario='$id_usuario' ");
      $arrayName = array('noticia' =>'ok');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }
  }




}
 ?>
