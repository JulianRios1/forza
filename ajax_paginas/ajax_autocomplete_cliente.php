<?php
@session_start();
include ("../conexion.php");
include ('../includes/parametros.php');

$query = $_POST["query"];
$resultado = null;

if($_SESSION["rol_usu"] == 1){//si es vendedor, que se filtren los usuarios por las zonas
    $resultado = $mysqli->query("SELECT u.id, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS nombre FROM medicos m JOIN usuarios u ON m.usuario_id = u.id JOIN zonas z ON z.id = m.zona WHERE u.eliminado = 0 AND m.habilitado = 1 AND u.estado = 1 AND z.id_vendedor = ".$_SESSION["idusuario"]." AND UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) LIKE '%$query%' ORDER BY nombre");
}else{
    $resultado = $mysqli->query("SELECT u.id, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS nombre FROM medicos m JOIN usuarios u ON m.usuario_id = u.id WHERE u.eliminado = 0 AND m.habilitado = 1 AND u.estado = 1 AND UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) LIKE '%$query%' ORDER BY nombre");
}

if($resultado){   
    while($row = mysqli_fetch_array($resultado)){		
        echo "<a href='#' class='cliente-item list-group-item list-group-item-action border-1'>".$row['id']." - ".$row['nombre']."</a>";
    }	
}else{
    echo "<p class='list-group-item border-1'>No hay datos.</p>";
}
?>