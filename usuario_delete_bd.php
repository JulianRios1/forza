<?php
@session_start();
require_once('conexion.php');

extract($_POST);

$error_ins = false;
$mysqli->autocommit(false);
$respuesta = new stdClass();


if (isset($id)){
	
	$eliminar = "DELETE FROM usuarios WHERE id = ".$id;
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
	    echo 'El usuario no pudo ser eliminado';
	  }
	  else {
	    echo 'Usuario eliminado con exito';
	  }
}
else {
	echo 'No sirve';
}
?>