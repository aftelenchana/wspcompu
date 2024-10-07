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

  $query_insert=mysqli_query($conection,"INSERT INTO preguntas(id_producto,pregunta,id_pregunta,id_responde)
  VALUES('$id_producto','$pregunta','$iduser','$id_usuario')");
  if ($query_insert) {
                  $query = mysqli_query($conection, "SELECT * FROM usuarios INNER JOIN producto_venta ON producto_venta.id_usuario = usuarios.id
                  WHERE usuarios.id =$iduser");
                  $result=mysqli_fetch_array($query);
                  $nombres_pregunta = $result['nombres'];
                  $apellidos_pregunta = $result['apellidos'];
                  if ($nombres_pregunta == '') {
                    $n_1 = 'G';
                    $nombres_pregunta='G';
                  }else {
                  $n_1 = $nombres_pregunta[0];
                  }
                  if ($apellidos_pregunta == '') {
                    $n_2 = 'G';
                    $apellidos_pregunta='G';
                  }else {
                  $n_2 = $apellidos_pregunta[0];
                  }
                  $nombre_pregunta = "$n_1$n_2";



    echo '    <div class="pregunta">
          <div class="img_user_pregunta conte_img_name">
            <p class="name_delta">'.$nombre_pregunta.'</p> <p style="display: flex;" class="name_uer"> <span> '.$nombres_pregunta.' comenta el (Hace un momento) :</span> </p>
          </div>
          <p class="pregunta_user">'.$pregunta.'</p>
        </div>';
    // code...
  }

}


if ($_POST['action'] == 'agregar_respuesta') {
  $respuesta = $_POST['respuesta'];
  $id_pregunta = $_POST['id_pregunta'];
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
