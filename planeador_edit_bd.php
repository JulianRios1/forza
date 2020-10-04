<?php
@session_start();
require_once('conexion.php');

extract($_POST);


if (isset($_POST['Evento'][0]) && isset($_POST['Evento'][1]) && isset($_POST['Evento'][2])){

$error_ins = false;
$mysqli->autocommit(false);
$respuesta = new stdClass();	
	
	$id = $_POST['Evento'][0];
	$inicio = $_POST['Evento'][1];
	$fin = $_POST['Evento'][2];

	$editar = "UPDATE agendas SET  inicio = '$inicio', fin = '$fin' WHERE id = $id ";

	if($mysqli->query($editar))
	{
		$error_ins = false;
	}
	else
	{
		$error_ins = true;
	    $mysqli->rollBack();
	}
	
	$mysqli->commit();

	if ($error_ins == true)
	{
		echo $editar;
	}
	else {
		echo "OK";
	}
}
?>