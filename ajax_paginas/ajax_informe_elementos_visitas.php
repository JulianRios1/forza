<?php
@session_start();
include ("../conexion.php");
include ('../includes/parametros.php');

$concepto = $_GET["concepto"];
$detalle = $_GET["detalle"];
$fechaInicial = $_GET["anhoInicial"]."-".$_GET["mesInicial"]."-".$_GET["diaInicial"];
$fechaFinal = $_GET["anhoFinal"]."-".$_GET["mesFinal"]."-".$_GET["diaFinal"];

$resultado = null;
$indice = 0;
$arrayIdsVisitas = array();

if($concepto == "1"){//literatura
    $resultado = $mysqli->query("SELECT id, literatura FROM visitas WHERE fecha BETWEEN '".$fechaInicial."' AND '".$fechaFinal."'");
}else{
    if($concepto == "2"){//obsequio
        $resultado = $mysqli->query("SELECT id, obsequios FROM visitas WHERE fecha BETWEEN '".$fechaInicial."' AND '".$fechaFinal."'");
    }else{
        if($concepto == "3"){//muestra médica
            $resultado = $mysqli->query("SELECT id, muestra FROM visitas WHERE fecha BETWEEN '".$fechaInicial."' AND '".$fechaFinal."'");
        }
    }
}

if($resultado){  
    while($row = mysqli_fetch_array($resultado)){		

        if($concepto == "1"){//literatura
            $arrayLiteraturas = explode(";", $row['literatura']);
            foreach ($arrayLiteraturas as $valor){
                if($valor == $detalle){
                    $arrayIdsVisitas[$indice] = $row['id'];
                }
            }
        }else{
            if($concepto == "2"){//obsequio
                $arrayObsequios = explode(";", $row['obsequios']);
                foreach ($arrayObsequios as $valor){
                    if($valor == $detalle){
                        $arrayIdsVisitas[$indice] = $row['id'];
                    }
                }
            }else{
                if($concepto == "3"){//muestra médica
                    $arrayMuestras = explode(";", $row['muestra']);
                    foreach ($arrayMuestras as $valor){
                        if($valor == $detalle){
                            $arrayIdsVisitas[$indice] = $row['id'];
                        }
                    }
                }
            }
        }

        $indice++;
    }
}

//armado del array final con las visitas que nos interesan
$indice = 0;
$todasVisitas = array();
$cadenaIdsVisitas = implode(",", $arrayIdsVisitas);

$resultado = $mysqli->query("SELECT v.id AS id, CONCAT(u2.nom,' ',u2.ape1,' (',u2.documento,')') AS empleado, tc.descripcion AS tipoContacto, 
    CONCAT(v.fecha,' ',v.hora) AS fechaHora, CONCAT(u1.nom,' ',u1.ape1,' (',u1.documento,')') AS medico
    FROM visitas v 
    JOIN usuarios u1 ON u1.id = v.usuario_id
    JOIN tipo_contactos tc ON tc.id = v.contacto
    JOIN usuarios u2 ON u2.id = v.id_vendedor
    WHERE v.id IN (".$cadenaIdsVisitas.");");

if($resultado){   
    while($row = mysqli_fetch_array($resultado)){		

        $ver = '<a href="visita_view.php?id_visita='.$row['id'].'" target="_blank" data-toggle="tooltip" data-placement="top" title="Ver" class="btn btn-primary btn-xs"><i class="fa fa-eye"></i></a>';
        
        $cadaVisita = array("id" => $row['id'], "empleado" => $row['empleado'], "tipoContacto" => $row['tipoContacto'], "fechaHora" => $row['fechaHora'], "medico" => $row['medico'], "ver" => $ver);
        $todasVisitas[$indice] = $cadaVisita;

        $indice++;
    }	
}

echo json_encode($todasVisitas);
?>