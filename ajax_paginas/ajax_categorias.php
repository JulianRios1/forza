<?php
@session_start();
include ("../conexion.php");
include('../includes/parametros.php');



$resultado = $mysqli->query("SELECT * FROM categorias");

$tabla = "";

while($row = mysqli_fetch_array($resultado)){		
//<td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button></td>
	$editar = '<button type=\"button\" id=\"'.$row["idcategoria"].'\" title=\"Editar\" class=\"btn btn-primary btn-xs ver\"><i class=\"fa fa-edit\"></i></button>';
	//$editar = '<a href=\"usuario_edit.php?id='.$row['id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Editar\" class=\"btn btn-primary btn-xs\"><i class=\"fa fa-edit\"></i></a>';
	//$eliminar = '<a href=\"usuario_delete_bd.php?id='.$row['id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Editar\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i></a>';
	$eliminar = '<button type=\"button\" id=\"'.$row["idcategoria"].'\" class=\"btn btn-danger btn-xs eliminar\" title=\"Eliminar\"><i class=\"fa fa-trash\" ></i></button>';

	$tabla.='{
		"categoria":"'.$row['descategoria'].'",
		"linea":"'.lineas($row['linea']).'",
		"editar":"'.$editar.'",
		"eliminar":"'.$eliminar.'"
	},';	
}	

//eliminamos la coma que sobra
$tabla = substr($tabla,0, strlen($tabla) - 1);
echo '{"data":['.$tabla.']}';	
?>