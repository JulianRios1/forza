<?php
include '../bd.php';
include_once "../funciones/upload.php";
		
	
if(isset($_POST["Import"])){
		
		if ($_FILES["file"]["name"] != "")
		{
			$adjunto = subir_archivo($_FILES["file"]["name"], $_FILES["file"]["size"], 2000000, $_FILES["file"]["tmp_name"], "archivos/");
		}

		//echo $filename=$_FILES["file"]["tmp_name"];
		

		 if($_FILES["file"]["size"] > 0)
		 {

		  	$file = fopen("archivos/$adjunto", "r");
	         while (($campo = fgetcsv($file, 10000, ";")) !== FALSE)
	         {
	    		$actualizar = "UPDATE producto SET valproducto=$campo[3], valproducto2=$campo[4],valproducto3=$campo[5],valproducto4=$campo[6],valproducto5=$campo[7],valproducto6=$campo[8],valproducto7=$campo[9],valproducto8=$campo[10] WHERE idproducto = $campo[0]";

	        	//we are using mysql_query function. it returns a resource on true else False on error
	          	$result = mysql_query( $actualizar, $conexion );
				if(! $result )
				{
					echo "<script type=\"text/javascript\">
							alert(\"Invalid File:Please Upload CSV File.\");
							window.location = \"lista_de_precios_update.php\"
						</script>";
				
				}

	         }
	         fclose($file);
	         //throws a message if data successfully imported to mysql database from excel file
	         echo "<script type=\"text/javascript\">
						alert(\"La lista de precios se actualizo correctamente.\");
						window.location = \"lista_de_precios_update.php\"
					</script>";
	        
			 

			 //close of connection
			mysql_close($conexion); 	
		 }
	}	 
?>		 