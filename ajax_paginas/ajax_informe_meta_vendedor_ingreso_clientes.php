<?php
@session_start();
include ("../conexion.php");
include ('../includes/parametros.php');

$zona = $_GET["zona"];

$resultado = null;
$indice = 0;
$arrayClientes = array();

$resultado = $mysqli->query("SELECT m.id AS ide, u.documento AS documento, CONCAT(u.nom,' ',u.ape1,' ',u.ape2) AS cliente
                            FROM medicos m
                            JOIN usuarios u ON u.id = m.usuario_id
                            WHERE m.zona = ".$zona."
                            ORDER BY cliente desc
");

if($resultado){  
    while($row = mysqli_fetch_array($resultado)){		

        $arrayClientes[$indice] = $row;
        $indice++;
    }
}

echo json_encode($arrayClientes);
?>