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


if ($_POST['action'] == 'anular_factura') {
  $codigo_interno = $_POST['codigo_interno'];

    $query_insert=mysqli_query($conection,"UPDATE comprobante_factura_final SET estado ='ANULADO'  WHERE id='$codigo_interno' ");


    if ($query_insert) {
        $arrayName = array('noticia'=>'insert_correct');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



      }else {
        $arrayName = array('noticia' =>'error_insertar');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }



  // code...
}
 ?>
