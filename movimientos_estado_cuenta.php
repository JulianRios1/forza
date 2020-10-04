<?php
@session_start();

extract($_GET);

include("mpdf60/mpdf.php");

$pagina = file_get_contents("http://".$_SERVER["SERVER_NAME"].dirname($_SERVER['PHP_SELF'])."/movimiento_print_pdf.php?cliente=".$cliente."&fecha_ini=".$fecha_ini."&fecha_fin=".$fecha_fin);

$mpdf=new mPDF('c','A4','','' , 10 , 0 , 0 , 0 , 0 , 0); 

$mpdf->SetDisplayMode('fullpage');

$mpdf->list_indent_first_level = 0;	// 1 or 0 - whether to indent the first level of a list

$mpdf->WriteHTML($pagina);
	    
$mpdf->Output();
?>