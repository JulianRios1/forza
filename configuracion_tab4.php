<?php
@session_start();
include('conexion.php');

extract($_POST);

$error_ins = false;
$mysqli->autocommit(false);

foreach ($arrayDataParametros as $parametro)
{
  $actualizar = "UPDATE parametros SET valor = '".$parametro[1]."', activo = ".$parametro[2]." WHERE clave = '".$parametro[0]."'";

  if($mysqli->query($actualizar))
  { 
    $error_ins = false; 
  }else{  
    $error_ins = true;
    $mysqli->rollBack();
  }

  $mysqli->commit();
}

if ($error_ins == true)
{
  echo $actualizar;
}
else {
  echo "Datos actualizados";
}

mysqli_close($mysqli);
?>