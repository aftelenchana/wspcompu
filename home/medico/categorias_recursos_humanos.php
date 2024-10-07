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
  mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }

    if ($_SESSION['rol'] == 'Publicidad') {
    include "../sessiones/session_cuenta_usuario_publicidad.php";

    }



 if ($_POST['action'] == 'consultar_datos') {

   $query_consulta = mysqli_query($conection, "SELECT * FROM categoria_recursos_humanos
      WHERE categoria_recursos_humanos.iduser ='$iduser'  AND categoria_recursos_humanos.estatus = '1'
   ORDER BY `categoria_recursos_humanos`.`fecha` ASC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }


 if ($_POST['action'] == 'agregar_categoria') {

   $nombre             = mysqli_real_escape_string($conection,$_POST['nombre']);
   $descripcion           = mysqli_real_escape_string($conection,$_POST['descripcion']);
   $salario           = mysqli_real_escape_string($conection,$_POST['salario']);

   $query_insert=mysqli_query($conection,"INSERT INTO categoria_recursos_humanos(iduser,nombre,descripcion,salario)
                                 VALUES('$iduser','$nombre','$descripcion','$salario') ");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'info_categoria') {

      $categoria       = $_POST['categoria'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM categoria_recursos_humanos
         WHERE   categoria_recursos_humanos.id = '$categoria' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'editar_sucursal') {

   $id_categoria            = mysqli_real_escape_string($conection,$_POST['id_categoria']);
   $nombre                  = mysqli_real_escape_string($conection,$_POST['nombre']);
   $descripcion             = mysqli_real_escape_string($conection,$_POST['descripcion']);
   $salario           = mysqli_real_escape_string($conection,$_POST['salario']);


  $query_update =mysqli_query($conection,"UPDATE categoria_recursos_humanos SET nombre= '$nombre' ,descripcion= '$descripcion'
    ,salario= '$salario'
    WHERE id='$id_categoria' ");


   if ($query_update) {
     $arrayName = array('noticia' =>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }





 if ($_POST['action'] == 'eliminar_categoria') {
   $categoria             = $_POST['categoria'];

   $query_delete=mysqli_query($conection,"UPDATE categoria_recursos_humanos SET estatus= 0  WHERE id='$categoria' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','categoria'=> $categoria);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
