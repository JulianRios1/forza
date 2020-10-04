<?php 
include('../conexion.php');

extract($_POST);

if(isset($action))
{
  if($action == "mostrar")
  {
    $output = array();

    $resultado = $mysqli->query("SELECT * FROM obsequios WHERE id = $id");    
    $row = mysqli_fetch_array($resultado) ; 

    //$result = $mysqli->fetchAll();
    foreach($row as $rows)
    {
      $output["id"] = $row["id"];
      $output["descripcion"] = $row["descripcion"];
      $output["estado"] = $row["estado"];
    }
    echo json_encode($output);
  }

  if($action == 'Actualizar')
  {

    $error_ins = false;
    $mysqli->autocommit(false);

    $actualizar = "UPDATE `obsequios` SET `descripcion` ='$des',`estado` ='$estado'  WHERE id = $hdd_id";


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
      echo "Obsequio editado con exito";
    }



  }

  if($action == 'Guardar')
  {

    $error_ins = false;
    $mysqli->autocommit(false);

    $insertar = "INSERT INTO `obsequios` (`descripcion`,`estado`) VALUES ('$des','$estado')";


    if($mysqli->query($insertar))
    { 
      $error_ins = false; 
    }else{  
      $error_ins = true;
      $mysqli->rollBack();
    }

    $mysqli->commit();

    if ($error_ins == true)
    {
      echo $insertar;
    }
    else {
      echo "Obsequio creado con exito";
    }

  }

  if($action == 'Eliminar')
  {

    $error_ins = false;
    $mysqli->autocommit(false);

    $eliminar = "DELETE FROM `obsequios` WHERE id = $id";


    if($mysqli->query($eliminar))
    { 
      $error_ins = false; 
    }else{  
      $error_ins = true;
      $mysqli->rollBack();
    }

    $mysqli->commit();

    if ($error_ins == true)
    {
      echo $eliminar;
    }
    else {
      echo "Obsequio eliminado con exito";
    }

  }
}
?>