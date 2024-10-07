<?php
//require_once 'ruth_esmeralda_sanchez_herrera.p12';
//if (isset($_POST['submit'])) {
class autorizar_parqueo {
	public function autorizar_generar_pdf($codigo_entrada ) {
		include "../../../../coneccion.php";
		include '../lib/PHPMailer/PHPMailerAutoload.php';

		//CODIGO PARA DISMINUIR LA CANTIDAD DE LOS PRODUCTOS EXISTENTES
 $iduser= $_SESSION['id'];
	 $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
	 $result_documentos = mysqli_fetch_array($query_doccumentos);
	 $documentos_electronicos = $result_documentos['documentos_electronicos'];
	 $nombre_empresa          = $result_documentos['nombre_empresa'];
	 $email_emisor            = $result_documentos['email'];
	 $estableciminento_f      = $result_documentos['estableciminento_f'];
	 $img_facturacion       = $result_documentos['img_facturacion'];
	 $contabilidad            = $result_documentos['contabilidad'];
	 $direccion               = $result_documentos['direccion'];
	 $punto_emision_f         = $result_documentos['punto_emision_f'];
	 $numero_identidad_emisor = $result_documentos['numero_identidad'];
	 $direccion_emisor        = $result_documentos['direccion'];
	 $celular                 = $result_documentos['celular'];
	 $estableciminento_f   = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
	 $punto_emision_f      = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);


	 $query_verificador_secuencial = mysqli_query($conection, "SELECT ingreso_vehiculo_lavanderia.qr_imagen,ingreso_vehiculo_lavanderia.id,ingreso_vehiculo_lavanderia.fecha_inicio,
		 ingreso_vehiculo_lavanderia.secuencial,ingreso_vehiculo_lavanderia.nombre_usuario,ingreso_vehiculo_lavanderia.placa,tarifas_parqueo_lavado_autos.valor_servicio,ingreso_vehiculo_lavanderia.fecha_final,ingreso_vehiculo_lavanderia.precio_cobrado,
tipo_vehiculo.tipo_vehiculo,tarifas_parqueo_lavado_autos.nombre_servicio,tarifas_parqueo_lavado_autos.minutos_servicio,tarifas_parqueo_lavado_autos.timpo_espera,tarifas_parqueo_lavado_autos.precio_sobrecargo
		  FROM ingreso_vehiculo_lavanderia
         INNER JOIN tarifas_parqueo_lavado_autos ON tarifas_parqueo_lavado_autos.id = ingreso_vehiculo_lavanderia.idtarifa
         INNER JOIN tipo_vehiculo ON tipo_vehiculo.id = ingreso_vehiculo_lavanderia.idvehiculo
         WHERE  ingreso_vehiculo_lavanderia.iduser  = '$iduser' AND ingreso_vehiculo_lavanderia.id='$codigo_entrada'  ORDER BY id DESC LIMIT 1");
	 $result_verificador_secuencial = mysqli_fetch_array($query_verificador_secuencial);
   $secuencial = $result_verificador_secuencial['secuencial'];
	 $qr_imagen = $result_verificador_secuencial['qr_imagen'];
	 $fecha_inicio = $result_verificador_secuencial['fecha_inicio'];
	 $nombre_usuario = $result_verificador_secuencial['nombre_usuario'];
	 $placa = $result_verificador_secuencial['placa'];
	 $valor_servicio = $result_verificador_secuencial['valor_servicio'];

	 //INFORMACION DEL TIPO DE VEHICULO
	  $tipo_vehiculo = $result_verificador_secuencial['tipo_vehiculo'];

		//INFORMACION DEL TIPO DE TARIFA QUE SE ESTA CONTRATANDO
 $nombre_servicio = $result_verificador_secuencial['nombre_servicio'];
 $minutos_servicio = $result_verificador_secuencial['minutos_servicio'];
 $timpo_espera = $result_verificador_secuencial['timpo_espera'];
 $precio_sobrecargo = $result_verificador_secuencial['precio_sobrecargo'];


 $fecha_final = $result_verificador_secuencial['fecha_final'];
 $precio_cobrado = $result_verificador_secuencial['precio_cobrado'];



   $secuencial           = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
	 $fecha_actual = date("d-m-Y");
	 $fechasf =  str_replace("-","",date("d-m-Y",strtotime($fecha_actual." -0 hours")));

	 $clave_acc_guardar = $fechasf.$punto_emision_f.$estableciminento_f.$numero_identidad_emisor.$secuencial.'55';

			require('clasepdf.php');
					$pdf = new TICKET('P','mm',array(76,130));
					$pdf->AddPage();
					$pdf->SetFont('Arial', '', 12);
					$pdf->SetAutoPageBreak(true,1);
					$pdf->setXY(2,1.5);

					$pdf->MultiCell(73, 4.2, ''.utf8_decode($nombre_empresa).'', 0,'C',0 ,1);
					$pdf->setXY(2,10);
					$pdf->SetFont('Arial', '', 6.9);
					$pdf->MultiCell(73, 4.2, utf8_decode(''.$direccion.''), 0,'C',0 ,1);
					$get_YD = $pdf->GetY();
					$pdf->setXY(2,6);
					$pdf->SetFont('Arial', '', 8);
					$pdf->MultiCell(73, 4.2, ''.utf8_decode($nombre_empresa).'', 0,'C',0 ,1);
					$pdf->setXY(2,$get_YD);
					$pdf->MultiCell(73, 4.2, 'RUC : '.$numero_identidad_emisor.'', 0,'C',0 ,1);

					/*INGRESAR EN ESTA LINEA EL TELEFONO DEL TICKET*/

					$pdf->setXY(2,$get_YD + 4);
					$pdf->MultiCell(73, 4.2, 'Telefono :'.$celular.' ', 0,'C',0 ,1);
					$pdf->setXY(2,$get_YD + 8);
					$pdf->MultiCell(73, 4.2, 'Serie : '.$punto_emision_f.'-'.$estableciminento_f.'-'.$secuencial.'', 0,'C',0 ,1);
         	$get_YH = $pdf->GetY();
					$pdf->SetFont('Arial', '', 9.2);
					$pdf->Text(2, $get_YH + 2 , '------------------------------------------------------------------');
					$pdf->SetFont('Arial', 'B', 8.5);
					$pdf->Text(3.8, $get_YH  + 5, 'Codigo : '.$secuencial.'');
					$pdf->Text(4, $get_YH + 10, 'Fecha : '.$fecha_inicio.'');
					$pdf->Text(4, $get_YH + 15, 'Nombre : '.$nombre_usuario.'');
					$pdf->Text(4, $get_YH + 20, 'Placa :'.$placa.' ');
					$pdf->Text(35, $get_YH  + 20, 'Precio:'.$minutos_servicio.'Min/$'.$valor_servicio.' Dolares');
					$pdf->Text(4, $get_YH + 25, 'Tipo de Vehiculo :'.$tipo_vehiculo.' ');
					$pdf->Text(4, $get_YH + 30, 'Servicio :'.$nombre_servicio.' ');
					$pdf->Text(4, $get_YH + 35, 'Tiempo Espera Maximo :'.$timpo_espera.' minutos ');
          $pdf->Text(4, $get_YH + 40, 'Fecha Salida :'.$fecha_final.' ');
          $pdf->Text(4, $get_YH + 45, 'Total: $'.$precio_cobrado.' Dolares ');

					$pdf->Text(4, $get_YH + 50, ''.$clave_acc_guardar.'');

					$pdf->SetFont('Arial', '', 9.2);
					$pdf->Text(2, $get_YH + 52, '------------------------------------------------------------------');
					$pdf->SetXY(2,$get_YH + 52);
					$pdf->Image('../../../img/qr/'.$qr_imagen.'' , 25 ,80, 30 , 30);

				  $pdf->Output('../comprobantes/parqueo/salida/'.$clave_acc_guardar.'.pdf','F');

				  $query_update=mysqli_query($conection,"UPDATE ingreso_vehiculo_lavanderia SET clave_acc_guardar='$clave_acc_guardar'  WHERE id='$codigo_entrada' ");
					if ($query_update) {
						$arrayName = array('noticia' =>'insert_correct','pdf'=>$clave_acc_guardar);
							echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

					}else {
						$arrayName = array('noticia' =>'error_insertar');
							echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
					}




	}
}

?>
