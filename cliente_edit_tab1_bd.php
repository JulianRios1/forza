<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($tipo_documento))
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

  if(isset($municipio2))
  {
    $municipio2 = $municipio2;
  }else {
    $municipio2 = 'NULL';
  }

  if(!empty($mes))
  {
    $mes = $mes;
  }else {
    $mes = 'NULL';
  }

  if(!empty($dia))
  {
    $dia = $dia;
  }else {
    $dia = 'NULL';
  }

  if(!isset($cli_esp))
  {
    $cli_esp = 0;
  }

  if(!isset($cli_des))
  {
    $cli_des = 0;
  }

  $actualizar = "UPDATE `usuarios` SET `tipo_documento`= $tipo_documento, `documento`= '$documento', `nom`= UPPER('$nom'), `ape1`= UPPER('$ape1'), `ape2`= UPPER('$ape2'), dir=UPPER('$dir'), barrio=UPPER('$barrio1'), tel='$tel', cel='$cel', mail=LOWER('$mail'), ciudad_actual='$municipio'  WHERE id = $hdd_id";

  if($mysqli->query($actualizar))
  { 
    //ALISTAMOS LA INFORMACIÓN DE LOS MEDIOS DE INFORMACIÓN PREFERIDOS
    $medios_info = "";
    if(isset($mi_correo)){
      $medios_info = $medios_info.$mi_correo."|";
    }
    if(isset($mi_llamada)){
      $medios_info = $medios_info.$mi_llamada."|";
    }
    if(isset($mi_sms)){
      $medios_info = $medios_info.$mi_sms."|";
    }
    if(isset($mi_whatsapp)){
      $medios_info = $medios_info.$mi_whatsapp."|";
    }

    $medios_info = substr_replace($medios_info ,"", -1);

    //SI SE ACTUALIZO EL USUARIO CORRECTAMENTE AHORA ACTUALIZAMOS LA INFORMACION DETALLADA DEL MEDICO
    $actualizar_med = "UPDATE `medicos` SET `especialidad`= $especialidad, `genero`= '$genero', `dir`= UPPER('$dir'),`dir2`= UPPER('$dir2'), `barrio1`= UPPER('$barrio1'), `barrio2`= UPPER('$barrio2'), tel2='$tel2', ciudaddir2=$municipio2, zona=$zona, hor='$horario', mes_cum = $mes, dia_cum = $dia, hijos = $hijos, mail=LOWER('$mail'), cond='$condiciones', hobby='$hobby', proyecto='$proyecto', observacion='$observacion', habilitado=$habilitado, listaPrecios = $lista, `cliente_especial` = $cli_esp , `cliente_descuento` = $cli_des, medios_informacion='$medios_info' WHERE usuario_id = $hdd_id";

    if($mysqli->query($actualizar_med))
    {
      $error_ins = false; 
    }
    else
    {
      $error_ins = true;
      $mysqli->rollBack(); 
    }
   
  }else{  
    $error_ins = true;
    $mysqli->rollBack();
  }

  $mysqli->commit();
  
  if ($error_ins == true)
  {
    echo $actualizar_med;
  }
  else {
    echo "Cliente editado con exito";
  }

}

mysqli_close($mysqli);
?>