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



 $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
 $result_configuracion = mysqli_fetch_array($query_configuracioin);
 $ambito_area          =  $result_configuracion['ambito'];




    if ($_POST['action'] == 'agregar_proveedor') {
      if (!empty($_FILES['foto']['name'])) {
        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];
        $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
        $destino = '../img/uploads/';
        $img_nombre = 'proveedor'.md5(date('d-m-Y H:m:s').$iduser);
        $imgProducto = $img_nombre.'.'.$extension;
        $src = $destino.$imgProducto;
          move_uploaded_file($url_temp,$src);
      }else {
        $imgProducto = 'proveedor.png';
        // code...
      }
      $razon_social_proveedor           = $_POST['razon_social_proveedor'];
      $tipo_identificacion_proveedor    = $_POST['tipo_identificacion_proveedor'];
      $identificacion_proveedor         = $_POST['identificacion_proveedor'];
      $direccion_proveedro              = $_POST['direccion_proveedro'];
      $celular_proveedor                = $_POST['celular_proveedor'];
      $email_proveedor                  = $_POST['email_proveedor'];
      $descripcion_proveedor                  = $_POST['descripcion_proveedor'];

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


      $query_insert=mysqli_query($conection,"INSERT INTO  proveedor(iduser,razon_social,tipo_identificacion,identificacion,direccion,celular,email,qr,qr_contenido,foto,descripcion_proveedor)
                                    VALUES('$iduser','$razon_social_proveedor','$tipo_identificacion_proveedor','$identificacion_proveedor','$direccion_proveedro',
                                      '$celular_proveedor','$email_proveedor','$qr_img','$contenido','$imgProducto','$descripcion_proveedor') ");

      if ($query_insert) {


          $arrayName = array('noticia'=>'insert_correct');
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

      if ($_POST['action'] == 'buscar_proveedor') {

          $factura = $_POST['factura'];
          if ($ambito_area == 'prueba') {
            $ruta_compra = 'C:\\xampp\\htdocs\\home\\archivos\\compras\\'.$factura.'';
          }else {
            $ruta_compra = '../archivos/compras/'.$factura.'';
          }
          $acceso_factura = simplexml_load_file($ruta_compra);
          $dirMatriz                       = (string)$acceso_factura->infoTributaria->dirMatriz;
          $claveAcceso                       = (string)$acceso_factura->infoTributaria->claveAcceso;
          $ruc_emisor                        = (string)$acceso_factura->infoTributaria->ruc;
          $razon_social_emisor               = (string)$acceso_factura->infoTributaria->razonSocial;
          $obligadoContabilidad               = (string)$acceso_factura->infoFactura->obligadoContabilidad;

              $arrayName = array('dirMatriz' =>$dirMatriz,'ruc_emisor'=>$ruc_emisor,'razon_social_emisor'=>$razon_social_emisor);
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

        }





 ?>
