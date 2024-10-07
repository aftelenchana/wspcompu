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



// Asegúrate de que el usuario está autenticado y tiene un rol asignado
if (!isset($_SESSION['rol'])) {
    // Manejar el caso en que el usuario no está autenticado o no tiene rol
    exit('Usuario no autenticado o sin rol asignado.');
}

// Asumiendo que ya tienes una función para verificar si el usuario tiene permisos
function verificar_permisos($iduser, $rol,$id_generacion) {
    global $conection; // Asegúrate de que la conexión a la base de datos está disponible

    $permisos_usuario = array();
    $query_permiso = mysqli_query($conection, "SELECT permiso, valor FROM `permisos` WHERE iduser = '$iduser' AND rol = '$rol' AND codigo_usuario = '$id_generacion'");

    while ($row = mysqli_fetch_assoc($query_permiso)) {
        $permisos_usuario[$row['permiso']] = $row['valor'];
    }

    return $permisos_usuario;
}


    $rol = $_SESSION['rol']; // Y que esta contiene el rol

    $permisos = verificar_permisos($iduser, $rol,$id_generacion);
    echo json_encode($permisos);
//}
?>
