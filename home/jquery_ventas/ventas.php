<?php
require("../mail/PHPMailer-master/src/PHPMailer.php");
require("../mail/PHPMailer-master/src/Exception.php");
require("../mail/PHPMailer-master/src/SMTP.php");

use  PHPMailer \ PHPMailer \ PHPMailer ;
use  PHPMailer \ PHPMailer \ Exception ;
// La instanciación y el paso de `true` habilita excepciones
$mail = new  PHPMailer ( true );
include "../../coneccion.php";
mysqli_set_charset($conection, 'utf8'); //linea a colocar
session_start();
$iduser= $_SESSION['id'];
$query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$nombres = $result['nombres'];
$apellidos = $result['apellidos'];
$mi_leben = $result['mi_leben'];
$cuenta_bancaria = $result['banco_pichincha'];
$banco_guayaquil = $result['banco_guayaquil'];
$banco_produbanco = $result['banco_produbanco'];
 $password_db = $result['password'];



if ($_POST['action'] == 'inforeporte') {
$venta = $_POST['venta'];
  $query = mysqli_query($conection, "SELECT * FROM ventas WHERE id='$venta'");
  $result = mysqli_fetch_array($query);
  $estado_reporte = $result['estado_reporte'];

  if ($estado_reporte == 'Activado') {
      $query = mysqli_query($conection, "SELECT * FROM ventas WHERE id='$venta'");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
  }else {
    $arrayName = array('noticia' =>'sin_reporte');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }
}


if ($_POST['action'] == 'reportar_reporte') {

  $idventa= $_POST['venta'];
  $descripcion_reporte= $_POST['descripcion_reporte'];
  $password= md5($_POST['password']);

  $foto           =    $_FILES['foto'];
  $nombre_foto    =    $foto['name'];
  $type 					 =    $foto['type'];
  $url_temp       =    $foto['tmp_name'];

  $imgProducto   =   'img_producto.jpg' || 'img_producto.png';
  if ($nombre_foto != '') {
   $destino = '../img/reportes/';
   $img_nombre = $iduser.md5(date('d-m-Y H:m:s'));
   $imgProducto = $img_nombre.'.jpg';
   $src = $destino.$imgProducto;
  }


  if ($password_db == $password) {
    $query_email_vendedor = mysqli_query($conection, "SELECT usuarios.email as 'email_vendedor' FROM `ventas`
  INNER JOIN producto_venta ON ventas.idp = producto_venta.idproducto
  INNER JOIN usuarios ON usuarios.id = producto_venta.id_usuario
  WHERE ventas.id = $idventa");
    $result_vendedor = mysqli_fetch_array($query_email_vendedor);
    $email_vendedor = $result_vendedor['email_vendedor'];


    $query_email_comprador = mysqli_query($conection, "SELECT usuarios.email as 'email_comprador' FROM `ventas`
INNER JOIN usuarios ON usuarios.id = ventas.id_comprador
WHERE ventas.id = $idventa");
    $result_comprador = mysqli_fetch_array($query_email_comprador);
    $email_comprador = $result_comprador['email_comprador'];
    date_default_timezone_set("America/Lima");
    $fecha_actual = date('d-m-Y H:m:s', time());
          $query_reportar=mysqli_query($conection,"UPDATE ventas SET estado_contrareporte= 'Activado',descripcion_contrareporte ='$descripcion_reporte',img_contrareporte='$imgProducto',fecha_contrareporte  = '$fecha_actual'
            WHERE id='$idventa'");
       if ($query_reportar) {
         if ($nombre_foto != '') {
           move_uploaded_file($url_temp,$src);
         }
       $arrayName = array('noticia' =>'venta_recontrareportada','id_venta'=>$idventa );
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
       try {
            // Configuración del servidor
           $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
           $mail -> isSMTP ();                                          // Enviar usando SMTP
           $mail -> Host        = 'cwpjava.hostingsupremo.org' ;                  // Configure el servidor SMTP para enviar a través de
           $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
           $mail ->Username = 'departamento-legal@guibis.com' ;                     // Nombrede usuario SMTP
           $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
           $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
           $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

           // Destinatarios
           $mail -> setFrom ( 'departamento-legal@guibis.com' , 'DEPARTAMENTO-LEGAL' );
           $mail -> addAddress ( $email_vendedor);     // Agrega un destinatario
           $mail -> addAddress ( $email_comprador);     // Agrega un destinatario
           $mail -> addAddress ('departamento-legal@guibis.com');    // Agrega un destinatario
           $mail -> addAddress ('logistica@guibis.com');    // Agrega un destinatario
           $mail -> addAddress ('financiero@guibis.com');    // Agrega un destinatario
           // Contenido
           $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
               $mail->CharSet = 'UTF-8';
           $mail -> Subject = 'CONTRA REPORTE DE LA VENTA CÓDIGO '.$idventa.'';
           $mail -> Body     = '



           <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
             <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
               <div class="logo-empresa" style="text-align: center;">
                 <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
               </div>
               <div class="contenedor-informacion" style="text-align: justify;">
                 <div class="">
                   <div class="">
                     <p style="padding: 5px;">Estimado(a), </p>

                     <p style="padding: 5px;">Estamos evaluando cuidadosamente el contrareporte que presentaste en respuesta al reporte de no entrega presentado por [nombre del cliente que reportó]. Desafortunadamente, debido a la complejidad de la situación, es necesario llevar a cabo un proceso legal para resolver este problema. </p>
                     <p style="padding: 5px;">Resumen:Código de contra-reporte '.$idventa.' si tienes alguna duda o enviar documentos se lo puede realizar a departamento-legal@guibis.com </p>
                     <p style="padding: 5px;">Queremos informarte que este proceso legal tiene un costo adicional del 2% del valor total de la venta, además de una comisión del 3% sobre el precio de compra. Este proceso tiene una duración de 24 horas laborables </p>
                     <p style="padding: 5px;">¡Gracias por elegir nuestra empresa de comercio electrónico para sus compras en línea!</p>
                     <p style="padding: 5px;">Si necesitas más información o tienes alguna pregunta, no dudes en comunicarte con nosotros. </p>
                     <p style="padding: 5px;">Agradecemos tu cooperación en este proceso y valoramos tu compromiso con nuestros procesos de venta. </p>
                     <p style="padding: 5px;"> Atentamente: </p>
                     <p style="padding: 5px;"> GUIBIS.COM </p>

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
                 <p style="color: #c1c1c1;">Los usuarios de ventas tienen la opción de presentar un contrareporte en respuesta a un reporte de no entrega presentado por un cliente.
           Para llevar a cabo el proceso de resolución de conflictos, se requiere la evaluación del Departamento Legal de la empresa.
           Si la decisión final favorece al usuario de ventas, no habrá costos adicionales asociados con el proceso de resolución de conflictos.
           Si la decisión final favorece al cliente, el usuario de ventas deberá pagar una comisión del 2% del valor total de la venta, además de una comisión del 3% sobre el precio de compra.
           La decisión final se tomará después de un período de 24 horas laborables desde la presentación del contrareporte.
           Si el usuario de ventas no está de acuerdo con la decisión final, se pueden tomar medidas adicionales, que pueden incluir costos adicionales.
           La empresa se reserva el derecho de cancelar o modificar el proceso de resolución de conflictos en cualquier momento y sin previo aviso.
           La empresa no se hace responsable por cualquier daño o pérdida resultante del proceso de resolución de conflictos.
           El uso del proceso de contrareporte y resolución de reportes de no entrega implica la aceptación de estos términos y condiciones.
           Al presentar un contrareporte, el usuario de ventas reconoce haber leído y comprendido estos términos y condiciones y acepta cumplir con ellos en su totalidad.</p>

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






if ($_POST['action'] == 'infoproducto_venta') {
  $venta = $_POST['venta'];
  $query = mysqli_query($conection, "SELECT producto_venta.nombre as 'nombre_producto',producto_venta.precio,producto_venta.identificador_trabajo,producto_venta.foto,ventas.id,ventas.fecha,producto_venta.descripcion,ventas.cantidad_producto FROM `ventas`
INNER JOIN usuarios ON ventas.id_comprador = usuarios.id
INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
WHERE ventas.id = $venta");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}


if ($_POST['action'] == 'infoComprador') {
  $venta = $_POST['venta'];
  $query = mysqli_query($conection, "SELECT usuarios.nombres as 'nombres_comprador', usuarios.apellidos as 'apellidos_comprador',
     usuarios.email as 'email_comprador', usuarios.whatsapp, usuarios.celular, ventas.metodo_pago,usuarios.fecha_creacion,usuarios.id as'id_usuario' FROM `ventas`
INNER JOIN usuarios ON ventas.id_comprador = usuarios.id
WHERE ventas.id = $venta");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}


if ($_POST['action'] == 'infoventa') {
  $venta = $_POST['venta'];
  $query = mysqli_query($conection, "SELECT * FROM ventas
  INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
WHERE ventas.id = $venta");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}
if ($_POST['action'] == 'infoventa2') {
  $venta = $_POST['venta'];
  $query = mysqli_query($conection, "SELECT * FROM ventas
WHERE ventas.id = $venta");
    $data = mysqli_fetch_assoc($query);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}


if ($_POST['action'] == 'entregar_producto') {
  $id_venta = $_POST['id_venta'];
  $query = mysqli_query($conection, "SELECT ventas.estado_financiero, usuarios.email, producto_venta.nombre, producto_venta.precio,ventas.estado FROM ventas
INNER JOIN usuarios ON usuarios.id = ventas.id_comprador
INNER JOIN producto_venta ON producto_venta.idproducto = ventas.idp
WHERE ventas.id = $id_venta");
 $result = mysqli_fetch_array($query);
  $estado_financiero = $result['estado_financiero'];
    $email_comprador = $result['email'];
    $nombre_producto = $result['nombre'];
    $precio_producto = $result['precio'];
    $estado_venta = $result['estado'];
    if ($estado_venta == 'Iniciada') {
      if ($estado_financiero == 'Pago Verificado' || $estado_financiero == 'PAGADO' ) {

        date_default_timezone_set("America/Lima");
        $fecha_actual = date('d-m-Y H:m:s', time());
         $fecha_final_reporte = date("d-m-Y H:m:s",strtotime($fecha_actual."+ 1 days"));
          $query_insert=mysqli_query($conection,"UPDATE ventas SET estado_fisico='ENTREGADO',fecha_entrega='$fecha_actual',fecha_tope_sin_novedades='$fecha_final_reporte'  WHERE ventas.id='$id_venta' ");
          if ($query_insert) {
             $filep = '../archivos/accioncomprar/guia_entregar_producto.pdf';
            try {
                 // Configuración del servidor
                $mail -> SMTPDebug = 0;                                      // Habilita la salida de depuración detallada
                $mail -> isSMTP ();                                           // Enviar usando SMTP
                $mail -> Host        = 'cwpjava.hostingsupremo.org' ;                  // Configure el servidor SMTP para enviar a través de
                $mail -> SMTPAuth    = true ;                                   // Habilita la autenticación SMTP
                $mail ->Username = 'logistica@guibis.com' ;                     // Nombrede usuario SMTP
                $mail ->Password = 'MACAra666_' ;                               // Contraseña SMTP
                $mail -> SMTPSecure = 'ssl';         // Habilite el cifrado TLS; Se recomienda `PHPMailer :: ENCRYPTION_SMTPS`
                $mail -> Port        = 465 ;                                     // Puerto TCP para conectarse, use 465 para `PHPMailer :: ENCRYPTION_SMTPS` arriba

                // Destinatarios
                        $mail -> setFrom ( 'logistica@guibis.com' , 'Deparatmento de Lógistica' );
                $mail -> addAddress ( $email_usuario);
                $mail -> addAddress ( $email_comprador);    // Agrega un destinatario
                $mail -> addAddress ('logistica@guibis.com');    // Agrega un destinatario

                $mail->AddAttachment($filep, 'guia_entregar_producto.pdf');


                // Contenido
                $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                $mail->CharSet = 'UTF-8';
                $mail -> Subject = 'ENTREGA DEL PRODUCTO '.$nombre_producto.' ' ;
                $mail -> Body     = '


                  <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
                    <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
                      <div class="logo-empresa" style="text-align: center;">
                        <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
                      </div>
                      <div class="contenedor-informacion" style="text-align: justify;">
                        <div class="">
                          <div class="">
                            <p style="padding: 5px;">Estimado.</p>

                            <p style="padding: 5px;">Nos complace informarle que su pedido de "'.$nombre_producto.'" ha sido entregado satisfactoriamente y registrado en nuestro sistema a las '.$fecha_actual.'. Agradecemos su confianza en nuestra empresa de comercio electrónico y esperamos que disfrute de su compra. </p>
                            <p style="padding: 5px;">Si tiene alguna pregunta o inquietud relacionada con su pedido, no dude en ponerse en contacto con nosotros y haremos todo lo posible para ayudarlo. </p>
                            <p style="padding: 5px;">¡Gracias por elegir nuestra empresa de comercio electrónico para sus compras en línea!</p>
                            <p style="padding: 5px;">Atentamente,Sistema de Logística  </p>



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
                        <p style="color: #c1c1c1;">Confirmación de la orden: El comprador es responsable de proporcionar información precisa y completa al realizar una orden, incluyendo la dirección de envío correcta y cualquier otra información relevante. El vendedor no será responsable de las pérdidas o retrasos causados por información inexacta o incompleta proporcionada por el comprador.

Entrega del producto: El vendedor es responsable de empaquetar y enviar el producto de manera oportuna y segura utilizando un servicio de mensajería confiable. Sin embargo, el vendedor no será responsable de las pérdidas o daños causados por el servicio de mensajería o cualquier otra causa fuera de su control.

Confirmación de entrega: El comprador es responsable de confirmar la entrega del producto y notificar al vendedor si hay algún problema con el envío. Si el comprador no confirma la entrega dentro de un plazo razonable, se considerará que el producto ha sido entregado correctamente.

Proceso de pago: El comprador es responsable de procesar el pago de manera oportuna y asegurarse de que se complete correctamente. Si hay algún problema con el proceso de pago, el comprador debe comunicarse con el vendedor lo antes posible para resolver el problema.

Política de devoluciones: El vendedor debe tener una política clara de devoluciones y reembolsos en su sitio web. El comprador es responsable de leer y comprender esta política antes de realizar una orden. Si el producto debe ser devuelto, el comprador es responsable de seguir las instrucciones del vendedor y devolver el producto de manera segura y oportuna.

Responsabilidad limitada: En ningún caso el vendedor será responsable de cualquier daño especial, incidental, indirecto o consecuente que surja del uso o la imposibilidad de usar el producto, incluso si el vendedor ha sido informado de la posibilidad de tales daños.

Al realizar una orden en esta empresa de comercio electrónico, el comprador acepta estos términos y condiciones y se compromete a cumplir con ellos. El vendedor se reserva el derecho de cambiar estos términos y condiciones en cualquier momento sin previo aviso.</p>

                      </div>

                    </div>
                    </div>

                  </body>

                  ' ;
                $mail -> send ();
            } catch ( Exception  $e ) {
            }
            $arrayName = array('noticia' =>'producto_entregado' ,'id_venta' =>$id_venta);
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
            // code...
          }else {
            $arrayName = array('noticia' =>'error_insertar_sistema');
            echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          }
      }else {
        $arrayName = array('noticia' =>'estado_financiero_no_valido');
       echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
      }
      // code...
    }else {
      $arrayName = array('noticia' =>'estado_cancelado_o_finalizado');
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }

}




if ($_POST['action'] == 'solicitar_pago') {
        $id_venta             = $_POST['id_venta'];
        $tipo_banco_solicitud = $_POST['tipo_banco_solicitud'];
        $query      = mysqli_query($conection, "SELECT * FROM ventas INNER JOIN producto_venta ON ventas.idp=producto_venta.idproducto WHERE ventas.id = $id_venta");
        $result     = mysqli_fetch_array($query);
        $estado_financiero = $result['estado_financiero'];
        $estado_fisico     = $result['estado_fisico'];
        $solicitud_pago    = $result['solicitud_pago'];
        $precio_producto   = $result['precio'];
        $nombre_producto   = $result['nombre'];
        $estado_hotmart    = $result['estado_hotmart'];

            $cantidad_producto = $result['cantidad_producto'];
            $id_usuario_dueno_producto = $result['id_usuario'];
            /*codigo insertado para colaboradores*/
            $estado_colaboracion = $result['estado_colaboracion'];
            $porcentaje_colaboracion = $result['porcentaje_colaboracion'];
              /**/
            $G_T = $cantidad_producto*$precio_producto;

            $fecha_tope_sin_novedades = $result['fecha_tope_sin_novedades'];
            $estado_reportes = $result['estado_reporte'];
            $fecha_actual = date('d-m-Y H:m:s', time());


  if ($estado_reportes == 'Ninguno' || $estado_reportes == '') {
    if ($fecha_tope_sin_novedades <= $fecha_actual ) {
        if ($estado_fisico =='ENTREGADO' && $fecha_tope_sin_novedades <= $fecha_actual  ) {
          if ($solicitud_pago != 'PAGADO') {
          if ($tipo_banco_solicitud == 'Mi Cuenta Leben') {
          if ($mi_leben == 'Activa') {
            $query_bancario = mysqli_query($conection, "SELECT saldo_total_leben.cantidad,saldo_total_leben.idusuario FROM saldo_total_leben
            WHERE idusuario = $iduser");
            $result_bancario = mysqli_fetch_array($query_bancario);
            $cantidad_bancaria = $result_bancario['cantidad'];
            /* inicio codigo insertado para colaboradores */
            $estado_colaboracion = $result['estado_colaboracion'];
            $porcentaje_colaboracion = $result['porcentaje_colaboracion'];
            if ($estado_colaboracion=='Aceptado') {
              $porcentaje_comision = (100-$porcentaje_colaboracion)/100;
              $detalle_colaboracion = 'Anclado';
            }else {
              $porcentaje_comision = 0.03;
              $detalle_colaboracion = '';
            }
            /* Final codigo insertado para colaboradores */
            $total_transferencia = ($precio_producto-($precio_producto*$porcentaje_comision))*$cantidad_producto+$cantidad_bancaria;
            $cantidad_parcial = ($precio_producto-($precio_producto*$porcentaje_comision))*$cantidad_producto;
            $cantidad_comision = $precio_producto*$cantidad_producto*$porcentaje_comision;
            if ($estado_hotmart == 'Activo') {
              /*Porcentaje Hotmart*/
              $porcen_hotmart = $result['porcen_hotmart'];
              $porcen_hotmart = ($porcen_hotmart)/100;
              /*Porcentaje Hotmart*/
                  $user_integrado = $result['user_integrado'];
                  $query_bancario_integrado = mysqli_query($conection, "SELECT saldo_total_leben.cantidad,saldo_total_leben.idusuario FROM saldo_total_leben
                  WHERE idusuario = $user_integrado");
                  $result_bancario_integrado = mysqli_fetch_array($query_bancario_integrado);
                  $cantidad_bancaria_integrado = $result_bancario_integrado['cantidad'];

                  /*Cuenta Principal*/

                  $total_transferencia_principal = $precio_producto*$cantidad_producto*(1-$porcen_hotmart-0.03)+$cantidad_bancaria;
                  $cantidad_parcial_principal = $precio_producto*$cantidad_producto*(1-$porcen_hotmart-0.03);
                  $cantidad_comision_principal = $precio_producto*$cantidad_producto*($porcen_hotmart+0.03);
                  /*Cuenta Secundaria*/
                  $query_bancario_secundario = mysqli_query($conection, "SELECT saldo_total_leben.cantidad,saldo_total_leben.idusuario FROM saldo_total_leben
                  WHERE idusuario = $user_integrado");
                  $result_bancario_secundario = mysqli_fetch_array($query_bancario_secundario);
                  $cantidad_bancaria_secundario = $result_bancario_secundario['cantidad'];

                  $cantidad_nueva_principal = $precio_producto*$cantidad_producto*($porcen_hotmart);
                  $total_transferencia_secundario = $cantidad_nueva_principal*0.97+$cantidad_bancaria_secundario;
                  $cantidad_parcial_secundario = $cantidad_nueva_principal*0.97;
                  $cantidad_comision_secundaria = $cantidad_nueva_principal*0.03;

                  $query_ganancias = mysqli_query($conection, "SELECT * FROM ganacias_netas_1804843900_leben_t");
                  $result_ganancias = mysqli_fetch_array($query_ganancias);
                  $ganancias_anteriores = $result_ganancias['ganacias_netas'];

                  $nuva_cantidad_ganancias = $ganancias_anteriores+$cantidad_comision_secundaria;
                   $query_cambio_ganancias =mysqli_query($conection,"UPDATE ganacias_netas_1804843900_leben_t SET ganacias_netas= '$nuva_cantidad_ganancias'");



                  $query_insert_dinero_principal=mysqli_query($conection,"UPDATE saldo_total_leben SET cantidad= '$total_transferencia_principal'  WHERE idusuario='$iduser' ");
                  $query_insert=mysqli_query($conection,"UPDATE ventas SET solicitud_pago='PAGADO',fecha_solicitud_pago ='$fecha_actual',tipo_retiro='Mi leben',estado='Finalizada'  WHERE ventas.id='$id_venta' ");
                  $query_historial_principal=mysqli_query($conection,"INSERT INTO historial_bancario(detalle_colaboracion,id_venta,cantidad_parcial,cantidad_comision,id_usuario,cantidad,accion,metodo,id_admin,id_accionado)
                  VALUES('$detalle_colaboracion','$id_venta','$cantidad_parcial_principal','$cantidad_comision_principal','$iduser','$G_T','Venta','Mi Leben','$id_usuario_dueno_producto','Ninguno') ");

                  $query_insert_dinero_secundario=mysqli_query($conection,"UPDATE saldo_total_leben SET cantidad= '$total_transferencia_secundario'  WHERE idusuario='$user_integrado' ");
                  $query_historial_secundario=mysqli_query($conection,"INSERT INTO historial_bancario(detalle_colaboracion,id_venta,cantidad_parcial,cantidad_comision,id_usuario,cantidad,accion,metodo,id_admin,id_accionado)
                                                                                              VALUES('$detalle_colaboracion','$id_venta','$cantidad_parcial_secundario','$cantidad_comision_secundaria','$user_integrado','$cantidad_nueva_principal','Venta Resiudal','Mi Leben','$id_usuario_dueno_producto','Ninguno') ");



              // code...
            }else {

              $query_insert_dinero=mysqli_query($conection,"UPDATE saldo_total_leben SET cantidad= '$total_transferencia'  WHERE idusuario='$iduser' ");
              $query_insert=mysqli_query($conection,"UPDATE ventas SET solicitud_pago='PAGADO',fecha_solicitud_pago ='$fecha_actual',tipo_retiro='Mi leben',estado='Finalizada'  WHERE ventas.id='$id_venta' ");
              $query_historial=mysqli_query($conection,"INSERT INTO historial_bancario(detalle_colaboracion,id_venta,cantidad_parcial,cantidad_comision,id_usuario,cantidad,accion,metodo,id_admin,id_accionado)
              VALUES('$detalle_colaboracion','$id_venta','$cantidad_parcial','$cantidad_comision','$iduser','$G_T','Venta','Mi Leben','$id_usuario_dueno_producto','Ninguno') ");

            }



            if ($query_insert) {
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
                    $mail -> setFrom ( 'guibis-ecuador@guibis.com' , 'Guibis-Ecuador' );
                  $mail -> addAddress ( $email_usuario);     // Agrega un destinatario
                  $mail -> addAddress ( 'financiero@guibis.com');
                    $mail -> addAddress ('guibis-ecuador@guibis.com');     // Agrega un destinatario
                  // Contenido
                  $mail -> isHTML ( true );                                  // Establecer el formato de correo electrónico en HTML
                  $mail->CharSet = 'UTF-8';
                  $mail -> Subject = 'SOLICITUD DE PAGO DE '.$nombre_producto.' ' ;
                  $mail -> Body     = '
                     <body style="background: #f5f5f5;padding: 6px;margin: 25px;">
                       <div class="contenedor" style="background: #fff;padding: 20px;margin: 10px;">
                         <div class="logo-empresa" style="text-align: center;">
                           <img src="https://guibis.com/home/img/reacciones/guibis.png" alt="" style="width: 200px;">
                         </div>
                         <div class="contenedor-informacion" style="text-align: justify;">
                           <div class="">
                             <div class="">
                               <p style="padding: 5px;">Estimado '.$nombres.' '.$apellidos.', </p>

                               <p style="padding: 5px;">Nos complace informarle que la solicitud de pago mediante la cuenta digital Guibis.com de un valor de $'.$G_T.' Dólares Americanos por '.$nombre_producto.', el porcentaje de comisión es del 3% ($'.$cantidad_comision.'), y el valor neto
                                depositado a tu cuenta digital es de ($'.$cantidad_parcial.'), a la fecha '.$fecha_actual.' esta acción lo puedes ver en tu cuenta digital. </p>
                               <p style="padding: 5px;">Si tiene alguna pregunta o inquietud relacionada , no dude en ponerse en contacto con nosotros y haremos todo lo posible para ayudarlo. </p>
                               <p style="padding: 5px;">¡Gracias por elegir nuestra empresa de comercio electrónico para sus compras en línea!</p>
                               <p style="padding: 5px;">Atentamente,Alex </p>

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
                           <p style="color: #c1c1c1;">Este es un mensaje enviado en automatico no responsas a este mensaje, guibis.com es una empresa que tiene tecnología en la cual evita las estafas al comprar y vender por intenet, tienes su propia pasarela de pagos y con ello controla las estafas o posibles escenarios fraudulentos,
                             toda la información que se registra en nuestro sitio nos brinda la potestad de activar cuentas de acuerdo a nuestros criterios y con ello salvaguardar la cominudad de guibis.com si deseas soporte directo contacta con nuestras lineas soporte@guibis.com, o al teléfono 0998855160, nosotros como empresa respaldamos los datos sin estar ligados con terceras
                           empresas por lo que la seguridad externa del usuariio es netamente del usuario.</p>

                         </div>

                       </div>
                       </div>

                     </body>

                    ' ;
                  $mail -> send ();
              } catch ( Exception  $e ) {
              }


              $arrayName = array('noticia' =>'pagado_correctamente','id_venta'=>$id_venta);
                  echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }else {
                $arrayName = array('noticia' =>'error_pago_servidor');
               echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
              }

         }else {
           $arrayName = array('noticia' =>'cuenta_inactiva');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
         }

        }


        }else {
          $arrayName = array('noticia' =>'venta_pagada_sin_acciones');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }



        }else {
          $arrayName = array('noticia' =>'pago_o_entrega_no_valido');
         echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
        }

    }else {
      $arrayName = array('noticia' =>'fecha_no_activa','fecha_activa'=>$fecha_tope_sin_novedades);
     echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
    }

  }else {
    $arrayName = array('noticia' =>'reporte_activado');
   echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
  }







}



 ?>
