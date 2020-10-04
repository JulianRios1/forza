<?php
@session_start();
include('../conexion.php');
include('../includes/parametros.php');

extract($_POST);
//$id = 1629;
//$action = 'consulta';

if(isset($action)) 
{
  if($action == 'cargar')
  {
    $output = '';
    $output .= '
     <table class="table table-striped table-hover table-bordered">
      <thead>
        <tr>
            <th>Documento</th>
            <th>Medico</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Contacto</th>
            <th></th>
        </tr>
      </thead>
      <tbody>
    ';
      $cons_zonas = '';

      if($_SESSION['rol_usu'] ==  1)
      {
          $resultado = $mysqli->query("SELECT id as zona FROM zonas z WHERE id_vendedor = ".$_SESSION["idusuario"]); 
          $zn='';
                          
          while($row_zon= mysqli_fetch_array($resultado))
          {
              $zn.= $row_zon['zona'].','; 
          }
          $cons_zonas = ' AND m.zona IN ('.substr ($zn , 0, -1 ).')';
          
      }

      $resultado = $mysqli->query("SELECT m.usuario_id, u.documento, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS medico, u.dir, u.tel, m.contacto FROM medicos m JOIN usuarios u ON m.usuario_id = u.id WHERE m.cliente_nuevo = 1 AND m.fechaCreacion >= DATE_SUB(NOW(), INTERVAL 3 MONTH) $cons_zonas");  
      $num_reg = mysqli_num_rows($resultado); 

      if($num_reg > 0)
      {
        while($row = mysqli_fetch_array($resultado))
        {
          $output .= '
          <tr>
           <td>'.$row["documento"].'</td>
           <td>'.$row["medico"].'</td>
           <td>'.$row["dir"].'</td>
           <td>'.$row["tel"].'</td>
           <td>'.$row["contacto"].'</td>
           <td align="center"><button type="button" id="'.$row["usuario_id"].'" class="btn btn-success btn-xs consultar"><i class="fa fa-check-circle" ></i> Validar</button></td>
          </tr>
          ';
        }
      }
      else
      {
        $output .= '
        <tr>
          <td align="center" colspan="6">No hay datos</td>
        </tr>
        ';
      }

    $output .= '</tbody></table>';
    echo $output;
  }

  //Con este codigo consultamos el cliente
  if($action == "consulta")
  {

    $output = array();
    //echo "SELECT td.tipo, u.documento, CONCAT_WS(' ',u.nom, u.ape1, u.ape2) AS nombre, e.descripcion AS especialidad, m.genero, u.dir, u.barrio, u.tel, mu.nombreMunicipio AS ciudad, u.cel, u.mail, z.des AS zona FROM usuarios u LEFT JOIN tipos_documentos td ON u.tipo_documento = td.id LEFT JOIN medicos m ON u.id = m.usuario_id LEFT JOIN especialidades e ON m.especialidad = e.id LEFT JOIN municipios mu ON u.ciudad_actual = mu.id LEFT JOIN zonas z ON z.id = m.zona WHERE u.id = ".$id;
    $resultado = $mysqli->query("SELECT td.tipo, u.documento, CONCAT_WS(' ',u.nom, u.ape1, u.ape2) AS nombre, e.descripcion AS especialidad, m.genero, u.dir, u.barrio, u.tel, mu.nombreMunicipio AS ciudad, u.cel, u.mail, z.des AS zona, m.hor, m.hijos, m.mes_cum, m.dia_cum, m.cond, m.hobby, m.proyecto, m.observacion FROM usuarios u LEFT JOIN tipos_documentos td ON u.tipo_documento = td.id LEFT JOIN medicos m ON u.id = m.usuario_id LEFT JOIN especialidades e ON m.especialidad = e.id LEFT JOIN municipios mu ON u.ciudad_actual = mu.id LEFT JOIN zonas z ON z.id = m.zona WHERE u.id = ".$id);    

    $row = mysqli_fetch_array($resultado) ; 

    foreach($row as $rows)
    {
      $output["tipo"] = utf8_encode($row["tipo"]);
      $output["documento"] = $row["documento"];
      $output["nombre"] = utf8_encode($row["nombre"]);
      $output["especialidad"] = utf8_encode($row["especialidad"]);
      $output["genero"] = genero($row["genero"]);
      $output["dir"] = $row["dir"];
      $output["barrio"] = utf8_encode($row["barrio"]);
      $output["tel"] = $row["tel"];
      $output["ciudad"] = utf8_encode($row["ciudad"]);
      $output["cel"] = $row["cel"];
      $output["mail"] = utf8_encode($row["mail"]);
      $output["zona"] = $row["zona"];
      $output["horario"] = $row["hor"];
      $output["hijos"] = sino($row["hijos"]);
      $output["mcum"] = $row["mes_cum"];
      $output["dcump"] = $row["dia_cum"];
      $output["condiciones"] = $row["cond"];
      $output["hobby"] = $row["hobby"];
      $output["proyecto"] = $row["proyecto"];
      $output["observaciones"] = $row["observacion"];
    }
    echo json_encode($output);
   }



  if($action == "Guardar")
  {
    $error_ins = false;
    $mysqli->autocommit(false);
    $respuesta = new stdClass();

    if($validar == true)
    {
      $valor_activo = 0;
    }
    else {
      $valor_activo = 1;
    }

    $actualizar = "UPDATE `medicos` SET `cliente_nuevo`= $valor_activo WHERE usuario_id = $id";

    if($mysqli->query($actualizar))
    {
      $error_ins = false; 
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
      echo "Cliente validado";
    }

  }


}
else{
  echo 'no hay nada';
}
?>