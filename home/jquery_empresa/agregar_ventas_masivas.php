<?php

include "../../coneccion.php";
session_start();

mysqli_set_charset($conection, 'utf8'); //linea a colocar

$iduser= $_SESSION['id'];
$query = mysqli_query($conection, "SELECT * FROM usuarios WHERE usuarios.id = $iduser");
$result = mysqli_fetch_array($query);
$email_usuario = $result['email'];
$nombres_usuario = $result['nombres'];
$apellidos_usuario = $result['apellidos'];
$nombre_empresa = $result['nombre_empresa'];

$query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
$result_configuracion = mysqli_fetch_array($query_configuracioin);
$ambito_area          =  $result_configuracion['ambito'];

$query_delete=mysqli_query($conection,"DELETE xml_subidos_ventas FROM xml_subidos_ventas WHERE xml_subidos_ventas.iduser = '$iduser' ");


$cont = 0;
// ciclo para recorrer el array de imagenes
  foreach ($_FILES["lista"]["name"] as $key => $value) {
    $ext = explode('.', $_FILES["lista"]["name"][$key]);
    $renombrar = $cont.md5(date('d-m-Y H:m:s').$iduser.$cont);
    $renombrar_guardar_autorizado = $cont.md5(date('d-m-Y H:m:s').$iduser.$cont.'05072023');
    $nombre_final = $renombrar.".".$ext[1];
    $nombre_final_autorizado = $renombrar_guardar_autorizado.".".$ext[1];
    $query_insert=mysqli_query($conection,"INSERT INTO xml_subidos_ventas (iduser,nombre,nombre_final_autorizado)
                                  VALUES('$iduser','$nombre_final','$nombre_final_autorizado') ");
    //Se copian los archivos de la carpeta temporal del servidor a su ubicación final
    move_uploaded_file($_FILES["lista"]["tmp_name"][$key], "../archivos/xml_autorizados/".$nombre_final);
    $cont++;
    $archivoOriginal = '../archivos/xml_autorizados/'.$nombre_final.'';
    $archivoCopia = '../archivos/xml_autorizados/'.$nombre_final_autorizado.''; // Ruta y nuevo nombre para la copia
      if (copy($archivoOriginal, $archivoCopia)) {
      } else {

      }
  }



  if ($query_insert) {

    $query_ventas_masivas = mysqli_query($conection, "SELECT * FROM xml_subidos_ventas WHERE xml_subidos_ventas.iduser = $iduser");
    while ($data_ventas_masivas =mysqli_fetch_array($query_ventas_masivas)) {
      $nombre_archivo = $data_ventas_masivas['nombre'];
      $nombre_final_autorizado_2 = $data_ventas_masivas['nombre_final_autorizado'];


      if ($ambito_area == 'prueba') {
        $ruta_compra = 'C:\\xampp\\htdocs\\home\\archivos\\xml_autorizados\\'.$nombre_archivo.'';
      }else {
        $ruta_compra = '../archivos/xml_autorizados/'.$nombre_archivo.'';
      }



      //CODIGO PARA SABER QUE DOCUMENTO ES
       $acceso_factura = simplexml_load_file($ruta_compra);

       $claveAcceso                       = (string)$acceso_factura->numeroAutorizacion[0];

       $cadena = $claveAcceso;
      $posicion_inicio = 8;
      $longitud = 2;
      $subcadena = substr($cadena, $posicion_inicio, $longitud);
      if ($subcadena == '01') {
      }
      if ($subcadena == '03') {
        $arrayName = array('noticia' =>'no_factura','mensaje'=>'LIQUIDACIÓN DE COMPRA DE BIENES Y PRESTACIÓN DE SERVICIOS');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          unlink($ruta_compra);
          exit;
      }

      if ($subcadena == '04') {
        $arrayName = array('noticia' =>'no_factura','mensaje'=>'NOTA DE CRÉDITO ');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          unlink($ruta_compra);
          exit;
      }
      if ($subcadena == '05') {
        $arrayName = array('noticia' =>'no_factura','mensaje'=>'NOTA DE DÉBITO');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          unlink($ruta_compra);
          exit;
      }
      if ($subcadena == '06') {
        $arrayName = array('noticia' =>'no_factura','mensaje'=>'GUÍA DE REMISIÓN');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          unlink($ruta_compra);
          exit;
      }

      if ($subcadena == '07') {
        $arrayName = array('noticia' =>'no_factura','mensaje'=>'COMPROBANTE DE RETENCIÓN');
          echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
          unlink($ruta_compra);
          exit;
      }


      //CODIGO PARA VER SI ES AUTORIZADA O NO
      $rutaArchivo = '../archivos/xml_autorizados/'.$nombre_archivo;

      // Leer el contenido del archivo
      $xml = file_get_contents($rutaArchivo);

      // Definir la expresión regular para eliminar el fragmento específico
      $patron = '/<autorizacion>.*?version="2.1.0">/s';

      // Eliminar el fragmento del XML
      $xmlNuevo = preg_replace($patron, '', $xml);

      // Guardar el contenido actualizado en el archivo
      file_put_contents($rutaArchivo, $xmlNuevo);






     $filename = '../archivos/xml_autorizados/'.$nombre_archivo;

      $xml = file_get_contents($filename );
      $nuevo_xml = substr($xml, 0, strpos($xml, '</infoAdicional>') + strlen('</infoAdicional>'));
      file_put_contents('../archivos/xml_autorizados/'.$nombre_archivo.'', $nuevo_xml);
      $xml = file_get_contents($filename);
      $nuevo_contenido = $xml . '</factura>';
      file_put_contents('../archivos/xml_autorizados/'.$nombre_archivo.'', $nuevo_contenido);


      // Ruta del archivo XML

// Leer el contenido del archivo
$xml = file_get_contents($rutaArchivo);

// Definir la etiqueta a insertar
$etiquetaNueva = '<factura id="comprobante" version="1.0.0">';

// Encontrar la posición de la etiqueta <infoTributaria>
$posicion = strpos($xml, '<infoTributaria>');

// Insertar la etiqueta nueva antes de la etiqueta <infoTributaria>
$xmlNuevo = substr_replace($xml, $etiquetaNueva . "\n\t", $posicion, 0);

// Guardar el contenido actualizado en el archivo
file_put_contents($rutaArchivo, $xmlNuevo);

      if ($ambito_area == 'prueba') {
        $ruta_compra = 'C:\\xampp\\htdocs\\home\\archivos\\xml_autorizados\\'.$nombre_archivo.'';
      }else {
        $ruta_compra = '../archivos/xml_autorizados/'.$nombre_archivo.'';
      }

       $acceso_factura = simplexml_load_file($ruta_compra);

       $claveAcceso                       = $acceso_factura->infoTributaria->claveAcceso;
       $ruc_emisor                       = $acceso_factura->infoTributaria->ruc;
       $razon_social_emisor             = $acceso_factura->infoTributaria->razonSocial;

       $importeTotal                       = $acceso_factura->infoFactura->importeTotal;
       //INFORMACION DEL RECEPTOR DE LA FACTURA
           $identificacion_receptor           = (string)$acceso_factura->infoFactura->identificacionComprador;
           $tipo_identificacion_receptor      = (string)$acceso_factura->infoFactura->tipoIdentificacionComprador;
           $razon_socialreceptorr             = (string)$acceso_factura->infoFactura->razonSocialComprador;

           $totalSinImpuestos      = (string)$acceso_factura->infoFactura->totalSinImpuestos;
           $totalDescuento             = (string)$acceso_factura->infoFactura->totalDescuento;

           $fechaEmision                      = (string)$acceso_factura->infoFactura->fechaEmision;
           $razonSocialreceptor               = (string)$acceso_factura->infoFactura->razonSocialComprador;
           $identificacionreceptor            = (string)$acceso_factura->infoFactura->identificacionComprador;

      $query_insert=mysqli_query($conection,"INSERT INTO ventas_externas_generadas (iduser,claveAcceso,razon_social,importeTotal,identificacion_receptor,razon_socialreceptorr,fechaEmision,razonSocialreceptor,totalSinImpuestos,totalDescuento,xml_limpio,nombre_final_autorizado)
                                    VALUES('$iduser','$claveAcceso','$razon_social_emisor','$importeTotal','$identificacion_receptor','$razon_socialreceptorr','$fechaEmision','$razonSocialreceptor','$totalSinImpuestos','$totalDescuento','$nombre_archivo','$nombre_final_autorizado_2') ");

                                    $base_tdll = 0;
                                		$base_array_detalle = 1;
                                    $contador_detalles = $acceso_factura->detalles->detalle;
                                		foreach($contador_detalles as $Item){
                                			$descripcion_producto= $acceso_factura->detalles->detalle[$base_tdll]->descripcion;
                                			$codigoPrincipal= $acceso_factura->detalles->detalle[$base_tdll]->codigoPrincipal;
                                			$cantidad= $acceso_factura->detalles->detalle[$base_tdll]->cantidad;
                                			$precioUnitario= $acceso_factura->detalles->detalle[$base_tdll]->precioUnitario;
                                			$descuento= $acceso_factura->detalles->detalle[$base_tdll]->descuento;
                                			$precioTotalSinImpuesto= $acceso_factura->detalles->detalle[$base_tdll]->precioTotalSinImpuesto;
                                		 	 $impuestos= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto;
                                			//CODIGO PARA DETALLES
                                			$codigo= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->codigo;
                                      $codigoPorcentaje= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->codigoPorcentaje;
                                			$tarifa= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->tarifa;
                                			$baseImponible= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->baseImponible;
                                			$valor= $acceso_factura->detalles->detalle[$base_tdll]->impuestos->impuesto->valor;
                                			 $base_tdll =$base_tdll +1;
                                			 //echo "contador de la parte de arriba $base_array_detalle";
                                			//echo "$codigoPrincipal";
                                			//echo "cantidad $cantidad";
                                      $query_subir_producto =mysqli_query($conection,"INSERT INTO productos_subida_ventas_xml (iduser,claveAcceso,descripcion_producto,codigoPrincipal,cantidad,precioUnitario,descuento,precioTotalSinImpuesto,impuestos,codigo,codigoPorcentaje,tarifa,baseImponible,valor)
                                                                    VALUES('$iduser','$claveAcceso','$descripcion_producto','$codigoPrincipal','$cantidad','$precioUnitario','$descuento','$precioTotalSinImpuesto','$impuestos','$codigo','$codigoPorcentaje','$tarifa','$baseImponible','$valor') ");

                                			}

    }
    //$query_delete=mysqli_query($conection,"DELETE xml_subidos_ventas FROM xml_subidos_ventas WHERE xml_subidos_ventas.iduser = '$iduser' ");
    $arrayName = array('noticia' =>'ventas_agregadas_correctamente','contar_facturas'=>$cont);
        echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);

     }else {
       $arrayName = array('noticia' =>'error');
           echo json_encode($arrayName,JSON_UNESCAPED_UNICODE);
     }


 ?>
