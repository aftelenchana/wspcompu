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
  mysqli_set_charset($conection, 'utf8'); //linea a colocar


    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }

    if ($_SESSION['rol'] == 'Mesero') {
    include "../sessiones/session_cuenta_mesero.php";

    }

    if ($_SESSION['rol'] == 'Cocina') {
    include "../sessiones/session_cuenta_cocina.php";
    }


 if ($_POST['action'] == 'consultar_datos') {

   $query_consulta = mysqli_query($conection, "SELECT * FROM usuarios_credenciales
      WHERE usuarios_credenciales.iduser ='$iduser'  AND usuarios_credenciales.estatus = '1'
   ORDER BY `usuarios_credenciales`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }


 if ($_POST['action'] == 'agregar_usuario_credenciales') {

        $identificacion      = $_POST['identificacion'];
           $query_cliente = mysqli_query($conection,"SELECT usuarios_credenciales.id,DATE_FORMAT(usuarios_credenciales.fecha, '%W  %d de %b %Y %H:%i:%s') as 'fecha_f',usuarios_credenciales.foto,usuarios_credenciales.nombres,usuarios_credenciales.identificacion,
           usuarios_credenciales.celular,usuarios_credenciales.mail
        FROM `usuarios_credenciales`
        WHERE usuarios_credenciales.iduser = '$iduser' AND usuarios_credenciales.estatus = '1' AND usuarios_credenciales.identificacion = '$identificacion' ");

        $result_cliente= mysqli_num_rows($query_cliente);

        if ($result_cliente>0) {

        $data_cliente =mysqli_fetch_array($query_cliente);
        $arrayName = array('noticia' =>'usuario_existente','identificacion'=>$identificacion,'cliente'=>$data_cliente['id'],'mail'=>$data_cliente['mail']);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;


        // code...
        }
         $largo_cadena = strlen($identificacion);

        if ($largo_cadena < 10 || $largo_cadena > 13 ) {
        $arrayName = array('noticia'=>'identificacion_invalida');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        exit;
        }


           if (!empty($_FILES['foto']['name'])) {
             $foto           =    $_FILES['foto'];
             $nombre_foto    =    $foto['name'];
             $type 					 =    $foto['type'];
             $url_temp       =    $foto['tmp_name'];
             $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
             $destino = '../img/uploads/';
             $img_nombre = 'cliente'.md5(date('d-m-Y H:m:s').$iduser);
             $imgProducto = $img_nombre.'.'.$extension;
             $src = $destino.$imgProducto;
               move_uploaded_file($url_temp,$src);
           }else {
             $imgProducto = 'avatar.png';
             // code...
           }
           $nombres             = mb_strtoupper($_POST['nombres']);
           $mail                = mb_strtoupper($_POST['mail_user']);



           $largo_cadena = strlen($identificacion);



           if ($largo_cadena < 10 || $largo_cadena > 13) {
               $arrayName = array('noticia' => 'identificacion_invalida');
               echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
               exit;
           } else {
               // La longitud está entre 10 y 13, incluyendo ambos
               if ($largo_cadena == 10) {
                   $tipo_identificacion = '05'; // Cédula
               } elseif ($largo_cadena == 13) {
                   if ($identificacion == '9999999999999') {
                       $tipo_identificacion = '07'; // Identificación especial
                   } else {
                       $tipo_identificacion = '04'; // RUC
                   }
               } else {
                   // Longitud entre 11 y 12, o cualquier otro caso no contemplado
                   $arrayName = array('noticia' => 'identificacion_invalida');
                   echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);
                   exit;
               }


           }



           $direccion_cliente   = $_POST['direccion'];
           $celular             = $_POST['celular'];
           $tipo_cliente        = $_POST['tipo_cliente'];


            $telefono                  = $_POST['telefono'];



     $img_nombre = 'guibis_cliente'.md5(date('d-m-Y H:m:s'));
     $qr_img = $img_nombre.'.png';
     $contenido = md5(date('d-m-Y H:m:s').$iduser);

     $direccion = '../img/qr/';
     $filename = $direccion.$qr_img;
     $tamanio = 7;
     $level = 'H';
     $frameSize = 5;
     $contenido = $contenido;
     QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);

       $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;



   $query_insert=mysqli_query($conection,"INSERT INTO usuarios_credenciales(nombres,mail,tipo_identificacion,direccion,identificacion,celular,foto,iduser,tipo_cliente,sistema,qr,qr_contenido,url_img_upload,url_upload_qr,telefono)
                                 VALUES('$nombres','$mail','$tipo_identificacion','$direccion_cliente','$identificacion','$celular','$imgProducto','$iduser','$tipo_cliente','facturacion','$qr_img','$contenido','$url','$url','$telefono') ");

   if ($query_insert) {


       $arrayName = array('noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'info_cliente') {
      $cliente       = $_POST['cliente'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM usuarios_credenciales
         WHERE usuarios_credenciales.iduser ='$iduser'  AND usuarios_credenciales.estatus = '1' AND usuarios_credenciales.id = '$cliente' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'info_parametro') {
      $parametro       = $_POST['parametro'];
      $usuario       = $_POST['usuario'];


      $query_consulta = mysqli_query($conection, "SELECT usuarios_credenciales.$parametro,usuarios_credenciales.nombres  FROM usuarios_credenciales
         WHERE  usuarios_credenciales.id = '$usuario' ");

         $data_parametro = mysqli_fetch_array($query_consulta);

        $arrayName = array('noticia'=>'insert_correct','parametro'=> $data_parametro[$parametro],'usuario'=> $usuario,'name_parametro'=> $parametro,'nombres_cliente'=> $data_parametro['nombres']);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
 }

 if ($_POST['action'] == 'editar_usuarios_credenciales') {

   $nombres             = $_POST['nombres'];
   $mail                = $_POST['mail_user'];
   $direccion           = $_POST['direccion'];
   $identificacion      = $_POST['identificacion'];
   $celular             = $_POST['celular'];
   $tipo_cliente        = $_POST['tipo_cliente'];
   $id_cliente          = $_POST['id_cliente'];
    $telefono           = $_POST['telefono'];
   $query_insert = mysqli_query($conection,"UPDATE usuarios_credenciales SET nombres='$nombres',mail='$mail',direccion='$direccion',
     identificacion='$identificacion', celular='$celular',tipo_cliente='$tipo_cliente',telefono='$telefono'
     WHERE id = '$id_cliente'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','id_cliente'=> $id_cliente);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }


 if ($_POST['action'] == 'editar_parametro') {

   $id_cliente             = $_POST['id_cliente'];
   $name_parametro         = $_POST['name_parametro'];
   $contenido_parametro    = $_POST['contenido_parametro'];






   $query_insert = mysqli_query($conection,"UPDATE usuarios_credenciales SET $name_parametro='$contenido_parametro'
     WHERE id = '$id_cliente'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','id_cliente'=> $id_cliente);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }





 if ($_POST['action'] == 'eliminar_cliente') {
   $cliente             = $_POST['cliente'];

   $query_delete=mysqli_query($conection,"UPDATE usuarios_credenciales SET estatus= 0  WHERE id='$cliente' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','cliente'=> $cliente);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
