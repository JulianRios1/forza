<?php

require_once ("../conexion.php");
	
	$cliente = $_REQUEST['cliente'];
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){

		$q = $mysqli->real_escape_string(strip_tags($_REQUEST['q'], ENT_QUOTES));
		$aColumns = array('desproducto');//Columnas de busqueda
		$sTable = "productos p";
		$sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ') AND p.oculto = 0 ';
		}
		else
		{
			$sWhere = " WHERE p.oculto = 0 ";
		}


		include '../funciones/paginacion.php'; //include pagination file
		
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 8; //registros por hoja
		$adjacents  = 4; //
		$offset = ($page - 1) * $per_page;


		$resultado= $mysqli->query("SELECT count(*) AS numrows FROM $sTable  $sWhere");
        $row = mysqli_fetch_array($resultado);


		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = '../pedido_add.php';

		//CONSULTAMOS LA LISTA DE PRECIOS PARA EL CLIENTE
		//echo "SELECT m.listaPrecios FROM medicos m WHERE m.usuario_id = ".$cliente;
		$resultado = $mysqli->query("SELECT m.listaPrecios FROM medicos m WHERE m.usuario_id = ".$cliente);
		$row_lista = mysqli_fetch_array($resultado);

		if($row_lista['listaPrecios'] == 1 || $row_lista['listaPrecios'] == 0)
		{
			$lista = '';
		}
		else
		{
			$lista = $row_lista['listaPrecios'];
		}


		//////////////////////////////////////////////////////////////////////////////////
		//echo "SELECT p.idproducto, p.valproducto".$lista." AS valproducto, p.desproducto, c.descategoria FROM  $sTable LEFT JOIN categorias c ON p.categoria_idcategoria = c.idcategoria $sWhere ORDER BY p.desproducto LIMIT $offset,$per_page";
		$sql= $mysqli->query("SELECT p.idproducto, p.valproducto".$lista." AS valproducto, p.desproducto, c.descategoria FROM  $sTable LEFT JOIN categorias c ON p.categoria_idcategoria = c.idcategoria $sWhere ORDER BY p.desproducto LIMIT $offset,$per_page");

		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="warning">
					<th>Producto</th>
					<th>Categoría</th>
					<th><span class="pull-right">Precio</span></th>
					<th><span class="pull-right">Cant.</span></th>
					<th style="width: 36px;"></th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($sql)){
					$id_producto=$row['idproducto'];
					$precio_venta=$row['valproducto'];

					?>
					<tr>
						<td><?php echo $row['desproducto']; ?></td>
						<td><?php echo $row['descategoria']; ?></td>
						<td class='col-xs-2'>
							<div class="pull-right">
							<?php echo number_format($precio_venta,0,',','.') ?>
							<input type="hidden" class="form-control" style="text-align:right" id="precio_venta_<?php echo $id_producto; ?>"  value="<?php echo $precio_venta;?>" >
							</div>
						</td>
						<td class='col-xs-1'>
							<div class="pull-right">
							<input type="text" class="form-control sm" style="text-align:right" id="cantidad_<?php echo $id_producto; ?>"  value="1" >
							</div>
						</td>						
						<td ><span class="pull-right"><a href="#" onclick="agregar('<?php echo $id_producto ?>')"><i class="glyphicon glyphicon-plus"></i></a></span></td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=5><span class="pull-right"><?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>