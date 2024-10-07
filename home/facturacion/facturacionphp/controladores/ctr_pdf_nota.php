<?php
require('clasepdf.php');
		$pdf = new TICKET('P','mm',array(76,297));
		$pdf->AddPage();
		$pdf->SetFont('Arial', '', 12);
		$pdf->SetAutoPageBreak(true,1);
		$pdf->setXY(2,1.5);

		$pdf->MultiCell(73, 4.2, 'iii', 0,'C',0 ,1);
		$pdf->setXY(2,10);
		$pdf->SetFont('Arial', '', 6.9);
		$pdf->MultiCell(73, 4.2, 'jjj', 0,'C',0 ,1);
		$get_YD = $pdf->GetY();
		$pdf->setXY(2,6);
		$pdf->SetFont('Arial', '', 8);
		$pdf->MultiCell(73, 4.2, 'gggg', 0,'C',0 ,1);

		$pdf->setXY(2,$get_YD);

		$pdf->MultiCell(73, 4.2, 'RUC : 555', 0,'C',0 ,1);

			$pdf->Output('I','Ticket_.pdf',true);








/*$pdf = new pdf();
$pdf->pdfFacTura('555');*/
?>
