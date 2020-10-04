<?php
@session_start();
include ("../conexion.php");
include('../includes/parametros.php');



$resultado = $mysqli->query("SELECT id,ano FROM tabla_valores_cli_celebres t ORDER BY t.ano DESC");

$tabla = "";

while($row = mysqli_fetch_array($resultado)){		
//<td><button type="button" id="'.$row["id"].'" class="btn btn-warning btn-xs update">Update</button></td>


	$editar = '<a href=\"tabla_val_clie_cel_edit.php?id='.$row['id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Editar\" class=\"btn btn-primary btn-xs\"><i class=\"fa fa-edit\"></i></a>';
	$eliminar = '<button type=\"button\" id=\"'.$row["id"].'\" class=\"btn btn-danger btn-xs eliminar\" title=\"Eliminar\"><i class=\"fa fa-trash\" ></i></button>';

	$tabla.='{
		"id":"'.$row['id'].'",
		"ano":"'.$row['ano'].'",
		"editar":"'.$editar.'",
		"eliminar":"'.$eliminar.'"
	},';	
}	

//eliminamos la coma que sobra
$tabla = substr($tabla,0, strlen($tabla) - 1);
echo '{"data":['.$tabla.']}';	
?>