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

   $query_consulta = mysqli_query($conection, "SELECT producto_venta.idproducto,producto_venta.foto,producto_venta.url_upload_img,producto_venta.nombre,producto_venta.precio,
     producto_venta.marca,producto_venta.cantidad,producto_venta.descripcion,producto_venta.qr,producto_venta.url_upload_qr,producto_venta.codigo_barras,producto_venta.categorias,
     producto_venta.subcategorias,producto_venta.provincia,producto_venta.ciudad,producto_venta.visibilidadExterna,producto_venta.visibilidadInterna
     FROM producto_venta
     WHERE producto_venta.id_usuario = '$iduser' AND producto_venta.estatus = '1' AND producto_venta.identificador_trabajo='servicio_suscripcion'
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
     $codigo_barras      = mysqli_real_escape_string($conection,$_POST['codigo_barras']);



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

    $visibilidadExterna           = (isset($_REQUEST['visibilidadExterna'])) ? $_REQUEST['visibilidadExterna'] : 'off';
    $visibilidadInterna           = (isset($_REQUEST['visibilidadInterna'])) ? $_REQUEST['visibilidadInterna'] : 'off';



     $query_insert = mysqli_query($conection,"UPDATE producto_venta SET proveedor='$proveedor',codigo_extra='$codigo_extra',nombre='$nombre_producto',
       precio='$precio', precio_costo='$precio_costo',tipo_ambiente='$tipo_ambiente',codigos_impuestos='$codigos_impuestos'
       ,valor_unidad_final_con_impuestps='$valor_unidad_final_con_impuestps',cantidad='$cantidad', descripcion='$descripcion',marca='$marca_producto'
       ,foto='$imgProducto',codigo_barras='$codigo_barras',url_upload_img='$url_upload_img',categorias='$categorias',subcategorias='$subcategorias',provincia='$provincia'
       ,ciudad='$ciudad',visibilidadExterna='$visibilidadExterna',visibilidadInterna='$visibilidadInterna'
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

   $categorias       =  mysqli_real_escape_string($conection,$_POST['categorias']);
   $subcategorias    =  mysqli_real_escape_string($conection,$_POST['subcategorias']);
   $provincia        =  mysqli_real_escape_string($conection,$_POST['provincia']);
   $ciudad           =  mysqli_real_escape_string($conection,$_POST['ciudad']);

  $visibilidadInterna = isset($_REQUEST['visibilidadInterna']) ? $_REQUEST['visibilidadInterna'] : 'off';
  $visibilidadInterna = mysqli_real_escape_string($conection, $visibilidadInterna);

  $visibilidadExterna = isset($_REQUEST['visibilidadExterna']) ? $_REQUEST['visibilidadExterna'] : 'off';
  $visibilidadExterna = mysqli_real_escape_string($conection, $visibilidadExterna);




   //  INFORMACION DEL DEPRODUCTO DEPENDIENDO EL TIPO DE IMPUESTOS

      $tipo_ambiente           =  mysqli_real_escape_string($conection,$_POST['elejir_tarifa_iva']);
      $codigo_barras           =  mysqli_real_escape_string($conection,$_POST['codigo_barras']);
      $codigos_impuestos           =  mysqli_real_escape_string($conection,$_POST['codigos_impuestos']);

      $valor_unidad_final_con_impuestps =  round($_POST['resultado_calculo'],2);

     $cantidad           =  mysqli_real_escape_string($conection,$_POST['cantidad']);
     $descripcion           =  mysqli_real_escape_string($conection,$_POST['descripcion']);
     $marca_producto           =  mysqli_real_escape_string($conection,$_POST['marca']);

     $tiempo_suscripcion           =  mysqli_real_escape_string($conection,$_POST['tiempo_suscripcion']);



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
      $contenido = 'https://guibis.com/suscripcion?codigo='.$idproducto;
      QRcode::png ($contenido,$filename,$level,$tamanio,$frameSize);



            $query_insert=mysqli_query($conection,"INSERT INTO producto_venta(nombre,precio,precio_costo,descripcion,id_usuario,qr,contenido_qr,identificador_trabajo,marca,cantidad,sistema,proveedor,codigo_extra,
                                         tipo_ambiente,codigos_impuestos,valor_unidad_final_con_impuestps,url_upload_qr,codigo_barras,categorias,subcategorias,provincia,ciudad,visibilidadInterna,visibilidadExterna,video_explicativo,url_video,meses_suscripcion)
                                          VALUES('$nombre_producto','$precio','$precio_costo','$descripcion','$iduser','$qr_img','$contenido','servicio_suscripcion','$marca_producto','$cantidad','facturacion','$proveedor','$codigo_extra',
                                          '$tipo_ambiente','$codigos_impuestos','$valor_unidad_final_con_impuestps','$url','$codigo_barras','$categorias','$subcategorias','$provincia','$ciudad','$visibilidadInterna','$visibilidadExterna','$nombre_video_new','$url_video','$tiempo_suscripcion') ");





      $cont = 1;
      foreach ($_FILES["lista"]["name"] as $key => $value) {
        //Obtenemos la extensión del archivo
        $ext = explode('.', $_FILES["lista"]["name"][$key]);
        //Generamos un nuevo nombre del archivo, esto para no duplicar el nombre del archivo y que se sobreescriba.
        $renombrar = $cont.md5(date('d-m-Y H:m:s').$iduser.$idproducto);
        $nombre_final = $renombrar.".".$ext[1];
        $query_insert=mysqli_query($conection,"INSERT INTO img_producto(id_user,idp,img,url)
                                      VALUES('$iduser','$idproducto','$nombre_final','$url') ");

          if ($cont == 1) {
           $query_insert=mysqli_query($conection,"UPDATE producto_venta SET foto='$nombre_final', url_upload_img='$url' WHERE idproducto='$idproducto'");
          }


        //Se copian los archivos de la carpeta temporal del servidor a su ubicación final
        move_uploaded_file($_FILES["lista"]["tmp_name"][$key], "../img/uploads/".$nombre_final);
              $cont++;

      }


      if ($query_insert) {


        if (substr($celular_user, 0, 4) === '+593') {
            $celular_user = substr($celular_user, 1);
        }

        // Verifica si el número ya tiene el prefijo '593'
        if (substr($celular_user, 0, 3) !== '593') {
            // Verifica si comienza con '09' o tiene 9 dígitos y agrega '593'
            if (substr($celular_user, 0, 2) === '09' || strlen($celular_user) === 9) {
                $celular_user = '593' . substr($celular_user, (strlen($celular_user) == 9 ? 0 : 1));
            }
        }

        if (strlen($celular_user) > 11) {
          $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;


            $mensaje = "".$url2."/servicio_suscripcion?codigo=".$idproducto."";

          // URL de la API a la que te quieres conectar
            $url = 'http://whatsapp.guibis.com:3001/send-message';

            // Los datos que quieres enviar en formato JSON
            $data = array(
                'number' => $celular_user,
                'message' => $mensaje
            );
            $data_json = json_encode($data);

            // Inicializa cURL
            $ch = curl_init($url);

            // Configura las opciones de cURL para POST
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_json)
            ));

            // Ejecuta la sesión cURL
            $response = curl_exec($ch);


            // Verifica si hubo un error en la solicitud
            if(curl_errno($ch)){
                throw new Exception(curl_error($ch));
            }

            // Cierra la sesión cURL
            curl_close($ch);



          // Decodifica la respuesta JSON y la imprime
          $responseData = json_decode($response, true);
          if (isset($responseData['success']) && $responseData['success'] === true) {

            $estado_wsp = 'Mensaje Enviado por WhatsApp '.$celular_user.'';
          }else {
            $estado_wsp = 'Mensaje por WhatsApp '.$celular_user.' no Enviado '.$response.' ';
          }
          // code...
        }else {
            $estado_wsp = 'número no soportado '.$celular_user.'';
        }



        $arrayName = array('noticia' =>'insert_correct','idproducto'=>$idproducto,'wsp'=>$estado_wsp);
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
