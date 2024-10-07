<?php
include 'digito_verificador.php';
$xml = new DOMDocument('1.0', 'utf-8');
$xml->formatOutput = true;
$xml_fac = $xml->createElement('comprobanteRetencion');
$cabecera = $xml->createAttribute('id');
$cabecera->value = 'comprobante';
$cabecerav = $xml->createAttribute('version');
$cabecerav->value = '2.0.0';
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
$xml_doc = $xml->createElement('codDoc','01');
$xml_est = $xml->createElement('estab', '001');
$xml_emi = $xml->createElement('ptoEmi', '001');
$xml_sec = $xml->createElement('secuencial','00000001');
$xml_dir = $xml->createElement('dirMatriz','AMBATO');
//INFORMACION DE LA RETENCION
$xml_iret    = $xml->createElement('infoCompRetencion');
$xml_fechae  = $xml->createElement('fechaEmision', '22/22/2');
$xml_dire  = $xml->createElement('dirEstablecimiento', 'Amabato');
$xml_cesp  = $xml->createElement('contribuyenteEspecial', 'SI');
$xml_ocon  = $xml->createElement('obligadoContabilidad', 'SI');
$xml_tipi  = $xml->createElement('tipoIdentificacionSujetoRetenido', '05');
$xml_tsjr  = $xml->createElement('tipoSujetoRetenido', '01');
$xml_rel  = $xml->createElement('parteRel', 'SI');
$xml_rzre  = $xml->createElement('razonSocialSujetoRetenido', 'GUIBIS');
$xml_isr  = $xml->createElement('identificacionSujetoRetenido', '1804843900001');
$xml_pfis  = $xml->createElement('periodoFiscal', '01/2023');

//TERCERA PARTE
$xml_docs    = $xml->createElement('docsSustento');
$xml_doc     = $xml->createElement('docSustento');
$xml_cds     = $xml->createElement('codSustento','10');
$xml_cdocss  = $xml->createElement('codDocSustento','10');
$xml_ndsu    = $xml->createElement('numDocSustento','002001000000001');
$xml_fedsu    = $xml->createElement('fechaEmisionDocSustento','22/01/2023');
$xml_frce    = $xml->createElement('fechaRegistroContable','22/02/2023');
$xml_nads    = $xml->createElement('numAutDocSustento','2110201116');
$xml_plex    = $xml->createElement('pagoLocExt','01');
$xml_tire    = $xml->createElement('tipoRegi','01');
$xml_papa    = $xml->createElement('paisEfecPago','580');
$xml_aptr    = $xml->createElement('aplicConvDobTrib','NO');
$xml_pale    = $xml->createElement('pagExtSujRetNorLeg','NO');
$xml_pafi    = $xml->createElement('pagoRegFis','SI');
$xml_tcre    = $xml->createElement('totalComprobantesReembolso','138.19');
$xml_tbir    = $xml->createElement('totalBaseImponibleReembolso','133.13');
$xml_tire    = $xml->createElement('totalImpuestoReembolso','3.25');
$xml_tsim    = $xml->createElement('totalSinImpuestos','133.13');
$xml_imto    = $xml->createElement('importeTotal','68.19');
//CUARTA PARTE

$xml_imdsu    = $xml->createElement('impuestosDocSustento');
$xml_imds_1    = $xml->createElement('impuestoDocSustento');
$xml_cids    = $xml->createElement('codImpuestoDocSustento','2');
$xml_cpje    = $xml->createElement('codigoPorcentaje','5');
$xml_bimo    = $xml->createElement('baseImponible','1000');
$xml_tafa    = $xml->createElement('tarifa','0');
$xml_vaim    = $xml->createElement('valorImpuesto','3.25');
//quinta parte
$xml_reten    = $xml->createElement('retenciones');
$xml_rete    = $xml->createElement('retencion');
$xml_codi    = $xml->createElement('codigo','1000');
$xml_cort    = $xml->createElement('codigoRetencion','423');
$xml_bile    = $xml->createElement('baseImponible','1000');
$xml_pher    = $xml->createElement('porcentajeRetener','12');
$xml_vrdo    = $xml->createElement('valorRetenido','0.25');

$xml_divi    = $xml->createElement('dividendos');
$xml_fedi    = $xml->createElement('fechaPagoDiv','12/12/2023');
$xml_imre    = $xml->createElement('imRentaSoc','102.54');
$xml_ejef    = $xml->createElement('ejerFisUtDiv','2012');

$xml_ccba    = $xml->createElement('compraCajBanano');
$xml_nuca    = $xml->createElement('NumCajBan','12');
$xml_pcba    = $xml->createElement('PrecCajBan','253');
//REEMBOLSOS
$xml_reem    = $xml->createElement('reembolsos');
$xml_rede    = $xml->createElement('reembolsoDetalle');
$xml_tipr    = $xml->createElement('tipoIdentificacionProveedorReembolso','04');
$xml_ipre    = $xml->createElement('identificacionProveedorReembolso','1760013210001');
$xml_cppp    = $xml->createElement('codPaisPagoProveedorReembolso','593');
$xml_tpre    = $xml->createElement('tipoProveedorReembolso','01');
$xml_cdre    = $xml->createElement('codDocReembolso','01');
$xml_edre    = $xml->createElement('estabDocReembolso','001');
$xml_pter    = $xml->createElement('ptoEmiDocReembolso','501');
$xml_sdre    = $xml->createElement('secuencialDocReembolso','000000008');
$xml_fedr    = $xml->createElement('fechaEmisionDocReembolso','04/03/2013');
$xml_nadr    = $xml->createElement('numeroAutorizacionDocReemb','04032013011792261104001100150100000000');

$xml_deis    = $xml->createElement('detalleImpuestos');
$xml_deim    = $xml->createElement('detalleImpuesto');
$xml_codo    = $xml->createElement('codigo','2');
$xml_cdje    = $xml->createElement('codigoPorcentaje','0');
$xml_rifa    = $xml->createElement('tarifa','0');
$xml_bire    = $xml->createElement('baseImponibleReembolso','68.19');
$xml_iree    = $xml->createElement('impuestoReembolso','0');

$xml_pags    = $xml->createElement('Pagos');
$xml_pago    = $xml->createElement('Pago');
$xml_fpgo    = $xml->createElement('formapago','01');
$xml_ttal    = $xml->createElement('total','500');

$xml_iadc    = $xml->createElement('infoAdicional');
$xml_fpgo    = $xml->createElement('formapago','01');

$xml_ifa = $xml->createElement('infoAdicional');
$xml_cp1 = $xml->createElement('campoAdicional','alejiss401997');
$atributo = $xml->createAttribute('nombre');
$atributo->value = 'email';




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

$xml_iret->appendChild($xml_fechae);
$xml_iret->appendChild($xml_dire);
$xml_iret->appendChild($xml_cesp);
$xml_iret->appendChild($xml_ocon);
$xml_iret->appendChild($xml_tipi);
$xml_iret->appendChild($xml_tsjr);
$xml_iret->appendChild($xml_rel);
$xml_iret->appendChild($xml_rzre);
$xml_iret->appendChild($xml_isr);
$xml_iret->appendChild($xml_pfis);
$xml_fac->appendChild($xml_iret);//cerrar caja de informacion del sujeto retenidp
$xml_docs->appendChild($xml_doc);

$xml_docs->appendChild($xml_doc);
$xml_doc->appendChild($xml_cds);
$xml_doc->appendChild($xml_cdocss);
$xml_doc->appendChild($xml_ndsu);
$xml_doc->appendChild($xml_fedsu);
$xml_doc->appendChild($xml_frce);
$xml_doc->appendChild($xml_nads);
$xml_doc->appendChild($xml_plex);
$xml_doc->appendChild($xml_tire);
$xml_doc->appendChild($xml_papa);
$xml_doc->appendChild($xml_aptr);
$xml_doc->appendChild($xml_pale);
$xml_doc->appendChild($xml_pafi);
$xml_doc->appendChild($xml_tcre);
$xml_doc->appendChild($xml_tbir);
$xml_doc->appendChild($xml_tire);
$xml_doc->appendChild($xml_tsim);
$xml_doc->appendChild($xml_imto);
$xml_doc->appendChild($xml_imdsu);
$xml_imdsu->appendChild($xml_imds_1);
$xml_imds_1->appendChild($xml_cids);
$xml_imds_1->appendChild($xml_cpje);
$xml_imds_1->appendChild($xml_bimo);
$xml_imds_1->appendChild($xml_tafa);
$xml_imds_1->appendChild($xml_vaim);

$xml_doc->appendChild($xml_reten);
$xml_reten->appendChild($xml_rete);
$xml_rete->appendChild($xml_codi);
$xml_rete->appendChild($xml_cort);
$xml_rete->appendChild($xml_bile);
$xml_rete->appendChild($xml_pher);
$xml_rete->appendChild($xml_vrdo);
$xml_reten->appendChild($xml_divi);
$xml_divi->appendChild($xml_fedi);
$xml_divi->appendChild($xml_imre);
$xml_divi->appendChild($xml_ejef);
$xml_reten->appendChild($xml_ccba);
$xml_ccba->appendChild($xml_nuca);
$xml_ccba->appendChild($xml_pcba);
$xml_fac->appendChild($xml_docs);//CERRAR CAJA DE BLOQUE 2
$xml_reten->appendChild($xml_rete);
$xml_rete->appendChild($xml_codi);
$xml_rete->appendChild($xml_cort);
$xml_rete->appendChild($xml_bile);
$xml_rete->appendChild($xml_pher);
$xml_rete->appendChild($xml_vrdo);
$xml_reten->appendChild($xml_divi);
$xml_divi->appendChild($xml_fedi);
$xml_divi->appendChild($xml_imre);
$xml_divi->appendChild($xml_ejef);
$xml_reten->appendChild($xml_ccba);
$xml_ccba->appendChild($xml_nuca);
$xml_ccba->appendChild($xml_pcba);

$xml_doc->appendChild($xml_reem);
$xml_reem->appendChild($xml_rede);

$xml_rede->appendChild($xml_tipr);
$xml_rede->appendChild($xml_ipre);
$xml_rede->appendChild($xml_cppp);
$xml_rede->appendChild($xml_tpre);
$xml_rede->appendChild($xml_cdre);
$xml_rede->appendChild($xml_edre);
$xml_rede->appendChild($xml_pter);
$xml_rede->appendChild($xml_sdre);
$xml_rede->appendChild($xml_fedr);
$xml_rede->appendChild($xml_nadr);
$xml_rede->appendChild($xml_deis);
$xml_deis->appendChild($xml_deim);
$xml_deim->appendChild($xml_codo);
$xml_deim->appendChild($xml_cdje);
$xml_deim->appendChild($xml_rifa);
$xml_deim->appendChild($xml_bire);
$xml_deim->appendChild($xml_iree);


$xml_doc->appendChild($xml_pags);
$xml_pags->appendChild($xml_pago);
$xml_pago->appendChild($xml_fpgo);
$xml_pago->appendChild($xml_ttal);

$xml_fac->appendChild($xml_ifa);
$xml_ifa->appendChild($xml_cp1);
$xml_cp1->appendChild($atributo);

$xml_fac->appendChild($cabecera);
$xml_fac->appendChild($cabecerav);
$xml->appendChild($xml_fac);

$tipo = 'retencion';
	echo $xml->save('../comprobantes/retencion/retencion.xml');
 ?>
