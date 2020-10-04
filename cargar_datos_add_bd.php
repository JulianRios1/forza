<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($mes))
{
	$error_ins = false;
	$mysqli->autocommit(false);
	$respuesta = new stdClass();
	$fotoArchivo = $nombreArchivo ='';

	$eliminar = "DELETE FROM cartera_usuarios WHERE mes = $mes AND ano = $ano";
	$mysqli->query($eliminar);

	if(!empty($_FILES['archivo_adjunto']['name'])){

		$extensiones_aceptadas = array("xls","xlsx");
		//ADJUNTAMOS LA IMAGEN
		$carpetaAdjunta="archivos/";

		// El nombre y nombre temporal del archivo que vamos para adjuntar
		$fotoArchivo=$_FILES['archivo_adjunto']['name'];
		$fotoTemporal=$_FILES['archivo_adjunto']['tmp_name'];

		$extension = strtolower(substr(strrchr($fotoArchivo, '.'), 1));
	  
		$info = @getimagesize($_FILES['archivo_adjunto']['tmp_name']); 
		$var_rand=rand(10000,999999)* rand(10000,999999); 
		$nombre_tem=md5($var_rand.$_FILES['archivo_adjunto']['name']); 
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




	$insertar = "INSERT INTO `archivos_cargados` (descripcion, fecha, hora, ano, mes)VALUES('$fotoArchivo', CURRENT_DATE(),CURRENT_TIME(), $ano, $mes)";

	if($mysqli->query($insertar))
	{ 
		$error_ins = false;

		$numero_ingresos = 0;

		require_once 'PHPExcel/Classes/PHPExcel.php';
		$archivo = $rutaArchivo;
		$inputFileType = PHPExcel_IOFactory::identify($archivo);
		$objReader = PHPExcel_IOFactory::createReader($inputFileType);
		$objPHPExcel = $objReader->load($archivo);
		$sheet = $objPHPExcel->getSheet(0); 
		$highestRow = $sheet->getHighestRow(); 
		$highestColumn = $sheet->getHighestColumn();
		for ($row = 1; $row <= $highestRow; $row++){ 
				/*echo $sheet->getCell("A".$row)->getValue()." - ";
				echo $sheet->getCell("B".$row)->getValue()." - ";
				echo $sheet->getCell("C".$row)->getValue();
				echo "<br>";*/

				$dato1 = $sheet->getCell("A".$row)->getValue();
				$dato2 = $sheet->getCell("B".$row)->getValue();
				$dato3 = $sheet->getCell("C".$row)->getValue();
				$dato4 = $sheet->getCell("D".$row)->getValue();
				$dato5 = $sheet->getCell("E".$row)->getValue();

				$insertar = "INSERT INTO cartera_usuarios(cliente_doc, mes, ano, compra, pago, descuento, retefuente) VALUES ('$dato1', $mes, $ano, $dato2, $dato3, $dato4, $dato5)";
				if($mysqli->query($insertar))
				{ 
					//tenemos que consultar primero cual es el id en usuarios 
					$resul = $mysqli->query("SELECT u.id FROM usuarios u WHERE u.documento = '".$dato1."'");
					$num_registros = mysqli_num_rows($resul);
					$row2 = mysqli_fetch_array($resul);

					if($num_registros > 0)
					{
						//ACTUALIZAMOS EL VALOR Y LA FECHA DEL ULTIMO CARGUE DE LAS COMPRAS
						$actualizar = "UPDATE `medicos` SET `valor_compras`= $dato2, `mes_compras` = $mes, `ano_compras` = $ano  WHERE usuario_id = ".$row2['id'];
						if($mysqli->query($actualizar))
						{
							$error_ins = false;
							$numero_ingresos++;
						}
						else{  
							$error_ins = true;
							$mysqli->rollBack();
						}
					}
					else
					{
						$error_ins = false;
						$numero_ingresos++;
					}
			
					
				}else{  
					$error_ins = true;
					$mysqli->rollBack();
				}
		}
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
		echo "Archivo cargado con exito. Se cargaron $numero_ingresos registros";
		unlink("$rutaArchivo");
	}
}

mysqli_close($mysqli);
?>