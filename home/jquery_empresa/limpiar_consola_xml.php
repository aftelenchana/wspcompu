<?php
include "../../coneccion.php";
session_start();

mysqli_set_charset($conection, 'utf8'); //linea a colocar

$iduser= $_SESSION['id'];
$query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$nombres_usuario = $result['nombres'];
$apellidos_usuario = $result['apellidos'];
$nombre_empresa = $result['nombre_empresa'];
$query_delete = mysqli_query($conection,"UPDATE xml_subidos_masivos SET vista='0' WHERE xml_subidos_masivos.id_user = '$iduser' ");
if ($query_delete) {
     $arrayName = array('noticia' =>'xml_eliminado');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }else {
     $arrayName = array('noticia' =>'error');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
   }




 ?>
