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
    $municipio = NULL;
  }

  //if(isset($municipio2) && $municipio2 != ''){ $municipio2 = $municipio2;}else { $municipio2 = NULL;}
  $municipio2 = (trim($municipio2) != "") ? "'".$municipio2."'" : 'NULL';

  if(!isset($act_directorio))
  {
    $act_directorio = 0;
  }

  if(!isset($cli_esp))
  {
    $cli_esp = 0;
  }

  if(!empty($mes)){ $mes = $mes;}else { $mes = NULL;}

  if(!empty($dia)){ $dia = $dia;}else { $dia = NULL;}

  if(!empty($hijos)){ $hijos = $hijos;}else { $hijos = NULL; }
  if(!empty($dia_contacto)){ $dia_contacto = $dia_contacto;}else { $dia_contacto = NULL; }
  if(!empty($mes_contacto)){ $mes_contacto = $mes_contacto;}else { $mes_contacto = NULL; }
/*
mes_cum
dia_cum
hijos
con_dia
con_mes

 */

  $insertar = "INSERT INTO `usuarios` (`tipo_documento`, `documento`, `nom`, `ape1`, `ape2`, `dir`, `barrio`, `tel`,`cel`,`mail`, `ciudad_actual`, `idrol`, `estado`, `cuenta_activa`, avatar) VALUES ($tipo_documento, '$documento', UPPER('$nom'), UPPER('$ape1'), UPPER('$ape2'), UPPER('$dir'), UPPER('$barrio1'), '$tel', '$cel', LOWER('$mail'), '$municipio', 5, 1, 0, 'avatar.png')";


  if($mysqli->query($insertar))
  { 
    //CAPTURAMOS EL ID QUE SE LE DIO AL NUEVO USUARIO
    $id_cliente_nuevo = $mysqli->insert_id;

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

    //INSERTAMOS LOS DATOS DETALLADOS EN LA TABLA MEDICO
    $insertar_med = "INSERT INTO `medicos` (`usuario_id`, `especialidad`, `zona`,`dir`, `dir2`, `ciudaddir2`, `barrio1`, `barrio2`, `tel2`,`mes_cum`,`dia_cum`, `hor`, `hijos`, `genero`, `contacto`, `con_dia`, `con_mes`, `cond`, `hobby`, `observacion`, `proyecto`, `directorio`, `univ_egresado`, `titulo`, `especializacion`, `especializacion2`, `especializacion3`, `univ_especial`, `univ_especial2`, `univ_especial3`, `resena`, `fechaCreacion`, `listaPrecios`, `cliente_especial`, `cliente_nuevo`, `medios_informacion`) VALUES ($id_cliente_nuevo, $especialidad, $zona, UPPER('$dir'), UPPER('$dir2'), $municipio2, UPPER('$barrio1'), UPPER('$barrio2'),  '$tel2', $mes, $dia, '$horario', $hijos, '$genero', '$contacto', $dia_contacto, $mes_contacto, '$condiciones', '$hobby', '$observacion' , '$proyecto', $act_directorio, '$univ_egresado', '$titulo', '$especializacion', '$especializacion2', '$especializacion3', '$univ_especial' , '$univ_especial2', '$univ_especial3', '$resena', CURDATE(), $lista, $cli_esp, 1, '$medios_info')";

    if($mysqli->query($insertar_med))
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
    echo $insertar.' - '.$insertar_med;
  }
  else {
    echo "Cliente creado con exito";
  }

}

mysqli_close($mysqli);
?>