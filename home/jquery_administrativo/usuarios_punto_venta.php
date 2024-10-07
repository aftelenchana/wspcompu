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

   $query_consulta = mysqli_query($conection, "SELECT * FROM usuarios_punto_venta
      WHERE usuarios_punto_venta.iduser ='$iduser'  AND usuarios_punto_venta.estatus = '1'
   ORDER BY `usuarios_punto_venta`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }


 if ($_POST['action'] == 'agregar_usuario_punto_venta') {

    $mail                = mb_strtoupper($_POST['mail_user']);

        $identificacion      = $_POST['identificacion'];
           $query_usuario_punto_venta = mysqli_query($conection,"SELECT usuarios_punto_venta.id,DATE_FORMAT(usuarios_punto_venta.fecha, '%W  %d de %b %Y %H:%i:%s') as 'fecha_f',usuarios_punto_venta.foto,usuarios_punto_venta.nombres,usuarios_punto_venta.identificacion,
           usuarios_punto_venta.celular
        FROM `usuarios_punto_venta`
        WHERE usuarios_punto_venta.iduser = '$iduser' AND usuarios_punto_venta.estatus = '1' AND usuarios_punto_venta.mail = '$mail' ");

        $result_usuario_punto_venta= mysqli_num_rows($query_usuario_punto_venta);

        if ($result_usuario_punto_venta>0) {

        $data_usuario_punto_venta =mysqli_fetch_array($query_usuario_punto_venta);
        $arrayName = array('noticia' =>'usuario_existente','identificacion'=>$identificacion,'usuarios_punto_venta'=>$data_usuario_punto_venta['id']);
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
             $img_nombre = 'guibis_punto_venta'.md5(date('d-m-Y H:m:s').$iduser);
             $imgProducto = $img_nombre.'.'.$extension;
             $src = $destino.$imgProducto;
               move_uploaded_file($url_temp,$src);
           }else {
             $imgProducto = 'avatar_usuario_punto_venta.png';
             // code...
           }
           $nombres             = mb_strtoupper($_POST['nombres']);
           $mail                = mb_strtoupper($_POST['mail_user']);

           $direccion_cliente   = $_POST['direccion'];
           $celular             = $_POST['celular'];
           $password             = md5($_POST['password']);

          $telefono                  = $_POST['telefono'];



     $img_nombre = 'guibis_qr_punto_venta'.md5(date('d-m-Y H:m:s'));
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



   $query_insert=mysqli_query($conection,"INSERT INTO usuarios_punto_venta(nombres,mail,direccion,identificacion,celular,foto,iduser,sistema,qr,qr_contenido,url_img_upload,url_upload_qr,telefono,password)
                                 VALUES('$nombres','$mail','$direccion_cliente','$identificacion','$celular','$imgProducto','$iduser','facturacion','$qr_img','$contenido'
                                ,'$url','$url','$telefono','$password') ");

   if ($query_insert) {


       $arrayName = array('noticia'=>'insert_correct');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }

 if ($_POST['action'] == 'info_usuario_punto_venta') {
      $usuario_punto_venta       = $_POST['usuario_punto_venta'];
      $query_consulta = mysqli_query($conection, "SELECT * FROM usuarios_punto_venta
         WHERE usuarios_punto_venta.iduser ='$iduser'  AND usuarios_punto_venta.estatus = '1' AND usuarios_punto_venta.id = '$usuario_punto_venta' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }


 if ($_POST['action'] == 'editar_usuario_punto_ventas') {

   $password             = md5($_POST['password']);

   $nombres             = $_POST['nombres'];
   $mail                = $_POST['mail_user'];
   $direccion   = $_POST['direccion'];
   $identificacion      = $_POST['identificacion'];
   $celular             = $_POST['celular'];
   $id_cliente_usuario_punto_venta        = $_POST['id_cliente_usuario_punto_venta'];
    $telefono        = $_POST['telefono'];
   $query_insert = mysqli_query($conection,"UPDATE usuarios_punto_venta SET nombres='$nombres',mail='$mail',direccion='$direccion',
     identificacion='$identificacion', celular='$celular',telefono='$telefono',password='$password'
     WHERE id = '$id_cliente_usuario_punto_venta'");
   if ($query_insert) {
       $arrayName = array('noticia'=>'insert_correct','id_cliente_usuario_punto_venta'=> $id_cliente_usuario_punto_venta);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }





 if ($_POST['action'] == 'eliminar_usuario_punto_venta') {
   $usuario_punto_venta             = $_POST['usuario_punto_venta'];

   $query_delete=mysqli_query($conection,"UPDATE usuarios_punto_venta SET estatus= 0  WHERE id='$usuario_punto_venta' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','usuario_punto_venta'=> $usuario_punto_venta);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
