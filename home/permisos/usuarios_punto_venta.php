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


 if ($_POST['action'] == 'enviar_petision_permiso') {

   $permiso = $_POST['permiso'];
   $valor = $_POST['valor'];
   $codigo_usuario = $_POST['codigo_usuario'];
   $rol = $_POST['rol'];

   //CODIGO PARA SACAR INFORMACION DEL PERMISO ES DECIR SI EXISTE O NO EL PERMISO
$query_permiso = mysqli_query($conection, "SELECT * FROM `permisos` WHERE permiso = '$permiso'  AND iduser = '$iduser' AND codigo_usuario = '$codigo_usuario' AND rol = '$rol' ");
$data_permisos = mysqli_fetch_array($query_permiso);

if ($data_permisos) {
   $query_insert=mysqli_query($conection,"UPDATE permisos SET valor= '$valor'  WHERE permiso='$permiso' AND iduser=$iduser AND codigo_usuario = '$codigo_usuario'  AND rol = '$rol' ");

   if ($query_insert) {
     $arrayName = array('noticia' =>'editado_correctamente');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     // code...
   }else {
     $arrayName = array('noticia' =>'error_servidor');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     // code...
   }

}else {
  $query_insert=mysqli_query($conection,"INSERT INTO permisos(iduser,permiso,valor,codigo_usuario,rol)
                                VALUES('$iduser','$permiso','$valor','$codigo_usuario','$rol') ");

        if ($query_insert) {
          $arrayName = array('noticia' =>'permiso_agregado');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          // code...
        }else {
          $arrayName = array('noticia' =>'error_servidor');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          // code...
        }
}


 }

if ($_POST['action'] == 'vizualizar_permisos') {
      $codigo_usuario = $_POST['codigo_usuario'];
      $rol = $_POST['rol'];
// Consulta para obtener los permisos del usuario
$query_permiso = mysqli_query($conection, "SELECT permiso, valor FROM `permisos` WHERE iduser = '$iduser' AND codigo_usuario = '$codigo_usuario'  AND rol = '$rol'");
$permisos_usuario = array();
while ($row = mysqli_fetch_assoc($query_permiso)) {
    $permisos_usuario[$row['permiso']] = $row['valor'];
}

// Envía los permisos al frontend
echo json_encode($permisos_usuario);

   // code...
 }











 ?>
