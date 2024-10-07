<?php
include 'digito_verificador.php';
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
$xml_raz = $xml->createElement('razonSocial','GUIBIS');
$xml_nom = $xml->createElement('nombreComercial','GUIBIS');
$xml_ruc = $xml->createElement('ruc','1804843900001');
$dig = new modulo();
$clave_acceso= '10012023018048439001200100100000001123456781';
$clave_acceso =  str_replace(" ","",$clave_acceso);
$xml_cla = $xml->createElement('claveAcceso',$clave_acceso.$dig->getMod11Dv($clave_acceso));
$xml_doc = $xml->createElement('codDoc','06');
$xml_est = $xml->createElement('estab', '001');
$xml_emi = $xml->createElement('ptoEmi', '001');
$xml_sec = $xml->createElement('secuencial','00000001');
$xml_dir = $xml->createElement('dirMatriz','AMBATO');
//INFORMACION DE LA RETENCION

$xml_gre = $xml->createElement('infoGuiaRemision');
$xml_det = $xml->createElement('dirEstablecimiento','AMBATO');
$xml_dpa = $xml->createElement('dirPartida','AMBATO');
$xml_rst = $xml->createElement('razonSocialTransportista','AMBATO');
$xml_tit = $xml->createElement('tipoIdentificacionTransportista','AMBATO');
$xml_rut = $xml->createElement('rucTransportista','AMBATO');
$xml_ris = $xml->createElement('rise','AMBATO');
$xml_oct = $xml->createElement('obligadoContabilidad','AMBATO');
$xml_ces = $xml->createElement('contribuyenteEspecial','AMBATO');
$xml_fit = $xml->createElement('fechaIniTransporte','AMBATO');
$xml_fft = $xml->createElement('fechaFinTransporte','AMBATO');
$xml_pca = $xml->createElement('placa','AMBATO');

$xml_dts = $xml->createElement('destinatarios');
$xml_dto = $xml->createElement('destinatario');
$xml_idt = $xml->createElement('identificacionDestinatario','AMBATO');
$xml_rdi = $xml->createElement('razonSocialDestinatario','AMBATO');
$xml_ddi = $xml->createElement('dirDestinatario','AMBATO');
$xml_mtr = $xml->createElement('motivoTraslado','AMBATO');
$xml_dau = $xml->createElement('docAduaneroUnico','AMBATO');
$xml_ced = $xml->createElement('codEstabDestino','AMBATO');
$xml_rut = $xml->createElement('ruta','AMBATO');
$xml_cos = $xml->createElement('codDocSustento','AMBATO');
$xml_nsu = $xml->createElement('numDocSustento','AMBATO');
$xml_mau = $xml->createElement('numAutDocSustento','AMBATO');
$xml_fes = $xml->createElement('fechaEmisionDocSustento','AMBATO');


$xml_dlls = $xml->createElement('detalles');
$xml_dlle = $xml->createElement('detalle');
$xml_cin = $xml->createElement('codigoInterno','AMBATO');
$xml_cadi = $xml->createElement('codigoAdicional','AMBATO');
$xml_dco = $xml->createElement('descripcion','AMBATO');
$xml_cans = $xml->createElement('cantidad','4541');

$xml_dal = $xml->createElement('detallesAdicionales');
$xml_dta = $xml->createElement('detAdicional');
$atributo = $xml->createAttribute('nombre');
$atributo->value = 'ABDC';
$atributo2 = $xml->createAttribute('valor');
$atributo2->value = 'EFGH';

$xml_iad = $xml->createElement('infoAdicional');
$xml_cad = $xml->createElement('campoAdicional','0998855160');
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
$xml_gre->appendChild($xml_rut);
$xml_gre->appendChild($xml_ris);
$xml_gre->appendChild($xml_oct);
$xml_gre->appendChild($xml_ces);
$xml_gre->appendChild($xml_fit);
$xml_gre->appendChild($xml_fft);
$xml_gre->appendChild($xml_pca);

$xml_dts->appendChild($xml_dto);
$xml_dto->appendChild($xml_idt);
$xml_dto->appendChild($xml_rdi);
$xml_dto->appendChild($xml_ddi);
$xml_dto->appendChild($xml_mtr);
$xml_dto->appendChild($xml_dau);
$xml_dto->appendChild($xml_ced);
$xml_dto->appendChild($xml_rut);
$xml_dto->appendChild($xml_cos);
$xml_dto->appendChild($xml_nsu);
$xml_dto->appendChild($xml_mau);
$xml_dto->appendChild($xml_fes);

$xml_dto->appendChild($xml_dlls);
$xml_dlls->appendChild($xml_dlle);
$xml_dlle->appendChild($xml_cin);
$xml_dlle->appendChild($xml_cadi);
$xml_dlle->appendChild($xml_dco);
$xml_dlle->appendChild($xml_cans);
$xml_dlle->appendChild($xml_dal);
$xml_fac->appendChild($xml_dts);

$xml_dal->appendChild($xml_dta);
$xml_dta->appendChild($atributo);
$xml_dta->appendChild($atributo2);

$xml_fac->appendChild($xml_iad);
$xml_iad->appendChild($xml_cad);
$xml_cad->appendChild($atributo3);

$xml_fac->appendChild($cabecera);
$xml_fac->appendChild($cabecerav);
$xml->appendChild($xml_fac);


	echo $xml->save('../comprobantes/guia-remision/guia-remision.xml');
 ?>
