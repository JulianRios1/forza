<?php
@session_start();
include ("../conexion.php");
include('../includes/parametros.php');

$resultado = $mysqli->query("SELECT p.idpedido, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS usuario, p.usuario_idusuario, p.estadopedido, p.total, p.fecpedido FROM pedidos p JOIN usuarios u ON p.usuario_idusuario = u.id WHERE DATEDIFF(CURDATE(), p.fecpedido) <= 360 ORDER BY p.idpedido DESC");

$tabla = "";

while($row = mysqli_fetch_array($resultado)){		

	//list($anio, $mes, $dia) = explode("-",$fecha);


	$editar = '<a href=\"pedido_view.php?id='.$row['idpedido'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Ver\" class=\"btn btn-primary btn-xs\"><i class=\"fa fa-eye\"></i></a>';
	
	

	$tabla.='{
			  "idpedido":"'.$row['idpedido'].'",
			  "nombre":"'.$row['usuario'].'",
			  "estado":"'.estados_pedidos($row['estadopedido']).'",
			  "fecha":"'.$row['fecpedido'].'",
			  "total":"'.number_format($row['total'],0,',','.').'",
			  "editar":"'.$editar.'"
			},';	
}	

//eliminamos la coma que sobra
$tabla = substr($tabla,0, strlen($tabla) - 1);
echo '{"data":['.$tabla.']}';	
?>