<?php
include 'digito_verificador.php';
$xml = new DOMDocument('1.0', 'utf-8');
$xml->formatOutput = true;
$xml_fac = $xml->createElement('notaCredito');
$cabecera = $xml->createAttribute('id');
$cabecera->value = 'comprobante';
$cabecerav = $xml->createAttribute('version');
$cabecerav->value = '1.0.0';
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

$xml_inc = $xml->createElement('infoNotaCredito');
$xml_fee = $xml->createElement('fechaEmision','AMBATO');
$xml_deo = $xml->createElement('dirEstablecimiento','AMBATO');
$xml_tic = $xml->createElement('tipoIdentificacionComprador','AMBATO');
$xml_zrc = $xml->createElement('razonSocialComprador','AMBATO');
$xml_ico = $xml->createElement('identificacionComprador','AMBATO');
$xml_ces = $xml->createElement('contribuyenteEspecial','AMBATO');
$xml_obc = $xml->createElement('obligadoContabilidad','AMBATO');
$xml_ris = $xml->createElement('rise','AMBATO');
$xml_cdi = $xml->createElement('codDocModificado','AMBATO');
$xml_nmo = $xml->createElement('numDocModificado','AMBATO');
$xml_fss = $xml->createElement('fechaEmisionDocSustento','AMBATO');
$xml_tis = $xml->createElement('totalSinImpuestos','AMBATO');
$xml_vuc = $xml->createElement('valorModificacion','AMBATO');
$xml_mda = $xml->createElement('moneda','AMBATO');

$xml_tci = $xml->createElement('totalConImpuestos');   //aqui va el while
$xml_tim = $xml->createElement('totalImpuesto');

$xml_cdo = $xml->createElement('codigo','AMBATO');
$xml_cdp = $xml->createElement('codigoPorcentaje','AMBATO');
$xml_bim = $xml->createElement('baseImponible','AMBATO');
$xml_lor = $xml->createElement('valor','AMBATO');

$xml_mtv = $xml->createElement('motivo','DEVOLUCIÓN');

$xml_dts = $xml->createElement('detalles');
$xml_dte = $xml->createElement('detalle');
$xml_cdi = $xml->createElement('codigoInterno','DEVOLUCIÓN');
$xml_cad = $xml->createElement('codigoAdicional','DEVOLUCIÓN');
$xml_dcp = $xml->createElement('descripcion','DEVOLUCIÓN');
$xml_ctd = $xml->createElement('cantidad','DEVOLUCIÓN');
$xml_puo = $xml->createElement('precioUnitario','DEVOLUCIÓN');
$xml_dto = $xml->createElement('descuento','DEVOLUCIÓN');
$xml_pts = $xml->createElement('precioTotalSinImpuesto','DEVOLUCIÓN');

$xml_das = $xml->createElement('detallesAdicionales');
$xml_dal = $xml->createElement('detAdicional');
$atributo = $xml->createAttribute('nombre');
$atributo->value = 'TELEFONO';

$xml_ims = $xml->createElement('impuestos');
$xml_imp = $xml->createElement('impuesto');

$xml_cgo = $xml->createElement('codigo','00');
$xml_cpt = $xml->createElement('codigoPorcentaje','00');
$xml_trf = $xml->createElement('tarifa','00');
$xml_cle = $xml->createElement('baseImponible','00');
$xml_vor = $xml->createElement('valor','00');


$xml_iad = $xml->createElement('infoAdicional');
$xml_cad = $xml->createElement('campoAdicional','ALEJISS401997@GMAIL.COM');
$atributo3 = $xml->createAttribute('nombre');
$atributo3->value = 'EMAIL';


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

$xml_inc->appendChild($xml_fee);
$xml_inc->appendChild($xml_deo);
$xml_inc->appendChild($xml_tic);
$xml_inc->appendChild($xml_zrc);
$xml_inc->appendChild($xml_ico);
$xml_inc->appendChild($xml_ces);
$xml_inc->appendChild($xml_obc);
$xml_inc->appendChild($xml_ris);
$xml_inc->appendChild($xml_cdi);
$xml_inc->appendChild($xml_nmo);
$xml_inc->appendChild($xml_fss);
$xml_inc->appendChild($xml_tis);
$xml_inc->appendChild($xml_vuc);
$xml_inc->appendChild($xml_mda);


$xml_inc->appendChild($xml_tci);
$xml_tci->appendChild($xml_tim);
$xml_tim->appendChild($xml_cdo);
$xml_tim->appendChild($xml_cdp);
$xml_tim->appendChild($xml_bim);
$xml_tim->appendChild($xml_lor);
$xml_fac->appendChild($xml_inc);
$xml_inc->appendChild($xml_mtv);

$xml_dts->appendChild($xml_dte);
$xml_dte->appendChild($xml_cdi);
$xml_dte->appendChild($xml_cad);
$xml_dte->appendChild($xml_dcp);
$xml_dte->appendChild($xml_ctd);
$xml_dte->appendChild($xml_puo);
$xml_dte->appendChild($xml_dto);
$xml_dte->appendChild($xml_pts);
$xml_dte->appendChild($xml_das);

$xml_das->appendChild($xml_dal);
$xml_dal->appendChild($atributo);
$xml_fac->appendChild($xml_dts);

$xml_dte->appendChild($xml_ims);
$xml_ims->appendChild($xml_imp);

$xml_imp->appendChild($xml_cgo);
$xml_imp->appendChild($xml_cpt);
$xml_imp->appendChild($xml_trf);
$xml_imp->appendChild($xml_cle);
$xml_imp->appendChild($xml_vor);

$xml_fac->appendChild($xml_iad);
$xml_iad->appendChild($xml_cad);
$xml_cad->appendChild($atributo3);

$xml_fac->appendChild($cabecera);
$xml_fac->appendChild($cabecerav);
$xml->appendChild($xml_fac);


	echo $xml->save('../comprobantes/nota-credito/nota-credito.xml');
 ?>
