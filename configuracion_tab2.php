<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($r1))
{
  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();

  $r1 = str_replace(".","",$r1);
  $r2 = str_replace(".","",$r2);
  $r3 = str_replace(".","",$r3);

  $actualizar = "UPDATE `tabla_descuentos` SET `rango1`= $r1, `rango2`= $r2, `rango3`= $r3 ,`descuento1`= $d1,`descuento2`= $d2 WHERE id = 1";

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
    echo "Datos actualizados";
  }

}

mysqli_close($mysqli);
?>