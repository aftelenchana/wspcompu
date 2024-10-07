
<?php

include 'digito_verificador.php';
class xml{
 public function xmlFactura($clave_acceso_factura,$direccion_partida,$razon_social_transportista,$tipoIdentificacionTransportista,$fecha_inicio_transporte,$fecha_final_transporte,$placa_transportista,$ruc_transportista,$direccion_llegada,$motivo_traslado){
  include "../../../../coneccion.php";
  //INFORMACION DE LA CONFIGURACION
  $query_configuracioin = mysqli_query($conection, "SELECT * FROM configuraciones ");
  $result_configuracion = mysqli_fetch_array($query_configuracioin);
  $ambito_area          =  $result_configuracion['ambito'];

    $iduser= $_SESSION['id'];
   $query_doccumentos =  mysqli_query($conection, "SELECT * FROM  usuarios  WHERE  id  = '$iduser'");
   $result_documentos = mysqli_fetch_array($query_doccumentos);
   $documentos_electronicos = $result_documentos['documentos_electronicos'];
   $nombre_empresa          = $result_documentos['nombre_empresa'];
   $email_emisor            = $result_documentos['email'];
   $estableciminento_f      = $result_documentos['estableciminento_f'];
   $contabilidad            = $result_documentos['contabilidad'];
   $punto_emision_f         = $result_documentos['punto_emision_f'];
   $numero_identidad_emisor = $result_documentos['numero_identidad'];
   $direccion_emisorfg      = $result_documentos['direccion'];
   $img_logo                = $result_documentos['img_facturacion'];
   $nombre_empresa          = $result_documentos['nombre_empresa'];
   $img_logo                = $result_documentos['img_facturacion'];

   $estableciminento_f   = str_pad($estableciminento_f, 3, "0", STR_PAD_LEFT);
   $punto_emision_f      = str_pad($punto_emision_f, 3, "0", STR_PAD_LEFT);
   $porcentaje_iva_f     = ($result_documentos['porcentaje_iva_f'])/100;

   $query_secuencial = mysqli_query($conection, "SELECT * FROM  comprobante_factura_final  WHERE  comprobante_factura_final.id_emisor  = $iduser ORDER BY fecha DESC LIMIT 1");
   $result_secuencial = mysqli_fetch_array($query_secuencial);

   if ($result_secuencial) {
     $secuencial = $result_secuencial['codigo_factura'];
     $secuencial = $secuencial +1;
     // code...
   }else {
     $secuencial =1;
   }
   $numeroConCeros = str_pad($secuencial, 9, "0", STR_PAD_LEFT);
   $secuencial_neto = $numeroConCeros;

   //de qui empezamos a sacar la informacion
   if ($ambito_area == 'prueba') {
     $ruta_factura = 'C:\\xampp\\htdocs\\home\\facturacion\\facturacionphp\\comprobantes\\no_firmados\\'.$clave_acceso_factura.'.xml';

   }else {
     $ruta_factura = '../comprobantes/no_firmados/'.$clave_acceso_factura.'.xml';
   }
   $acceso_factura = simplexml_load_file($ruta_factura);
    $codDocModificado                = $acceso_factura->infoTributaria->codDoc;

    //para crear el numero dl documento necesito de 4 partes
     $estab                       = $acceso_factura->infoTributaria->estab;
     $ptoEmi                      = $acceso_factura->infoTributaria->ptoEmi;
     $secuencial                  = $acceso_factura->infoTributaria->secuencial;
   $numDocModificado                = ''.$estab.'-'.$ptoEmi.'-'.$secuencial.'';
   $xml = new DOMDocument('1.0', 'utf-8');
   $xml->formatOutput = true;
   $xml_fac = $xml->createElement('guiaRemision');
   $cabecera = $xml->createAttribute('id');
   $cabecera->value = 'comprobante';
   $cabecerav = $xml->createAttribute('version');
   $cabecerav->value = '1.1.0';
   //INFORMACION TRIBUTARIA
   $xml_inf = $xml->createElement('infoTributaria');
   $xml_amb = $xml->createElement('ambiente','2');
   $xml_tip = $xml->createElement('tipoEmision','1');
   $xml_raz = $xml->createElement('razonSocial',$nombre_empresa);
   $xml_nom = $xml->createElement('nombreComercial',$nombre_empresa);
   $xml_ruc = $xml->createElement('ruc',$numero_identidad_emisor);
   $fecha_actual = date("d-m-Y");
   $fechasf =  str_replace("-","",date("d-m-Y",strtotime($fecha_actual." -0 hours")));
   $dig = new modulo();
		$clave_acceso= $fechasf.'06'.$numero_identidad_emisor.'2'.$estableciminento_f.$punto_emision_f.$secuencial_neto.'123456781';
   $clave_acceso =  str_replace(" ","",$clave_acceso);
   $xml_cla = $xml->createElement('claveAcceso',$clave_acceso.$dig->getMod11Dv($clave_acceso));
   $xml_doc = $xml->createElement('codDoc','06');
   $xml_est = $xml->createElement('estab', $estableciminento_f);
   $xml_emi = $xml->createElement('ptoEmi', $punto_emision_f);
   $xml_sec = $xml->createElement('secuencial',$secuencial_neto);
   $xml_dir = $xml->createElement('dirMatriz',$direccion_emisorfg);
   //INFORMACION DE LA RETENCION

   $xml_gre = $xml->createElement('infoGuiaRemision');
   $xml_det = $xml->createElement('dirEstablecimiento',$direccion_emisorfg);
   $xml_dpa = $xml->createElement('dirPartida',$direccion_partida);
   $xml_rst = $xml->createElement('razonSocialTransportista',$razon_social_transportista);
   $xml_tit = $xml->createElement('tipoIdentificacionTransportista',$tipoIdentificacionTransportista);
   $xml_ruc_transportista = $xml->createElement('rucTransportista',$ruc_transportista);
   $xml_fit = $xml->createElement('fechaIniTransporte',$fecha_inicio_transporte);
   $xml_fft = $xml->createElement('fechaFinTransporte',$fecha_final_transporte);
   $xml_pca = $xml->createElement('placa',$placa_transportista);


   //informacion del comprador
     $identificacion_comprador             = $acceso_factura->infoFactura->identificacionComprador;
     $tipo_identificacion_comprador         = $acceso_factura->infoFactura->tipoIdentificacionComprador;
     $razon_social_comprador                = $acceso_factura->infoFactura->razonSocialComprador;
     $obligadoContabilidad                = $acceso_factura->infoFactura->obligadoContabilidad;
     $fechaEmision                = $acceso_factura->infoFactura->fechaEmision;
     $totalSinImpuestos_general                = $acceso_factura->infoFactura->totalSinImpuestos;
     $totalDescuento_general                = $acceso_factura->infoFactura->totalDescuento;

   $xml_dts = $xml->createElement('destinatarios');
   $xml_dto = $xml->createElement('destinatario');
   $xml_idt = $xml->createElement('identificacionDestinatario',$identificacion_comprador);
   $xml_rdi = $xml->createElement('razonSocialDestinatario',$razon_social_comprador);
   $xml_ddi = $xml->createElement('dirDestinatario',$direccion_llegada);
   $xml_mtr = $xml->createElement('motivoTraslado',$motivo_traslado);
   $xml_rut = $xml->createElement('ruta','AMBATO');
   $xml_cos = $xml->createElement('codDocSustento','01');
   $xml_nsu = $xml->createElement('numDocSustento',$numDocModificado);
   $xml_mau = $xml->createElement('numAutDocSustento',$clave_acceso_factura);
   $xml_fes = $xml->createElement('fechaEmisionDocSustento',$fechaEmision);

 $xml_dlls = $xml->createElement('detalles');

   $conte_variable_detalles= $acceso_factura->detalles->detalle;
   //var_dump($acceso_factura->detalles);



   $uig = 0;
   $base_if = 1;
   foreach($conte_variable_detalles as $Item){
        //var_dump($acceso_factura->detalles->detalle[$uig]);
       $conte_variable_detalles= $acceso_factura->detalles->detalle[$uig]->descripcion;
       $codigoPrincipal= $acceso_factura->detalles->detalle[$uig]->codigoPrincipal;
       $cantidad= $acceso_factura->detalles->detalle[$uig]->cantidad;
       $uig =$uig +1;
       $xml_dlle[$base_if] = $xml->createElement('detalle');
       $xml_cin[$base_if] = $xml->createElement('codigoInterno',$codigoPrincipal);
       $xml_dco[$base_if] = $xml->createElement('descripcion',$conte_variable_detalles);
       $xml_cans[$base_if] = $xml->createElement('cantidad',$cantidad);
       $base_if =$base_if+1;
     }


   $xml_iad = $xml->createElement('infoAdicional');
   $xml_cad = $xml->createElement('campoAdicional','0999999999');
   $atributo3 = $xml->createAttribute('nombre');
   $atributo3->value = 'TELEFONO';

   $xml_inf->appendChild($xml_amb);
   $xml_inf->appendChild($xml_tip);
   $xml_inf->appendChild($xml_raz);
   $xml_inf->appendChild($xml_nom);
   $xml_inf->appendChild($xml_ruc);
   $xml_inf->appendChild($xml_cla);
   $xml_inf->appendChild($xml_doc);
   $xml_inf->appendChild($xml_est);
   $xml_inf->appendChild($xml_emi);
   $xml_inf->appendChild($xml_sec);
   $xml_inf->appendChild($xml_dir);
   $xml_fac->appendChild($xml_inf);//CERRAR LA CAJA DE INFOMACION

   $xml_fac->appendChild($xml_gre);
   $xml_gre->appendChild($xml_det);
   $xml_gre->appendChild($xml_dpa);
   $xml_gre->appendChild($xml_rst);
   $xml_gre->appendChild($xml_tit);
   $xml_gre->appendChild($xml_ruc_transportista);
   $xml_gre->appendChild($xml_rut);
   $xml_gre->appendChild($xml_fit);
   $xml_gre->appendChild($xml_fft);
   $xml_gre->appendChild($xml_pca);
   $xml_dts->appendChild($xml_dto);
   $xml_dto->appendChild($xml_idt);
   $xml_dto->appendChild($xml_rdi);
   $xml_dto->appendChild($xml_ddi);
   $xml_dto->appendChild($xml_mtr);
   $xml_dto->appendChild($xml_rut);
   $xml_dto->appendChild($xml_cos);
   $xml_dto->appendChild($xml_nsu);
   $xml_dto->appendChild($xml_mau);
   $xml_dto->appendChild($xml_fes);
   $xml_dto->appendChild($xml_dlls);

 $uig_kd = 1;
    $conte_variable_detalles= $acceso_factura->detalles->detalle;
   foreach($conte_variable_detalles as $Item){
       $xml_dlls->appendChild($xml_dlle[$uig_kd]);
       $xml_dlle[$uig_kd]->appendChild($xml_cin[$uig_kd]);
       $xml_dlle[$uig_kd]->appendChild($xml_dco[$uig_kd]);
       $xml_dlle[$uig_kd]->appendChild($xml_cans[$uig_kd]);
   $uig_kd =$uig_kd +1;

     }





   $xml_fac->appendChild($xml_dts);



   $xml_fac->appendChild($xml_iad);
   $xml_iad->appendChild($xml_cad);
   $xml_cad->appendChild($atributo3);

   $xml_fac->appendChild($cabecera);
   $xml_fac->appendChild($cabecerav);
   $xml->appendChild($xml_fac);


   	 $xml->save('../comprobantes/guia-remision/no_firmados/guiaremision'.$iduser.'.xml');

 }
}

?>
