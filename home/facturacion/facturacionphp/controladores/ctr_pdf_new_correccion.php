<?php
require_once '../lib/dompdf/autoload.inc.php';
include ('../lib/codigo_barras/barcode.inc.php');
use Dompdf\Dompdf;
use Dompdf\Options;

 function crecion($clave_acc_guardar,$fechaAutorizacion,$clave_acceso_factura){

	 $iduser= $_SESSION['id'];
	 // Introducimos HTML de prueba

	  $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;

	  $html=file_get_contents("$url2/home/pdf/factura_correccion.php?id=$iduser&clave_acc_guardar=$clave_acc_guardar&fechaAutorizacion=$fechaAutorizacion&clave_acceso_factura=$clave_acceso_factura");



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

	 $archivo = '../comprobantes/pdf/'.$clave_acc_guardar.'.pdf';
	 file_put_contents($archivo, $pdf->output());




}




/*$pdf = new pdf();

$pdf->pdfFacTura('555');*/

?>
