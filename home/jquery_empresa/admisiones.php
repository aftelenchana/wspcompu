<?php
session_start();
$iduser= $_SESSION['id'];
if (empty($_SESSION['active'])) {
  header('location:/');
}
include "../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar

       if ($_POST['action'] == 'buscar_admisiones') {
         $id_cliente = $_POST['cliente'];
         $query_admisiones = mysqli_query($conection,"SELECT * FROM admisiones_facturacion  WHERE admisiones_facturacion.idcliente ='$id_cliente' AND iduser = '$iduser'");
         $exustencia_admisio = mysqli_num_rows($query_admisiones);
         if ($exustencia_admisio>0) {
           $data_admisiones = mysqli_fetch_array($query_admisiones);
           $arrayName = array('noticia' =>'tiene_adimsion','cliente'=>$id_cliente);
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

        }else {
          $arrayName = array('noticia' =>'no_tiene_admision','cliente'=>$id_cliente);
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }
      }



      if ($_POST['action'] == 'agregar_admision') {
        $cliente       = $_POST['cliente'];
        $descripcion       = $_POST['descripcion'];

        $query_insert=mysqli_query($conection,"INSERT INTO admisiones_facturacion(iduser,idcliente,descripcion)
                                      VALUES('$iduser','$cliente','$descripcion') ");
        if ($query_insert) {


            $arrayName = array('noticia'=>'insert_correct');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



          }else {
            $arrayName = array('noticia' =>'error_insertar');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }

      }

 ?>
