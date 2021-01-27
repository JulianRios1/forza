<?php
@session_start();
include ("../conexion.php");
include ('../includes/parametros.php');

$mes = $_GET["mes"];
$anho = $_GET["anho"];
$metaTotalDefinida = $_GET["metaTotalDefinida"];
$periodo = $anho."-".$mes."-01";

$efectividadTotal = 0;
$porcentajeEfectividadTotal = 0;

$resultado = $mysqli->query("SELECT id FROM usuarios WHERE idrol <> 5 AND estado = 1");

while($row = mysqli_fetch_array($resultado)){		

    $consultorio = 0;
    $oficina = 0;
    
    //numero visitas por consultorio
    $resultado2 = $mysqli->query("SELECT COUNT(*) AS cantidadConsultorio FROM visitas WHERE id_vendedor = ".$row['id']." AND contacto = 2 AND MONTH(fecha) = MONTH('".$periodo."') AND YEAR(fecha) = YEAR('".$periodo."')");

    while($row2 = mysqli_fetch_array($resultado2)){
        $consultorio = $row2['cantidadConsultorio'];
    }

    //numero visitas por oficina
    $resultado5 = $mysqli->query("SELECT COUNT(*) AS cantidadOficina FROM visitas WHERE id_vendedor = ".$row['id']." AND contacto = 3 AND MONTH(fecha) = MONTH('".$periodo."') AND YEAR(fecha) = YEAR('".$periodo."')");

    while($row5 = mysqli_fetch_array($resultado5)){
        $oficina = $row5['cantidadOficina'];
    }

    //calculo del total
    $efectividadTotal = $efectividadTotal + intval($consultorio) + intval($oficina);
}	

$porcentajeEfectividadTotal = round(($efectividadTotal*100)/intval($metaTotalDefinida));
$porcentajeEfectividadTotal = $porcentajeEfectividadTotal."%";

echo json_encode(array("efectividadTotal"=>$efectividadTotal, "porcentajeEfectividadTotal"=>$porcentajeEfectividadTotal));
?>