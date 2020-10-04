<?php
require_once("conexion.php");

$cliente = $_POST["elegido"];

$resultado = $mysqli->query('SELECT SUM(pp.cantpedido_producto) AS cantidad, pp.producto_idproducto
FROM pedidos_productos pp WHERE pp.pedido_idpedido IN(19183,19184) GROUP BY pp.producto_idproducto');

/*$cliente = $_POST["elegido"];

$resultado = $mysqli->query('SELECT * FROM municipios WHERE departamento_id = '.$_POST["elegido"].' ORDER BY nombreMunicipio ASC');


$options="";
if ($_POST["elegido"]== !'') {
    
	
		while ($registro_ciu = mysqli_fetch_array($resultado))
		{
			$options .='
			<option value="'.$registro_ciu['id'].'">'.$registro_ciu['nombreMunicipio'].'</option>';
		}
   
}
else
{
	$options='<option value="">Seleccionar</option>';
}
echo $options;  */  
?>

