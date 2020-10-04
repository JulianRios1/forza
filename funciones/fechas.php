<?php
//Devuelve el numero de meses entre dos fechas
function meses($fech_ini,$fech_fin) {

    $fIni_yr=substr($fech_ini,0,4);
    $fIni_mon=substr($fech_ini,5,2);
    $fIni_day=substr($fech_ini,8,2);

    //SEPARO LOS VALORES DEL ANIO, MES Y DIA PARA LA FECHA FINAL EN DIFERENTES
    //VARIABLES PARA SU MEJOR MANEJO
    $fFin_yr=substr($fech_fin,0,4);
    $fFin_mon=substr($fech_fin,5,2);
    $fFin_day=substr($fech_fin,8,2);

    $yr_dif=$fFin_yr - $fIni_yr;
    // echo "la diferencia de años es -> ".$yr_dif."<br>";
   
    //LA FUNCION strtotime NOS PERMITE COMPARAR CORRECTAMENTE LAS FECHAS
    //TAMBIEN ES UTIL CON LA FUNCION date
    if(strtotime($fech_ini) > strtotime($fech_fin)){
        echo 'ERROR -> la fecha inicial es mayor a la fecha final <br>';
        exit();
    }
    else{
       if($yr_dif == 1){
         $fIni_mon = 12 - $fIni_mon;
         $meses = $fFin_mon + $fIni_mon;
         return $meses;
         //LA FUNCION utf8_encode NOS SIRVE PARA PODER MOSTRAR ACENTOS Y
         //CARACTERES RAROS
         //echo utf8_encode("la diferencia de meses con un año de diferencia es -> ".$meses."<br>");
      }
      else{
          if($yr_dif == 0){
             $meses=$fFin_mon - $fIni_mon;
            return $meses;
            //echo utf8_encode("la diferencia de meses con cero años de diferencia es -> ".$meses.", donde el mes inicial es ".$fIni_mon.", el mes final es ".$fFin_mon."<br>");
         }
         else{
             if($yr_dif > 1){
               $fIni_mon = 12 - $fIni_mon;
               $meses = $fFin_mon + $fIni_mon + (($yr_dif - 1) * 12);
               return $meses;
               //echo utf8_encode("la diferencia de meses con mas de un año de diferencia es -> ".$meses."<br>");
            }
            else
               echo "ERROR -> la fecha inicial es mayor a la fecha final <br>";
               exit();
         }
      }
   }

}

function sumar_restar_dia($fecha,$dias)
{
  $nuevafecha = strtotime ( $dias.' day' , strtotime ( $fecha ) ) ;
  $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
   
  return $nuevafecha;
}

function sumarmeses ($fechaini, $meses)
{
  //recortamos la cadena separandola en
  //tres variables de dia, mes y año
  $dia=substr($fechaini,0,2);
  $mes=substr($fechaini,3,2);
  $anio=substr($fechaini,6,4);

   //Sumamos los meses requeridos
   $tmpanio=floor($meses/12);
   $tmpmes=$meses%12;
   $anionew=$anio+$tmpanio;
   $mesnew=$mes+$tmpmes;
 
  //Comprobamos que al sumar no nos hayamos
  //pasado del año, si es así incrementamos
  //el año
  if ($mesnew>12)
  {
    $mesnew=$mesnew-12;
    if ($mesnew<10)
    $mesnew="0".$mesnew;
    $anionew=$anionew+1;
  }
 
  //Ponemos la fecha en formato americano y la devolvemos
  if($dia == 31)
  {
    if($mesnew == 4 || $mesnew == 6 || $mesnew == 9 || $mesnew == 11 )
    {
      $dia = $dia-1;
    }
  }
 
  if($dia == 31 || $dia == 30 || $dia == 29)
  {   
    if($mesnew==2)
    {
      $dia = $dia-3;
    }
  }
 
 $fecha=date( "Y/m/d", mktime(0,0,0,$mesnew,$dia,$anionew) );
 return $fecha;
}

//funcion que traduce el numero de mes a español
function traducir_nombre_mes_corto($numero_mes)
{ 
  switch($numero_mes)
  {
    case 1:
      $nombre_mes_esp = "ENE";
      break;
    case 2:
      $nombre_mes_esp = "FEB";
      break;
    case 3:
      $nombre_mes_esp = "MAR";
      break;
    case 4:
      $nombre_mes_esp = "ABR";
      break;
    case 5:
      $nombre_mes_esp = "MAY";
      break;
    case 6:
      $nombre_mes_esp = "JUN";
      break;
    case 7:
      $nombre_mes_esp = "JUL";
      break;
    case 8:
      $nombre_mes_esp = "AGO";
      break;
    case 9:
      $nombre_mes_esp = "SEP";
      break;
    case 10:
      $nombre_mes_esp = "OCT";
      break;
    case 11:
      $nombre_mes_esp = "NOV";
      break;
    case 12:
      $nombre_mes_esp = "DIC";
      break;
    default:
      $nombre_mes_esp = "Err!";
  }
  
  return $nombre_mes_esp;
}

//funcion que traduce el numero de mes a español
function traducir_nombre_mes($numero_mes)
{ 
  switch($numero_mes)
  {
    case 1:
      $nombre_mes_esp = "Enero";
      break;
    case 2:
      $nombre_mes_esp = "Febrero";
      break;
    case 3:
      $nombre_mes_esp = "Marzo";
      break;
    case 4:
      $nombre_mes_esp = "Abril";
      break;
    case 5:
      $nombre_mes_esp = "Mayo";
      break;
    case 6:
      $nombre_mes_esp = "Junio";
      break;
    case 7:
      $nombre_mes_esp = "Julio";
      break;
    case 8:
      $nombre_mes_esp = "Agosto";
      break;
    case 9:
      $nombre_mes_esp = "Septiembre";
      break;
    case 10:
      $nombre_mes_esp = "Octubre";
      break;
    case 11:
      $nombre_mes_esp = "Noviembre";
      break;
    case 12:
      $nombre_mes_esp = "Diciembre";
      break;
    default:
      $nombre_mes_esp = "No seleccionado";
  }
  
  return $nombre_mes_esp;
}

//funcion q escribe la fecha (dd de mes de YYYY)
function escribir_fecha($fecha)
{
  $fecha_final = intval(substr($fecha, 8, 2))." de ".traducir_nombre_mes(intval(substr($fecha, 5, 2)))." de ".substr($fecha, 0, 4);
  
  return $fecha_final;
}

//calcula el ultimo dia del mes
function ultimo_dia($ano,$mes)
{ 
   if (((fmod($ano,4)==0) and (fmod($ano,100)!=0)) or (fmod($ano,400)==0)) 
   { 
       $dias_febrero = 29; 
   } 
   else 
   { 
       $dias_febrero = 28; 
   } 
   
   switch($mes) 
   { 
       case 1: return 31; break; 
       case 2: return $dias_febrero; break; 
       case 3: return 31; break; 
       case 4: return 30; break; 
       case 5: return 31; break; 
       case 6: return 30; break; 
       case 7: return 31; break; 
       case 8: return 31; break; 
       case 9: return 30; break; 
       case 10: return 31; break; 
       case 11: return 30; break; 
       case 12: return 31; break; 
   } 
} 

//DEVUELVE EL NUMERO DE DIAS DE UN MES
function dias_mes($mes, $ano)
{
   //Si la extensión que mencioné está instalada, usamos esa.
   if( is_callable("cal_days_in_month"))
   {
      return cal_days_in_month(CAL_GREGORIAN, $mes, $ano);
   }
   else
   {
      //Lo hacemos a mi manera.
      return date("d",mktime(0,0,0,$mes+1,0,$ano));
   }
}

//retorna la diferencia en dias entre dos fechas (YYYY-mm-dd)
function diferencia_en_dias($fecha_ini, $fecha_fin)
{
  if (strtotime($fecha_fin) > strtotime($fecha_ini))
  {
    $segundos = strtotime($fecha_fin)-strtotime($fecha_ini);
  }
  else if (strtotime($fecha_fin) < strtotime($fecha_ini))
  {
    $segundos = (strtotime($fecha_ini)-strtotime($fecha_fin)) * (-1);
  }
  else
  {
    $segundos = 0;
    return 0;
  }
  
  $dias = intval($segundos/(60*60*24));
  
  return $dias;
}
?>