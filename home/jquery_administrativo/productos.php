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
 mysqli_set_charset($conection, 'utf8mb4'); //linea a colocar

 $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
 $result_configuracion = mysqli_fetch_array($query_configuracioin);
 $ambito_area          =  $result_configuracion['ambito'];
 $envio_wsp          =  $result_configuracion['envio_wsp'];



    if ($_SESSION['rol'] == 'cuenta_empresa') {
    include "../sessiones/session_cuenta_empresa.php";

    }

    if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
    include "../sessiones/session_cuenta_usuario_venta.php";

    }

    $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
    $result_configuracion = mysqli_fetch_array($query_configuracioin);
    $ambito_area          =  $result_configuracion['ambito'];
    $envio_wsp          =  $result_configuracion['envio_wsp'];


 if ($_POST['action'] == 'consultar_datos') {
   $farmacia = $_POST['codigo_farmacia'];

   $query_consulta = mysqli_query($conection, "SELECT producto_venta.idproducto,producto_venta.foto,producto_venta.url_upload_img,producto_venta.nombre,producto_venta.precio,
     producto_venta.marca,producto_venta.cantidad,producto_venta.descripcion,producto_venta.qr,producto_venta.url_upload_qr,producto_venta.codigo_barras,producto_venta.categorias,
     producto_venta.subcategorias,producto_venta.provincia,producto_venta.ciudad,producto_venta.visibilidadExterna,producto_venta.visibilidadInterna,
     producto_venta.via_administracion,producto_venta.descripcion_tienda
     FROM producto_venta
     WHERE producto_venta.id_usuario = '$iduser' AND producto_venta.estatus = '1' AND producto_venta.identificador_trabajo='producto'
     AND producto_venta.farmacia='$farmacia'
     ORDER BY `producto_venta`.`fecha_producto` DESC ");
   $data = array();
while ($row = mysqli_fetch_assoc($query_consulta)) {
    $data[] = $row;
}

echo json_encode(array("data" => $data));
   // code...
 }



 if ($_POST['action'] == 'info_producto') {
      $producto       = $_POST['producto'];
   $query_consulta = mysqli_query($conection, "SELECT * FROM producto_venta
  WHERE producto_venta.id_usuario ='$iduser'  AND producto_venta.estatus = '1' AND producto_venta.idproducto = '$producto' ");
   $data_producto = mysqli_fetch_array($query_consulta);
   echo json_encode($data_producto,JSON_UNESCAPED_UNICODE);
 }



 if ($_POST['action'] == 'editar_producto') {

     $idproducto   =  mysqli_real_escape_string($conection,$_POST['idproducto']);

     if (!empty($_FILES['foto']['name'])) {
       $foto           =    $_FILES['foto'];
       $nombre_foto    =    $foto['name'];
       $type 					 =    $foto['type'];
       $url_temp       =    $foto['tmp_name'];
       $extension = pathinfo($nombre_foto, PATHINFO_EXTENSION);
       $destino = '../img/uploads/';
       $img_nombre = 'producto_guibis'.md5(date('d-m-Y H:m:s').$iduser);
       $imgProducto = $img_nombre.'.'.$extension;
       $src = $destino.$imgProducto;
         move_uploaded_file($url_temp,$src);

      $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
      $url_upload_img = $url;
     }else {
       $query_producto = mysqli_query($conection, "SELECT * FROM producto_venta WHERE producto_venta.idproducto = $idproducto");
       $data_producto = mysqli_fetch_array($query_producto);
       $imgProducto = $data_producto['foto'];
       $url_upload_img = $data_producto['url_upload_img'];
     }

     $proveedor           = (isset($_REQUEST['proveedor'])) ? $_REQUEST['proveedor'] : '';
     $codigo_extra           = (isset($_REQUEST['codigo_extra'])) ? $_REQUEST['codigo_extra'] : '';

     $nombre_producto   =  mysqli_real_escape_string($conection,$_POST['nombre_producto']);
     $precio            =  mysqli_real_escape_string($conection,$_POST['precio']);
     $precio_costo      =  mysqli_real_escape_string($conection,$_POST['precio_costo']);




     //  INFORMACION DEL DEPRODUCTO DEPENDIENDO EL TIPO DE IMPUESTOS

     $tipo_ambiente                    =  mysqli_real_escape_string($conection,$_POST['elejir_tarifa_iva']);
     $codigos_impuestos                =  mysqli_real_escape_string($conection,$_POST['codigos_impuestos']);
     $valor_unidad_final_con_impuestps =  round($_POST['resultado_calculo'],2);

     $cantidad          =  mysqli_real_escape_string($conection,$_POST['cantidad']);
     $descripcion       =  mysqli_real_escape_string($conection,$_POST['descripcion']);
     $marca_producto    =  mysqli_real_escape_string($conection,$_POST['marca']);

     $categorias       =  mysqli_real_escape_string($conection,$_POST['categorias']);
     $subcategorias    =  mysqli_real_escape_string($conection,$_POST['subcategorias']);
     $provincia        =  mysqli_real_escape_string($conection,$_POST['provincia']);
     $ciudad           =  mysqli_real_escape_string($conection,$_POST['ciudad']);
     $descripcion_tienda     =  mysqli_real_escape_string($conection,$_POST['descripcion_tienda']);

     $via_administracion     =  mysqli_real_escape_string($conection,$_POST['via_administracion']);

    $visibilidadExterna           = (isset($_REQUEST['visibilidadExterna'])) ? $_REQUEST['visibilidadExterna'] : 'off';
    $visibilidadInterna           = (isset($_REQUEST['visibilidadInterna'])) ? $_REQUEST['visibilidadInterna'] : 'off';



     $query_insert = mysqli_query($conection,"UPDATE producto_venta SET proveedor='$proveedor',codigo_extra='$codigo_extra',nombre='$nombre_producto',
       precio='$precio', precio_costo='$precio_costo',tipo_ambiente='$tipo_ambiente',codigos_impuestos='$codigos_impuestos'
       ,valor_unidad_final_con_impuestps='$valor_unidad_final_con_impuestps',cantidad='$cantidad', descripcion='$descripcion',marca='$marca_producto'
       ,foto='$imgProducto',url_upload_img='$url_upload_img',categorias='$categorias',subcategorias='$subcategorias',provincia='$provincia'
       ,ciudad='$ciudad',visibilidadExterna='$visibilidadExterna',visibilidadInterna='$visibilidadInterna',descripcion_tienda='$descripcion_tienda'
       ,via_administracion='$via_administracion'
       WHERE idproducto = '$idproducto'");
     if ($query_insert) {
         $arrayName = array('noticia'=>'insert_correct','idproducto'=> $idproducto,'imgProducto'=> $imgProducto);
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

       }else {
         $arrayName = array('noticia' =>'error_insertar');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       }

   }



 if ($_POST['action'] == 'agregar_producto') {

      $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


   //INFORMACION DEL VIDEO EXPLICATIVO
  if (!empty($_FILES['video_explicativo']['name'])) {
    $video           =    $_FILES['video_explicativo'];
    $nombre_video    =    $video['name'];
    $type 					 =   $video['type'];
    $url_temp        =    $video['tmp_name'];
    $extension = pathinfo($nombre_video, PATHINFO_EXTENSION);
    $nombre_video = 'guibis_video_suscripcion'.md5(date('d-m-Y H:m:s'));
    $nombre_video_new = $nombre_video.'.'.$extension;
    $destino = '../img/videos/';
    $src = $destino.$nombre_video_new;
     move_uploaded_file($url_temp,$src);

     $url_video = $url;
    }else {
      $nombre_video_new = '';
      $url_video = '';
    }



   $proveedor = isset($_REQUEST['proveedor']) ? $_REQUEST['proveedor'] : '';
   $proveedor = mysqli_real_escape_string($conection, $proveedor);

   $codigo_extra = isset($_REQUEST['codigo_extra']) ? $_REQUEST['codigo_extra'] : '';
   $codigo_extra = mysqli_real_escape_string($conection, $codigo_extra);


   $nombre_producto       =  mysqli_real_escape_string($conection,$_POST['nombre_producto']);
   $precio       =  mysqli_real_escape_string($conection,$_POST['precio']);
   $precio_costo       =  mysqli_real_escape_string($conection,$_POST['precio_costo']);

   $categorias             =  mysqli_real_escape_string($conection,$_POST['categorias']);
   $subcategorias          =  mysqli_real_escape_string($conection,$_POST['subcategorias']);
   $provincia              =  mysqli_real_escape_string($conection,$_POST['provincia']);
   $ciudad                 =  mysqli_real_escape_string($conection,$_POST['ciudad']);

   $via_administracion     =  mysqli_real_escape_string($conection,$_POST['via_administracion']);

   $via_administracion     =  mysqli_real_escape_string($conection,$_POST['via_administracion']);

  $visibilidadInterna = isset($_REQUEST['visibilidadInterna']) ? $_REQUEST['visibilidadInterna'] : 'off';
  $visibilidadInterna = mysqli_real_escape_string($conection, $visibilidadInterna);

  $visibilidadExterna = isset($_REQUEST['visibilidadExterna']) ? $_REQUEST['visibilidadExterna'] : 'off';
  $visibilidadExterna = mysqli_real_escape_string($conection, $visibilidadExterna);

   //  INFORMACION DEL DEPRODUCTO DEPENDIENDO EL TIPO DE IMPUESTOS

      $tipo_ambiente                       =  mysqli_real_escape_string($conection,$_POST['elejir_tarifa_iva']);
      $codigos_impuestos                   =  mysqli_real_escape_string($conection,$_POST['codigos_impuestos']);
      $valor_unidad_final_con_impuestps    =  round($_POST['resultado_calculo'],2);

     $cantidad                             =  mysqli_real_escape_string($conection,$_POST['cantidad']);
     $descripcion                          =  mysqli_real_escape_string($conection,$_POST['descripcion']);
     $marca_producto                       =  mysqli_real_escape_string($conection,$_POST['marca']);
     $farmacia                             =  mysqli_real_escape_string($conection,$_POST['codigo_farmacia']);
     $descripcion_tienda                   =  mysqli_real_escape_string($conection,$_POST['descripcion_tienda']);



      $img_nombre = 'guibis_producto'.md5(date('d-m-Y H:m:s'));
      $qr_img = $img_nombre.'.png';


      $query=mysqli_query($conection,"SELECT * FROM producto_venta  ORDER BY fecha_producto DESC");
       $result = mysqli_fetch_array($query);
       $idproducto = $result['idproducto']+1;



      $direccion = '../img/qr/';
      $filename = $direccion.$qr_img;
      $tamanio = 7;
      $level = 'H';
      $frameSize = 5;
      $contenido = 'https://guibis.com/producto?codigo='.$idproducto;
      QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);


      $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;


   $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(nombre,precio,precio_costo,descripcion,id_usuario,qr,contenido_qr,identificador_trabajo,marca,cantidad,sistema,proveedor,codigo_extra,
                                tipo_ambiente,codigos_impuestos,valor_unidad_final_con_impuestps,url_upload_qr,categorias,subcategorias,provincia,ciudad,visibilidadInterna,visibilidadExterna,video_explicativo,url_video,descripcion_tienda,farmacia,via_administracion)
                                 VALUES('$nombre_producto','$precio','$precio_costo','$descripcion','$iduser','$qr_img','$contenido','producto','$marca_producto','$cantidad','facturacion','$proveedor','$codigo_extra',
                                 '$tipo_ambiente','$codigos_impuestos','$valor_unidad_final_con_impuestps','$url','$categorias','$subcategorias','$provincia','$ciudad','$visibilidadInterna','$visibilidadExterna','$nombre_video_new','$url_video','$descripcion_tienda','$farmacia','$via_administracion') ");

                                 $cont = 1;
                                 $hayImagenes = isset($_FILES["lista"]) && is_array($_FILES["lista"]["name"]) && !empty($_FILES["lista"]["name"][0]);

                                 if ($hayImagenes) {
                                     foreach ($_FILES["lista"]["name"] as $key => $value) {
                                         //Obtenemos la extensión del archivo
                                         $ext = explode('.', $_FILES["lista"]["name"][$key]);
                                         //Generamos un nuevo nombre del archivo
                                         $renombrar = 'guibis_img'.$cont.md5(date('d-m-Y H:m:s').$iduser.$idproducto);
                                         $nombre_final = $renombrar.".".$ext[1];

                                         //Insertamos la información en la base de datos
                                         $query_insert = mysqli_query($conection, "INSERT INTO img_producto(id_user,idp,img,url) VALUES('$iduser','$idproducto','$nombre_final','$url')");

                                         if ($cont == 1) {
                                           $img_producto = $nombre_final;
                                           $
                                             $query_insert = mysqli_query($conection, "UPDATE producto_venta SET foto='$nombre_final', url_upload_img='$url' WHERE idproducto='$idproducto'");
                                         }

                                         // Se copian los archivos de la carpeta temporal del servidor a su ubicación final
                                         move_uploaded_file($_FILES["lista"]["tmp_name"][$key], "../img/uploads/".$nombre_final);
                                         $cont++;
                                     }
                                 } else {
                                   $img_producto = 'img_producto.png';
                                   $query_insert2 = mysqli_query($conection, "INSERT INTO img_producto(id_user,idp,img,url) VALUES('$iduser','$idproducto','$img_producto','$url')");
                                   $query_insert = mysqli_query($conection, "UPDATE producto_venta SET foto='img_producto.png', url_upload_img='$url' WHERE idproducto='$idproducto'");
                                 }





      if ($query_insert) {



          $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;


          $url_img = $url . "/home/img/uploads/" . $img_producto;
          $mensaje = "*Nombre:* " . $nombre_producto . "\n";
          $mensaje .= "*Precio:* $" . $valor_unidad_final_con_impuestps . "\n";
          $mensaje .= "*Descripción:* " . $descripcion . "\n\n"; // Añade un salto de línea extra aquí
          $mensaje .= "Más información y compra aquí: " . $url . "/producto?codigo=" . $idproducto . "\n"; // Salto de línea al final
          $mensaje .= $url_img . "\n"; // URL de la imagen seguida por un salto de línea


          include '../mensajes/mensajes.php';
          if ($envio_wsp == 'SI') {
            //$respuestaDeposito    = enviarMensajeWhatsApp_guibis($celular_user, $mensaje);
          }




        $arrayName = array('noticia' =>'insert_correct','idproducto'=>$idproducto,'wsp'=>'ninguno');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }else {
        $arrayName = array('noticia' =>'error');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }
 }



 if ($_POST['action'] == 'eliminar_productos') {
   $producto             = $_POST['producto'];

   $query_delete=mysqli_query($conection,"UPDATE producto_venta SET estatus= 0  WHERE idproducto='$producto' ");

   if ($query_delete) {
       $arrayName = array('noticia'=>'insert_correct','producto'=> $producto);
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }else {
       $arrayName = array('noticia' =>'error_insertar');
      echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }

 }







 ?>
