<?php
require '../../../QR/phpqrcode/qrlib.php';
 include "../../../../coneccion.php";
 mysqli_set_charset($conection, 'utf8'); //linea a colocar

      session_start();
   if ($_SESSION['rol'] == 'cuenta_empresa') {
   include "../../../sessiones/session_cuenta_empresa.php";

   }

   if ($_SESSION['rol'] == 'cuenta_usuario_venta') {
   include "../../../sessiones/session_cuenta_usuario_venta.php";

   }

   if ($_SESSION['rol'] == 'Mesero') {
   include "../../../sessiones/session_cuenta_mesero.php";

   }

   if ($_SESSION['rol'] == 'Cocina') {
   include "../../../sessiones/session_cuenta_cocina.php";
   }

   $rol_user = $_SESSION['rol'];

		include '../lib/PHPMailer/PHPMailerAutoload.php';




		//CODIGO PARA SACAR SACAR LA SECUENCIA DE LA NOTA AUTORIZADA

    $codigo_factura_comprobante = $_POST['codigo_factura'];


	 $query_secuencial = mysqli_query($conection, "SELECT * FROM  nota_venta_autorizada  WHERE  nota_venta_autorizada.id_emisor  = '$iduser'  ORDER BY fecha DESC");
		$result = mysqli_fetch_array($query_secuencial);
		if ($result) {
			$secuencial = $result['codigo_factura'];
			$secuencial = $secuencial+1;
			// code...
		}else {
			$secuencial =1;
		}


		//CODIGO PARA DISMINUIR LA CANTIDAD DE LOS PRODUCTOS EXISTENTES
		$query_actualizar_cantidad = mysqli_query($conection,"SELECT * FROM comprobantes
			WHERE id_emisor= '$iduser' AND secuencial = '$codigo_factura_comprobante'");
	 while ($resultados_actualizar = mysqli_fetch_array($query_actualizar_cantidad)) {
			 if ($resultados_actualizar['id_producto'] != '0') {
         $id_producto = $resultados_actualizar['id_producto'];
				 $cantidad_vende = $resultados_actualizar['cantidad_producto'];
				 $codigo_factura = $resultados_actualizar['secuencial'];
				 $codigo_mesa = $resultados_actualizar['codigo_mesa'];

				 $query_resultados_productos = mysqli_query($conection,"SELECT * FROM producto_venta   WHERE idproducto= '$id_producto'");
				 $resultados_producto = mysqli_fetch_array($query_resultados_productos);
				 $cantidad_existente = $resultados_producto['cantidad'];
         $cantidad_new = $cantidad_existente-$cantidad_vende;
				 $query_edit_cantidad = mysqli_query($conection,"UPDATE producto_venta SET cantidad='$cantidad_new' WHERE idproducto = '$id_producto'");
				 $query_insert_cantidad=mysqli_query($conection,"INSERT INTO inventario(cantidad,motivo,detalles_extras,idproducto,iduser,cantidad_new,accion )
																																		 VALUES('$cantidad_vende','VENTA SISTEMA','TICKET','$id_producto','$iduser','$cantidad_new','DISMINUIR') ");

			 }
		}




		$query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
		$result_documentos = mysqli_fetch_array($query_doccumentos);
		$img_logo                 = $result_documentos['img_facturacion'];
		$url_img_upload           = $result_documentos['url_img_upload'];
		$correo                   = $result_documentos['email'];
		$celular                  = $result_documentos['celular'];
		$telefono                 = $result_documentos['telefono'];
		$direccion                = $result_documentos['direccion'];
		$nombre_empresa           = $result_documentos['nombre_empresa'];
		$razon_social             = $result_documentos['razon_social'];
		$numero_identidad         = $result_documentos['numero_identidad'];
		$img_facturacion         = $result_documentos['img_facturacion'];
    $ciudad         = $result_documentos['ciudad'];
    $provincia         = $result_documentos['provincia'];
    $regimen         = $result_documentos['regimen'];

		//codigo para saber como va el emisor
		if (empty($nombre_empresa) || $nombre_empresa == '0') {
			$nombre_salida = $razon_social;
		}else {
			$nombre_salida = $nombre_empresa;
		}

		//redes

		$facebook                = $result_documentos['facebook'];
		$instagram           = $result_documentos['instagram'];
		$whatsapp             = $result_documentos['whatsapp'];



		if (!empty($facebook)) {
			$facebook = '<a style="text-align: center; margin:3px; padding4px;" href="'.$facebook.'"> <img src="https://guibis.com/home/img/reacciones/facebook.png" alt="" width="30px;"></a>';
		}else {
			$facebook = '';
		}

		if (!empty($instagram)) {
			$instagram = '<a style="text-align: center; margin:3px; padding4px;" href="'.$instagram.'"> <img src="https://guibis.com/home/img/reacciones/instagram.png" alt="" width="30px;"></a>';
		}else {
			$instagram = '';
		}

		if (!empty($whatsapp)) {
			$whatsapp = '<a style="text-align: center; margin:3px; padding4px;" href="https://api.whatsapp.com/send?phone='.$whatsapp.'&amp;text=Hola!&nbsp;Vengo&nbsp;De&nbsp;'.$nombre_salida.'&nbsp;"> <img src="https://guibis.com/home/img/reacciones/whatsapp.png" alt="" width="30px;"></a>';
		}else {
			$whatsapp = '';
		}


		$host_envio                 = $result_documentos['host_envio'];
		$puerto_email_envio         = $result_documentos['puerto_email_envio'];
		$email_user_name_envio      = $result_documentos['email_user_name_envio'];
		$password_envio_email       = $result_documentos['password_envio_email'];
		$descripcion_envio_email    = $result_documentos['descripcion_envio_email'];
	 $punto_emision_f         = $result_documentos['punto_emision_f'];
	 $estableciminento_f      = $result_documentos['estableciminento_f'];
	 $estableciminento_f   = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
	 $punto_emision_f      = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);
	 $secuencial           = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
			$query_lista_t = mysqli_query($conection,"SELECT SUM(((comprobantes.cantidad_producto)*(comprobantes.valor_unidad))) as
      'compra_total', SUM(((comprobantes.iva_producto))) AS 'iva_general',
      SUM(((comprobantes.precio_neto)+(comprobantes.iva_producto))) AS 'precioncluido_iva',SUM(((comprobantes.cantidad_producto))) AS 'productos_totales'
      FROM `comprobantes`
      WHERE comprobantes.id_emisor = '$iduser' AND secuencial = '$codigo_factura'");
      $data_lista_t=mysqli_fetch_array($query_lista_t);
      $precio_12_iva = round(($data_lista_t['iva_general']),2);
      $precio_88_iva = round(($data_lista_t['compra_total']),2);
      $precio_total  = round( $precio_12_iva+$precio_88_iva,2);
			$productos_totales = $data_lista_t['productos_totales'];
      $descuento = 0;
			$fecha_actual = date("d-m-Y");
			$fechasf =  str_replace("-","",date("d-m-Y",strtotime($fecha_actual." -0 hours")));

			$clave_acc_guardar = $fechasf.$punto_emision_f.$estableciminento_f.$numero_identidad.$secuencial;

			$numDocModificado = $punto_emision_f.'-'.$estableciminento_f.'-'.$secuencial;
	    $fecha_actual = date("d-m-Y h:m:s");
			$fecha_emision =  date("d-m-Y h:m:s",strtotime($fecha_actual." +0 hours"));

			$query_resultados_emmisor = mysqli_query($conection,"SELECT * FROM comprobantes
				WHERE id_emisor= '$iduser' AND secuencial = '$codigo_factura_comprobante'");
				$data__emmisor=mysqli_fetch_array($query_resultados_emmisor);
				$id_receptor = $data__emmisor['id_receptor'];
				$nombres_receptor   = $data__emmisor['nombres_receptor'];
				$precio_neto        = $data__emmisor['precio_neto'];
				$descripcion        = $data__emmisor['descripcion_producto'];
				$direccion_receptor = $data__emmisor['direccion_reeptor'];
				$celular_receptor   = $data__emmisor['celular_receptor'];
				$email_receptor     = $data__emmisor['email_reeptor'];
				$numero_identidad_receptor = $data__emmisor['numero_identidad_receptor'];
				$tipo_identificacion = $data__emmisor['tipo_identificacion'];
				$efectivo = $data__emmisor['efectivo'];
				$vuelto = $data__emmisor['vuelto'];


        $sql_notas_autorizadas = mysqli_query($conection,"SELECT COUNT(*) as  nota_venta_autorizada  FROM
        nota_venta_autorizada WHERE nota_venta_autorizada.id_emisor  = '$iduser'");
        $data_autorizadas = mysqli_fetch_array($sql_notas_autorizadas);
        $total_notas_autorizadas = $data_autorizadas['nota_venta_autorizada'];


        $query_parametros_nota_venta = mysqli_query($conection, "SELECT * FROM parametros_notas_venta  WHERE parametros_notas_venta.iduser = $iduser");
        $data_parametros_nota_venta = mysqli_fetch_array($query_parametros_nota_venta);
        $nombre_imprenta = $data_parametros_nota_venta['nombre_imprenta'];
        $nombre_propietario = $data_parametros_nota_venta['nombre_propietario'];
        $ruc_imprenta = $data_parametros_nota_venta['ruc_imprenta'];
        $numero_autorizacion = $data_parametros_nota_venta['numero_autorizacion'];
        $fecha_emision = $data_parametros_nota_venta['fecha_emision'];
        $numero_venta_autorizada = $data_parametros_nota_venta['numero_venta_autorizada'];
        $fecha_limite_validez = $data_parametros_nota_venta['fecha_limite_validez'];




			require('clasepdf.php');

		  $pdf = new TICKET('P','mm',array(76,297));
							$pdf->AddPage();
							$pdf->SetFont('Times', '', 12);
							$pdf->SetAutoPageBreak(true,1);
							$pdf->setXY(2,0);

                                      // Ruta de la imagen
                $rutaImagen = '../../../img/uploads/'.$img_facturacion.'';

                // Verificar si la imagen existe
                if (file_exists($rutaImagen)) {
                 $extension = pathinfo($img_facturacion, PATHINFO_EXTENSION);
                 $anchoImagen = 40; // Ancho de la imagen en milímetros
                 $altoImagen = 40; // Alto de la imagen en milímetros
                          // La imagen existe, agregarla al PDF
                  $pdf->Image($rutaImagen, 20, 10, $anchoImagen, $altoImagen, $extension);

                          // Ajustar la posición para el contenido posterior
                  $pdf->SetY($altoImagen + 20);
                  $pdf->setXY(20,10);
                  } else {
                      // La imagen no existe, puedes manejar este caso como prefieras
                      // Por ejemplo, puedes dejar un espacio en blanco o agregar un texto
                      // $pdf->Cell(0, 10, 'Imagen no disponible', 0, 1, 'C');
                    $altoImagen = 0; // Alto de la imagen en milímetros
                  }


                  // Posición actual después de la imagen
                  $posicionActual = $pdf->GetY();

                  // Agregar la frase "CONTRIBUYENTE NEGOCIO POPULAR" debajo de la imagen
                  $pdf->setXY(2, $posicionActual+$altoImagen);
                  $pdf->SetFont('Times', 'B', 10);
                  $pdf->MultiCell(72, 4, ''.$regimen.'', 0, 'C', 0, 1);


                  // Resto del contenido
                  $get_YD = $pdf->GetY();


                  $pdf->SetFont('Times', 'B', 10);
                  // Asegúrate de que el ancho de MultiCell sea igual al ancho total del área de contenido
                  $anchoTotal = 73; // Ajusta esto según el ancho de tu área de contenido
                  $pdf->setXY(4, $get_YD); // Ajusta la posición X si es necesario
                  $pdf->MultiCell($anchoTotal, 4.2, utf8_decode($nombre_salida), 0, 'C', 0, 1);


                  // Posición actual después de la imagen
                  $posicionActual = $pdf->GetY();



                  $pdf->SetFont('Times', '', 8);
                  $pdf->setXY(2, $get_YD + 3);
                  $alturaLinea = 4.2; // Altura de una línea

                  // Calcular la altura total del texto de la dirección
                  $altoDireccion = $pdf->GetStringWidth($direccion) / 73 * $alturaLinea;
                  if ($altoDireccion < $alturaLinea) {
                      $altoDireccion = $alturaLinea;
                  }

                  // Imprimir la dirección
                  $pdf->MultiCell(73, $alturaLinea, utf8_decode($direccion), 0, 'C', 0, 1);

                  // Ajustar la posición Y para los elementos siguientes
                  $posicionY = $get_YD + 8 + $altoDireccion;

                  // Teléfono
                  $pdf->setXY(2, $posicionY);
                  $pdf->MultiCell(73, 4.2, utf8_decode('Teléfono: ') . $celular . ' ', 0, 'C', 0, 1);
                  $posicionY += 4.2; // Aumentar la posición Y

                  // Ciudad
                  $pdf->setXY(2, $posicionY);
                  $pdf->MultiCell(73, 4.2, ''.$ciudad.' - ECUADOR', 0, 'C', 0, 1);
                  $posicionY += 4.2;

                  // NOTA DE VENTA
                  $pdf->SetFont('Times', '', 14);
                  $pdf->setXY(2, $posicionY);
                  $pdf->MultiCell(73, 4.2, 'NOTA DE VENTA', 0, 'C', 0, 1);
                  $posicionY += 4.2;


                  $pdf->SetFont('Times', '', 9);
                  $pdf->setXY(2, $get_YD + 26);
                  $pdf->MultiCell(73, 4.2, 'SERIE '.$numDocModificado.'', 0, 'C', 0, 1);
                  $pdf->setXY(2, $get_YD + 29);
                  $pdf->MultiCell(73, 4.2, 'RUC: ' . $numero_identidad . ' ', 0, 'C', 0, 1);
                  $pdf->setXY(2, $get_YD + 33);
                  $pdf->MultiCell(73, 4.2, 'AUT. SRI. N:'.$numero_autorizacion.'', 0, 'C', 0, 1);
                  // Establecer la posición en X e Y
                  $pdf->setXY(2, $get_YD + 39);
                  // Cambiar la fuente a negrita
                  $pdf->SetFont('Times', 'B', 8);
                  // MultiCell con alineación a la derecha
                  $pdf->MultiCell(73, 4.2, 'FECHA DE EMISION: ' . $fecha_actual . ' ', 0, 'L', 0, 1);

					    $get_YH = $pdf->GetY();

											$pdf->SetFont('Times', '', 9.2);
											$pdf->Text(0, $get_YH + 2 , '-------------------------------------------------------------------------');
											$pdf->SetFont('Times', 'B', 8.5);
											$pdf->Text(3.8, $get_YH  + 5, 'CLIENTE :'.$nombres_receptor.'');
											$pdf->Text(4, $get_YH + 8, 'DNI/RUC : '.$numero_identidad_receptor.'');
											$pdf->Text(4, $get_YH + 11, 'DIRECCION : '.$direccion_receptor.'');
											$pdf->SetFont('Times', '', 9.2);
											$pdf->Text(0, $get_YH + 14, '---------------------------------------------------------------------------');
											$pdf->SetXY(2,$get_YH + 14);
							        		$pdf->SetFillColor(255,255,255);
							        		$pdf->SetFont('Times','B',8);
							        		$pdf->Cell(13,4,'Cantid',0,0,'L',1);
							        		$pdf->Cell(28,4,''.utf8_decode('Descripción').'',0,0,'L',1);
							        		$pdf->Cell(16,4,'P. UN.',0,0,'L',1);
							        		$pdf->Cell(12,4,'IMP.',0,0,'L',1);
                          $pdf->SetFont('Times', '', 9.2);
							        		$pdf->Text(0, $get_YH + 20, '-------------------------------------------------------------------------------------------');
                          $pdf->SetFont('Times','B',8);
											$pdf->Ln(6);
											$item = 0;
											$query_resultados = mysqli_query($conection,"SELECT * FROM comprobantes
												WHERE id_emisor= '$iduser' AND secuencial = '$codigo_factura_comprobante'");
		                    while ($resultados = mysqli_fetch_array($query_resultados)) {
		                        $item = $item + 1;
		                        $pdf->setX(1.1);
		                        $pdf->Cell(13, 4, $resultados['cantidad_producto'], 0, 0, 'L');

		                        // Calcular el espacio disponible para la descripción
		                        $anchoDescripcion = 28;
		                        $altoCelda = 4;
		                        $xDescripcion = $pdf->GetX();
		                        $yDescripcion = $pdf->GetY();
		                        // Añadir la descripción con MultiCell
		                        $pdf->MultiCell($anchoDescripcion, $altoCelda, $resultados['descripcion_producto'].'-'.$resultados['detalle_extra'], 0, 'L');
		                        // Calcular el nuevo Y después de la descripción
		                        $nuevoY = max($pdf->GetY(), $yDescripcion + $altoCelda);
		                        // Posicionar para los siguientes elementos
		                        $pdf->setXY($xDescripcion + $anchoDescripcion, $yDescripcion);
		                        $pdf->Cell(16, $nuevoY - $yDescripcion, '$' . round($resultados['valor_unidad'], 2), 0, 0, 'L');
		                        $pdf->Cell(8, $nuevoY - $yDescripcion, '$' . round($resultados['iva_producto'], 2), 0, 0, 'L');

		                        // Mover a la siguiente línea
		                        $pdf->Ln($nuevoY - $yDescripcion);
		                        $get_Y = $pdf->GetY();
		                    }


	                    $pdf->SetFont('Times', 'B', 9.2);
											$pdf->Text(0, $get_Y+1, '-----------------------------------------------------------------------------------------------');
											$pdf->SetFont('Times','B',8);
											$pdf->Text(40,$get_Y + 5,'Importe Total:');
                    	$pdf->Text(59,$get_Y + 5,'$');
                      $pdf->Text(63,$get_Y + 5,'10');

                    	$pdf->SetFont('Times', 'B', 9.2);
                    	$pdf->Text(0, $get_Y+8, '-----------------------------------------------------------------------------------------------');
	                    $pdf->SetFont('Times','B',8);

											$pdf->Text(44,$get_Y + 10,'Descuento :');
                      $pdf->Text(59,$get_Y + 10,'$');
											$pdf->Text(63,$get_Y + 10,round($descuento,3));


                      $pdf->Text(44,$get_Y + 13,'Subtotal :');
                      $pdf->Text(59,$get_Y + 13,'$');
                      $pdf->Text(63,$get_Y + 13,round($precio_88_iva,3));


                      $pdf->Text(44,$get_Y + 16,'Iva :');
                      $pdf->Text(59,$get_Y + 16,'$');
                      $pdf->Text(63,$get_Y + 16,round($precio_12_iva,3));

                      $pdf->SetFont('Times', 'B', 9.2);
											$pdf->Text(2, $get_Y+18, '-----------------------------------------------------------------------');

                      $pdf->SetFont('Times','B',8);
                      $pdf->Text(35,$get_Y + 21,'TOTAL A PAGAR :');
                      $pdf->Text(59,$get_Y + 21,'$');
                      $pdf->Text(63,$get_Y + 21,round($precio_total,3));

                      $pdf->SetFont('Times', 'B', 9.2);
                      $pdf->Text(2, $get_Y+23, '-----------------------------------------------------------------------');

                      function numeroALetras($num, $moneda) {
                          $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);
                          $num = round($num, 2); // Redondear a dos decimales
                          $partes = explode('.', (string)$num);
                          $entero = $formatter->format($partes[0]);
                          $decimal = count($partes) > 1 ? $formatter->format($partes[1]) : '00';

                          return strtoupper(utf8_decode($entero)).' '.strtoupper(utf8_decode($moneda));
                      }

                      if ($precio_total > 1 ) {
                          $plural_moneda = ('DÓLARES');
                      } else {
                          $plural_moneda = ('DÓLAR');
                      }


                      $precioEnLetras = numeroALetras($precio_total, $plural_moneda);

                    	$pdf->SetFont('Times','B',8.5);
											$pdf->Text(4,$get_Y + 25,'SON : '.$precioEnLetras.':');
                    	$pdf->Text(4,$get_Y + 28,'FORMA DE PAGO : EFECTIVO :');


                    	$pdf->Text(4,$get_Y + 44,'__________________');
                      $pdf->Text(6,$get_Y + 47,'F. AUTORIZADA');



                    	$pdf->Text(40,$get_Y + 44,'__________________');
                      $pdf->Text(44,$get_Y + 47,'F. CLIENTE');

                      $pdf->Text(2,$get_Y + 53,''.$nombre_imprenta.','.$nombre_propietario.'');
                      $pdf->Text(2,$get_Y + 56,'RUC:'.$ruc_imprenta.',N.A.:'.$numero_autorizacion.'');
                      $pdf->Text(2,$get_Y + 59,'FECHA E.: '.$fecha_actual.',AUT: '.$total_notas_autorizadas.'');
                      $pdf->Text(2,$get_Y + 62,'FECHA V.: '.$fecha_actual.'');


						$pdf->Output('../comprobantes/nota_venta_autorizada/'.$clave_acc_guardar.'.pdf','F');


					date_default_timezone_set("America/Lima");
					$fecha_actual = date('d-m-Y H:m:s', time());
					$codigo_factura = $iduser.md5(date('d-m-Y H:m:s')).$iduser;
					$xml_no_firmado = $codigo_factura.'.xml';

						 $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://'; $domain = $_SERVER['HTTP_HOST']; $url = $protocol . $domain;
						$query_insert=mysqli_query($conection,"INSERT INTO nota_venta_autorizada(codigo_factura,id_emisor,id_receptor,nombres_receptor,
							cedula_receptor,email_receptor,precio_neto,descripcion,direccion_receptor,celular_receptor,clave_acceso,tipo_identificacion,subtotal,iva,total,secuencia,url,IDROLPUNTOVENTA,rol,secuencial_comprobante,cantidad_producto)
						VALUES('$secuencial','$iduser','$id_receptor','$nombres_receptor','$numero_identidad_receptor',
							'$email_receptor','$precio_neto','$descripcion','$direccion_receptor','$celular_receptor','$clave_acc_guardar','$tipo_identificacion','$precio_88_iva','$precio_12_iva','$precio_total','$numDocModificado','$url','$id_generacion','$rol_user','$codigo_factura_comprobante','$productos_totales') ");

						//$query_delete=mysqli_query($conection,"DELETE comprobantes FROM comprobantes WHERE comprobantes.id_emisor = '$iduser' AND secuencial = '$codigo_factura' ");
						try{

						$filep = '../comprobantes/nota_venta_autorizada/'.$clave_acc_guardar.'.pdf';

						// Creamos una nueva instancia
						$mail = new PHPMailer();
						// Activamos el servicio SMTP
						$mail->isSMTP();
				    // Activamos / Desactivamos el "debug" de SMTP (Lo activo para ver en el HTML el resultado)
				    // 0 = Apagado, 1 = Mensaje de Cliente, 2 = Mensaje de Cliente y Servidor
				    $mail->SMTPDebug = 0;
				    // Log del debug SMTP en formato HTML
				    $mail->Debugoutput = 'html';
						// Servidor SMTP (para este ejemplo utilizamos gmail)
				    $mail->Host = $host_envio;
				    // Puerto SMTP
				    $mail->Port = $puerto_email_envio ;
				    // Tipo de encriptacion SSL ya no se utiliza se recomienda TSL
				    $mail->SMTPSecure = 'ssl';
				    // Si necesitamos autentificarnos
				    $mail->SMTPAuth = true;
				    // Usuario del correo desde el cual queremos enviar, para Gmail recordar usar el usuario completo (usuario@gmail.com)
				    $mail->Username = $email_user_name_envio;
				    // Contraseña
				    $mail->Password = $password_envio_email;

						$mail -> setFrom ( $email_user_name_envio , 'Sistema de Facturación' );
				    $mail->addAddress('factura@facturacion.guibis.com');
						$mail->addAddress($email_receptor);
						$mail->addAddress($correo);

            $query_lista = mysqli_query($conection, "SELECT *  FROM lista_correos_envios_email
               WHERE lista_correos_envios_email.iduser ='$iduser'  AND lista_correos_envios_email.estatus = '1'
            ORDER BY `lista_correos_envios_email`.`fecha` DESC ");
             $result_lista= mysqli_num_rows($query_lista);
            if ($result_lista > 0) {
                  while ($data_lista=mysqli_fetch_array($query_lista)) {
                    $mail->addAddress($data_lista['correo']);
                  }
              }

              //CODIGO PARA SACAR LOS EMAIL DEL CLIENTE
              $query__correos_email = mysqli_query($conection, "SELECT *  FROM lista_correos_envios_email_cliente
                 WHERE lista_correos_envios_email_cliente.iduser ='$iduser'  AND lista_correos_envios_email_cliente.estatus = '1' AND lista_correos_envios_email_cliente.cliente = '$id_receptor'
              ORDER BY `lista_correos_envios_email_cliente`.`fecha` DESC ");
               $result__email= mysqli_num_rows($query__correos_email);
              if ($result__email > 0) {
                    while ($data_email=mysqli_fetch_array($query__correos_email)) {
                      $mail->addAddress($data_email['correo']);
                    }
                  }



						$mail->AddAttachment($filep, ''.$clave_acc_guardar.'.pdf');
						$mail->CharSet = 'UTF-8';
						$mail->Subject = 'Tiket de Venta de '.$nombre_salida.'';
						//Creamos el mensaje
						$message =
				 '
				 <body>


		 			<div class="conte_general" style="text-align: center;background: #f5f5f5;border-radius: 10px;">
		 				<div class="contenedor_image">
		 					<img src="'.$url_img_upload.'/home/img/uploads/'.$img_logo.'" width="150px;" alt="">
		 				</div>
		 				<div class="redes_email" style="text-align: center;">
		 				'.$facebook.'
		 				'.$instagram.'
		 				'.$whatsapp.'

		 		</div>
		 		<div style="margin: 0; padding: 0;">
		 				<p style="margin: 5px 0;">'.$direccion.'</p>
		 		</div>
		 		<div style="margin: 0; padding: 0;">
		 			<strong><p style="margin: 5px 0;">'.$celular.' '.$telefono.'</p></strong>

		 		</div>

		 				<div class="contenedor_informacion_factura">
		 					<table style="margin: 0 auto;width: 80%;">
		 						<tr>
		 							<td></td>
		 							<td><hr></td>
		 						</tr>
		 						<tr>
		 							<td> <strong>DESTINATARIO:</strong> </td>
		 							<td>
		 								<div style="margin: 0; padding: 0;">
		 							<strong style="display: block; margin: 5px 0;background: #d8d6d5;">'.$nombres_receptor.'</strong>
		 								</div>
		 							<div style="margin: 0; padding: 0;">
		 									<p style="margin: 5px 0;font-size: 12px;">Has recibido una Nota de Venta Autorizada de:</p>
		 							</div>
		 							</td>
		 						</tr>
		 						<tr>
		 							<td> <strong>EMISOR</strong> </td>
		 							<td style="background: #d8d6d5;"> <strong>'.$nombre_salida.'</strong> </td>
		 						</tr>
		 						<tr>
		 							<td>  </td>
		 							<td> <hr>  </td>
		 						</tr>
		 						<tr>
		 							<td> <strong>FACTURA:</strong> </td>
		 							<td> '.$numDocModificado.' </td>
		 						</tr>
		 						<tr>
		 							<td> <strong>FECHA EMISION:</strong> </td>
		 							<td>'.$fecha_actual.'</td>
		 						</tr>

		 						<tr>
		 							<td> <strong>VALOR:</strong> </td>
		 							<td>Por el Valor de</td>
		 						</tr>
		 						<tr>
		 							<td></td>
		 							<td style="font-size: 25px;background: #d8d6d5;"> <strong>$'.$precio_total.'</strong> </td>
		 						</tr>
		 						<tr>
		 							<td>  </td>
		 							<td> <hr>  </td>
		 						</tr>
		 						<tr>
		 							<td> </td>
		 							<td style="font-size: 10px;">'.$descripcion_envio_email.'</td>
		 						</tr>
		 						<tr>
		 							<td> </td>
		 							<td style="font-size: 10px;">Descarga tus documentos electrónicos en el siguiente  <a href="https://guibis.com/mis_facturas">Enlace</a> </td>
		 						</tr>
		 					</table>
		 				</div>
		 			</div>
		 		</body>

								';
						//Agregamos el mensaje al correo
						$mail->msgHTML($message);
						// Enviamos el Mensaje
						if (!$mail->send()) {

						} else {

						 }
						}catch(Exception $e){}

					 $arrayName = array('noticia' =>'insert_correct','clave_acc_guardar'=>$clave_acc_guardar);
							echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);





?>
