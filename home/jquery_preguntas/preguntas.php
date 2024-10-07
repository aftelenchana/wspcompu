<?php
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar
session_start();
$iduser= $_SESSION['id'];

if ($_POST['action'] == 'agregar_pregunta') {

  $id_producto = $_POST['idp'];
  $pregunta = $_POST['pregunta'];
  $sql_producto = mysqli_query($conection,"SELECT * FROM   producto_venta
  WHERE idproducto='$id_producto'");
  $data_producto=mysqli_fetch_array($sql_producto);
  $id_usuario =  $data_producto['id_usuario'];

  $query_insert=mysqli_query($conection,"INSERT INTO preguntas(id_producto,pregunta,id_pregunta,id_responde,rol)
  VALUES('$id_producto','$pregunta','$iduser','$id_usuario','cliente')");
  if ($query_insert) {
                  $query = mysqli_query($conection, "SELECT * FROM clientes
                  WHERE clientes.id =$iduser");
                  $result=mysqli_fetch_array($query);
                  $nombre_pregunta = $result['nombres'];




    echo '


        <div class="row mb-3">
           <div class="col-8">
             <div class="card border-0">
               <div class="card-body shadow-sm" style="border-radius: 15px; background-color: #f8d7da;">
                 <h5 class="card-title">'.$nombre_pregunta.' <small class="text-muted">'.$nombre_pregunta.'  comenta hace un momento</small></h5>
                 <p class="card-text">'.$pregunta.'</p>
               </div>
             </div>
           </div>
           <div class="col-4"></div>
         </div>


        ';
  }

}


if ($_POST['action'] == 'agregar_respuesta') {
  $respuesta = $_POST['respuesta'];
  $id_pregunta = $_POST['pregunta_respondes'];
  date_default_timezone_set("America/Lima");
  $fecha_actual = date('d-m-Y H:m:s', time());

  $query_insert=mysqli_query($conection,"UPDATE preguntas SET respuesta='$respuesta',fecha_respuesta='$fecha_actual'
    WHERE id = '$id_pregunta' ");
    if ($query_insert) {
      // code...
      $arrayName = array('noticia' =>'insert_ok','respuesta'=>$respuesta);
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }else {
      echo "no se eito";
    }




}


 ?>
