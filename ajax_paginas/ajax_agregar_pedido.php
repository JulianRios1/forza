<?php

session_start();
$session_id= session_id();

if (isset($_POST['id'])){$id=$_POST['id'];}
if (isset($_POST['cantidad'])){$cantidad=$_POST['cantidad'];}
if (isset($_POST['precio_venta'])){$precio_venta=$_POST['precio_venta'];}

require_once ("../conexion.php");

if (!empty($id) and !empty($cantidad) and !empty($precio_venta))
{

	//BUSCAMOS SI EL PRODUCTO YA ESTA EN EL CARRITO
	$resultado = $mysqli->query("SELECT p.cantidad_tmp AS cantidad FROM pedido_tmp p WHERE p.session_id = '$session_id' AND p.id_producto = $id");
	$row_prod = mysqli_fetch_array($resultado);
	
	if($row_prod['cantidad'] > 0)
	{
		$nueva_cantidad = $row_prod['cantidad'] + $cantidad;
		$editar = "UPDATE pedido_tmp SET  cantidad_tmp = $nueva_cantidad WHERE id_producto = $id AND session_id = '$session_id'";
		$mysqli->query($editar);
	}
	else
	{
		$insertar = "INSERT INTO `pedido_tmp` (id_producto,cantidad_tmp,precio_tmp,session_id) VALUES ('$id','$cantidad','$precio_venta','$session_id')";
		$mysqli->query($insertar);
	}
	
}
if (isset($_GET['id']))//codigo elimina un elemento del array
{
	$id=intval($_GET['id']);

	$eliminar = "DELETE FROM pedido_tmp WHERE id_tmp = ".$id;
	$mysqli->query($eliminar);
}

//CONSULTAMOS SI EL PARAMETRO DE ESCOGER DESTINO DEL PEDIDO ESTÁ HABILITADO, Y SI ES ASÍ CARGAR EL SELECT CON TODA LA INFO
$destinos = array();

if(isset($_SESSION['SELECT_DESTINOS_PEDIDO'])){
	$valor_param = $_SESSION['SELECT_DESTINOS_PEDIDO'];
	$arr1 = explode(';',$valor_param);

	foreach($arr1 as $option){
		$arr2 = explode(',',$option);
		$destinos[$arr2[0]] = $arr2[1];
	}
}
?>
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
	<th>PRODUCTO</th>
	<th>CAT.</th>
	<th>CANT.</th>
	<th><span class="pull-right">PRECIO UNIT.</span></th>
	<th><span class="pull-right">PRECIO TOTAL</span></th>
	<th></th>
</tr>
</thead>
<?php
	$sumador_total=0;

	$sql= $mysqli->query ("SELECT t.*, p.desproducto, c.descategoria FROM pedido_tmp t JOIN productos p ON t.id_producto = p.idproducto JOIN categorias c ON p.categoria_idcategoria = c.idcategoria
where t.session_id= '".$session_id."'");
	$num_reg = mysqli_num_rows($sql);
	while ($row=mysqli_fetch_array($sql))
	{
		$id_tmp=$row["id_tmp"];
		$desproducto=$row['desproducto'];
		$descategoria=$row['descategoria'];		
		$cantidad=$row['cantidad_tmp'];

		$precio_venta=$row['precio_tmp'];
		$precio_venta_f=number_format($precio_venta,0,',','.');//Formateo variables

		$precio_total=$precio_venta*$cantidad;
		$precio_total_f=number_format($precio_total,0,',','.');//Precio total formateado

		$sumador_total+=$precio_total;//Sumador

		?>
		<tr>
			<td><?php echo $desproducto;?></td>
			<td><?php echo $descategoria;?></td>
			<td><?php echo $cantidad;?></td>
			<td><span class="pull-right"><?php echo $precio_venta_f;?></span></td>
			<td><span class="pull-right"><?php echo $precio_total_f;?></span></td>
			<td ><span class="pull-right"><a href="#" onclick="eliminar('<?php echo $id_tmp ?>')"><i class="glyphicon glyphicon-trash"></i></a></span></td>
		</tr>		
		<?php
	}

?>
<tr>
	<td colspan=4><span class="pull-right">TOTAL $</span></td>
	<td><span class="pull-right"><b><?php echo number_format($sumador_total,0,',','.');?></b></span></td>
	<td></td>
</tr>

</table>
<?php 
	if ($num_reg > 0) {
		?>
		<div class="portlet-body form">
	            <div class="form-body">
					<?php 
						if(count($destinos) > 0){
					?>
							<div class="form-group">
								<label>Destino del Pedido</label>
								<select class="form-control" id="destinos_pedido">
									<option value="">Selecciona una opción</option>
								<?php 
									foreach ($destinos as $clave => $valor){
								?>
									<option value="<?php echo $clave; ?>"><?php echo $valor; ?></option>
								<?php 
									}
								?>
								</select>
							</div>       
					<?php 
						}
					?>  
		        	<div class="form-group">
	                    <label>Observaciones</label>
	                    <textarea class="form-control" rows="3" id="observaciones" name="observaciones"></textarea>
	                    <input type="hidden" name="hdd_total" id="hdd_total" value="<?php echo $sumador_total ?>">
	                </div> 
	            </div>
	            <div class="form-actions" align="right">
	            	<button type="button" class="btn btn-md" name="accion" id="accion"> <i class="fa fa-check"></i> Enviar Orden</button>
	            </div>
		</div>
		
		<?php
	}
?>

<script>
//FORMULARIO QUE GUARDA PEDIDO
$('#accion').click(function(){
	var obs = $('#observaciones').val();
	var id_cliente = $("#hdd_cliente").val();
	var total = $("#hdd_total").val();

	var parametros_pedido = null;

	if($('#destinos_pedido').val() == undefined){//si no está cargado el select de destinos del pedido porque tiene el parametro apagado...
		parametros_pedido = {"id":id_cliente,"obs":obs,"total":total,"destino_pedido":""};
	}else{
		if($('#destinos_pedido').val() == ""){
			alert("El campo de destino del pedido es obligarotio.");
			$('#destinos_pedido').focus();
			return false;
		}else{
			parametros_pedido = {"id":id_cliente,"obs":obs,"total":total,"destino_pedido":$('#destinos_pedido').val()};
		}
	}

    $.ajax({
        type: "POST",
        url: "ajax_paginas/ajax_finalizar_pedido.php",
        data: parametros_pedido,
        beforeSend: function(objeto){
            $("#resultados").html("Mensaje: Enviando Pedido...");
        },
        success: function(datos){
            //$("#resultados").html(datos);
            //console.log(datos);
            if(datos == 0)
            {
            	$("#resultados").html('Enviado');
            	location.href= "pedido_add.php";
            }
            else
            {
            	$("#resultados").html('El correo no pudo ser enviado.');
            	setTimeout("location.href='pedido_add.php'", 5000);
            }
        }
    });
});
</script>