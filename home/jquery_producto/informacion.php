<?php

require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");

use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
include "../../coneccion.php";
     session_start();
     $iduser= $_SESSION['id'];
     $query = mysqli_query($conection, "SELECT usuarios.email, usuarios.nombres, usuarios.apellidos FROM usuarios WHERE usuarios.id = $iduser");
     $result = mysqli_fetch_array($query);
     $email_usuario = $result['email'];
     $nombres = $result['nombres'];
     $apellidos = $result['apellidos'];
     $idproducto = $_POST['idproducto'];
     $query_tienda_favorita = mysqli_query($conection, "SELECT usuarios.id, usuarios.email FROM `producto_venta`
INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
WHERE idproducto = $idproducto");
$result_tienda_favorita = mysqli_fetch_array($query_tienda_favorita);
$id_tienda = $result_tienda_favorita['id'];
$email = $result_tienda_favorita['email'];

 $query_consulta_tienda = mysqli_query($conection, "SELECT * FROM `tienda_favorita` WHERE id_tienda = $id_tienda AND id_usuario=$iduser ");
$result_tienda_consulta = mysqli_fetch_array($query_consulta_tienda);

         if ($result_tienda_consulta > 0) {
           $estado_en_tienda = $result_tienda_consulta['estado'];
           if ($estado_en_tienda == 'Activo') {
             $arrayName = array('noticia' =>'tienda_agregada_como_favorita','id_tienda'=>$id_tienda);
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             // code...
           }else {
             $arrayName = array('noticia' =>'inactivo_en_tienda_favorita','id_tienda'=>$id_tienda);
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }



         }else {
           $arrayName = array('noticia' =>'no_existe_en_tienda_favorita');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



         }


 ?>
