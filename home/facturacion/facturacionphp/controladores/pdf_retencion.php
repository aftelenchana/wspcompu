<?php
require_once '../lib/dompdf/autoload.inc.php';
include ('../lib/codigo_barras/barcode.inc.php');
	 use Dompdf\Dompdf;

 function crecion_pdf_nota_credito($nomnto_modificacion,$razon_modficiacion,$clave_acceso_factura,$clave_acc_guardar){

	 $iduser= $_SESSION['id'];
	 // Introducimos HTML de prueba

   $razon_modficiacion = urlencode($razon_modficiacion);

	  $protocol = empty($_SERVER['HTTPS']) ? 'http://' : 'https://';$domain = $_SERVER['HTTP_HOST'];$url2 = $protocol . $domain;

    $url_vista = "$url2/home/pdf/nota_credito.php?id=$iduser&clave_acc_guardar=$clave_acc_guardar&nomnto_modificacion=$nomnto_modificacion&razon_modficiacion=$razon_modficiacion&clave_acceso_factura=$clave_acceso_factura";
    //echo "$url_vista";


	  $html=file_get_contents("$url2/home/pdf/nota_credito.php?id=$iduser&clave_acc_guardar=$clave_acc_guardar&nomnto_modificacion=$nomnto_modificacion&razon_modficiacion=$razon_modficiacion&clave_acceso_factura=$clave_acceso_factura");

	 // Instanciamos un objeto de la clase DOMPDF.
	 $pdf = new DOMPDF();

	 // Definimos el tamaño y orientación del papel que queremos.
	 $pdf->set_paper("letter", "portrait");
	 //$pdf->set_paper(array(0,0,104,250));

	 // Cargamos el contenido HTML.
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
