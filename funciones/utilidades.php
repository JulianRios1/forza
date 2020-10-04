<?php 
//CONSULTA LA CEDULA Y DEVUELVE EL NOMBRE
function consulta_usuarios($id)
{
	$cliente='';
	
	if($id != '')
	{
		include ('conexion.php');
		$resultado = $mysqli->query("SELECT CONCAT_WS(' ',u.nom,u.ape1,u.ape2) AS nom_usuario, u.avatar FROM usuarios u WHERE u.id = ".$id);
		$row = mysqli_fetch_array($resultado);
		$cliente = $row["nom_usuario"].';'.$row["avatar"];
	}
	return $cliente;
}

//CONSULTA EL DEPARTAMENTO DE LA CIUDAD 
function consulta_departamento($ciudad)
{
	if($ciudad != '')
	{
		include 'conexion.php';
		$resultado = $mysqli->query("SELECT * FROM municipios m WHERE m.id = ".$ciudad);
		$row = mysqli_fetch_array($resultado);
		$departamento_id = $row["departamento_id"];
	}
	else{
		$departamento_id = '';
	}
	return $departamento_id;
}

function calcula_tiempo($time)
{
	//COLOCAR HORA EN UNIX
	//calcula_tiempo(strtotime(date('2017-03-22 08:10:00')))
    $periodos = array("segundo", "minuto", "hora", "día", "semana", "mes", "año", "década");
    $duraciones = array("60","60","24","7","4.35","12","10");
    $now = time();
    $diferencia = $now - $time;
 
    for($j = 0; $diferencia >= $duraciones[$j] && $j < count($duraciones)-1; $j++) {
        $diferencia /= $duraciones[$j];
    }
    $diferencia = round($diferencia);
 
    if($diferencia != 1) {
        if($j != 5){
            $periodos[$j].= "s";
        }else{
            $periodos[$j].= "es";
        }
    }
 	
   return "hace $diferencia $periodos[$j]";
}

function color_random() {
    return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
}


function regla_tres($valor, $porcentaje){

	$resultado = ($valor*$porcentaje)/100;

	return $resultado;
}
?>
