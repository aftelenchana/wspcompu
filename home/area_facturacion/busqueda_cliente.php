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


 if ($_POST['action'] == 'buscar_productos') {
   $datos = $_POST['datos'];
   $query_producto = mysqli_query($conection,"SELECT producto_venta.idproducto,producto_venta.precio,producto_venta.precio_costo,producto_venta.nombre,producto_venta.valor_unidad_final_con_impuestps FROM producto_venta WHERE producto_venta.idproducto ='$datos'");
   $data_producto = mysqli_fetch_array($query_producto);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }
 if ($_POST['action'] == 'buscar_usuarios_id') {
   $datos = $_POST['datos'];
   $query_clientes = mysqli_query($conection,"SELECT * FROM clientes WHERE clientes.id ='$datos'");
   $data_clientes = mysqli_fetch_array($query_clientes);
   echo json_encode($data_clientes,JSON_UNESCAPED_UNICODE);
 }


 ?>
