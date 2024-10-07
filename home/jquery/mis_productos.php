<?php
  include "../../coneccion.php";
  session_start();
  if (empty($_SESSION['active'])) {
    header('location:/');

  }
  mysqli_set_charset($conection, 'utf8'); //linea a colocar
  $query_config = mysqli_query($conection, "SELECT * FROM `configuraciones` ");
  $result_config = mysqli_fetch_array($query_config);
  $nombre_empresa_ttt = $result_config['nombre_empresa'];
  $foto_representativa = $result_config['foto_representativa'];
    $web = $result_config['web'];
    $servidor_email = $result_config['servidor_email'];
        $email_empresa_i = $result_config['email_empresa'];
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");

use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
require '../QR/phpqrcode/qrlib.php';
$dir = '../img/qr/';
$iduser= $_SESSION['id'];
$query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$nombres_usuario = $result['nombres'];
$apellidos_usuario = $result['apellidos'];
$nombre_empresa = $result['nombre_empresa'];
if ($nombre_empresa == '') {
  $nombre_empresarial = $nombres_usuario;

}else {
  $nombre_empresarial = $nombre_empresa;

}



      if ($_POST['action'] == 'infoproducto') {

        $producto = $_POST['producto'];
        $query = mysqli_query($conection, "SELECT producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,
          producto_venta.foto,producto_venta.porcentaje,producto_venta.qr, subcategorias.nombre as 'subcategorias',subcategorias.id as 'id_subcategorias', ciudad.nombre as 'ciudad',ciudad.id as 'id_ciudad', usuarios.nombre_empresa,
          usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp, usuarios.img_logo,usuarios.id, producto_venta.fecha_producto,usuarios.mi_leben,provincia.nombre as 'provincia', provincia.id as 'id_provincia', categorias.nombre as 'categorias',categorias.id as 'id_categorias'   FROM producto_venta
            INNER JOIN subcategorias ON producto_venta.subcategorias = subcategorias.id
            INNER JOIN ciudad ON ciudad.id = producto_venta.ciudad
            INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
            INNER JOIN categorias ON categorias.id = producto_venta.categorias
            INNER JOIN provincia ON provincia.id = producto_venta.provincia
            WHERE idproducto =  $producto AND producto_venta.estatus = 1 ");
          $data = mysqli_fetch_assoc($query);
          echo json_encode($data,JSON_UNESCAPED_UNICODE);
          exit;

        // code...
      }
      if ($_POST['action'] == 'infover') {

        $producto = $_POST['producto'];
        $query = mysqli_query($conection, "SELECT * FROM producto_venta
            INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
            WHERE idproducto =  $producto AND producto_venta.estatus = 1 ");
          $data = mysqli_fetch_assoc($query);
          echo json_encode($data,JSON_UNESCAPED_UNICODE);

        // code...
      }
      if ($_POST['action'] == 'info_editar') {

        $producto = $_POST['producto'];
        $query = mysqli_query($conection, "SELECT producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,
          producto_venta.foto,producto_venta.porcentaje,producto_venta.qr, ciudad.nombre as 'ciudad', usuarios.nombre_empresa,
          usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp, usuarios.img_logo,usuarios.id, producto_venta.fecha_producto,usuarios.mi_leben FROM producto_venta
            INNER JOIN ciudad ON ciudad.id = producto_venta.ciudad
            INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
            WHERE idproducto =  $producto AND producto_venta.estatus = 1 ");
          $data = mysqli_fetch_assoc($query);
          echo json_encode($data,JSON_UNESCAPED_UNICODE);

        // code...
      }

      if ($_POST['action'] == 'info_eliminar') {

        $producto = $_POST['producto'];
        $query = mysqli_query($conection, "SELECT * FROM producto_venta
            INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
            WHERE idproducto =  $producto AND producto_venta.estatus = 1 ");
          $data = mysqli_fetch_assoc($query);
          echo json_encode($data,JSON_UNESCAPED_UNICODE);

        // code...
      }
      if ($_POST['action'] == 'eliminar_actual_producto') {

        $producto = $_POST['producto'];
       $query_delete=mysqli_query($conection,"UPDATE producto_venta SET estatus= 0  WHERE idproducto='$producto' ");

       if ($query_delete) {
         $arrayName = array('respuesta' =>'elimado_correctamnete','idproducto'=>$producto);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }else {
           $arrayName = array('respuesta' =>'error_insertar');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }
         exit;


        // code...
      }
      if ($_POST['action'] == 'infoproducto_comprar') {

        $producto = $_POST['producto'];
        $query = mysqli_query($conection, "SELECT producto_venta.idproducto, producto_venta.nombre,producto_venta.precio,producto_venta.descripcion,producto_venta.meses_suscripcion,
          producto_venta.foto,producto_venta.porcentaje,producto_venta.qr, ciudad.nombre as 'ciudad', usuarios.nombre_empresa,producto_venta.identificador_trabajo,
          usuarios.celular,usuarios.facebook,usuarios.instagram, usuarios.whatsapp, usuarios.img_logo,usuarios.id, producto_venta.fecha_producto,usuarios.mi_leben,usuarios.solicitud_vacunacion FROM producto_venta
            INNER JOIN ciudad ON ciudad.id = producto_venta.ciudad
            INNER JOIN usuarios ON producto_venta.id_usuario = usuarios.id
            WHERE idproducto =  $producto AND producto_venta.estatus = 1 ");
          $data = mysqli_fetch_assoc($query);
          echo json_encode($data,JSON_UNESCAPED_UNICODE);

        // code...
      }


      if ($_POST['action'] == 'eiminar_producto') {
         $idproducto   =  $_POST['idproducto'];
        $query_delete=mysqli_query($conection,"UPDATE producto_venta SET estatus= 0  WHERE idproducto='$idproducto' ");

        if ($query_delete) {
          $arrayName = array('respuesta' =>'elimado_correctamnete');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }else {
            $arrayName = array('respuesta' =>'error_insertar');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
          exit;

        // code...
      }




      if ($_POST['action'] == 'editt_editar_producto') {
        $idproducto   =  $_POST['idproducto'];
        $nombre_producto   =  $_POST['nombre_producto'];
        $precio            =  $_POST['precio'];
        $descripcion       =  $_POST['descripcion'];
        $provincia         =  $_POST['provincia'];
        $ciudad            =  $_POST['ciudad'];
        $categorias        =  $_POST['categorias'];
        $subcategorias     =  $_POST['subcategorias'];
        $porcentaje        =  $_POST['porcentaje'];
        $id_user           =  $_SESSION['id'];
        $precio_total      =  $precio + ($precio*$porcentaje)/100;
        //Foto
        $foto           =    $_FILES['foto'];
        $nombre_foto    =    $foto['name'];
        $type 					 =    $foto['type'];
        $url_temp       =    $foto['tmp_name'];

        $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
        if ($nombre_foto != '') {
         $destino = '../img/uploads/';
         $img_nombre = 'guibis_'.md5(date('d-m-Y H:m:s'));
         $imgProducto = $img_nombre.'.jpg';
         $imgProducto2 = $img_nombre.'.png';
         $src = $destino.$imgProducto;
        }

        $query_insert=mysqli_query($conection,"UPDATE producto_venta SET nombre='$nombre_producto',precio='$precio_total',descripcion='$descripcion',foto='$imgProducto',categorias='$categorias',
                                                                   subcategorias='$subcategorias',ciudad='$ciudad',provincia='$provincia',porcentaje='$porcentaje'  WHERE idproducto='$idproducto' ");

       if ($query_insert) {
           if ($nombre_foto != '') {
             move_uploaded_file($url_temp,$src);
           }

           $arrayName = array('noticia' =>'editado_correctamente');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);


         }else {
           $arrayName = array('noticia' =>'error_insertar');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }
        // code.

      }




            if ($_POST['action'] == 'add_boletos_electronicos') {

                $nombre_producto   =  $_POST['nombre_boleto'];
                $precio            =  $_POST['precio_boleto'];
                $cantidad_boletos  =  $_POST['cantidad_boletos'];
                $fecha_del_sorteo  =  $_POST['fecha_del_sorteo'];
                $hora_sorteo       =  $_POST['hora_sorteo'];
                $provincia         =  $_POST['provincia'];
                $ciudad            =  $_POST['ciudad'];
                $porcentaje        =  $_POST['porcentaje'];
                $descripcion       =  $_POST['descripcion'];
                $id_user           =  $_SESSION['id'];
                $ganancia_total      =  $cantidad_boletos*$precio - ($precio*$porcentaje*$cantidad_boletos)/100;
                //Foto
                $foto           =    $_FILES['foto'];
                $nombre_foto    =    $foto['name'];
                $type 					 =    $foto['type'];
                $url_temp       =    $foto['tmp_name'];

                $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
                if ($nombre_foto != '') {
                 $destino = '../img/uploads/';
                 $img_nombre = 'guibis_'.md5(date('d-m-Y H:m:s'));
                 $imgProducto = $img_nombre.'.jpg';
                 $imgProducto2 = $img_nombre.'.png';
                 $src = $destino.$imgProducto;
                }


                $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(nombre,precio,descripcion,id_usuario,foto,ciudad,provincia,porcentaje,qr,ganancias_totales,fecha_sorteo,hora_sorteo,	identificador_trabajo,cantidad_boletos)
                                              VALUES('$nombre_producto','$precio','$descripcion','$id_user','$imgProducto','$ciudad','$provincia','$porcentaje','$imgProducto2','$ganancia_total','$fecha_del_sorteo','$hora_sorteo','sorteos','$cantidad_boletos') ");
                 if ($query_insert) {
                   if ($nombre_foto != '') {
                     move_uploaded_file($url_temp,$src);
                   }
                   $arrayName = array('nombre' =>$nombre_producto,'foto' =>$imgProducto,'precio' =>$ganancia_total,'ciudad' =>$ciudad ,'descripcion' =>$descripcion,'fecha_sorteo' =>$fecha_del_sorteo,'hora_sorteo' =>$hora_sorteo,'cantidad_boletos' =>$cantidad_boletos,'img_qr'=>$imgProducto2);
                   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                   $query=mysqli_query($conection,"SELECT * FROM producto_venta WHERE id_usuario = $id_user  ORDER BY fecha_producto DESC");
                   $result = mysqli_fetch_array($query);
                   $data = mysqli_fetch_assoc($query);
                   $idproducto = $result['idproducto'];
                   $dirboletos = '../img/qr/';
                   $filename = $dirboletos.$imgProducto2;
                   $tamanio = 7;
                   $level = 'H';
                   $frameSize = 5;
                   $contenido = 'https://www.guibis.com/vista-general-producto.php?idp='.$idproducto;
                   QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
                 }else {
                   $arrayName = array('Error' =>'error_insertar');
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                 }
                // code...

            }


      //Entradas para eventos

                  if ($_POST['action'] == 'add_entradas_eventos') {

                      $nombre_producto   =  ($_POST['nombre_evento']);
                      $entrada            =  $_POST['precio_entrada'];
                      $cantidad_entradas  =  $_POST['cantidad_entradas'];
                      $fecha_evento      =  $_POST['fecha_evento'];
                      $hora_evento       =  $_POST['hora_evento'];
                      $tipo_evento       =  $_POST['tipo_evento'];
                      $provincia         =  $_POST['provincia'];
                      $ciudad            =  $_POST['ciudad'];
                      $categorias        =  8;
                      $subcategorias     =  32;
                      $tipo_asiento      =  $_POST['tipo_asiento'];
                      $porcentaje        =  3;
                      $descripcion       =  ($_POST['descripcion']);
                      $id_user           =  $_SESSION['id'];
                      $ganancia_total      =  $cantidad_entradas*$entrada - ($entrada*$porcentaje*$cantidad_entradas)/100;
                      //Foto
                      $foto           =    $_FILES['foto'];
                      $nombre_foto    =    $foto['name'];
                      $type 					 =    $foto['type'];
                      $url_temp       =    $foto['tmp_name'];

                      $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
                      if ($nombre_foto != '') {
                       $destino = '../img/uploads/';
                       $img_nombre = 'guibis_'.md5(date('d-m-Y H:m:s'));
                       $imgProducto = $img_nombre.'.jpg';
                       $imgProducto2 = $img_nombre.'.png';
                       $src = $destino.$imgProducto;
                      }


                      $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(categorias,subcategorias,nombre,precio,descripcion,id_usuario,foto,ciudad,provincia,porcentaje,qr,ganancias_totales,fecha_evento,hora_evento,tipo_evento,identificador_trabajo,cantidad_entradas,tipo_asiento)
                                                    VALUES('$categorias','$subcategorias','$nombre_producto','$entrada','$descripcion','$id_user','$imgProducto','$ciudad','$provincia','$porcentaje','$imgProducto2','$ganancia_total','$fecha_evento','$hora_evento','$tipo_evento','evento','$cantidad_entradas','$tipo_asiento') ");
                       if ($query_insert) {
                         if ($nombre_foto != '') {
                           move_uploaded_file($url_temp,$src);
                         }
                         $query=mysqli_query($conection,"SELECT * FROM producto_venta WHERE id_usuario = $id_user  ORDER BY fecha_producto DESC");
                         $data = mysqli_fetch_assoc($query);
                          $result = mysqli_fetch_array($query);
                         $idproducto = $result['idproducto'];
                         $dirboletos4 = '../img/qr/';
                         $filename = $dirboletos4.$imgProducto2;
                         $tamanio = 7;
                         $level = 'H';
                         $frameSize = 5;
                         $contenido = 'https://'.$web.'/producto.php?idp='.$idproducto;
                         QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
                         try {
                              // Configuración del servidor
                              $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                              $mail -> isSMTP ();                                          // Enviar usando SMTP
                              $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
                              $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                              $mail ->Username = 'guibis-ecuador@guibis.com' ;                       // Nombrede usuario SMTP
                              $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                              $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                              $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                              // Destinatarios
                              $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );  // Agrega un destinatario                                   // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                                 // Agrega un destinatario
                             $query_lista = mysqli_query($conection,"SELECT usuarios.email FROM `tienda_favorita`
                         INNER JOIN usuarios ON usuarios.id = tienda_favorita.id_usuario
                         WHERE tienda_favorita.id_tienda = $id_user");
                                   while ($data_lista=mysqli_fetch_array($query_lista)) {
                                     $mail -> addAddress ($data_lista['email']);


                                   }    // Agrega un destinatario
                              $mail -> addAddress ('subgerencia@guibis.com');
                              $mail -> addAddress ( $email_usuario);    // Agrega un destinatario
                             // Contenido
                             $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                             $mail->CharSet = 'UTF-8';
                             $mail -> Subject = 'Nuevo Evento  de '.$nombre_empresarial.'';
                             $mail -> Body     = '
                             <div class="img_logo" style="text-align: center;  background:">
                               <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" width="300px;" >
                             </div>
                             <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                                 <h3 style="text-align:center; color:#fff;   font-size: 40px; margin:0; padding:0;">Nuevo Evento de '.$nombre_empresarial.'</h3>
                                 <p style="font-weight: bold; font-style: italic;" >Muchas Gracias por confiar en Nosotros</p>
                                 <img src="https://guibis.com/home/img/uploads/'.$imgProducto.'" alt="" width="120px">
                                 <p>Precio del evento : $ '.$entrada.'</p>
                                 <h3>Se ha creado un nuevo Evento en la tienda de <a href="https://guibis.com/perfil-general.php?ide='.$id_user.'">'.$nombre_empresarial.'</a></h3>
                                  <h3>Se ha creado un nuevo Evento <a href="https://guibis.com/vista-general-producto.php?idp='.$idproducto.'">'.$nombre_producto.'</a></h3>
                                  <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
                                  <p><img src="https://guibis.com/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
                                  <p> <img src="https://guibis.com/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
                                  <p><img src="https://guibis.com/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
                                  <div style="border-color: #fff;border-width: 1px;
                               border-style: solid;
                               border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                               <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://guibis.com">Comprar o Vender en Guibis.com</a>

                                  </div>
                               <br>
                               <br>
                               <div class="redes_email" style="text-align: center;">
                                 <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                                 <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                                 <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>

                               </div>
                               ' ;
                             $mail -> send ();
                         } catch ( Exception  $e ) {
                         }
                         $arrayName = array('noticia' =>'add_ok_evento');
                             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                       }else {
                         $arrayName = array('Error' =>'error_insertar');
                        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
                       }
                      // code...

                  }
















         //Crear un nuevo producto

      if ($_POST['action'] == 'editt_add_servicios') {
        if (empty($_POST['categorias']) || empty($_POST['subcategorias']) ||  empty($_POST['provincia']) || empty($_POST['ciudad'])){
          $arrayName = array('Error' =>'Escoge las opciones para identificar a tu producto');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }else {
          $nombre_producto   =  ($_POST['nombre_producto']);
          $precio            =  $_POST['precio'];
          $descripcion       =  ($_POST['descripcion']);
          $provincia         =  $_POST['provincia'];
          $ciudad            =  $_POST['ciudad'];
          $categorias        =  $_POST['categorias'];
          $subcategorias     =  $_POST['subcategorias'];
          $porcentaje        =  3;
          $marca_producto        =  $_POST['marca_producto'];
          if ($marca_producto=='') {
            $marca_producto = 'Ninguna';
          }
          $id_user           =  $_SESSION['id'];
          //Foto
          $foto           =    $_FILES['foto'];
          $nombre_foto    =    $foto['name'];
          $type 					 =    $foto['type'];
          $url_temp       =    $foto['tmp_name'];

          $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
          if ($nombre_foto != '') {
           $destino = '../img/uploads/';
           $img_nombre = 'product_charge'.md5(date('d-m-Y H:m:s'));
           $imgProducto = $img_nombre.'.jpg';
           $imgProducto2 = $img_nombre.'.png';
           $src = $destino.$imgProducto;
          }
          $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(nombre,precio,descripcion,id_usuario,foto,categorias,subcategorias,ciudad,provincia,porcentaje,qr,identificador_trabajo,marca)
                                        VALUES('$nombre_producto','$precio','$descripcion','$id_user','$imgProducto','$categorias','$subcategorias','$ciudad','$provincia','$porcentaje','$imgProducto2','producto','$marca_producto') ");
           if ($query_insert) {
             if ($nombre_foto != '') {
               move_uploaded_file($url_temp,$src);
             }

             $query=mysqli_query($conection,"SELECT * FROM producto_venta WHERE id_usuario = $id_user  ORDER BY fecha_producto DESC");
             $result = mysqli_fetch_array($query);
             $idproducto = $result['idproducto'];

             $filename = $dir.$imgProducto2;
             $tamanio = 7;
             $level = 'H';
             $frameSize = 5;
              $contenido = 'https://guibis.com/producto?idp='.$idproducto;
             QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
             try {
               // Configuración del servidor
               $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
               $mail -> isSMTP ();                                          // Enviar usando SMTP
               $mail -> Host        = 'mail.guibis.com' ;                  // Configure el servidor SMTP para enviar a través de
               $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
               $mail ->Username = 'guibis-ecuador@guibis.com' ;                       // Nombrede usuario SMTP
               $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
               $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
               $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

               // Destinatarios
               $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );  // Agrega un destinatario
                     // Agrega un destinatario
                 $query_lista = mysqli_query($conection,"SELECT usuarios.email FROM `tienda_favorita`
             INNER JOIN usuarios ON usuarios.id = tienda_favorita.id_usuario
             WHERE tienda_favorita.id_tienda = $id_user");
                       while ($data_lista=mysqli_fetch_array($query_lista)) {
                         $mail -> addAddress ($data_lista['email']);


                       }    // Agrega un destinatario
                  $mail -> addAddress ($email_usuario);    // Agrega un destinatario
                 // Contenido
                 $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                $mail->CharSet = 'UTF-8';
                 $mail -> Subject = 'Nuevo Producto  de '.$nombre_empresarial.'';
                 $mail -> Body     = '
                   <div class="img_logo" style="text-align: center;  background:#fff;">
                     <img src="https://'.$web.'/home/img/reacciones/guibis.png" alt="" width="300px;" >
                   </div>
                   <div class="contenido" style="text-align: center;  background: #232F3E;color:#fff;" >
                       <h3 style="text-align:center; color:#fff;   font-size: 40px; margin:0; padding:0;">Nuevo Evento de '.$nombre_empresarial.'</h3>
                       <p style="font-weight: bold; font-style: italic;" >Muchas Gracias por confiar en Nosotros</p>
                       <img src="https://'.$web.'/home/img/uploads/'.$imgProducto.'" alt="" width="120px">
                       <p>Precio del producto : $ '.$precio.'</p>
                       <h3>Se ha creado un nuevo Producto en la tienda de <a href="https://'.$web.'/perfil-general.php?ide='.$id_user.'">'.$nombre_empresarial.'</a></h3>
                        <h3>Se ha creado un nuevo Producto <a href="https://guibis.com/vista-general-producto.php?idp='.$idproducto.'">'.$nombre_producto.'</a></h3>
                        <p>Estamos comprometidos contigo y te mostramos las líneas directas para cualquier inquietud.</p>
                        <p><img src="https://'.$web.'/home/img/reacciones/telefono-inteligente.png" alt="" width="30px"> 0998855160</p>
                        <p> <img src="https://'.$web.'/home/img/reacciones/telefonocasa.png" alt="" width="30px">   032436519</p>
                        <p><img src="https://'.$web.'/home/img/reacciones/correo-electronico.png" alt="" width="30px"> soporte@guibis.com </p>
                        <div style="border-color: #fff;border-width: 1px;
                     border-style: solid;
                     border-radius: 9px; width:180px; padding:5px;margin: 0 auto;" >
                     <a style="color:#fff;text-decoration:none;" target= "_blank" href="https://'.$web.'">Comprar o Vender en Guibis.com</a>

                        </div>
                     <br>
                     <br>
                     <div class="redes_email" style="text-align: center;background:#fff;">
                       <a style="text-align: center; margin:3px; padding4px;" href="https://www.facebook.com/guibisEcuador"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                       <a style="text-align: center; margin:3px; padding4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"> <img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                       <a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone=593998855160&text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>
                     </div>

                   ' ;
                 $mail -> send ();
             } catch ( Exception  $e ) {
             }
             $arrayName = array('noticia' =>'add_ok_prod');
                 echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }else {
             $arrayName = array('error' =>'error_insertar');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }
          // code...
        }

      }



      if ($_POST['action'] == 'editt_add_servicios_empre') {
        if (empty($_POST['provincia2']) || empty($_POST['ciudad2'])){
          $arrayName = array('Error' =>'Escoge las opciones para identificar a tu producto');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }else {
          $nombre_producto   =  $_POST['nombre_producto'];
          $precio            =  $_POST['precio'];
          $descripcion       =  $_POST['descripcion'];
          $provincia         =  $_POST['provincia2'];
          $ciudad         =  $_POST['ciudad2'];
          $tipo              =  $_POST['tipo'];
          $porcentaje        =  $_POST['porcentaje'];
          $id_user           =  $_SESSION['id'];
          $precio_total      =  $precio + ($precio*$porcentaje)/100;

          $foto           =    $_FILES['foto'];
          $nombre_foto    =    $foto['name'];
          $type 					 =    $foto['type'];
          $url_temp       =    $foto['tmp_name'];

          $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
          if ($nombre_foto != '') {
           $destino = '../img/uploads/';
           $img_nombre = 'img_'.md5(date('d-m-Y H:m:s'));
           $imgProducto = $img_nombre.'.jpg';
           $imgProducto2 = $img_nombre.'.png';
           $src = $destino.$imgProducto;
          }



          $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(nombre,precio,descripcion,id_usuario,foto,ciudad,provincia,porcentaje,tipo_servicio,qr,identificador_trabajo)
                                            VALUES('$nombre_producto','$precio_total','$descripcion','$id_user','$imgProducto','$ciudad','$provincia','$porcentaje','$tipo','$imgProducto2','servicios') ");
           if ($query_insert) {
             if ($nombre_foto != '') {
               move_uploaded_file($url_temp,$src);
             }


             $query=mysqli_query($conection,"SELECT * FROM producto_venta WHERE id_usuario = $id_user  ORDER BY fecha_producto DESC");
             $result = mysqli_fetch_array($query);
             $idproducto = $result['idproducto'];

             $arrayName = array('nombre' =>$nombre_producto,'foto' =>$imgProducto,'precio' =>$precio_total,'idp' =>$idproducto,'ciudad' =>$ciudad ,'descripcion' =>$descripcion);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             $filename = $dir.$imgProducto2;
             $tamanio = 7;
             $level = 'H';
             $frameSize = 5;
             $contenido = 'https://www.guibis.com/vista-general-producto.php?=idp'.$idproducto;
             QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
           }else {
             $arrayName = array('Error' =>'error_insertar');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }
          // code...
        }
        // code...
      }


      if ($_POST['action'] == 'editt_add_cuenta_digital') {

          $nombre_producto   =  $_POST['nombre_producto'];
          $precio            =  $_POST['precio'];
          $descripcion       =  $_POST['descripcion'];
          $categorias        =  $_POST['categorias'];
          $subcategorias     =  $_POST['subcategorias'];
          $tipo_cuenta       =  $_POST['tipo_cuenta'];
          $porcentaje        =  $_POST['porcentaje'];
          $id_user           =  $_SESSION['id'];
          $precio_total      =  $precio + ($precio*$porcentaje)/100;


          //Foto
          $foto           =    $_FILES['foto'];
          $nombre_foto    =    $foto['name'];
          $type 					 =    $foto['type'];
          $url_temp       =    $foto['tmp_name'];

          $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
          if ($nombre_foto != '') {
           $destino = '../img/uploads/';
           $img_nombre = 'guibis_'.md5(date('d-m-Y H:m:s'));
           $imgProducto = $img_nombre.'.jpg';
           $imgProducto2 = $img_nombre.'.png';
           $src = $destino.$imgProducto;
          }



          $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(nombre,precio,descripcion,id_usuario,foto,porcentaje,tipo_digital,qr,categorias,subcategorias,identificador_trabajo)
                                            VALUES('$nombre_producto','$precio_total','$descripcion','$id_user','$imgProducto','$porcentaje','$tipo_cuenta','$imgProducto2','$categorias','$subcategorias','cuentas_digitales') ");
           if ($query_insert) {
             if ($nombre_foto != '') {
               move_uploaded_file($url_temp,$src);
             }
             $query=mysqli_query($conection,"SELECT * FROM producto_venta WHERE id_usuario = $id_user  ORDER BY fecha_producto DESC");
             $result = mysqli_fetch_array($query);
             $idproducto = $result['idproducto'];
             $arrayName = array('nombre' =>$nombre_producto,'foto' =>$imgProducto,'precio' =>$precio_total,'idp' =>$idproducto ,'descripcion' =>$descripcion,'tipo' =>$tipo_cuenta );
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             $filename = $dir.$imgProducto2;
             $tamanio = 7;
             $level = 'H';
             $frameSize = 5;
             $contenido = 'https://www.guibis.com/vista-general-producto.php?idp='.$idproducto;
             QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
           }else {
             $arrayName = array('Error' =>'error_insertar');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }

        // code...
      }



      if ($_POST['action'] == 'add_servivio_recuadacion') {

          $nombre_evento_recaudacion        =  $_POST['nombre_evento_recaudacion'];
          $precio_evento_recaudacion        =  $_POST['precio_evento_recaudacion'];
          $meta_evento_recaudacion          =  $_POST['meta_evento_recaudacion'];
          $provincia                        =  $_POST['provincia2'];
          $ciudad                           =  $_POST['ciudad2'];
          $descripcion_evento_recaudacion   =  $_POST['descripcion_evento_recaudacion'];


          //Foto
          $foto             =    $_FILES['foto'];
          $nombre_foto      =    $foto['name'];
          $type 					  =    $foto['type'];
          $url_temp         =    $foto['tmp_name'];

          $imgProducto      =   'img_producto.jpg' || 'img_producto.png';
          if ($nombre_foto != '') {
           $destino = '../img/uploads/';
           $img_nombre    = 'guibis_evento_recaudacion'.md5(date('d-m-Y H:m:s').$iduser);
           $imgProducto   = $img_nombre.'.jpg';
           $imgProducto2  = $img_nombre.'.png';
           $src = $destino.$imgProducto;
          }



          $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(nombre,precio,descripcion,id_usuario,foto,qr,identificador_trabajo,meta_recaudacion,ciudad,provincia)
                                            VALUES('$nombre_evento_recaudacion','$precio_evento_recaudacion','$descripcion_evento_recaudacion','$iduser','$imgProducto','$imgProducto2','evento_recaudacion','$meta_evento_recaudacion','$ciudad','$provincia') ");
           if ($query_insert) {
             if ($nombre_foto != '') {
               move_uploaded_file($url_temp,$src);
             }
             $query=mysqli_query($conection,"SELECT * FROM producto_venta WHERE id_usuario = $iduser  ORDER BY fecha_producto DESC");
             $result = mysqli_fetch_array($query);
             $idproducto = $result['idproducto'];
             $arrayName = array('noticia' =>'add_correcto');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             $filename = $dir.$imgProducto2;
             $tamanio = 7;
             $level = 'H';
             $frameSize = 5;
             $contenido = 'https://www.guibis.com/perfil?idp='.$idproducto;
             QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
           }else {
             $arrayName = array('Error' =>'error_insertar');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }

        // code...
      }

      if ($_POST['action'] == 'add_servicio_suscripcion') {

          $nombre_suscripcion                 =  $_POST['nombre_suscripcion'];
          $precio_suscripcion                 =  $_POST['precio_suscripcion'];
          $tiempo_suscripcion                 =  $_POST['tiempo_suscripcion'];
          $provincia                          =  $_POST['provincia2'];
          $ciudad                             =  $_POST['ciudad2'];
          $descripcion_servicio_suscripcion   =  $_POST['descripcion_servicio_suscripcion'];

          $mifecha = new DateTime();
          $mifecha->modify('+'.$tiempo_suscripcion.' month');
         $fecha_limite_suscripcion =  $mifecha->format('d-m-Y H:i:s');



          //Foto
          $foto             =    $_FILES['foto'];
          $nombre_foto      =    $foto['name'];
          $type 					  =    $foto['type'];
          $url_temp         =    $foto['tmp_name'];

          $imgProducto      =   'img_producto.jpg' || 'img_producto.png';
          if ($nombre_foto != '') {
           $destino = '../img/uploads/';
           $img_nombre    = 'guibis_suscripcion'.md5(date('d-m-Y H:m:s').$iduser);
           $imgProducto   = $img_nombre.'.jpg';
           $imgProducto2  = $img_nombre.'.png';
           $src = $destino.$imgProducto;
          }



          $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(nombre,precio,descripcion,id_usuario,foto,qr,identificador_trabajo,ciudad,provincia,meses_suscripcion)
                                            VALUES('$nombre_suscripcion','$precio_suscripcion','$descripcion_servicio_suscripcion','$iduser','$imgProducto','$imgProducto2','servicio_suscripcion','$ciudad','$provincia','$tiempo_suscripcion') ");
           if ($query_insert) {
             if ($nombre_foto != '') {
               move_uploaded_file($url_temp,$src);
             }
             $query=mysqli_query($conection,"SELECT * FROM producto_venta WHERE id_usuario = $iduser  ORDER BY fecha_producto DESC");
             $result = mysqli_fetch_array($query);
             $idproducto = $result['idproducto'];
             $arrayName = array('noticia' =>'add_correcto');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             $filename = $dir.$imgProducto2;
             $tamanio = 7;
             $level = 'H';
             $frameSize = 5;
             $contenido = 'https://www.guibis.com/perfil?idp='.$idproducto;
             QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);
           }else {
             $arrayName = array('Error' =>'error_insertar');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
           }

        // code...
      }



 ?>
