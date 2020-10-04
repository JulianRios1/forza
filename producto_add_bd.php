<?php
@session_start();
include('conexion.php');

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
		$carpetaAdjunta="../imagenes_productos/";

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
		}
		else
		{
		   $fotoArchivo = ''; 
		}
	}

	//SUBIR ARCHIVO
	if(!empty($_FILES['archivo_adjunto']['name'])){

		$extensiones_aceptadas = array("doc","docx","png");
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
		}
		else
		{
		   $nombreArchivo = ''; 
		}
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
	$precio_promo = str_replace(".","",$precio_promo);

	if($meta == '') { $meta = 0;}
	if($precio_promo == '') { $precio_promo = 'NULL';}

	if(isset($promocion) && $promocion == true){ $promocion = 1;}else {$promocion = 0;}
	if(isset($agotado) && $agotado == true){ $agotado = 1;}else {$agotado = 0;}
	if(isset($inactivo) && $inactivo == true){ $inactivo = 1;}else {$inactivo = 0;}
	if(isset($destacado) && $destacado == true){ $destacado = 1;}else {$destacado = 0;}
	/*
	if($promocion == true){ $promocion = 1;}else {$promocion = 0;}
	if($agotado == true){ $agotado = 1;}else {$agotado = 0;}
	if($inactivo == true){ $inactivo = 1;}else {$inactivo = 0;}
	if($destacado == true){ $destacado = 1;}else {$destacado = 0;}*/

	$insertar = "INSERT INTO `productos` (categoria_idcategoria, linea, laboratorio, desproducto, valproducto, valproducto_anti, rutproducto, promocion, agotado, oculto, destacado,meta_producto, recomendados, archivo, descripcion1, descripcion2, descripcion3, descripcion4, descripcion5, descripcion6, descripcion7, descripcion8, h1, h2, h3, h4, h5, h6, title, description)VALUES($categoria, $linea,$laboratorio, '$nombre', $precio, $precio_promo, '$nombreArchivo', $promocion, $agotado, $inactivo, $destacado, '$meta', '$recomendados', '$nombreArchivo', '$des_tab2', '$des_tab3' , '$des_tab4' , '$des_tab5' , '$des_tab6' , '$des_tab7' , '$des_tab8' , '$des_tab9', '$h1', '$h2', '$h3', '$h4', '$h5', '$h6', '$title', '$description')";

	if($mysqli->query($insertar))
	{ 
		$error_ins = false;
	}else{  
		$error_ins = true;
		$mysqli->rollBack();
	}

	$mysqli->commit();

	if ($error_ins == true)
	{
		echo $insertar;
	}
	else {
		echo "Producto creado con éxito";
	}
	//,foto,,,,,promocion,,,,,archivo_adjunto,des_tab1,des_tab2,des_tab3,des_tab4,des_tab5,des_tab6,des_tab7,des_tab8,des_tab9,title,description,h1,h2,h3,h4,h5,h6

	//nombre,foto,laboratorio,categoria,linea,precio,promocion,,agotado,inactivo,destacado,archivo_adjunto,des_tab1,des_tab2,des_tab3,des_tab4,des_tab5,des_tab6,des_tab7,des_tab8,des_tab9,title,description,h1,h2,h3,h4,h5,h6
}

mysqli_close($mysqli);
?>