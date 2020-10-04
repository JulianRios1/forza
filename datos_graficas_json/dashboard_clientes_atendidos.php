<?php
include('../conexion.php');
include('../funciones/fechas.php');
$data = array();
for($i=-10; $i<=0; $i++){
	//echo "SELECT cl.fecha_atencion AS fecha, COUNT(cl.cliente_id) AS num_clientes FROM clientes_atendidos cl WHERE cl.fecha_atencion = '".sumar_restar_dia(date('Y-m-d'),$i)."'";
	$resultado = $mysqli->query("SELECT cl.fecha_atencion AS fecha, COUNT(cl.cliente_id) AS num_clientes FROM clientes_atendidos cl WHERE cl.fecha_atencion = '".sumar_restar_dia(date('Y-m-d'),$i)."'");
	$row = mysqli_fetch_array($resultado);

	  $data[] = array('fecha'=> sumar_restar_dia(date('Y-m-d'),$i), 'num_clientes'=> $row['num_clientes']);

}


echo json_encode( $data );

?>