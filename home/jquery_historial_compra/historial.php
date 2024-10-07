<?php
session_start();
if (empty($_SESSION['active'])) {
  header('location:/');

}
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar
  require("../mail/PHPMailer-master/src/PHPMailer.php");
  require("../mail/PHPMailer-master/src/Exception.php");
  require("../mail/PHPMailer-master/src/SMTP.php");

  use  PHPMailer \ PHPMailer \ PHPMailer ;
  use  PHPMailer \ PHPMailer \ Exception ;
  // La instanciación y el paso de `true` habilita excepciones
  $mail = new  PHPMailer ( true );
       $iduser= $_SESSION['id'];
       $query = mysqli_query($conection, "SELECT usuarios.email, usuarios.nombres, usuarios.apellidos,usuarios.password FROM usuarios WHERE usuarios.id = $iduser");
       $result = mysqli_fetch_array($query);
       $email_usuario = $result['email'];
       $nombres = $result['nombres'];
       $apellidos = $result['apellidos'];
       $password_db = $result['password'];

if ($_POST['action'] == 'infoproducto') {
  $idcompra= $_POST['venta'];
  $query = mysqli_query($conection, "SELECT ventas.fecha as 'fecha_compra', ventas.id as 'id', producto_venta.idproducto as 'idproducto',ventas.estado_financiero,subcategorias.nombre as 'subcategorias', producto_venta.foto,
  categorias.nombre as 'categorias', provincia.nombre as 'provincia2',ciudad.nombre as 'ciudad2',producto_venta.fecha_producto,producto_venta.precio,producto_venta.porcentaje,producto_venta.qr,producto_venta.tipo_digital,producto_venta.identificador_trabajo,producto_venta.tipo_servicio,producto_venta.fecha_sorteo,producto_venta.hora_sorteo,producto_venta.ganancias_totales,producto_venta.cantidad_boletos,
  producto_venta.fecha_evento,producto_venta.hora_evento,producto_venta.tipo_evento,producto_venta.cantidad_entradas
  , usuarios.nombres, usuarios.apellidos,usuarios.img_perfil,usuarios.nombre_empresa,usuarios.email,usuarios.celular,
  usuarios.facebook,usuarios.facebook,usuarios.instagram,usuarios.whatsapp,usuarios.img_logo,usuarios.celular2,usuarios.numero_identidad,
  ventas.qr_venta,ventas.codigo_venta,ventas.idp,producto_venta.nombre as 'nombre_producto',producto_venta.descripcion,producto_venta.marca,
  ventas.metodo_pago,ventas.fecha_inicio_venta,ventas.fecha_tope_venta,ventas.estado_fisico,ventas.estado,ventas.tipo_reporte,ventas.img_reporte,ventas.fecha_reporte,ventas.descripcion_reporte,ventas.fecha_final_reporte,ventas.qr_venta
  FROM ventas
  INNER JOIN producto_venta ON ventas.idp = producto_venta.idproducto
  INNER JOIN provincia ON   producto_venta.provincia = provincia.id
  INNER JOIN ciudad ON   producto_venta.ciudad = ciudad.id
  INNER JOIN subcategorias ON   producto_venta.subcategorias = subcategorias.id
  INNER JOIN categorias ON   producto_venta.categorias = categorias.id
  INNER JOIN usuarios ON ventas.id_comprador = usuarios.id
  WHERE ventas.id = $idcompra ORDER BY ventas.fecha DESC ");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}

if ($_POST['action'] == 'infoventa_reporte') {
  $idcompra= $_POST['venta'];
  $query = mysqli_query($conection, "SELECT ventas.id,ventas.fecha_cancelacion_venta,ventas.estado_fisico,ventas.estado,ventas.tipo_reporte,ventas.fecha_reporte,ventas.fecha_final_reporte,ventas.img_reporte,
  producto_venta.precio,producto_venta.nombre as 'nombre_producto',ventas.cantidad_producto,usuarios.nombres,usuarios.apellidos,ventas.descripcion_reporte   FROM ventas
  INNER JOIN producto_venta ON ventas.idp = producto_venta.idproducto
  INNER JOIN usuarios ON usuarios.id = ventas.id_comprador
  WHERE ventas.id = $idcompra ORDER BY ventas.fecha DESC ");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}
if ($_POST['action'] == 'detalles_compra') {
  $idcompra= $_POST['venta'];
  $query = mysqli_query($conection, "SELECT * FROM ventas
  INNER JOIN producto_venta ON ventas.idp = producto_venta.idproducto
  WHERE ventas.id = $idcompra ORDER BY ventas.fecha DESC ");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}


if ($_POST['action'] == 'infoventa_producto') {
  $idcompra= $_POST['venta'];
  $query = mysqli_query($conection, "SELECT * FROM ventas
  WHERE ventas.id = $idcompra ORDER BY ventas.fecha DESC ");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}

if ($_POST['action'] == 'cancelar_compra') {
  $idventa  = $_POST['venta'];
  $password = md5($_POST['password']);
  if ($password_db == $password) {
    $query = mysqli_query($conection, "SELECT ventas.cantidad_producto,ventas.id_comprador,ventas.estado,ventas.metodo_pago,producto_venta.precio,ventas.estado_financiero,usuarios.nombres,usuarios.apellidos,producto_venta.nombre as 'nombre_producto',usuarios.email as 'email_prop_pr',producto_venta.idproducto FROM ventas
INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
  WHERE ventas.id = $idventa");
   $result = mysqli_fetch_array($query);
   $id_comprador = $result['id_comprador'];
   $email_prop_pr = $result['email_prop_pr'];
   $nombre_producto = $result['nombre_producto'];
   $metodo_pago = $result['metodo_pago'];
   $idproducto = $result['idproducto'];
   $cantidad_producto  = $result['cantidad_producto'];
   $precio_rebote = $result['precio']*$cantidad_producto;
   $estado_financiero = $result['estado_financiero'];
   $precio_con_comision = ($precio_rebote-$precio_rebote*0.03);
   $ganancias_comision = ($precio_rebote-$precio_con_comision);
     $query_ganancias = mysqli_query($conection, "SELECT * FROM ganacias_netas_1804843900_leben_t");
      $result_ganancias = mysqli_fetch_array($query_ganancias);
      $ganancias_anteriores = $result_ganancias['ganacias_netas'];


   if ($metodo_pago == 'Mi Leben') {
     $query_historial=mysqli_query($conection,"INSERT INTO historial_bancario(cantidad_parcial,cantidad_comision,id_usuario,cantidad,accion,metodo,id_admin,id_accionado)
     VALUES('$precio_con_comision','$ganancias_comision','$id_comprador','$precio_rebote','Deposito','Cancelacion','$id_comprador','Sistema') ");
       $query_bancario = mysqli_query($conection, "SELECT * FROM `saldo_total_leben` WHERE idusuario = '$id_comprador'");
       $result_bancario = mysqli_fetch_array($query_bancario);
       $cantidad_bancaria = $result_bancario['cantidad'];
         $nueva_cantidad = $precio_con_comision +$cantidad_bancaria;
         $nuva_cantidad_ganancias = $ganancias_anteriores+$ganancias_comision;
        $query_cambio_ganancias =mysqli_query($conection,"UPDATE ganacias_netas_1804843900_leben_t SET ganacias_netas= '$nuva_cantidad_ganancias'");
         $query_cambio_estado2=mysqli_query($conection,"UPDATE saldo_total_leben SET cantidad= '$nueva_cantidad' WHERE idusuario='$id_comprador' ");
     $fecha_actual = date('d-m-Y H:m:s', time());
       $query_cancelar_venta=mysqli_query($conection,"UPDATE ventas SET estado= 'Cancelada',fecha_cancelacion_venta='$fecha_actual'  WHERE id='$idventa' AND id_comprador = '$iduser'");
        if ($query_cancelar_venta && $query_cambio_estado2 && $query_historial) {
          try {

            $filep = '../archivos/accioncomprar/guia_cencelacion_compra.pdf';
            // Configuración del servidor
           $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
           $mail -> isSMTP ();                                          // Enviar usando SMTP
           $mail -> Host        = 'cwpjava.hostingsupremo.org' ;                  // Configure el servidor SMTP para enviar a través de
           $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
           $mail ->Username = 'financiero@guibis.com' ;                     // Nombrede usuario SMTP
           $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
           $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
           $mail -> Port        = 465 ;                                      // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

              // Destinatarios
              $mail -> setFrom ( 'financiero@guibis.com' , 'DEPARTAMENTO FINANCIERO' );
              $mail -> addAddress ('financiero@guibis.com');   // Agrega un destinatario
              $mail -> addAddress ('logistica@guibis.com');   // Agrega un destinatario
              $mail -> addAddress ( $email_usuario);
              $mail -> addAddress ( $email_prop_pr);


              $mail->AddAttachment($filep, 'guia_cencelacion_compra.pdf');


              // Contenido
              $mail -> isHTML ( true );                                   // Establecer el formato de correo electrónico en HTML
              $mail->CharSet = 'UTF-8';
              $mail -> Subject = 'CANCELACIÓN DE LA COMPRA DE '.$nombre_producto.'' ;
              $mail -> Body     = '
              <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
                <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
                  <div class="logo-empresa" style="text-align: center;">
                    <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
                  </div>
                  <div class="contenedor-informacion" style="text-align: justify;">
                    <div class="">
                      <div class="">
                        <p style="padding: 5px;">¡Hola!, </p>

                        <p style="padding: 5px;">Lamentamos saber que has cancelado una venta en nuestra plataforma. Para poder solucionar el problema lo antes posible, necesitamos que nos proporciones algunos detalles adicionales. </p>
                        <p style="padding: 5px;">  Se ha hecho la cancelación de compra con código #'.$idventa.', del producto '.$nombre_producto.'  (#'.$idproducto.'), con un precio de $'.$result['precio'].' por unidad el precio total es de '.$precio_con_comision.' por '.$cantidad_producto.' unidades,  la fecha de cancelación
                          es '.$fecha_actual.', por lo que se ha retenido un 3% del total de la venta al usuario que realizo la cancelación, esta acción se puede ver en
                          MENU -> CUENTA-> CUENTA DIGITAL, y también en las consolas de Mis Compras y Mis Ventas. </p>
                        <p style="padding: 5px;">¡Gracias por elegir nuestra empresa de comercio electrónico para sus compras en línea!</p>
                        <p style="padding: 5px;">Atentamente, Equipo Logistico y Financiero </p>



                      </div>
                    </div>

                    <div class="redes-sociales">
                      <div class="redes_email" style="text-align: center;">
                        <a style="text-align: center; margin:3px; padding:4px;" href="https://www.facebook.com/guibisEcuador"><img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                        <a style="text-align: center; margin:3px; padding:4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"><img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                        <a style="text-align: center; margin:3px; padding:4px;" href="https://api.whatsapp.com/send?phone=593998855160&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"><img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>
                      </div>
                  </div>
                  <div class="footer" style="font-size: 10px;">
                    <p style="color: #c1c1c1;">Las cancelaciones de compra solo se pueden hacer en caso de que el comprador haya cambiado de opinión y ya no desee adquirir el producto. No se aceptarán cancelaciones si el producto ya ha sido enviado.
Para hacer una cancelación de compra, es necesario proporcionar la información requerida por la empresa, que incluye el nombre y apellido del comprador, la fecha de compra, el nombre del producto y el motivo de la cancelación.
Al presentar una cancelación de compra, la empresa se reserva el derecho de solicitar pruebas o evidencias que respalden la cancelación, como capturas de pantalla o correos electrónicos.
En caso de que la cancelación de compra sea válida y la empresa acepte hacer un reembolso total del producto, se aplicará una tarifa del 5% del valor total de la venta para cubrir los costos administrativos de procesar la cancelación.
La empresa se compromete a revisar y responder a cada cancelación de compra en un plazo razonable, y a informar al comprador sobre el resultado de la investigación y cualquier acción tomada como resultado.
Las cancelaciones de compra solo pueden ser presentadas por el comprador original del producto, y no pueden ser transferidas a terceros.
La empresa se reserva el derecho de modificar estos términos y condiciones en cualquier momento, y cualquier cambio será comunicado de manera oportuna a los usuarios.
Al hacer uso de nuestros servicios, los usuarios aceptan los términos y condiciones establecidos por la empresa.</p>

                  </div>

                </div>
                </div>

              </body>
                ' ;
              $mail -> send ();
          } catch ( Exception  $e ) {
          }

        $arrayName = array('noticia' =>'venta_cancelada','id_venta'=>$idventa );
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        // code...
        }else {
        $arrayName = array('noticia' =>'Error_cancelar_venta');
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        // code...
        }
     // code...
   }

   if ($metodo_pago == 'Comprobante') {
     if ($estado_financiero == 'PAGADO') {
       $fecha_actual = date('d-m-Y H:m:s', time());
       $nuva_cantidad_ganancias = $ganancias_anteriores+$ganancias_comision;
      $query_cambio_ganancias =mysqli_query($conection,"UPDATE ganacias_netas_1804843900_leben_t SET ganacias_netas= '$nuva_cantidad_ganancias'");
       $query_cancelar_venta=mysqli_query($conection,"UPDATE ventas SET estado= 'Cancelada',fecha_cancelacion_venta='$fecha_actual',estado_reembolso='EN PROCESO'  WHERE id='$idventa' AND id_comprador = '$iduser'");
             if ($query_cancelar_venta) {
             $arrayName = array('noticia' =>'venta_cancelada' );
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }else {
             $arrayName = array('noticia' =>'Error_cancelar_venta');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
     }else {
       $fecha_actual = date('d-m-Y H:m:s', time());
       $query_cancelar_venta=mysqli_query($conection,"UPDATE ventas SET estado= 'Cancelada',fecha_cancelacion_venta='$fecha_actual',estado_reembolso='FINALIZADO'  WHERE id='$idventa' AND id_comprador = '$iduser'");
             if ($query_cancelar_venta) {
             $arrayName = array('noticia' =>'venta_cancelada' );
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }else {
             $arrayName = array('noticia' =>'Error_cancelar_venta');
             echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
             }
     }

   }



  }else {
    $arrayName = array('noticia' =>'Error_password');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }

}

if ($_POST['action'] == 'reporte_problema') {
  $idventa= $_POST['venta'];
  $tipo_reporte= $_POST['tipo_reporte'];
  $descripcion_reporte= $_POST['descripcion_reporte'];
  $password= md5($_POST['password']);

  $foto           =    $_FILES['foto'];
  $nombre_foto    =    $foto['name'];
  $type 					 =    $foto['type'];
  $url_temp       =    $foto['tmp_name'];

  $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
  if ($nombre_foto != '') {
   $destino = '../img/reportes/';
   $img_nombre = 'guibis_reporte_'.md5(date('d-m-Y H:m:s').$iduser);
   $imgProducto = $img_nombre.'.jpg';
   $src = $destino.$imgProducto;
  }


  if ($password_db == $password) {
    $query_email_vendedor = mysqli_query($conection, "SELECT usuarios.email as 'email_vendedor',producto_venta.idproducto,ventas.id,producto_venta.nombre,producto_venta.foto,producto_venta.precio,ventas.cantidad_producto FROM `ventas`
  INNER JOIN producto_venta ON ventas.idp = producto_venta.idproducto
  INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
  WHERE ventas.id = $idventa");
    $result_vendedor = mysqli_fetch_array($query_email_vendedor);
    $email_vendedor = $result_vendedor['email_vendedor'];
    $id_venta_g = $result_vendedor['id'];
    $nombre_producto_g = $result_vendedor['nombre'];
    $idproducto_g = $result_vendedor['idproducto'];
    $precio_g = $result_vendedor['precio'];
    $cantidad_g = $result_vendedor['cantidad_producto'];
    $t_G = $precio_g*$cantidad_g;

    date_default_timezone_set("America/Lima");
    $fecha_actual         =   date('d-m-Y H:m:s', time());
    $fecha_final_reporte  =   date("d-m-Y H:m:s",strtotime($fecha_actual."+ 2 days"));
          $query_reportar =   mysqli_query($conection,"UPDATE ventas SET estado_reporte= 'Activado', tipo_reporte= '$tipo_reporte',descripcion_reporte='$descripcion_reporte',img_reporte='$imgProducto',fecha_reporte = '$fecha_actual',fecha_final_reporte='$fecha_final_reporte',estado ='Reportado'
            WHERE id='$idventa' AND id_comprador = '$iduser'");
       if ($query_reportar) {
         if ($nombre_foto != '') {
           move_uploaded_file($url_temp,$src);
         }
       $arrayName = array('noticia' =>'venta_reportada','id_venta'=>$idventa );
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       try {
            // Configuración del servidor
           $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
           $mail -> isSMTP ();                                          // Enviar usando SMTP
           $mail -> Host        = 'cwpjava.hostingsupremo.org' ;                  // Configure el servidor SMTP para enviar a través de
           $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
           $mail ->Username = 'financiero@guibis.com' ;                     // Nombrede usuario SMTP
           $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
           $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
           $mail -> Port        = 465 ;                                      // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

              // Destinatarios
              $mail -> setFrom ( 'financiero@guibis.com' , 'DEPARTAMENTO FINANCIERO' );
              $mail -> addAddress ('financiero@guibis.com');   // Agrega un destinatario
              $mail -> addAddress ('logistica@guibis.com');   // Agrega un destinatario
           $mail -> addAddress ( $email_vendedor);     // Agrega un destinatario
           $mail -> addAddress ( $email_usuario);     // Agrega un destinatario
           // Contenido
           $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
           $mail->CharSet = 'UTF-8';
           $mail -> Subject = 'Reporte Enviado de '.$nombre_producto_g.'';
           $mail -> Body     = '

           <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
             <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
               <div class="logo-empresa" style="text-align: center;">
                 <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
               </div>
               <div class="contenedor-informacion" style="text-align: justify;">
                 <div class="">
                   <div class="">
                   <h3 style="text-align:center;   font-size: 20px; margin:0; padding:0;"> Reporte Enviado</h3>
                     <p style="padding: 5px;">¡Hola! </p>

                     <p style="padding: 5px;">Lamentamos saber que has reportado una venta en nuestra plataforma. Para poder solucionar el problema lo antes posible, necesitamos que nos proporciones algunos detalles adicionales. </p>
                     <p style="padding: 5px;">  Se ha hecho un reporte de la compra con código #'.$idventa.', del producto '.$nombre_producto.'  (#'.$idproducto.'), con un precio de $'.$result['precio'].' por unidad el precio total es de '.$precio_con_comision.' por '.$cantidad_producto.' unidades,  la fecha de cancelación
                       es '.$fecha_actual.', por lo que se ha retenido un 3% del total de la venta al usuario que realizo la cancelación, esta acción se puede ver en
                       MENU -> CUENTA-> CUENTA DIGITAL, y también en las consolas de Mis Compras y Mis Ventas. </p>
                     <p style="padding: 5px;">¡Gracias por elegir nuestra empresa de comercio electrónico para sus compras en línea!</p>
                     <p style="padding: 5px;">Atentamente, Equipo Logistico y Financiero </p>

                   </div>
                 </div>

                 <div class="img_logo" style="text-align: center;  background:">
                   <img src="https://guibis.com/home/img/reportes/'.$imgProducto.'" alt="'.$imgProducto.'" width="300px;" >
                 </div>

                 <div class="redes-sociales">
                   <div class="redes_email" style="text-align: center;">
                     <a style="text-align: center; margin:3px; padding:4px;" href="https://www.facebook.com/guibisEcuador"><img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="50px;"> </a>
                     <a style="text-align: center; margin:3px; padding:4px;" href="https://www.youtube.com/channel/UCUv90_DETO87rRse6GKCJvg"><img src="https://guibis.com/home/img/reacciones/youtube.png" alt="" width="50px;"> </a>
                     <a style="text-align: center; margin:3px; padding:4px;" href="https://api.whatsapp.com/send?phone=593998855160&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;Guibis&nbsp;"><img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="50px;"> </a>
                   </div>
               </div>
               <div class="footer" style="font-size: 10px;">
                 <p style="color: #c1c1c1;">Las cancelaciones de compra solo se pueden hacer en caso de que el comprador haya cambiado de opinión y ya no desee adquirir el producto. No se aceptarán cancelaciones si el producto ya ha sido enviado.
Para hacer una cancelación de compra, es necesario proporcionar la información requerida por la empresa, que incluye el nombre y apellido del comprador, la fecha de compra, el nombre del producto y el motivo de la cancelación.
Al presentar una cancelación de compra, la empresa se reserva el derecho de solicitar pruebas o evidencias que respalden la cancelación, como capturas de pantalla o correos electrónicos.
En caso de que la cancelación de compra sea válida y la empresa acepte hacer un reembolso total del producto, se aplicará una tarifa del 5% del valor total de la venta para cubrir los costos administrativos de procesar la cancelación.
La empresa se compromete a revisar y responder a cada cancelación de compra en un plazo razonable, y a informar al comprador sobre el resultado de la investigación y cualquier acción tomada como resultado.
Las cancelaciones de compra solo pueden ser presentadas por el comprador original del producto, y no pueden ser transferidas a terceros.
La empresa se reserva el derecho de modificar estos términos y condiciones en cualquier momento, y cualquier cambio será comunicado de manera oportuna a los usuarios.
Al hacer uso de nuestros servicios, los usuarios aceptan los términos y condiciones establecidos por la empresa.</p>

               </div>

             </div>
             </div>

           </body>

             ' ;
           $mail -> send ();
       } catch ( Exception  $e ) {
       }
       // code...
       }else {
       $arrayName = array('noticia' =>'Error_reportar_venta');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       // code...
       }

  }else {
    $arrayName = array('noticia' =>'Error_password');
    echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }

}









 ?>
