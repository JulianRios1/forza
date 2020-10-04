<?php
include("conexion.php");

extract($_POST);

if (isset($id))
{
	$error_ins = false;
    $mysqli->autocommit(false);

	$actualizar = "UPDATE medicos SET cliente_nuevo = 0 WHERE usuario_id = ".$id;
	
	if ($mysqli->query($actualizar))
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
      echo $actualizar;
    }
    else {
      echo "Realizado";
    }
}
?>