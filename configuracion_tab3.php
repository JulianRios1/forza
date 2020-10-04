<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($msg_1))
{
  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();

  for ($i=1; $i <= $num_msg ; $i++) { 
      
      $actualizar = "UPDATE `texto_correos` SET `texto`= '".${"msg_".$i}."' WHERE id = $i ";

      if($mysqli->query($actualizar))
      { 

          $error_ins = false; 
      }else{  
        $error_ins = true;
        $mysqli->rollBack();
      }

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