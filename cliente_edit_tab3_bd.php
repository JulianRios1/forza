<?php
@session_start();
include('conexion.php');

extract($_POST);
 
if(isset($univ_egresado))
{
  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();

  if(!isset($act_directorio))
  {
    $act_directorio = 0;
  }


  $actualizar = "UPDATE `medicos` SET `univ_egresado`= UPPER('$univ_egresado'), directorio = $act_directorio, titulo = UPPER('$titulo'), especializacion = UPPER('$especializacion'), especializacion2 = UPPER('$especializacion2'), especializacion3 = UPPER('$especializacion3'), univ_especial = UPPER('$univ_especial'), univ_especial2 = UPPER('$univ_especial2'), univ_especial3 = UPPER('$univ_especial3'), resena = UPPER('$resena') WHERE usuario_id = $hdd_id";

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
    echo "Datos editados con exito";
  }

}
else{
  echo "Los datos no fueron guardados";
}

mysqli_close($mysqli);
?>