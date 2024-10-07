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

   $query_consulta = mysqli_query($conection, "SELECT *  FROM proveedor
      WHERE proveedor.iduser ='$iduser'  AND proveedor.estatus = '1'
   ORDER BY `proveedor`.`fecha` DESC ");

   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }



 if ($_POST['action'] == 'info_proveedor') {
      $proveedor       = $_POST['proveedor'];

   $query_consulta = mysqli_query($conection, "SELECT * FROM proveedor

      WHERE proveedor.iduser ='$iduser'  AND proveedor.estatus = '1' AND proveedor.id = '$proveedor'
   ORDER BY `proveedor`.`fecha` DESC ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }



 if ($_POST['action'] == 'editar_proveedor') {

   $id_proveedor           = $_POST['id_proveedor'];
   $razon_social_proveedor           = $_POST['razon_social_proveedor'];
   $identificacion_proveedor         = $_POST['identificacion_proveedor'];
   $direccion_proveedro              = $_POST['direccion_proveedro'];
   $celular_proveedor                = $_POST['celular_proveedor'];
   $email_proveedor                  = $_POST['email_proveedor'];
   $descripcion_proveedor            = $_POST['descripcion_proveedor'];
   //codigo para verificar si esta correcto la identificacion

     $largo_cadena = strlen($identificacion_proveedor);

       if ($largo_cadena < 10 || $largo_cadena > 13 ) {
         $arrayName = array('noticia'=>'identificacion_invalida');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         exit;
       }else {
         if ($largo_cadena == '13') {
           if ($tipo_identificacion_proveedor == '9999999999999') {
               $tipo_identificacion       = '07';
           }
           if ($tipo_identificacion_proveedor != '9999999999999') {
             //echo "Esto es un ruc";
               $tipo_identificacion       = '04';
           }
         }
         if ($largo_cadena == '10') {
             $tipo_identificacion_proveedor       ='05';
           //echo "Este es cedula";
         }

       }

  $query_update =mysqli_query($conection,"UPDATE proveedor SET razon_social= '$razon_social_proveedor',tipo_identificacion= '$tipo_identificacion_proveedor',
    identificacion= '$identificacion_proveedor',celular= '$celular_proveedor',email= '$email_proveedor' ,  descripcion_proveedor='$descripcion_proveedor' WHERE id = '$id_proveedor' ");

   if ($query_update) {
     $arrayName = array('noticia' =>'insert_correct');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }






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
   $identificacion_proveedor         = $_POST['identificacion_proveedor'];
   $direccion_proveedro              = $_POST['direccion_proveedro'];
   $celular_proveedor                = $_POST['celular_proveedor'];
   $email_proveedor                  = $_POST['email_proveedor'];
   $descripcion_proveedor            = $_POST['descripcion_proveedor'];


   //codigo para verificar si esta correcto la identificacion

     $largo_cadena = strlen($identificacion_proveedor);

       if ($largo_cadena < 10 || $largo_cadena > 13 ) {
         $arrayName = array('noticia'=>'identificacion_invalida');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         exit;
       }else {
         if ($largo_cadena == '13') {
           if ($tipo_identificacion_proveedor == '9999999999999') {
               $tipo_identificacion       = '07';
           }
           if ($tipo_identificacion_proveedor != '9999999999999') {
             //echo "Esto es un ruc";
               $tipo_identificacion       = '04';
           }
         }
         if ($largo_cadena == '10') {
             $tipo_identificacion_proveedor       ='05';
           //echo "Este es cedula";
         }

       }

   //QR DEL TRANSPORTISTA

   $img_nombre = 'guibis_proveedor'.md5(date('d-m-Y H:m:s'));
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



 if ($_POST['action'] == 'eliminar_proveedor') {
   $proveedor             = $_POST['proveedor'];

   $query_delete=mysqli_query($conection,"UPDATE proveedor SET estatus= 0  WHERE id='$proveedor' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','proveedor'=> $proveedor);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }



 if ($_POST['action'] == 'agregar_proveedor_desde_productos') {
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
   $identificacion_proveedor         = $_POST['identificacion_proveedor'];
   $direccion_proveedro              = $_POST['direccion_proveedro'];
   $celular_proveedor                = $_POST['celular_proveedor'];
   $email_proveedor                  = $_POST['email_proveedor'];
   $descripcion_proveedor            = $_POST['descripcion_proveedor'];


   //codigo para verificar si esta correcto la identificacion

     $largo_cadena = strlen($identificacion_proveedor);

       if ($largo_cadena < 10 || $largo_cadena > 13 ) {
         $tipo_identificacion_proveedor       ='0';
       }else {
         if ($largo_cadena == '13') {
           if ($tipo_identificacion_proveedor == '9999999999999') {
               $tipo_identificacion       = '07';
           }
           if ($tipo_identificacion_proveedor != '9999999999999') {
             //echo "Esto es un ruc";
               $tipo_identificacion       = '04';
           }
         }
         if ($largo_cadena == '10') {
             $tipo_identificacion_proveedor       ='05';
           //echo "Este es cedula";
         }

       }

   //QR DEL TRANSPORTISTA

   $img_nombre = 'guibis_proveedor'.md5(date('d-m-Y H:m:s'));
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

             // Consulta para obtener todos los proveedores
        $query_select = mysqli_query($conection, "SELECT iduser, razon_social FROM proveedor");
        $proveedores = array();

        // Guardar los resultados en un array
        while ($row = mysqli_fetch_assoc($query_select)) {
            $proveedores[] = array('id' => $row['iduser'], 'text' => $row['razon_social']);
        }

        // Preparar el array para enviar
        $arrayName = array('noticia' => 'insert_correct', 'proveedores' => $proveedores);
        echo json_encode($arrayName, JSON_UNESCAPED_UNICODE);



     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
