<?php
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
extract($_POST);


if(isset($hdd_ano)) 
{
  $error_ins = false;
  $mysqli->autocommit(false);

  if(isset($valor_boton))
  {
    if($valor_boton == 1)
    {
      for($i=0; $i<sizeof($cliente); $i++)
      {
        $actualizar = "UPDATE medicos SET tipo_cliente_celebre ='".$categoria[$i]."' WHERE usuario_id = '".$cliente[$i]."'"; 
        if($mysqli->query($actualizar))
        {
          $error_ins = false;
        }
        else
        {
          $error_ins = true;
          $mysqli->rollBack();
        }
        
      }
    }
    elseif($valor_boton == 2)
    {
      for($i=0; $i<sizeof($cliente); $i++)
      {
        $insertar = "INSERT INTO tabla_cierre_cli_celebres (medico, zona, cliente_celebre, rango1, rango2, compras, bono, trimestre, ano) VALUES ('".$cliente[$i]."', ".$hdd_zona.", ".$categoria[$i].", ".$rango1[$i].", ".$rango2[$i].", ".$total[$i].", ".$bono[$i].", ".$hdd_trimestre.", ".$hdd_ano.")";  
        if($mysqli->query($insertar))
        {
          $error_ins = false;
        }
        else
        {
          $error_ins = true;
          $mysqli->rollBack();
        }
      }
    }
  }
  else
  {
    $error_ins = true;
  }


  $mysqli->commit();
  
  if ($error_ins == true)
  {
    echo "Error";
  }
  else {
    echo "Los datos fueron actualizados correctamente";
  }



}
else{
  echo 'Datos invalidos';
  //echo print_r($cliente);
}
?>