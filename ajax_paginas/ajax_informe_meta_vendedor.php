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
$mejor_venta = null;
$promedio_actual = null;
$pronostico_vendedor = null;
$venta_actual = null;
$porcentaje_cumplimiento = null;


$indice = 0;
$clientes = array();

$resultado = $mysqli->query("SELECT u.id AS ide, m.id AS idem, u.documento AS documento, CONCAT('(',COALESCE(u.documento,''),') ',COALESCE(u.nom,''),' ',COALESCE(u.ape1,''),' ',COALESCE(u.ape2,'')) AS cliente
                            FROM medicos m
                            JOIN usuarios u ON u.id = m.usuario_id
                            JOIN meta_vendedor mv ON mv.id_cliente = m.id
                            WHERE m.zona = ".$zona." AND mv.id_vendedor = ".$vendedor." AND mv.mes = ".$mes." AND mv.ano = ".$ano."
                            ORDER BY cliente asc");

if($resultado){   
    while($row = mysqli_fetch_array($resultado)){		
        $resultado1 = $mysqli->query("SELECT MAX(c.compra) AS mejor_venta FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND ano IN (".$ano_last_last.",".$ano_last.",".$ano.")");
        if($resultado1){  
            while($row1 = mysqli_fetch_array($resultado1)){		

                $mejor_venta = $row1['mejor_venta'];
            }
        }

        $resultado2 = $mysqli->query("SELECT AVG(c.compra) AS promedio_actual FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND ano = ".$ano);
        if($resultado2){  
            while($row2 = mysqli_fetch_array($resultado2)){		

                $promedio_actual = $row2['promedio_actual'];
            }
        }

        $resultado3 = $mysqli->query("SELECT meta AS pronostico_vendedor FROM meta_vendedor WHERE id_vendedor = ".$vendedor." AND id_cliente = ".$row['idem']." AND mes = ".$mes." AND ano = ".$ano);
        if($resultado3){  
            while($row3 = mysqli_fetch_array($resultado3)){		

                $pronostico_vendedor = $row3['pronostico_vendedor'];
            }
        }

        $resultado4 = $mysqli->query("SELECT c.compra AS venta_actual FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND mes = ".$mes." AND ano = ".$ano);
        if($resultado4){  
            while($row4 = mysqli_fetch_array($resultado4)){		

                $venta_actual = $row4['venta_actual'];
            }
        }

        $porcentaje_cumplimiento = (intval($venta_actual)/intval($pronostico_vendedor)) * 100;
        if($porcentaje_cumplimiento <= 70){
            $porcentaje_cumplimiento_html = "<b style='color:red;'>".intval($porcentaje_cumplimiento)."%</b>";
        }else{
            if($porcentaje_cumplimiento > 70 && $porcentaje_cumplimiento <= 90){
                $porcentaje_cumplimiento_html = "<b style='color:orange;'>".intval($porcentaje_cumplimiento)."%</b>";
            }else{
                if($porcentaje_cumplimiento > 90){
                    $porcentaje_cumplimiento_html = "<b style='color:green;'>".intval($porcentaje_cumplimiento)."%</b>";
                }
            }
        }
        
        $cadaCliente = array("id" => $row['ide'], "cliente" => $row['cliente'], "mejor_venta" => $mejor_venta, "promedio_actual" => intval($promedio_actual), "pronostico_vendedor" => $pronostico_vendedor, "venta_actual" => $venta_actual, "porcentaje_cumplimiento" => $porcentaje_cumplimiento_html);
        $clientes[$indice] = $cadaCliente;

        $mejor_venta = null;
        $promedio_actual = null;
        $pronostico_vendedor = null;
        $venta_actual = null;
        $porcentaje_cumplimiento = null;

        $indice++;
    }	
}

echo json_encode($clientes);
?>