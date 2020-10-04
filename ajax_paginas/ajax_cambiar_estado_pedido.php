<?php
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
extract($_POST);

if(isset($id)) 
{


  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();


  $actualizar = "UPDATE `pedidos` SET estadopedido=$elegido WHERE idpedido = $id";

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
    echo "Pedido Actualizado";
  }



}
else{
  echo 'no hay nada-';
}
?>