<?php
@session_start();
include ("../conexion.php");
include ('../includes/parametros.php');

$resultado = $mysqli->query("SELECT p.idproducto AS id, p.desproducto, p.valproducto, l.nomlaboratorio AS laboratorio, c.descategoria, p.linea, p.agotado, p.oculto FROM productos p LEFT JOIN laboratorios l ON p.laboratorio = l.id LEFT JOIN categorias c ON c.idcategoria = p.categoria_idcategoria");

$tabla = "";

while($row = mysqli_fetch_array($resultado)){		


	$editar = '<a href=\"producto_edit.php?id='.$row['id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Ver\" class=\"btn btn-primary btn-xs\"><i class=\"fa fa-edit\"></i></a>';
	//$eliminar = '<a href=\"visita_new.php?id='.$row['id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Visitar\" class=\"btn btn-primary btn-xs purple\" ><i class=\"fa fa-suitcase\"></i></a>';
	$eliminar = '<button type=\"button\" id=\"'.$row["id"].'\" class=\"btn btn-danger btn-xs eliminar\" title=\"Eliminar\"><i class=\"fa fa-trash\" ></i></button>';
	

	$tabla.='{
				"producto":"'.strtoupper($row['desproducto']).'",
				"valor":"'.number_format($row['valproducto'],0,',','.').'",
				"laboratorio":"'.$row['laboratorio'].'",
				"categoria":"'.$row['descategoria'].'",
				"linea":"'.lineas($row['linea']).'",
				"agotado":"'.estado($row['agotado']).'",
				"oculto":"'.oculto_visible($row['oculto']).'",
				"editar":"'.$editar.'",
				"eliminar":"'.$eliminar.'"
			},';	
}	

//eliminamos la coma que sobra
$tabla = substr($tabla,0, strlen($tabla) - 1);
echo '{"data":['.$tabla.']}';	
?>