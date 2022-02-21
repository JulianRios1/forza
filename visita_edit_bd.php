<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($validar))
{
  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();


  $actualizar = "UPDATE `visitas` SET `accion`= '$accion', `observacion`= '$observacion', `prioridad`= '$prioridad', `contacto`= $contacto, `comentario`= '$comentario', `estado`= $validar, `usuario_id_com`= ".$_SESSION['idusuario'].", fecha_ver_com = CURRENT_TIMESTAMP() WHERE id = $hdd_id";

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
    echo $actualizar;
  }
  else {
    echo "Visita editada con exito";
  }

}

mysqli_close($mysqli);
?>