<?php
@session_start();
include('conexion.php');

extract($_POST);
$contrasena = '';

if(isset($tipo_documento))
{
  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();
  $fotoArchivo = $nombreArchivo ='';

  

  if(!empty($_FILES['foto']['name'])){

    $extensiones_aceptadas = array("jpg","gif","png");
    //ADJUNTAMOS LA IMAGEN
    $carpetaAdjunta="../imagenes_productos/";

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
    }
    else
    {
       $fotoArchivo = ''; 
    }
  }

  if(isset($municipio))
  {
    $municipio = $municipio;
  }else {
    $municipio = 'NULL';
  }

  $contra_format = '';
  if(!empty($pass))
  {
    $contra_format = md5(sha1($pass));
  }

  $insertar = "INSERT INTO `usuarios` (`estado`,`tipo_documento`, `documento`, `idrol`, `nom`, `ape1`, `ape2`, `dir`, `tel`, `cel`, `mail`, `ciudad_actual`, `usu`, `puntos`,`pass`,`avatar`) VALUES ($estado, $tipo_documento, $documento, $rol, UPPER('$nom'), UPPER('$ape1'), UPPER('$ape2'), '$dir', '$tel', '$cel', LOWER('$mail'), $municipio, '$usuario', 0,'$contra_format', '$fotoArchivo')";


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
    echo "Usuario creado con exito";
  }

}

mysqli_close($mysqli);
?>