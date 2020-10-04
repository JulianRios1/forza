<?php 
include_once('../conexion.php');
include_once('../funciones/fechas.php');
$fecha_actual=date('Y-m-d');
$mes_actual =date('n');
$ano_actual =date('Y');

$ano_consulta = $mes_consulta = '';

$error_ins = false;
$mysqli->autocommit(false);


if($mes_actual == 1 ){
	$mes_consulta = 12;
	$ano_consulta = ($ano_actual-1);
}else{
	$mes_consulta = ($mes_actual-1);
	$ano_consulta = $ano_actual;
}
//echo "SELECT * FROM tabla_info_prod_mes t WHERE t.ano = ".$ano_consulta." AND t.mes = ".$mes_consulta."<br>";
$resultado = $mysqli->query("SELECT * FROM tabla_info_prod_mes t WHERE t.ano = ".$ano_consulta." AND t.mes = ".$mes_consulta); 
$num_reg = mysqli_num_rows($resultado);
$row = mysqli_fetch_array($resultado);

if($num_reg > 0)
{
	//echo 'entro a eliminar';
	$eliminar = "DELETE FROM tabla_info_prod_mes WHERE ano = ".$ano_consulta." AND mes = ".$mes_consulta."";
	
	if($mysqli->query($eliminar))
	{
		$error_ins = false;

		//CONSULTAMOS LOS PRODUCTOS DEL MES
		$resultado2 = $mysqli->query("SELECT p.idproducto, p.meta_producto FROM productos p WHERE p.destacado"); 

		while ($row2 = mysqli_fetch_array($resultado2)) {
	
			$insertar = "INSERT INTO `tabla_info_prod_mes` (`producto`,`meta`, `ano`, `mes`) VALUES (".$row2['idproducto'].",".$row2['meta_producto'].", ".$ano_consulta.", ".$mes_consulta." )";
			if($mysqli->query($insertar))
			{
				$error_ins = false;
			}else{
				$error_ins = true;
				$mysqli->rollBack();
			}
		}
	}
	else
	{

		$error_ins = true;
		$mysqli->rollBack();	
	}
	$error_ins = false;
}
else{  

	//CONSULTAMOS LOS PRODUCTOS DEL MES
	$resultado2 = $mysqli->query("SELECT p.idproducto, p.meta_producto FROM productos p WHERE p.destacado"); 

	while ($row2 = mysqli_fetch_array($resultado2)) {

		$insertar = "INSERT INTO `tabla_info_prod_mes` (`producto`,`meta`, `ano`, `mes`) VALUES (".$row2['idproducto'].",".$row2['meta_producto'].", ".$ano_consulta.", ".$mes_consulta." )";
		if($mysqli->query($insertar))
		{
			$error_ins = false;
		}else{
			$error_ins = true;
			$mysqli->rollBack();
		}
	}
}

$mysqli->commit();

if ($error_ins == true)
{
	echo "No se realizo ninguna operacion";
}
else {
	echo "Operacion realizada con exito";
}

?>