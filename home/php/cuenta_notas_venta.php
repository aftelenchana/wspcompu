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





$query = mysqli_query($conection, "SELECT usuarios.email, usuarios.nombres, usuarios.apellidos,usuarios.mi_leben FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$email = $result['email'];
$nombres = $result['nombres'];
$apellidos = $result['apellidos'];





if ($_POST['action'] == 'agregar_datos_notas_venta') {

    $inicio_secuencial = $_POST['inicio_secuencial'];
    $final_secuencial = $_POST['final_secuencial'];
    $nombre_imprenta = $_POST['nombre_imprenta'];
    $nombre_propietario = $_POST['nombre_propietario'];
    $ruc_imprenta = $_POST['ruc_imprenta'];
    $numero_autorizacion = $_POST['numero_autorizacion'];
    $fecha_emision = $_POST['fecha_emision'];
    $fecha_limite_validez = $_POST['fecha_limite_validez'];

 $query_notas_venta = mysqli_query($conection, "SELECT * FROM  parametros_notas_venta   WHERE  parametros_notas_venta.iduser  = $iduser");
  $data_notas_venta = mysqli_fetch_array($query_notas_venta);

  if ($data_notas_venta) {
    $query_insert=mysqli_query($conection,"UPDATE parametros_notas_venta SET inicio_secuencial='$inicio_secuencial',
       final_secuencial='$final_secuencial', nombre_imprenta='$nombre_imprenta', nombre_propietario='$nombre_propietario', ruc_imprenta='$ruc_imprenta'
       , numero_autorizacion='$numero_autorizacion', fecha_emision='$fecha_emision',fecha_limite_validez='$fecha_limite_validez'  WHERE iduser='$iduser' ");
       $query_insert=mysqli_query($conection,"INSERT INTO nota_venta_autorizada (codigo_factura,codigo_interno_factura,id_emisor)
       VALUES('$inicio_secuencial','00000000','$iduser') ");
    if ($query_insert) {
           $arrayName = array('noticia' => 'insert_correct');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

   }else {
     $arrayName = array('noticia' =>'error_servidor');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }


  }else {
    $query_insert=mysqli_query($conection,"INSERT INTO parametros_notas_venta(iduser,inicio_secuencial,final_secuencial,nombre_imprenta,nombre_propietario,ruc_imprenta,numero_autorizacion,fecha_emision,fecha_limite_validez)
  VALUES('$iduser','$inicio_secuencial','$final_secuencial','$nombre_imprenta','$nombre_propietario','$ruc_imprenta','$numero_autorizacion','$fecha_emision','$fecha_limite_validez') ");

  $query_insert=mysqli_query($conection,"INSERT INTO nota_venta_autorizada (codigo_factura,codigo_interno_factura,id_emisor)
  VALUES('$inicio_secuencial','00000000','$iduser') ");

        if ($query_insert) {
            $arrayName = array('noticia' => 'insert_correct');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          // code...
        }else {
          $arrayName = array('noticia' =>'error_insertar');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

  }
}





 ?>
