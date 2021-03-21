<?php
@session_start();
include ("../conexion.php");
include ('../includes/parametros.php');

$vendedor = $_GET["vendedor"];
$zona = $_GET["zona"];
$mes = $_GET["mes"];
$ano = $_GET["ano"];
$ano_last = (date('Y')-1);
$ano_last_last = (date('Y')-2);
$pronostico_vendedor = null;
$venta_actual = null;

$indice = 0;
$clientes = array();

$totalEsperadoVentas = 0;
$totalEjecutado = 0;

$resultado = $mysqli->query("SELECT u.id AS ide, m.id AS idem, u.documento AS documento, CONCAT('(',COALESCE(u.documento,''),') ',COALESCE(u.nom,''),' ',COALESCE(u.ape1,''),' ',COALESCE(u.ape2,'')) AS cliente
                            FROM medicos m
                            JOIN usuarios u ON u.id = m.usuario_id
                            JOIN meta_vendedor mv ON mv.id_cliente = m.id
                            WHERE m.zona = ".$zona." AND mv.id_vendedor = ".$vendedor." AND mv.mes = ".$mes." AND mv.ano = ".$ano."
                            ORDER BY cliente asc");

if($resultado){   
    while($row = mysqli_fetch_array($resultado)){		
        $resultado1 = $mysqli->query("SELECT meta AS pronostico_vendedor FROM meta_vendedor WHERE id_vendedor = ".$vendedor." AND id_cliente = ".$row['idem']." AND mes = ".$mes." AND ano = ".$ano);
        if($resultado1){  
            while($row1 = mysqli_fetch_array($resultado1)){		

                $pronostico_vendedor = $row1['pronostico_vendedor'];
            }
        }

        $resultado2 = $mysqli->query("SELECT c.compra AS venta_actual FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND mes = ".$mes." AND ano = ".$ano);
        if($resultado2){  
            while($row2 = mysqli_fetch_array($resultado2)){		

                $venta_actual = $row2['venta_actual'];
            }
        }
        
        $totalEsperadoVentas += intval($pronostico_vendedor);
        $totalEjecutado += intval($venta_actual);

        $pronostico_vendedor = null;
        $venta_actual = null;
    }	
}

$porcentajeTotalEjecutado = intval(($totalEjecutado/$totalEsperadoVentas) * 100);

echo json_encode(array("totalEsperadoVentas"=>$totalEsperadoVentas, "porcentajeTotalEjecutado"=>$porcentajeTotalEjecutado));
?>