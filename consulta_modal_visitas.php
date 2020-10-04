<?php
include_once("conexion.php");

$id = $_REQUEST['empid'];
//$id = 123;
$i=0;

if($id) {
	$resultado = $mysqli->query("SELECT * FROM visitas v WHERE id=".$id);    

	/*while( $rows = mysqli_fetch_assoc($resultado) ) {
		$data = $rows;
	}*/
	while($row = mysqli_fetch_array($resultado)) 
	{ 
		//SACO LOS VALORES DE LA LITERATURAS
		$literarura = explode(";",$row['literatura']);
		$imp_literatura = '';
		
		for($i=0; $i<(sizeof($literarura)-1); $i++)
		{

			$resultado_lit = $mysqli->query("SELECT descripcion FROM literaturas 
					WHERE id = ".$literarura[$i]);  
			$row2= mysqli_fetch_array($resultado_lit);
			
			$imp_literatura.= $row2['descripcion'].', ';
		}

		$obsequios = explode(";",$row['obsequios']);
		$imp_obsequios = '';
		
		for($i=0; $i<(sizeof($obsequios)-1); $i++)
		{

			$resultado_obs = $mysqli->query("SELECT descripcion FROM obsequios 
						WHERE id = ".$obsequios[$i]);  
			$row3= mysqli_fetch_array($resultado_obs);
				
			$imp_obsequios.= $row3['descripcion'].', ';
		
		}
		
		//SACO LOS VALORES DE LAS MUESTRA MEDICAS ENTREGADAS
		$muestra = explode(";",$row['muestra']);
		$imp_muestra = '';
		
		for($i=0; $i<(sizeof($muestra)-1); $i++)
		{

			$resultado_mue = $mysqli->query("SELECT desproducto, formafarmaceutica FROM productos
							WHERE idproducto = ".$muestra[$i]);  
			$row4= mysqli_fetch_array($resultado_mue);
				
			$imp_muestra.= $row4['desproducto'].'('.$row4['formafarmaceutica'].'), ';
		
		}
		
		//SACO EL TIPO DE CONTACTO
		$resultado_cat = $mysqli->query("SELECT descripcion FROM tipo_contactos WHERE id = ".$row['contacto']);  
		$row5 = mysqli_fetch_array($resultado_cat);


	    $id=$row['id'];
	    $fecha=$row['fecha'].' ('.$row['hora'].')';
	    $literatura=substr($imp_literatura,0,-2);
	    $obsequios=substr($imp_obsequios,0,-2);
	    $muestras=substr($imp_muestra,0,-2);
	    $contacto = $row5['descripcion'];
	    $observacion=$row['observacion'];
	    $accion=$row['accion'];
	    $comentario=$row['comentario'];

	    $data = array('id'=> $id, 'fecha'=> $fecha, 'literatura'=> $literatura, 'obsequios'=> $obsequios, 'muestras'=> $muestras, 'contacto'=> $contacto, 'observacion'=>$observacion, 'accion'=>$accion, 'comentario'=>$comentario);

	}
    echo json_encode($data);
	
} else {
	echo 0;	
}

?>

