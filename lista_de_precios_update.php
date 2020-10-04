<?php
$permisos = array(1);
include '../bd.php';
include_once('control_admin.php');
include_once('../funciones/fechas.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $GLOBAL_nombre_pagina?></title>
<!-- Estilos -->
<link rel="stylesheet" type="text/css" href="../css/intranet.css">
<link rel="stylesheet" type="text/css" href="../css/menu_intranet.css">
<link href="../funciones/PHPPaging.lib.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="../css/tcal.css" />
<link rel="stylesheet" type="text/css" href="../css/botones.css" />
<link rel="stylesheet" href="../font-awesome-4.2.0/css/font-awesome.min.css">
<script type="text/javascript" src="../js/tcal.js"></script> 

<!-- Javascript -->
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script type="text/javascript" src="../js/stayontop.js"></script>
<script language="javascript" src="../js/ajax.js"></script>
<script language="javascript" type="text/javascript" src="../js/archivos.js"></script>
<!-- ************************* VALIDACION ****************************-->
<!-- Estilo de los campos de error-->
<link rel="stylesheet" href="../validadorForm/css/validationEngine.jquery.css" type="text/css"/>
<!-- Script de los validadores-->
<script src="../validadorForm/js/languages/jquery.validationEngine-es.js" type="text/javascript" charset="utf-8">
</script>
<script src="../validadorForm/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
</script>

<script language="javascript">
$(document).ready(function() {	

	// Formulario y tipo de datos para el validador
	jQuery("#frm_cargar").validationEngine();
	//$("#registro").bind("jqv.field.result", function(event, field, errorFound, prompText){ console.log(errorFound) })

});
</script>
<!-- ************************* VALIDACION ****************************-->
<?php
if ($_FILES["arc_doc"]["name"] != "")
{
	$ano = $_POST["ano"];
	$mes =  $_POST["mes"];
	
	$eliminar = "DELETE FROM cartera_cliente WHERE mes = $mes AND ano = $ano";
	mysql_query($eliminar);

	
	include_once "../funciones/upload.php";
		
	if ($_FILES["arc_doc"]["name"] != "")
	{
		$adjunto = subir_archivo($_FILES["arc_doc"]["name"], $_FILES["arc_doc"]["size"], 2000000, $_FILES["arc_doc"]["tmp_name"], "archivos/");
	}
	
	$archivo = $adjunto;	
	
	//Abrimos el archivo en modo lectura
	$fp = fopen("archivos/$archivo","r");
	//Leemos linea por linea el contenido del archivo
	$i = $contador = 0;
	$nit = $compra = $pago = $descuento = $retencion = "";

	//Insertarmos el nombre del archivo a la base de datos
	$insercion = "INSERT INTO archivos_cargados(descripcion, fecha, hora, ano, mes) VALUES ('$archivo',CURRENT_DATE(),CURRENT_TIME, $ano, $mes)";
	mysql_db_query($bd_nombre, $insercion);
	
	
	while ($linea= fgets($fp,10000))
	{
		
		//Sustituimos las ocurrencias de la cadena que buscamos
		$linea = explode(";",$linea);
		
		$nit = $linea[0];
		$compra = $linea[1];
		$pago = $linea[2];
		$descuento = $linea[3];
		$retencion = $linea[4];
					
		$insercion = "INSERT INTO cartera_cliente(medico, mes, ano, compra, pago, descuento, retefuente) VALUES ('$nit', $mes, $ano, $compra, $pago, $descuento, $retencion)";

		if (mysql_db_query($bd_nombre, $insercion))
		{	
			$i++;
		}
		mysql_db_query($bd_nombre, "BEGIN");
		
		
	}
	fclose($fp);
	/* Eliminarmos el archivo subido */
	unlink("archivos/$archivo");
	
	?>
	<script>
	alert("Se Ingresaron <?php echo $i?> registros");
	document.location.href = "subir_datos.php";
	</script>
<?php
}
?>
</head>

<body>
<?php include_once('cabezote.php')?>

<div><?php include_once('menu.php')?></div>

	<div>
    <table width="100%" border="0">
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="center">
        <table width="93%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="box"><div class="left"></div>
              <div class="right"></div>
              <div class="heading">
                <h1><strong>ACTUALIZAR LISTA DE PRECIOS</strong></h1>
                <div align="right"></div>
              </div></td>
          </tr>
          <tr>
            <td class="box" valign="top" bgcolor="#eeeeee">
            <div class="content" align="left">
            <form action="importar_precios.php" method="post" enctype="multipart/form-data" id="frm_cargar" name="frm_cargar">
              <table width="100%" border="0">
                <tr>
                  <td align="left"><table width="0%" border="0">
                    <tr>
                      <td>Seleccionar Archivo: </td>
                      <td><input type="file" name="file" id="file" class="validate[required] text-input" />&nbsp;<button type="submit" id="submit" name="Import" class="boton medium green" data-loading-text="Loading..."><i class="fa fa-cloud-upload fa-lg" style="margin-right:5px"></i>Cargar</button></td>
                    </tr>
                    <tr>
                      <td colspan="2"></td>
                      </tr>
                  </table></td>
                </tr>
                <tr>
                  <td><hr /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>
			  		<table class="list" id="table1">
                        <thead>
                            <tr>
                                <td>Id</td>
                                <td>Producto</td>
                                <td>Description</td>
                                <?php
								for($i=0; $i<8; $i++)
								{
									?>
									<td>Lista <?php echo $i+1?></td>
									<?php
								}
								?>
                            </tr>	
                        </thead>
                        
                        <tbody>  
                        <?php
						$consulta = "SELECT producto.idproducto, producto.desproducto, categoria.descategoria, producto.valproducto,producto.valproducto2,producto.valproducto3,producto.valproducto4,producto.valproducto5,producto.valproducto6,producto.valproducto7,producto.valproducto8 FROM producto JOIN categoria ON producto.categoria_idcategoria = categoria.idcategoria ORDER BY idproducto";
						$resultado =  mysql_query($consulta, $conexion);
						while($registro = mysql_fetch_array($resultado))
						{
							?>                     	
                            <tr>
                                <td><?php echo $registro['idproducto']; ?></td>
                                <td><?php echo $registro['desproducto']; ?></td>
                                <td><?php echo $registro['descategoria']; ?></td>
                                <?php
                                for($i=0; $i<8; $i++)
                                {
									if($i==0)
									{
										
										$valor_producto = number_format($registro['valproducto'],0,',','.');
									}
									else
									{
										$contador= $i+1;
										$valor_producto = number_format($registro['valproducto'.$contador],0,',','.');
									}
                                    ?>
                                    <td><?php echo '$'.$valor_producto ?></td>
                                    <?php
                                }
                                ?>
                            </tr>                                    							
							<?php
						}
                        ?>
                        </tbody>
                    </table>
                  </td>
                </tr>
              </table>
            </form>
            <div id="div_listar"></div>
            <div id="div_oculto" style="display: none;"></div> 
            </div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
    </div>
<div><?php include_once('pie.php')?></div>


</body>
