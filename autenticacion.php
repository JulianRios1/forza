<?php  require_once("conexion.php");

$clave = $mysqli->real_escape_string(md5(sha1($_POST["password"])));
$usuario = $mysqli->real_escape_string($_POST["usuario"]);


//vemos si el usuario y contrasena es valido 
$resultado = $mysqli->query("SELECT u.id, u.nom, u.ape1, u.ape2, u.idrol, u.mail, u.avatar, u.cambiar_fecha_visita, u.ciudad_nomina  FROM usuarios u WHERE u.usu ='".$usuario."' AND u.pass ='".$clave."' AND u.estado = 1 AND idrol != 5");

$num_registros = mysqli_num_rows($resultado);

if ($num_registros > 0) 
{
    //defino una sesion y guardo datos 
    @session_start(); 
	$registro_usuario= mysqli_fetch_array($resultado);
	
	$_SESSION["autentica"] = "SIP"; 
	$_SESSION["idusuario"] = $registro_usuario["id"];
	$_SESSION["nomusu"] = $registro_usuario["nom"];
	$_SESSION["apeusu"] = $registro_usuario["ape1"].' '.$registro_usuario["ape2"];
	$_SESSION["rol_usu"] = $registro_usuario["idrol"];
	$_SESSION["email_usu"] = $registro_usuario["mail"];
	$_SESSION["avatar"] = $registro_usuario["avatar"];
	$_SESSION["sede"] = $registro_usuario["ciudad_nomina"];
	$_SESSION["permiso_cambio_fecha"] = $registro_usuario["cambiar_fecha_visita"];


	/*=============================================
	=        SAcamos los permisos del cargo       =
	=============================================*/
	$permisos = array();
	//CONSULTO LOS PERMISOS
	$resultado_rol = $mysqli->query("SELECT * FROM permisos_roles WHERE rol_id =".$registro_usuario["idrol"]);
	
	while($registro_rol= mysqli_fetch_array($resultado_rol))
	{
		array_push($permisos, $registro_rol["permiso_id"]);
	}
	
	// ENCAPSULAMOS LOS PERMISOS A UNA SESSION
	$_SESSION["permisos"] = $permisos;
	
	
	/*=====        FIN DEL BLOQUE       ======*/
	
	///////////////////////////////////////
	//CONSULTAMOS LOS DATOS DE LA EMPRESA//
	///////////////////////////////////////

	$resultado = $mysqli->query("SELECT * FROM datos_basicos_empresa");
	$row= mysqli_fetch_array($resultado);

	$_SESSION["razon_social"] = $row["razon_social"];
	$_SESSION["direccion_empresa"] = $row["direccion"];
	$_SESSION["telefono_empresa"] = $row["telefono"];
	$_SESSION["correo_saliente"] = $row["correo_saliente"];
	$_SESSION["web"] = $row["web"];
	$_SESSION["logo_cliente"] = $row["logo"];
    echo 1;

}
else 
{ 
    //si no existe lo enviamos al login
    echo 0;
} 
$mysqli->close();
?>