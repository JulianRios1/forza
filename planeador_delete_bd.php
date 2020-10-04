<?php
@session_start();
require_once('conexion.php');

//echo $_POST['hdd_id'];
extract($_POST);

$error_ins = false;
$mysqli->autocommit(false);
$respuesta = new stdClass();


if (isset($hdd_id)){
	
	$eliminar = "DELETE FROM agendas WHERE id = ".$hdd_id;
	if($mysqli->query($eliminar))
	{
		$error_ins = false;
	}
	else
	{
		$error_ins = true;
	    $mysqli->rollBack();
	}
	
	$mysqli->commit();
  

}
header('Location: planeador.php');	
?>