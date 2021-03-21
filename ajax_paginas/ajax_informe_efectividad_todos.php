<?php
@session_start();
include ("../conexion.php");
include ('../includes/parametros.php');

$mes = $_GET["mes"];
$anho = $_GET["anho"];
$metaDefinida = $_GET["metaDefinida"];
$metaDefinidaHtml = "<b>".$metaDefinida."</b>";
$periodo = $anho."-".$mes."-01";

$indice = 0;
$todasPersonas = array();

$resultado = $mysqli->query("SELECT id, CONCAT(nom,' ',ape1,' (',documento,')') AS nombre FROM usuarios WHERE idrol <> 5 AND estado = 1");

while($row = mysqli_fetch_array($resultado)){		

    $nombre = $row['nombre'];
    $nombreHtml = "<b>".$nombre."</b>";
    $consultorio = "";
    $consultorioHtml = "";
    $email = "";
    $noSeEncontro = "";
    $oficina = "";
    $oficinaHtml = "";
    $telefono = "";
    $efectividad = "";
    $efectividadHtml = "";
    
    //numero visitas por consultorio
    $resultado2 = $mysqli->query("SELECT COUNT(*) AS cantidadConsultorio FROM visitas WHERE id_vendedor = ".$row['id']." AND contacto = 2 AND MONTH(fecha) = MONTH('".$periodo."') AND YEAR(fecha) = YEAR('".$periodo."')");

    while($row2 = mysqli_fetch_array($resultado2)){
        $consultorio = $row2['cantidadConsultorio'];
        $consultorioHtml = "<b style='color:green;'>".$row2['cantidadConsultorio']."</b>";
    }

    //numero visitas por email
    $resultado3 = $mysqli->query("SELECT COUNT(*) AS cantidadEmail FROM visitas WHERE id_vendedor = ".$row['id']." AND contacto = 4 AND MONTH(fecha) = MONTH('".$periodo."') AND YEAR(fecha) = YEAR('".$periodo."')");

    while($row3 = mysqli_fetch_array($resultado3)){
        $email = $row3['cantidadEmail'];
    }

    //numero visitas por no se encontró
    $resultado4 = $mysqli->query("SELECT COUNT(*) AS cantidadNoSeEncontro FROM visitas WHERE id_vendedor = ".$row['id']." AND contacto = 5 AND MONTH(fecha) = MONTH('".$periodo."') AND YEAR(fecha) = YEAR('".$periodo."')");

    while($row4 = mysqli_fetch_array($resultado4)){
        $noSeEncontro = $row4['cantidadNoSeEncontro'];
    }

    //numero visitas por oficina
    $resultado5 = $mysqli->query("SELECT COUNT(*) AS cantidadOficina FROM visitas WHERE id_vendedor = ".$row['id']." AND contacto = 3 AND MONTH(fecha) = MONTH('".$periodo."') AND YEAR(fecha) = YEAR('".$periodo."')");

    while($row5 = mysqli_fetch_array($resultado5)){
        $oficina = $row5['cantidadOficina'];
        $oficinaHtml = "<b style='color:green;'>".$row5['cantidadOficina']."</b>";
    }

    //numero visitas por telefono
    $resultado6 = $mysqli->query("SELECT COUNT(*) AS cantidadTelefono FROM visitas WHERE id_vendedor = ".$row['id']." AND contacto = 1 AND MONTH(fecha) = MONTH('".$periodo."') AND YEAR(fecha) = YEAR('".$periodo."')");

    while($row6 = mysqli_fetch_array($resultado6)){
        $telefono = $row6['cantidadTelefono'];
    }

    //calculo de efectividad
    $totalVisitasValidas = intval($consultorio) + intval($oficina);
    $efectividad = round(($totalVisitasValidas*100)/intval($metaDefinida));
    if($efectividad < 34){
        $efectividadHtml = "<b style='color:red;'>".$efectividad."%</b>";
    }else{
        if($efectividad > 33 && $efectividad < 67){
            $efectividadHtml = "<b style='color:orange;'>".$efectividad."%</b>";
        }else{
            if($efectividad > 66){
                $efectividadHtml = "<b style='color:green;'>".$efectividad."%</b>";
            }
        }
    }
    

    $cadaPersona = array("id" => $row['id'], "nombre" => $nombreHtml, "consultorio" => $consultorioHtml, "email" => $email, "noSeEncontro" => $noSeEncontro, "oficina" => $oficinaHtml, "telefono" => $telefono, "meta" => $metaDefinidaHtml, "efectividad" => $efectividadHtml);
    $todasPersonas[$indice] = $cadaPersona;

    $indice++;
}	

echo json_encode($todasPersonas);
?>