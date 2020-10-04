<?php

include ("../conexion.php");
	
	extract($_REQUEST);

	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){

		//SELECT u.id, UPPER(CONCAT_WS(' ',u.nom,u.ape1,u.ape2)) AS nombre FROM bitacora_acceso b JOIN usuarios u ON u.id = b.usuario_id JOIN medicos m ON u.id = m.usuario_id  WHERE YEAR(b.fecha) = 2018 AND MONTH(b.fecha) = 4 AND m.zona = 9 GROUP BY m.usuario_id
		//


		//////////////////////////////////////////////////////////////////////////////////
		//echo "SELECT CONCAT_WS(' ',u.nom,u.ape1,u.ape2) AS nombre FROM pedidos_productos pp JOIN pedidos p ON pp.pedido_idpedido = p.idpedido JOIN medicos m ON p.usuario_idusuario = m.usuario_id JOIN usuarios u ON m.usuario_id = u.id WHERE pp.producto_idproducto = $producto AND m.zona = $zona AND YEAR(p.fecpedido) = $ano AND MONTH(p.fecpedido) = $mes GROUP BY m.usuario_id";
		$resultado = $mysqli->query("SELECT CONCAT_WS(' ',u.nom,u.ape1,u.ape2) AS nombre FROM pedidos_productos pp JOIN pedidos p ON pp.pedido_idpedido = p.idpedido JOIN medicos m ON p.usuario_idusuario = m.usuario_id JOIN usuarios u ON m.usuario_id = u.id WHERE pp.producto_idproducto = $producto AND m.zona = $zona AND YEAR(p.fecpedido) = $ano AND MONTH(p.fecpedido) = $mes GROUP BY m.usuario_id");

		$numrows = mysqli_num_rows($resultado);

		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="warning">
					<th>Usuario</th>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($resultado)){

					?>
					<tr>
						<td><?php echo $row['nombre']; ?></td>					
					</tr>
					<?php
				}
				?>
			  </table>
			</div>
			<?php
		}
	}
?>