<?php
@session_start();
require_once('conexion.php');

//echo $_POST['title'];
extract($_POST);
$inicio;

$fecha = date($inicio); //inicializo la fecha con la hora

$nuevafecha = strtotime ( '+0 hour' , strtotime ( $fecha ) ) ;
$nuevafecha = strtotime ( '+30 minute' , $nuevafecha ) ; // utilizo "nuevafecha"
$nuevafecha = strtotime ( '+0 second' , $nuevafecha ) ; // utilizo "nuevafecha"
$nuevafecha = date ( 'Y-m-j H:i:s' , $nuevafecha );


if (isset($inicio) && isset($cliente)){

$error_ins = false;
$mysqli->autocommit(false);
$respuesta = new stdClass();
	
	$insertar = "INSERT INTO `agendas` (`medico`, `vendedor`, `observacion`, `color`, `inicio`, `fin`) VALUES ($cliente, ".$_SESSION["idusuario"].", '$observacion', '$color', '$inicio', '$nuevafecha')";


	if($mysqli->query($insertar))
	{ 
		$error_ins = false; 
	}else{  
		$error_ins = true;
		$mysqli->rollBack();
	}

	$mysqli->commit();

	if ($error_ins == true)
	{
		echo $insertar;
	}
	else {
		echo "Cita agendada";
	}

}
//header('Location: '.$_SERVER['HTTP_REFERER']);

	
?>