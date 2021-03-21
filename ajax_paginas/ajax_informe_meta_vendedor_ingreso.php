<?php
@session_start();
include('../conexion.php');

extract($_POST);

$error_ins = false;
$mysqli->autocommit(false);
$mensaje = "";
$bandera = 0;

//verificamos que no haya definido ya su meta en el mes para el cliente escogido
$resultado = $mysqli->query("SELECT *
                            FROM meta_vendedor
                            WHERE id_vendedor = ".$_SESSION["idusuario"]." AND id_cliente = ".$cliente." AND mes = ".$mes." AND ano = ".$ano);

if($resultado){  
    while($row = mysqli_fetch_array($resultado)){		

        $bandera = 1;
    }
}

if($bandera == 1){  
    $mensaje = "Ya fue definida una meta para el cliente en el mes y año actual. Intenta con uno diferente.";
}else{
    $insertar = "INSERT INTO `meta_vendedor` (`meta`, `id_vendedor`, `id_cliente`, `mes`, `ano`) VALUES ($meta, ".$_SESSION["idusuario"].", $cliente, $mes, $ano)";

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
        $mensaje = "Se ha presentado un error en el servidor. Intente más tarde.";
    }
    else {
        $mensaje = "Meta definida correctamente!";
    }
}

$mysqli->close();

echo json_encode(array("mensaje"=>$mensaje));
?>