<?php
@session_start();
require_once('conexion.php');

extract($_POST);

$error_ins = false;
$mysqli->autocommit(false);
$respuesta = new stdClass();


if (isset($id)){
	
	$eliminar = "DELETE FROM tabla_valores_cli_celebres WHERE id = ".$id;
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
  
  
	  if ($error_ins == true)
	  {
	    echo 'El año no pudo ser eliminado';
	  }
	  else {
	    echo 'Año eliminado con exito';
	  }
}
else {
	echo 'No sirve';
}
?>