<?php
@session_start();
include ("../conexion.php");
include ('../includes/parametros.php');

$vendedor = $_GET["vendedor"];

$resultado = null;
$indice = 0;
$arrayZonas = array();

$resultado = $mysqli->query("SELECT * FROM zonas WHERE id_vendedor = ".$vendedor);

if($resultado){  
    while($row = mysqli_fetch_array($resultado)){		

        $arrayZonas[$indice] = $row;
        $indice++;
    }
}

echo json_encode($arrayZonas);
?>