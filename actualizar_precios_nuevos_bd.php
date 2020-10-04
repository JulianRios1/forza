<?php
@session_start();
include('conexion.php');

extract($_POST);

if(isset($_FILES['archivo_adjunto']['name']))
{
	$error_ins = false;
	$mysqli->autocommit(false);
	$respuesta = new stdClass();
	$fotoArchivo = $nombreArchivo ='';

	//$eliminar = "DELETE FROM cartera_usuarios WHERE mes = $mes AND ano = $ano";
	//$mysqli->query($eliminar);

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




	//$insertar = "INSERT INTO `archivos_cargados` (descripcion, fecha, hora, ano, mes)VALUES('$fotoArchivo', CURRENT_DATE(),CURRENT_TIME(), $ano, $mes)";

	//if($mysqli->query($insertar))
	//{ 
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
				$dato6 = $sheet->getCell("F".$row)->getValue();
				$dato7 = $sheet->getCell("G".$row)->getValue();
				$dato8 = $sheet->getCell("H".$row)->getValue();
				$dato9 = $sheet->getCell("I".$row)->getValue();
				$dato10 = $sheet->getCell("J".$row)->getValue();
				$dato11 = $sheet->getCell("K".$row)->getValue();

				$actualizar = "UPDATE productos SET valproducto=$dato4, valproducto2=$dato5,valproducto3=$dato6,valproducto4=$dato7,valproducto5=$dato8,valproducto6=$dato9,valproducto7=$dato10,valproducto8=$dato11 WHERE idproducto = $dato1";

				//$insertar = "INSERT INTO cartera_usuarios(cliente_doc, mes, ano, compra, pago, descuento, retefuente) VALUES ('$dato1', $mes, $ano, $dato2, $dato3, $dato4, $dato5)";
				if($mysqli->query($actualizar))
				{ 
					$error_ins = false;
					$numero_ingresos++;
				}else{  
					$error_ins = true;
					$mysqli->rollBack();
				}
		}
	/*}else{  
		$error_ins = true;
		$mysqli->rollBack();
	}*/

	$mysqli->commit();

	if ($error_ins == true)
	{
		echo $insertar;
	}
	else {
		echo "Archivo cargado con exito. Se actualizaron $numero_ingresos productos";
		unlink("$rutaArchivo");
	}
}

mysqli_close($mysqli);
?>