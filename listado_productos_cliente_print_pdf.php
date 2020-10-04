<?php
include('conexion.php');
include('funciones/fechas.php');
include('includes/parametros.php');

extract($_GET);

$salt = '$bgr$/';

$array_productos = $array_prod_mes = array();


//REVISAMOS SI VIEN UNA LINEA ESPECIAL
$cons_linea = '';
if (!empty($linea)) {
	$cons_linea = '  WHERE c.linea = '.$linea;
}

//CONSULTAMOS LOS PRODUCTOS DEL MES
$i=1;
$resultado = $mysqli->query("SELECT p.idproducto FROM productos p WHERE p.destacado = 1 AND p.agotado = 0 AND p.oculto = 0 ORDER BY p.desproducto");
while($row= mysqli_fetch_array($resultado))
{     
	$array_prod_mes[$i] = $row['idproducto'];
	$i++;
}



//CONSULTAMOS LOS PEDIDOS DEL CLIENTE
$result= $mysqli->query("SELECT * FROM pedidos p WHERE p.usuario_idusuario = ".$cliente." AND p.estadopedido = 5 AND YEAR(p.fecpedido) = ".$ano." AND MONTH(p.fecpedido) = ".$mes);
while($row = mysqli_fetch_array($result))
{
	$result2= $mysqli->query("SELECT pp.producto_idproducto, pp.cantpedido_producto FROM pedidos_productos pp WHERE pp.pedido_idpedido = ".$row['idpedido']);
	while($row2 = mysqli_fetch_array($result2))
	{
		$array_productos[] = array("idprod"=>$row2['producto_idproducto'], "cantidad"=>$row2['cantpedido_producto']);
	}
}	


$result = array();

foreach($array_productos as $t) {
	
	$repeat=false;
	for($i=1;$i<=count($result);$i++)
	{
		if($result[$i]['idprod']==$t['idprod'])
		{
			$result[$i]['cantidad']+=$t['cantidad'];
			$repeat=true;
			break;
		}
	}
	if($repeat==false){
		$result[] = array('idprod' => $t['idprod'], 'cantidad' => $t['cantidad']);

	}

}

?>
<!DOCTYPE html>
<html>
<head>



</head>
<body>


<div>
<?php 
$resultado= $mysqli->query("SELECT c.idcategoria, UPPER(c.descategoria) AS nombre_cat FROM categorias c $cons_linea ORDER BY c.descategoria");
while($row = mysqli_fetch_array($resultado))
{
	?>
	<table style="border-collapse:collapse;border-spacing:0;border-color:#ccc;" width="100%">
		<thead>
			<tr>
				<th style="font-size:10px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:#f0f0f0;" colspan="2"><?php echo $row['nombre_cat'] ?></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$consulta= $mysqli->query("SELECT p.idproducto, p.desproducto AS nombre_prod FROM productos p WHERE p.oculto = 0 AND p.agotado=0 AND p.categoria_idcategoria =".$row['idcategoria']);
				
		while ($row2 = mysqli_fetch_array($consulta)) 
		{
			
			$clave = array_search($row2['idproducto'], array_column($result, 'idprod'));
			if($clave !== false){
				$valor = $result[$clave]['cantidad'];				
			}else{
				$valor = '-';
			}


			//CONSULTAMOS SI EL PRODUCTO ES DEL MES
			$val_key = array_search($row2['idproducto'], $array_prod_mes);

			if(!empty($val_key))
			{
				$bg = '#E0FFEB';
			}
			else
			{
				$bg = '#fff';
			}
			?>
			<tr>
				<td style="font-size:10px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:<?php echo $bg ?>;" width="90%" height="100%"><?php echo $row2['nombre_prod'] ?></td>
				<td style="font-size:10px;padding:2px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#ccc;color:#333;background-color:<?php echo $bg ?>; text-align: right;" width="10%"><?php echo $valor ?></td>
			</tr>
			<?php 
		}
		?>
		</tbody>

	</table>
	<?php 
}

//print_r($result);
?>
</div>	


</body>
</html>