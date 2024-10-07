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


    if ($_POST['action'] == 'abrir_punto') {
      if (!empty($_FILES['foto'])) {
        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $destino = '../img/punto_emision/';
        $img_nombre = 'guibis_punto_emision'.md5(date('d-m-Y H:m:s').$iduser);
        $imgProducto = $img_nombre.'.'.$extension;
        $src = $destino.$imgProducto;
      }else {
        $imgProducto = 'guibis_punto_emision.png';
        // code...
      }
      $razon_social_punto    = $_POST['razon_social_punto'];
      $tipo_identificacion_punto_emision   = $_POST['tipo_identificacion_punto_emision'];
      $identificacion_punto_emision        = $_POST['identificacion_punto_emision'];
      $direccion_punto_emision             = $_POST['direccion_punto_emision'];
      $celular_punto_emision               = $_POST['celular_punto_emision'];
      $email_punto_emision                 = $_POST['email_punto_emision'];


      $contabilidad = (isset($_POST['contabilidad'])) ? $_POST['contabilidad'] : '';
      $transacciones = (isset($_POST['transacciones'])) ? $_POST['transacciones'] : '';
      $documentos = (isset($_POST['documentos'])) ? $_POST['documentos'] : '';
      $clientes = (isset($_POST['clientes'])) ? $_POST['clientes'] : '';
      $transporte = (isset($_POST['transporte'])) ? $_POST['transporte'] : '';
      $bancos = (isset($_POST['bancos'])) ? $_POST['bancos'] : '';




      //QR DEL TRANSPORTISTA

      $img_nombre = 'guibis_punto'.md5(date('d-m-Y H:m:s'));
      $qr_img = $img_nombre.'.png';
      $contenido = md5(date('d-m-Y H:m:s').$iduser);

      $direccion = '../img/qr/';
      $filename = $direccion.$qr_img;
      $tamanio = 7;
      $level = 'H';
      $frameSize = 5;
      $contenido = $contenido;
      QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);


      $query_insert=mysqli_query($conection,"INSERT INTO punto_venta(razon_social_punto,tipo_identificacion_punto_emision,identificacion_punto_emision,direccion_punto_emision,celular_punto_emision,email_punto_emision,contabilidad,
        transacciones,documentos,clientes,transporte,bancos,iduser,foto,qr_img,qr_contenido )
                                    VALUES('$razon_social_punto','$tipo_identificacion_punto_emision','$identificacion_punto_emision','$direccion_punto_emision','$celular_punto_emision','$email_punto_emision','$contabilidad'
                                      ,'$transacciones','$documentos','$clientes','$transporte','bancos','$iduser','$imgProducto','$qr_img','$contenido') ");

      if ($query_insert) {
        if (!empty($_FILES['foto'])) {
            move_uploaded_file($url_temp,$src);
        }

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
