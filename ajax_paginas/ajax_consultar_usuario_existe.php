<?php
include('../conexion.php');

$usuario = $_REQUEST["username"];
//$usuario = 'saulo';
//echo "SELECT COUNT(id) AS registros FROM usuarios WHERE usu = '$usuario'";
$resultado = $mysqli->query("SELECT COUNT(id) AS registros FROM usuarios WHERE usu = '$usuario'"); 
$row= mysqli_fetch_array($resultado);

if ($row['registros'] > 0) {
	echo json_encode(array('status' => 'ERROR', 'message' => 'Usuario <b>' . $usuario . '</b> no está disponible. Por favor elije otro'));
} else {
	echo json_encode(array('status' => 'OK', 'message' => 'Usuario <b>' . $usuario . '</b> está disponible.'));
}
?>