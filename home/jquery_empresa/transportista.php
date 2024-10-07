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


    if ($_POST['action'] == 'agregar_transportista') {
      if (!empty($_FILES['foto'])) {
        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $destino = '../img/transporte/';
        $img_nombre = 'transportista'.md5(date('d-m-Y H:m:s').$iduser);
        $imgProducto = $img_nombre.'.'.$extension;
        $src = $destino.$imgProducto;
        move_uploaded_file($url_temp,$src);
      }else {
        $imgProducto = 'transporte.png';
        // code...
      }
      $tipo_identificacion_transportista    = $_POST['tipo_identificacion_transportista'];
      $identificacion_transportista         = $_POST['identificacion_transportista'];
      $razon_social_transportista           = $_POST['razon_social_transportista'];
      $direccion_transportista              = $_POST['direccion_transportista'];
      $celular_transportista                = $_POST['celular_transportista'];
      $email_trasnportista                  = $_POST['email_trasnportista'];
      $placa                                = $_POST['placa'];

      $provincia                  = $_POST['provincia'];
      $ciudad                                = $_POST['ciudad'];

      //QR DEL TRANSPORTISTA

      $img_nombre = 'guibis'.md5(date('d-m-Y H:m:s'));
      $qr_img = $img_nombre.'.png';
      $contenido = md5(date('d-m-Y H:m:s').$iduser);

      $direccion = '../img/qr/';
      $filename = $direccion.$qr_img;
      $tamanio = 7;
      $level = 'H';
      $frameSize = 5;
      $contenido = $contenido;
      QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);


      $query_insert=mysqli_query($conection,"INSERT INTO transportistas(tipo_identificacion_transportista,identificacion_transportista,razon_social_transportista,direccion_transportista,celular_transportista,email_trasnportista,foto,iduser,qr_imagen_transportista,contenido_qr_transportista,placa,provincia,ciudad)
                                    VALUES('$tipo_identificacion_transportista','$identificacion_transportista','$razon_social_transportista','$direccion_transportista','$celular_transportista','$email_trasnportista','$imgProducto','$iduser','$qr_img','$contenido','$placa','$provincia','$ciudad') ");

      if ($query_insert) {

          $arrayName = array('img' =>$imgProducto,'noticia'=>'insert_correct');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



        }else {
          $arrayName = array('noticia' =>'error_insertar');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }

    if ($_POST['action'] == 'agregar_tr') {
        $transportista = $_POST['transportista'];
        $query_transportista = mysqli_query($conection,"SELECT * FROM transportistas WHERE transportistas.id ='$transportista'");
        $data_transportista = mysqli_fetch_array($query_transportista);
        echo json_encode($data_transportista,JSON_UNESCAPED_UNICODE);
      }




 ?>
