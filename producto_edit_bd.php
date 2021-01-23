<?php
@session_start();
include('conexion.php');

//llamamos las variables globales
require_once('global_var.php');

extract($_POST);

if(isset($nombre))
{
	$error_ins = false;
	$mysqli->autocommit(false);
	$respuesta = new stdClass();
	$fotoArchivo = $nombreArchivo ='';

	

	if(!empty($_FILES['foto']['name'])){

		$extensiones_aceptadas = array("jpg","gif","png");
		//ADJUNTAMOS LA IMAGEN
		$carpetaAdjunta=$GLOBALS['product_images_route'];

		// El nombre y nombre temporal del archivo que vamos para adjuntar
		$fotoArchivo=$_FILES['foto']['name'];
		$fotoTemporal=$_FILES['foto']['tmp_name'];

		$extension = strtolower(substr(strrchr($fotoArchivo, '.'), 1));
	  
		$info = @getimagesize($_FILES['foto']['tmp_name']); 
		$var_rand=rand(10000,999999)* rand(10000,999999); 
		$nombre_tem=md5($var_rand.$_FILES['foto']['name']); 
		$fotoArchivo=$nombre_tem.'.'.$extension; 

		$rutaArchivo=$carpetaAdjunta.$fotoArchivo;

		if (in_array($extension, $extensiones_aceptadas)) {
		  //Subimos defintivamente la foto
		  move_uploaded_file($fotoTemporal,$rutaArchivo);

		  	if(!empty($hdd_foto))
            {
              unlink($carpetaAdjunta.$hdd_foto);
            }
		}
		
	}
	else
	{
	   $fotoArchivo = $hdd_foto; 
	}

	//SUBIR ARCHIVO
	if(!empty($_FILES['archivo_adjunto']['name'])){

		$extensiones_aceptadas = array("doc","docx","xls","xlsx","pdf");
		//ADJUNTAMOS LA IMAGEN
		$carpetaAdjunta="../archivos/";

		// El nombre y nombre temporal del archivo que vamos para adjuntar
		$nombreArchivo=$_FILES['archivo_adjunto']['name'];
		$nombreTemporal=$_FILES['archivo_adjunto']['tmp_name'];

		$extension = strtolower(substr(strrchr($nombreArchivo, '.'), 1));
	  
		$info = @getimagesize($_FILES['archivo_adjunto']['tmp_name']); 
		$var_rand=rand(10000,999999)* rand(10000,999999); 
		$nombre_tem=md5($var_rand.$_FILES['archivo_adjunto']['name']); 
		$nombreArchivo=$nombre_tem.'.'.$extension; 

		$rutaArchivo=$carpetaAdjunta.$nombreArchivo;

		if (in_array($extension, $extensiones_aceptadas)) {
		  //Subimos defintivamente la foto
		  move_uploaded_file($nombreTemporal,$rutaArchivo);

		  	if(!empty($hdd_archivo))
            {
              unlink($carpetaAdjunta.$hdd_archivo);
            }
		}
		
	}
	else
	{
	   $nombreArchivo = $hdd_archivo; 
	}


	$recomendados =  '';

	if(isset($select_productos1))
	{
		for ($i = 0; $i < sizeof($select_productos1); $i++)
		{
			$recomendados .= $select_productos1[$i].';';
		}
	}

	$precio = str_replace(".","",$precio);
	$precio2 = str_replace(".","",$precio2);
	$precio3 = str_replace(".","",$precio3);
	$precio4 = str_replace(".","",$precio4);
	$precio5 = str_replace(".","",$precio5);
	$precio6 = str_replace(".","",$precio6);
	$precio7 = str_replace(".","",$precio7);
	$precio8 = str_replace(".","",$precio8);

	//if($promocion == true){ $promocion = 1;}else {$promocion = 0;}
	if(isset($agotado) && $agotado == true){ $agotado = 1;}else {$agotado = 0;}
	if(isset($inactivo) && $inactivo == true){ $inactivo = 1;}else {$inactivo = 0;}
	if(isset($destacado) && $destacado == true){ $destacado = 1;}else {$destacado = 0;}

	//$insertar = "INSERT INTO `productos` (, , , , , , , ,  , )VALUES(, ,  , , , , , ', , '$des_tab4' , '$des_tab5' , '$des_tab6' , '$des_tab7' , '$des_tab8' , '$des_tab9', '$h1', '$h2', '$h3', '$h4', '$h5', '$h6', '$title', )";

	$actualizar = "UPDATE `productos` SET categoria_idcategoria = $categoria, linea=$linea, laboratorio=$laboratorio, desproducto='$nombre', valproducto=$precio, valproducto2=$precio2, valproducto3=$precio3, valproducto4=$precio4, valproducto5=$precio5, valproducto6=$precio6, valproducto7=$precio7, valproducto8=$precio8, rutproducto='$fotoArchivo', agotado=$agotado, oculto=$inactivo,  destacado=$destacado, meta_producto='$meta', recomendados='$recomendados', archivo='$nombreArchivo', descripcion1='$des_tab2', descripcion2='$des_tab3', descripcion3='$des_tab4' , descripcion4='$des_tab5' , descripcion5='$des_tab6' , descripcion6='$des_tab7' , descripcion7='$des_tab8' , descripcion8='$des_tab9' , h1='$h1', h2='$h2', h3='$h3', h4='$h4', h5='$h5', h6='$h6', title='$title', description='$description' WHERE idproducto = $hdd_id";

	if($mysqli->query($actualizar))
	{ 
		$error_ins = false;
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
		echo "Producto actualizado con éxito";
	}

}

mysqli_close($mysqli);
?>