<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($contacto))
{
  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();

  $actualizar_med = "UPDATE `medicos` SET `contacto`= $contacto, con_mes = '$mes_contacto', con_dia = '$dia_contacto' WHERE usuario_id = $hdd_id";

  if($mysqli->query($actualizar))
  { 
      $error_ins = false;    
  }else{  
    $error_ins = true;
    $mysqli->rollBack();
  }

  $mysqli->commit();
  
  if ($error_ins == true)
  {
    echo $actualizar_med;
  }
  else {
    echo "Datos editados con exito";
  }

}
else{
  echo "Los datos no fueron guardados";
}

mysqli_close($mysqli);
?>