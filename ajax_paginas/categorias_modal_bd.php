<?php 
include('../conexion.php');

extract($_POST);

if(isset($action))
{
  if($action == "mostrar")
  {
    $output = array();

    $resultado = $mysqli->query("SELECT * FROM categorias WHERE idcategoria = $id");    
    $row = mysqli_fetch_array($resultado) ; 

    //$result = $mysqli->fetchAll();
    foreach($row as $rows)
    {
      $output["des"] = $row["descategoria"];
      $output["linea"] = $row["linea"];
    }
    echo json_encode($output);
  }

  if($action == 'Actualizar')
  {

    $error_ins = false;
    $mysqli->autocommit(false);

    $actualizar = "UPDATE `categorias` SET `descategoria` ='$des', `linea`= $linea WHERE idcategoria = $hdd_id";


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
      echo "Categoría editada con exito";
    }



  }

  if($action == 'Guardar')
  {

    $error_ins = false;
    $mysqli->autocommit(false);

    $insertar = "INSERT INTO `categorias` (`descategoria`, `linea`) VALUES ('$des', $linea)";


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
      echo "Categoría creada con exito";
    }

  }

  if($action == 'Eliminar')
  {

    $error_ins = false;
    $mysqli->autocommit(false);

    $eliminar = "DELETE FROM `categorias` WHERE idcategoria = $id";


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
      echo "Categoría eliminada con exito";
    }

  }
}
?>