<?php
@session_start();
include ("../conexion.php");
include('../includes/parametros.php');
/*=============================================
=     Si es un vendedor sacamos las zonas    =
=============================================*/
$cons_zonas = '';

if($_SESSION['rol_usu'] ==  1)
{
    $resultado = $mysqli->query("SELECT id as zona FROM zonas z WHERE id_vendedor = ".$_SESSION["idusuario"]); 
    $zn='';
                    
    while($row_zon= mysqli_fetch_array($resultado))
    {
        $zn.= $row_zon['zona'].','; 
    }
    $cons_zonas = ' AND m.zona IN ('.substr ($zn , 0, -1 ).')';
    
}


/*=====   Fin del comentario   ======*/


$resultado = $mysqli->query("SELECT u.id, u.documento, u.nom, u.ape1, u.ape2, u.mail, u.estado, u.usu, u.cel, u.puntos, r.nomrol FROM usuarios u JOIN roles r ON u.idrol = r.id WHERE u.id != 1 ");

$tabla = "";

while($row = mysqli_fetch_array($resultado)){		


	$editar = '<a href=\"usuario_edit.php?id='.$row['id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Editar\" class=\"btn btn-primary btn-xs\"><i class=\"fa fa-edit\"></i></a>';
	//$eliminar = '<a href=\"usuario_delete_bd.php?id='.$row['id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Editar\" class=\"btn btn-danger btn-xs\"><i class=\"fa fa-trash\"></i></a>';
	$eliminar = '<button type=\"button\" id=\"'.$row["id"].'\" class=\"btn btn-danger btn-xs eliminar\" title=\"Eliminar\"><i class=\"fa fa-trash\" ></i></button>';

	$tabla.='{
		"documento":"'.$row['documento'].'",
		"nombre":"'.ltrim(strtoupper($row['nom'].' '.$row['ape1'].' '.$row['ape2'])).'",
		"rol":"'.$row['nomrol'].'",
		"cel":"'.$row['cel'].'",
		"mail":"'.strtolower($row['mail']).'",
		"usuario":"'.$row['usu'].'",
		"estado":"'.estado_usuarios($row['estado']).'",
		"puntos":"'.$row['puntos'].'",
		"editar":"'.$editar.'",
		"eliminar":"'.$eliminar.'"
	},';	
}	

//eliminamos la coma que sobra
$tabla = substr($tabla,0, strlen($tabla) - 1);
echo '{"data":['.$tabla.']}';	
?>