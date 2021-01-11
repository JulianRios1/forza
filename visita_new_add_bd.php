<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($observacion))
{

  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();

  $literatura =  '';
  for ($i = 0; $i < sizeof($select_lite1); $i++)
  {
    $literatura .= $select_lite1[$i].';';
  }
  
  $obsequios =  '';
  for ($i = 0; $i < sizeof($select_obse1); $i++)
  {
    $obsequios .= $select_obse1[$i].';';
  }
  
  $productos =  '';
  for ($i = 0; $i < sizeof($select_muestra1); $i++)
  {
    $productos .= $select_muestra1[$i].';';
  }

  if($_SESSION["permiso_cambio_fecha"] == 1)
  {
    $fecha_visita = $fecha_visita;
  }else{
    $fecha_visita = date('Y-m-d');
  }

  $insertar = "INSERT INTO `visitas` (`usuario_id`, `fecha`, `hora`, `literatura`, `obsequios`, `muestra`, `observacion`,`accion`,`id_vendedor`, `contacto`, `prioridad`) VALUES ($hdd_id, '$fecha_visita', CURTIME(), '$literatura', '$obsequios', '$productos', '$observacion', '$accion', ".$_SESSION["idusuario"].", $contacto, '$prioridad')";


  if($mysqli->query($insertar))
  { 

    if($contacto == 2 || $contacto == 3)//si es consultorio cliente u oficina bihomedis, que si cambie la ultima fecha visita y la tenga en cuenta en el contador de clientes visitados del dashboard
    {
      //ACTUALIZAMOS LA ULTIMA VISITA
      $actualizar = "UPDATE medicos SET fecha_ult_vis = CURDATE()  WHERE usuario_id = $hdd_id";
      if($mysqli->query($actualizar))
      {
        $error_ins = false; 
      }else{  
        $error_ins = true;
        $mysqli->rollBack();
      }
    }
    else
    {
      $error_ins = false; 
    }

  }else{  
    $error_ins = true;
    $mysqli->rollBack();
  }

  $mysqli->commit();
  
  if ($error_ins == true)
  {
    echo $literatura;
  }
  else {
    echo "Visita creada con exito";
  }
  $mysqli->close();
}
?>