<?php
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
extract($_POST);


if(isset($hdd_ano)) 
{


  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();

  $eliminar = "DELETE FROM porcentajes_crecimiento WHERE zona=".$hdd_zona." AND ano = ".$hdd_ano;
  if($mysqli->query($eliminar))

  {
    $error_ins = false;

    for ($i=1; $i <=12 ; $i++) { 

      if($array_porcentajes[$i] != '')
      {
        $val_pesos = $array_porcentajes[$i];
      }
      else {
        $val_pesos = 0;
      }
     
      $insertar = "INSERT INTO `porcentajes_crecimiento` (`zona`,`porcentaje`,`pesos`,`mes`,`ano`) VALUES ($hdd_zona, $val_pesos, ".str_replace(".","",$array_pesos[$i]).", $i, $hdd_ano)";


      if($mysqli->query($insertar))
      { 

        $error_ins = false;   
      }else{  
        $error_ins = true;
        $mysqli->rollBack();
      }
    }

  }
  else
  {
    $error_ins = true;
      $mysqli->rollBack();
  }

  
  $mysqli->commit();
  
  if ($error_ins == true)
  {
    echo $insertar;
  }
  else {
    echo "Los datos fueron actualizados correctamente";
  }



}
else{
  echo 'Datos invalidos';
  //echo print_r($array_porcentajes);
}
?>