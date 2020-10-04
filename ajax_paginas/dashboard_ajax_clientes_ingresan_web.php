<?php

include ("../conexion.php");
	
	$zona = $_REQUEST['zona'];
	
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){

		//SELECT u.id, UPPER(CONCAT_WS(' ',u.nom,u.ape1,u.ape2)) AS nombre FROM bitacora_acceso b JOIN usuarios u ON u.id = b.usuario_id JOIN medicos m ON u.id = m.usuario_id  WHERE YEAR(b.fecha) = 2018 AND MONTH(b.fecha) = 4 AND m.zona = 9 GROUP BY m.usuario_id
		//


		//////////////////////////////////////////////////////////////////////////////////
		//echo "SELECT u.id, UPPER(CONCAT_WS(' ',u.nom,u.ape1,u.ape2)) AS nombre, m.fec_ult_pedido FROM bitacora_acceso b JOIN usuarios u ON u.id = b.usuario_id JOIN medicos m ON u.id = m.usuario_id  WHERE YEAR(b.fecha) = ".date('Y')." AND MONTH(b.fecha) = ".date('m')." AND m.zona = $zona GROUP BY m.usuario_id";
		$resultado = $mysqli->query("SELECT u.id, UPPER(CONCAT_WS(' ',u.nom,u.ape1,u.ape2)) AS nombre FROM bitacora_acceso b JOIN usuarios u ON u.id = b.usuario_id JOIN medicos m ON u.id = m.usuario_id  WHERE YEAR(b.fecha) = ".date('Y')." AND MONTH(b.fecha) = ".date('m')." AND m.zona = $zona GROUP BY m.usuario_id");

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