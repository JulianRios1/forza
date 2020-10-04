<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($nom))
{
  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();

  if(isset($municipio))
  {
    $municipio = $municipio;
  }else {
    $municipio = 'NULL';
  }

  $fotoArchivo = $nombreArchivo ='';

  

  if(!empty($_FILES['foto']['name'])){

    $extensiones_aceptadas = array("jpg","gif","png");
    //ADJUNTAMOS LA IMAGEN
    $carpetaAdjunta="assets/layouts/layout/img/";

    // El nombre y nombre temporal del archivo que vamos para adjuntar
    $fotoArchivo=$_FILES['foto']['name'];
    $fotoTemporal=$_FILES['foto']['tmp_name'];

    $extension = strtolower(substr(strrchr($fotoArchivo, '.'), 1));
    
    $info = @getimagesize($_FILES['foto']['tmp_name']); 
    $var_rand=rand(10000,999999)* rand(10000,999999); 
    $nombre_tem=md5($var_rand.$_FILES['foto']['name']); 
    $fotoArchivo=$nombre_tem.'.'.$extension; 

    $rutaArchivo=$carpetaAdjunta.$fotoArchivo;

    if (in_array($extension, $extensiones_aceptadas)) {
      //Subimos defintivamente la foto
      move_uploaded_file($fotoTemporal,$rutaArchivo);

        if(!empty($hdd_foto))
        {
          unlink($carpetaAdjunta.$hdd_foto);
        }
    }
    
  }
  else
  {
     $fotoArchivo = $hdd_foto; 
  }

  $actualizar = "UPDATE `datos_basicos_empresa` SET `nit`= '$nit', `razon_social`= '$nom',`representante`= '$rep',`documento`= '$doc_rep',`direccion`= '$dir',`telefono`= '$tel',`web`= '$web',`logo`= '$fotoArchivo',`correo_saliente`= '$mail',`ciudad`= '$municipio' ";

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