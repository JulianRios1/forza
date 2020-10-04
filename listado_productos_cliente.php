<?php
@session_start();
include('conexion.php');
include('funciones/fechas.php');

extract($_GET);

include("mpdf60/mpdf.php");

$pagina = file_get_contents("http://".$_SERVER["SERVER_NAME"].dirname($_SERVER['PHP_SELF'])."/listado_productos_cliente_print_pdf.php?cliente=".$cliente."&ano=".$ano."&mes=".$mes."&linea=".$linea);


$html = '<div align="center">'.$nom.'</div><br>
			<div align="center">Rotación de productos '.traducir_nombre_mes($mes).' del '.$ano.'</div>
';
//$path = (getenv('MPDF_ROOT')) ? getenv('MPDF_ROOT') : __DIR__;
//require_once $path . '/vendor/autoload.php';
$mpdf = new mpdf([
	'mode' => 'c',
	'margin_left' => 32,
	'margin_right' => 25,
	'margin_top' => 27,
	//'margin_bottom' => 25,
	'margin_header' => 16,
	'margin_footer' => 13
]);

$mpdf->SetDisplayMode('fullpage');
//$stylesheet = file_get_contents('assets/mpdfstyleA4.css');
//$mpdf->WriteHTML($stylesheet,1);	// The parameter 1 tells that this is css/style only and no body/html/text
// Bullets in columns are probably best not indented
$mpdf->list_indent_first_level = 1;	// 1 or 0 - whether to indent the first level of a list
$mpdf->max_colH_correction = 1.1;
$mpdf->WriteHTML($html,2);
$mpdf->WriteHTML('<hr />');
//$mpdf->WriteHTML($loremH,2);
// consider reducing lineheight when using columns - especially if vAligned justify
$mpdf->SetDefaultBodyCSS('line-height', 1);
$mpdf->SetColumns(2,'J');
$mpdf->WriteHTML($pagina);

//$mpdf->WriteHTML('<hr />');
/*$mpdf->SetColumns(2,'J');
$mpdf->WriteHTML($loremH,2);
$mpdf->WriteHTML('<hr />');
$mpdf->SetColumns(0);
$mpdf->WriteHTML('<hr />');
$mpdf->SetColumns(3,'J');
$mpdf->WriteHTML($loremH,2);
$mpdf->SetColumns(0);
$mpdf->WriteHTML('<hr />');
$mpdf->SetColumns(2,'J');
$mpdf->WriteHTML($loremH,2);*/
$mpdf->Output();
?>