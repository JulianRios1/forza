<?php
require_once("../conexion.php");
$elegido = $_POST["elegido"];
//$elegido = 1;
//echo "SELECT u.id, UPPER(CONCAT_WS(' ',u.nom, u.ape1,u.ape2)) AS nommedico FROM medicos m JOIN usuarios u ON m.usuario_id = u.id WHERE m.zona = ".$elegido." AND habilitado = 0 ORDER BY nommedico ASC";
$resultado = $mysqli->query("SELECT u.id, UPPER(CONCAT_WS(' ',u.nom, u.ape1,u.ape2)) AS nommedico FROM medicos m JOIN usuarios u ON m.usuario_id = u.id WHERE m.zona = ".$elegido." AND habilitado = 1 ORDER BY nommedico ASC "); 

$options="";
if ($elegido== !'') {
    
	
		while ($row= mysqli_fetch_array($resultado))
		{
			$options .='
			<option value="'.$row['id'].'">'.strtoupper(($row['nommedico'])).'</option>';
		}   
}
else
{
	$options='<option value="0">-Seleccione-</option>';
}
echo $options;    
?>