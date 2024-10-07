<?php
require_once '../lib/dompdf/autoload.inc.php';
include ('../lib/codigo_barras/barcode.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

 function crecion_pdf_nota_credito($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar,$sucursal_facturacion){


   include "../../../../coneccion.php";

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


   $razon_modficiacion = urlencode($razon_modficiacion);

	  $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;

    $url_vista = "$url2/home/pdf/nota_credito.php?id=$iduser&clave_acc_guardar=$clave_acc_guardar&nomnto_modificacion=$nomnto_modificacion&razon_modficiacion=$razon_modficiacion&clave_acceso_factura=$clave_acceso_factura&sucursal_facturacion=$sucursal_facturacion&user_in=$user_in";


	  $html=file_get_contents("$url2/home/pdf/nota_credito.php?id=$iduser&clave_acc_guardar=$clave_acc_guardar&nomnto_modificacion=$nomnto_modificacion&razon_modficiacion=$razon_modficiacion&clave_acceso_factura=$clave_acceso_factura&sucursal_facturacion=$sucursal_facturacion&user_in=$user_in");

	 // Instanciamos un objeto de la clase DOMPDF.
	 $options = new Options();
	 $options  -> set('isRemoteEnabled', TRUE);
	 // Instanciamos un objeto de la clase DOMPDF.
	 $pdf = new DOMPDF($options);
	 // Definimos el tamaño y orientación del papel que queremos.
	 $pdf->set_paper("letter", "portrait");
	 //$pdf->set_paper(array(0,0,104,250));ntenido HTML.
	 $pdf->load_html($html,'UTF-8');
	 $pdf->setPaper('A4', 'portrait');
	 // Renderizamos el documento PDF.
	 $pdf->render();

	 $archivo = '../comprobantes/nota-credito/pdf/'.$clave_acc_guardar.'.pdf';
	 file_put_contents($archivo, $pdf->output());




}




/*$pdf = new pdf();

$pdf->pdfFacTura('555');*/

?>
