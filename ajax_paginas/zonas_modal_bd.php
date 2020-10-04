<?php 
include('../conexion.php');

extract($_POST);

if(isset($action))
{
  if($action == "mostrar")
  {
    $output = array();

    $resultado = $mysqli->query("SELECT * FROM zonas WHERE id = $id");    
    $row = mysqli_fetch_array($resultado) ; 

    //$result = $mysqli->fetchAll();
    foreach($row as $rows)
    {
      $output["zona"] = $row["id"];
      $output["des"] = $row["des"];
      $output["linea"] = $row["linea"];
      $output["id_vendedor"] = $row["id_vendedor"];
    }
    echo json_encode($output);
  }

  if($action == 'Actualizar')
  {

    $error_ins = false;
    $mysqli->autocommit(false);

    $actualizar = "UPDATE `zonas` SET `des` ='$des', `id_vendedor`=$vendedor, `linea`= $linea WHERE id = $hdd_id";


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
      echo "Zona editada con exito";
    }



  }

  if($action == 'Guardar')
  {

    $error_ins = false;
    $mysqli->autocommit(false);

    $insertar = "INSERT INTO `zonas` (`des`, `id_vendedor`, `linea`) VALUES ('$des', $vendedor, $linea)";


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
      echo "Zona creada con exito";
    }

  }

  if($action == 'Eliminar')
  {

    $error_ins = false;
    $mysqli->autocommit(false);

    $eliminar = "DELETE FROM `zonas` WHERE id = $id";


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
      echo "Zona eliminada con exito";
    }

  }
}
?>