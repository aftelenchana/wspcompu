<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET');
header('content-type: application/json; charset=utf-8');

if (!empty($_GET['key'])) {
   if (!empty($_GET['callback'])) {
     if (!empty($_GET['CIRUC'])) {
       require "../coneccion.php" ;
       mysqli_set_charset($conection, 'utf8'); //linea a colocar
       $token_usuario = $_GET['key'];
       $query_existencia_token = "SELECT * FROM usuarios WHERE id_e ='$token_usuario'";
       $result_usuario = mysqli_query($conection, $query_existencia_token);
       $existencia_usuario = mysqli_num_rows($result_usuario);
       if ($existencia_usuario>0) {
         if ($_GET['callback'] == 'all') {
           $data_lista=mysqli_fetch_array($result_usuario);
           $iduser = $data_lista['id'];
           $email_user = $data_lista['email'];

           $datos = json_decode(file_get_contents('https://guibis.com/api/suscripciones/check?producto=1811&email='.$email_user.''),true);

           if ($datos['noticia'] =='no existe ventas de este producto' || $datos['RESPUESTA'] =='DEFAULT SIN_VENTA' ) {
             $data = ['respuesta'=>'no existe registro de este servicio para '.$email_user.' compra siguiendo este enlace https://guibis.com/servicio_suscripcion?idp=1811&name=API%20REST%20para%20la%20consulta%20de%20informaci%C3%B3n%20de%20los%20contribuyentes%20a%20nivel%20nacional. '];
             echo $json_info = json_encode($data);
             exit;
           }

            $ciruc= $_GET['CIRUC'];

            $query_insert_historial=mysqli_query($conection,"INSERT INTO historial_api_ruc(iduser,ruc_consulta)
                                    VALUES('$iduser','$ciruc') ");
           $query_user = "SELECT personas_ecuador.NUMERO_RUC,personas_ecuador.ACTIVIDAD_ECONOMICA,personas_ecuador.RAZON_SOCIAL,personas_ecuador.NOMBRE_COMERCIAL,
           personas_ecuador.ESTADO_CONTRIBUYENTE,personas_ecuador.FECHA_INICIO_ACTIVIDADES,personas_ecuador.DESCRIPCION_PROVINCIA,personas_ecuador.DESCRIPCION_CANTON,
           personas_ecuador.CELULAR,personas_ecuador.EMAIL,personas_ecuador.DIRECCION,personas_ecuador.DESCRIPCION_PARROQUIA FROM personas_ecuador WHERE NUMERO_RUC =$ciruc LIMIT 1";
           $result_usuario = mysqli_query($conection, $query_user);
           $existencia_usuario = mysqli_num_rows($result_usuario);
           if ($existencia_usuario>0) {
             $data = mysqli_fetch_assoc($result_usuario);
             echo json_encode($data,JSON_UNESCAPED_UNICODE);
           }else {
             $data = ['Error' => "450",'noticia'=>'User Inexistent'];
             echo $json_info = json_encode($data);
           }

         }else {
           $data = ['Error' => "135",'noticia'=>'Elija la busqueda'];
           echo $json_info = json_encode($data);

         }





       }else {

         $data = ['Error' => "130",'noticia'=>'token de seguridad invalido'];

         echo $json_info = json_encode($data);

       }





     }else {

       $data = ['respuesta' => "401",'noticia'=>'consulta_vacia'];

       echo $json_info = json_encode($data);

     }

  }else {

    $data = ['respuesta' => "129",'noticia'=>'callback vacia'];

    echo $json_info = json_encode($data);

  }





}else {

  $data = ['respuesta' => "128",'noticia'=>'token_vacio'];

  echo $json_info = json_encode($data);

}







 ?>
