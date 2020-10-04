<?php
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
extract($_POST);


if(isset($ano)) 
{


  $error_ins = false;
  $mysqli->autocommit(false);
  
  $array_valores = array();

  for ($i=1; $i <= 5 ; $i++) { 

      if(${"val_".$i."_1"} == '')
      {
        $array_valores[] = 0;
      }else
      {
        $array_valores[] = str_replace(".","",${"val_".$i."_1"});
      }

      if(${"val_".$i."_2"} == '')
      {
        $array_valores[] = 0;
      }else
      {
        $array_valores[] = str_replace(".","",${"val_".$i."_2"});
      }

  } 

  if($porc1 =='')
  {
    $porc1 = 0;
  }

  if($porc2 =='')
  {
    $porc2 = 0;
  }

  $insertar = "INSERT INTO `tabla_valores_cli_celebres` (`ano`,`porcentaje1`,`porcentaje2`,`cat1_1`,`cat1_2`,`cat2_1`,`cat2_2`,`cat3_1`,`cat3_2`,`cat4_1`,`cat4_2`,`cat5_1`,`cat5_2`) VALUES ($ano, $porc1, $porc2, $array_valores[0],$array_valores[1],$array_valores[2],$array_valores[3],$array_valores[4],$array_valores[5],$array_valores[6],$array_valores[7],$array_valores[8],$array_valores[9] )";
  
  if($mysqli->query($insertar))
  {
    $error_ins = false;
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
    echo "Los datos fueron ingresados correctamente";
  }



}
else{
  echo 'Datos invalidos';
  //echo print_r($array_porcentajes);
}
?>