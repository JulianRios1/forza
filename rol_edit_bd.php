<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($nomrol))
{
  $error_ins = false;
  $mysqli->autocommit(false);
  $respuesta = new stdClass();


  $fotoArchivo = $nombreArchivo ='';

  
  $actualizar = "UPDATE roles SET nomrol = '$nomrol' WHERE id = ".$hdd_id;
  $mysqli->query($actualizar);
  
    
  //ELIMINAMOS TODOS LOS PERMISOS
  $eliminar = "DELETE FROM permisos_roles WHERE rol_id = ".$hdd_id;
  if($mysqli->query($eliminar))
  {
    $error_ins = false;

     //ACTUALIZAMOS LOS PERMISOS
      for ($i = 0; $i < sizeof($_POST["chk_permisos"]); $i++)
      {
        $insertar = "INSERT INTO permisos_roles (permiso_id, rol_id) VALUES (".$_POST["chk_permisos"][$i].",".$_POST["hdd_id"].")";
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
  else
  {
    $error_ins = true;
      $mysqli->rollBack();
  }
  
  /*
  $eliminar = "DELETE FROM permiso_rol WHERE rol_idrol = ".$_POST["hdd_id"];
  $resultado = mysql_query($eliminar, $conexion);
  
  //ACTUALIZAMOS LOS PERMISOS
  for ($i = 0; $i < sizeof($_POST["chk_permisos"]); $i++)
  {
    $insertar = "INSERT INTO permiso_rol (permiso_idpermiso, rol_idrol) VALUES (".$_POST["chk_permisos"][$i].",".$_POST["hdd_id"].")";
    mysql_db_query($bd_nombre, $insertar);
  }



  $actualizar = "UPDATE `usuarios` SET `estado`=$estado,`tipo_documento`= $tipo_documento, `documento`= '$documento', `idrol`= $rol, `nom`= UPPER('$nom'), `ape1`= UPPER('$ape1'), `ape2`= UPPER('$ape2'), dir='$dir', tel='$tel', cel='$cel', mail=LOWER('$mail'), ciudad_actual='$municipio', usu='$usuario', puntos=$puntos, cambiar_fecha_visita=$cambiar_fecha_visita, avatar='$fotoArchivo' $contrasena WHERE id = $hdd_id";

  if($mysqli->query($actualizar))
  { 

    $error_ins = false;   

    $actualizar_med = "UPDATE `medicos` SET habilitado = $habilitado WHERE usuario_id =  $hdd_id";

    if($mysqli->query($actualizar_med))
    { 

      $error_ins = false; 
    }else{  
      $error_ins = true;
      $mysqli->rollBack();
    }
    
  }else{  
    $error_ins = true;
    $mysqli->rollBack();
  }
  */
  $mysqli->commit();
  
  if ($error_ins == true)
  {
    echo $insertar;
  }
  else {
    echo "Rol editado con exito";
  }

}

mysqli_close($mysqli);
?>