<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: POST');
header('content-type: application/json; charset=utf-8');



if (!empty($_POST['KEY'])) {
   if (!empty($_POST['callback'])) {
     if (!empty($_POST['CIRUC'])) {
       require "../coneccion.php" ;
       mysqli_set_charset($conection, 'utf8'); //linea a colocar
       $token_usuario = $_POST['KEY'];
       $query_existencia_token = "SELECT * FROM usuarios WHERE id_e ='$token_usuario'";
       $result_usuario = mysqli_query($conection, $query_existencia_token);
       $existencia_usuario = mysqli_num_rows($result_usuario);
       if ($existencia_usuario>0) {
         if ($_POST['callback'] == 'message') {




         }else {
           $data = ['noticia'=>'accion_vacia'];
           echo $json_info = json_encode($data);

         }

       }else {
         $data = ['noticia'=>'token de seguridad invalido'];
         echo $json_info = json_encode($data);
       }





     }else {
       $data = ['noticia'=>'consulta_vacia'];
       echo $json_info = json_encode($data);
     }

  }else {

    $data = ['noticia'=>'callback vacia'];
    echo $json_info = json_encode($data);

  }


}else {

  $data = ['noticia'=>'token_vacio'];

  echo $json_info = json_encode($data);

}







 ?>
