<?php
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
extract($_POST);


if(isset($hdd_id)) 
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

  $actualizar = "UPDATE `tabla_valores_cli_celebres` SET `porcentaje1`=$porc1,`porcentaje2`=$porc2,`cat1_1`=$array_valores[0],`cat1_2`=$array_valores[1],`cat2_1`=$array_valores[2],`cat2_2`=$array_valores[3],`cat3_1`=$array_valores[4],`cat3_2`=$array_valores[5],`cat4_1`=$array_valores[6],`cat4_2`=$array_valores[7],`cat5_1`=$array_valores[8],`cat5_2`=$array_valores[9] WHERE id = $hdd_id"; 
  
  if($mysqli->query($actualizar))
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
    echo $actualizar;
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