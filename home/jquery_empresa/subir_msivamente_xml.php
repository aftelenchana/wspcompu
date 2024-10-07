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


$cont = 0;
// ciclo para recorrer el array de imagenes
  foreach ($_FILES["lista"]["name"] as $key => $value) {
    $ext = explode('.', $_FILES["lista"]["name"][$key]);
    $renombrar = $cont.md5(date('d-m-Y H:m:s').$iduser.$cont);
    $nombre_final = $renombrar.".".$ext[1];
    $query_insert=mysqli_query($conection,"INSERT INTO xml_subidos_masivos (id_user,nombre)
                                  VALUES('$iduser','$nombre_final') ");
    //Se copian los archivos de la carpeta temporal del servidor a su ubicación final
    move_uploaded_file($_FILES["lista"]["tmp_name"][$key], "../archivos/xml_nofirmados/".$nombre_final);
    $cont++;
  }

  if ($query_insert) {
       $arrayName = array('noticia' =>'xml_agregados_correctamente');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 ?>
