<?php
include_once('../bd.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<?php
    echo $bd_nombre;
    echo $actualizar;
if($_POST['hdd_accion'] == 'actualizar')
{
	$val1 = $_POST['val1'];
	$val2 = $_POST['val2'];
	
	$actualizar = "UPDATE producto SET valproducto=$val2 WHERE valproducto = ".$val1;
		
	if (!mysql_db_query($bd_nombre))
	{
		?>
        <script>
		alert('No se realizaron los cambios');
		</script>
        <?php
	}
	else
	{
		?>
        <script>
		alert('Se realizaron los cambios exitosamente');
		</script>
        <?php
	}
}
?>
<script>
function cambioPrecios(){
	
	if(document.form_cambios.val1.valued != '' && document.form_cambios.val1.value != "")
	{
		document.form_cambios.hdd_accion.value = 'actualizar';
		document.form_cambios.submit();
		
	}
	else
	{
		alert('Algunos campos estan vacios');
	}
	
}
</script>
</head>

<body>
<form action="" method="post" name="form_cambios" id="form_cambios">
<table width="300px" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Precio Antiguo</td>
    <td><label for="val1"></label>
      <input type="text" name="val1" id="val1" /></td>
  </tr>
  <tr>
    <td>Precio Nuevo</td>
    <td><label for="val2"></label>
      <input type="text" name="val2" id="val2" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><input type="button" name="button" id="button" value="Cambiar Precios" onclick="cambioPrecios();" /></td>
  </tr>
</table>
<input name="hdd_accion" type="hidden" value="" />
</form>
</body>
</html>