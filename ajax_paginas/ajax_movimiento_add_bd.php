<?php
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
extract($_POST);

if(isset($accion)) 
{


  if($accion == "crear")
  {

    //CONSULTAMOS CUAL ES EL ULTIMO SALDO QUE TIENE
    $resultado = $mysqli->query("SELECT m.saldoPrepago,m.saldoEfectivo FROM medicos m WHERE m.usuario_id = $hdd_id"); 
    $row = mysqli_fetch_array($resultado);

    $saldo_credito_bd = $row['saldoPrepago'];
    $saldo_efectivo_bd = $row['saldoEfectivo'];
    $bonificacion = 0;
    $valor = str_replace(".","",$valor);


    if($tipo_operacion == 1)
    {
      if($tipo == 1)
      {
        //Si es una consignacion o pago en Efectivo
        if($tipo_con == 1 || $tipo_con == 2)
        {
          //Consultamos el porcentaje de beneficio
          $resultado= $mysqli->query("SELECT * FROM tabla_beneficios");
          $row = mysqli_fetch_array($resultado);

          
          if(($valor >= $row['rango1']) && ($valor <= $row['rango2']))
          {
            $bonificacion = ($valor * $row['descuento_r1'])/100;
            $valor = $valor + ceil($bonificacion);
            $saldo_prep = $saldo_prep + $valor;     
          }
          else if(($valor >= $row['rango3']) && ($valor <= $row['rango4']))
          {
            $bonificacion = ($valor * $row['descuento_r2'])/100;
            $valor = $valor + ceil($bonificacion);
            $saldo_prep = $saldo_prep + $valor;     
          }
          else if(($valor >= $row['rango5']) && ($valor <= $row['rango6']))
          {
            $bonificacion = ($valor * $row['descuento_r3'])/100;
            $valor = $valor + ceil($bonificacion);
            $saldo_prep = $saldo_prep + $valor;     
          }
          else{
            $saldo_prep = $saldo_prep + $valor;
          }
        }
        // Si es un Bono no suma bonificacion
        else if($tipo_con == 3)
        {
          $saldo_prep = $saldo_prep + $valor; 
        }
      }
      else if($tipo == 2)
      {
        //Asignamos el valor al saldo en efectivo
        $saldo_efec = $saldo_efec + $valor; 
      }

      $error_ins = false;
      $mysqli->autocommit(false);
      $respuesta = new stdClass();


      $insertar = "INSERT INTO `movimientos` (medico, des_mov, fecha, hora, tipoMov, valMov, bonificacion, usuarioRegistra, tipoSaldo, referencia) VALUES ($hdd_id,'$descripcion','$fecha',current_time(),$tipo_operacion,$valor,$bonificacion,".$_SESSION["idusuario"].",$tipo,$tipo_con)";

      if($mysqli->query($insertar))
      {

        $actualizar = "UPDATE `medicos` SET saldoPrepago=$saldo_prep, saldoEfectivo=$saldo_efec  WHERE usuario_id = $hdd_id";

        if($mysqli->query($actualizar))
        {
          $error_ins = false; 
        }
        else
        {
          $error_ins = true;
          $mysqli->rollBack(); 
        }
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
        echo "Movimiento exitoso;$hdd_id";
        exit;
      }

    }

    if($tipo_operacion == 2)
    {
      if($tipo == 1)
      {
        if($valor > $saldo_prep)
        {
          echo "No tiene saldo disponible para pagar la factura;$hdd_id";
          exit;
        }
        else
        {
          

          //Descontamos del Saldo de Prepago
          $saldo_prep = $saldo_prep - $valor;
          
          $insertar = "INSERT INTO `movimientos` (medico, des_mov, fecha, hora, tipoMov, valMov, bonificacion, usuarioRegistra, tipoSaldo, referencia) VALUES ($hdd_id,'$descripcion','$fecha',current_time(),$tipo_operacion,$valor,$bonificacion,".$_SESSION["idusuario"].",$tipo,$tipo_ret)";

          if($mysqli->query($insertar))
          {

            $actualizar = "UPDATE `medicos` SET saldoPrepago=$saldo_prep, saldoEfectivo=$saldo_efec  WHERE usuario_id = $hdd_id";

            if($mysqli->query($actualizar))
            {
              $error_ins = false; 
            }
            else
            {
              $error_ins = true;
              $mysqli->rollBack(); 
            }
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
            echo "Retiro exitoso;$hdd_id";
          }
        }
      }

      //SI es retiro de saldoEfectivo
      else if($tipo == 2)
      {


        if($valor > $saldo_efec)
        {
          echo "No tiene saldo suficiente;$hdd_id";
          exit;
        }
        else
        {
          //Descontamos del Saldo de Prepago
          $saldo_efec = $saldo_efec - $valor;
          

          $insertar = "INSERT INTO `movimientos` (medico, des_mov, fecha, hora, tipoMov, valMov, bonificacion, usuarioRegistra, tipoSaldo, referencia) VALUES ($hdd_id,'$descripcion','$fecha',current_time(),$tipo_operacion,$valor,$bonificacion,".$_SESSION["idusuario"].",$tipo,$tipo_ret)";

          if($mysqli->query($insertar))
          {

            $actualizar = "UPDATE `medicos` SET saldoPrepago=$saldo_prep, saldoEfectivo=$saldo_efec  WHERE usuario_id = $hdd_id";

            if($mysqli->query($actualizar))
            {
              $error_ins = false; 
            }
            else
            {
              $error_ins = true;
              $mysqli->rollBack(); 
            }
          }
          else
          {
            $error_ins = true;
            $mysqli->rollBack(); 
          }

        }

        $mysqli->commit();
          
        if ($error_ins == true)
        {
          echo $actualizar;
        }
        else {
          echo "Retiro exitoso;$hdd_id";
        }

      }
    }
  }
  else
  {
    echo 'No puede realizar la operacion';
  }

}
else{
  echo 'no hay nada-'.$accion;
}

$mysqli->close();
?>