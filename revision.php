<?php
include('conexion.php');

$array_medicos = array();




$consulta = $mysqli->query("SELECT u.id, u.documento, u.nom, u.ape1, u.ape2, u.mail, u.dir, u.tel, u.cel, z.des AS zona, m.barrio1, m.fecha_ult_vis, m.listaPrecios, m.fec_ult_pedido, m.valor_compras, m.mes_compras, m.ano_compras FROM usuarios u JOIN medicos m ON m.usuario_id = u.id JOIN zonas z ON m.zona = z.id WHERE u.idrol = 5 AND u.estado = 1 AND m.habilitado = 1 AND m.zona = 12");   
while($row2 = mysqli_fetch_array($consulta))
{
	$array_medicos[] =  $row2['id'];
}


$resultado = $mysqli->query("SELECT u.id, u.documento, YEAR(m.fecha_ult_vis) AS ano_ult_visita, MONTH(m.fecha_ult_vis) AS mes_ult_visita, m.valor_compras, m.ano_compras, m.mes_compras FROM medicos m JOIN usuarios u ON m.usuario_id = u.id AND m.habilitado = 1 WHERE m.zona = 12");    

while($row = mysqli_fetch_array($resultado))
{
	
	if (in_array($row['id'], $array_medicos)) {
    	//echo "Existe Irix";
	}
	else {
	    echo "No existe el id ".$row['id'];
	}
	//echo "Documento: ".$row['documento']."<br>";
}

//echo sizeof($array_medicos)."<br>";

//print_r($array_medicos);

//$os = array("Mac", "NT", "Irix", "Linux");

?>