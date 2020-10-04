<?php
include_once('conexion.php');
include_once('funciones/fechas.php');

header("Pragma: ");
header('Cache-control: ');
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
/*header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);*/
 header("Content-type: application/vnd.ms-excel");
// Exporta en CSVheader ("Content-type: application/x-msexcel"); 
header("Content-disposition: attachment; filename=listado_productos.xls");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php

$resul = $mysqli->query('SELECT * FROM productos LEFT JOIN categorias ON categorias.idcategoria = productos.categoria_idcategoria');

$num_registros = mysqli_num_rows($resul);


?>
<table width="98%" border="0" cellspacing="0" cellpadding="0" >
<?php	
if($num_registros > 0)
{
	
	while ($registro = mysqli_fetch_array($resul))
	{	
	?>
  	<tr class="list">
    	<td align="left" bgcolor="#FFFFFF"><?php echo $registro['idproducto']?></td>
      	<td align="left" bgcolor="#FFFFFF"><?php echo $registro['desproducto']?></td>
      	<td align="left" bgcolor="#FFFFFF"><?php echo $registro['descategoria']?></td>
        <td align="left" bgcolor="#FFFFFF"><?php echo number_format($registro['valproducto'],0,',','.')?></td>
		<?php
		for($i=2; $i<=8; $i++)
		{
			?>
            <td align="left" bgcolor="#FFFFFF"><?php echo number_format($registro['valproducto'.$i],0,',','.')?></td>
            <?php
		}
		?>
  	</tr>
	<?php  	
	}
}
?>
</table>
</body>
</html>
