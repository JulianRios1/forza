<?php
@session_start();
require_once('conexion.php');

extract($_POST);

$error_ins = false;
$mysqli->autocommit(false);


if (isset($id)){
	
	//ELIMINAMOS TODOS LOS PERMISOS
	$eliminar = "DELETE FROM permisos_roles WHERE rol_id = ".$id;
	if($mysqli->query($eliminar))
	{
		$error_ins = false;

		$eliminar = "DELETE FROM roles WHERE id = ".$id;
		if($mysqli->query($eliminar))
		{
			$error_ins = false;
		}
		else
		{
			$error_ins = true;
		    $mysqli->rollBack();
		}

	}
	else
	{
	$error_ins = true;
	  $mysqli->rollBack();
	}


	
	
	$mysqli->commit();
  
  
	  if ($error_ins == true)
	  {
	    echo 'El rol no pudo ser eliminado';
	  }
	  else {
	    echo 'Rol eliminado con exito';
	  }
}
else {
	echo 'No sirve';
}
?>