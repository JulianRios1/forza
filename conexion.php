<?php
//SERVIDOR

$hostname = 'localhost';
$bd_usuario = 'bihomedi_admin';
$bd_clave = 't(*Gl?e}0ywO';
$bd_nombre = 'bihomedi_forza';

/*
$hostname = 'localhost';
$bd_usuario = 'root';
$bd_clave = '';
$bd_nombre = 'bihomedis';
*/
$mysqli = new mysqli($hostname, $bd_usuario,$bd_clave, $bd_nombre);
if ($mysqli -> connect_errno) {
	die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno() . ") " . $mysqli -> mysqli_connect_error());
}
//mysqli_close($mysqli);
date_default_timezone_set('America/Bogota');
?>