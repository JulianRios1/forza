<?php
@session_start();
require_once('conexion.php');

extract($_POST);

$error_ins = false;
$mysqli->autocommit(false);
$respuesta = new stdClass();


if (isset($id)){
	
	//CONSULTAMOS LOS ARCHIVOS A ELIMINAR DEL PRODUCTO FOTO Y ARCHIVO SI TIENEN
	$resultado = $mysqli->query("SELECT p.rutproducto, p.archivo FROM productos p WHERE p.idproducto = $id");
	$row = mysqli_fetch_array($resultado);


	$eliminar = "DELETE FROM productos WHERE idproducto = ".$id;
	if($mysqli->query($eliminar))
	{
		$error_ins = false;

		$carpetaAdjunta="../imagenes_productos/";
		if(!empty($row['rutproducto']))
        {
          unlink($carpetaAdjunta.$row['rutproducto']);
        }

        $carpetaAdjunta2="../archivos/";
        if(!empty($row['archivo']))
        {
          unlink($carpetaAdjunta2.$row['archivo']);
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
	    echo 'El producto no pudo ser eliminado';
	  }
	  else {
	    echo 'Producto eliminado con exito';
	  }
}
else {
	echo 'No sirve';
}
?>