<?php
require_once("conexion.php");

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
echo $options;    
?>