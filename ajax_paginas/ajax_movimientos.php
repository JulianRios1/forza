<?php 
include('../conexion.php');
include('../includes/parametros.php');
extract($_POST);

$mes_actual = date('m');
$ano_actual = date('Y');
$consulta_add = '';
//echo "SELECT u.id, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS nombre, u.dir, u.cel, u.tel, u.mail, m.saldoPrepago, m.saldoEfectivo FROM usuarios u JOIN medicos m ON m.usuario_id = u.id WHERE u.id = ".$cliente;

/*----------  CONSULTAMOS EL CLIENTE  ----------*/
$resultado= $mysqli->query("SELECT u.id, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS nombre, u.dir, u.cel, u.tel, u.mail, m.saldoPrepago, m.saldoEfectivo FROM usuarios u JOIN medicos m ON m.usuario_id = u.id WHERE u.id = ".$cliente);
$row = mysqli_fetch_array($resultado);

?>
<div class="portlet light ">
    <div class="row">
        <div class="col-xs-4">
            <h3>Cliente:</h3>
            <ul class="list-unstyled">
                <li> <?php echo $row['nombre'] ?> </li>
                <li> <?php echo $row['dir'] ?>  </li>
                <li> <?php echo $row['cel'] ?>  </li>
                <li> <?php echo $row['tel'] ?>  </li>
                <li> <?php echo $row['mail'] ?>  </li>
            </ul>
        </div>

        <div class="col-xs-4 invoice-payment">
            <h3>Estado de cuenta:</h3>
            <ul class="list-unstyled">
                <li>
                    <strong>Creditos:</strong> <?php echo "$".number_format($row['saldoPrepago'],0,',','.')?> </li>
                <li>
                    <strong>Efectivo:</strong> <?php echo "$".number_format($row['saldoEfectivo'],0,',','.')?> </li>
                <li>
                    <strong>Total:</strong> <?php echo "$".number_format($row['saldoPrepago']+$row['saldoEfectivo'],0,',','.')?> </li>
            </ul>
        </div>
    </div>

    <div class="row pull-right">
    	<div class="col-xs-12">
			<div class="btn-group btn-group-solid">
                <a href="movimientos_estado_cuenta.php?cliente=<?php echo $cliente ?>&fecha_ini=<?php if(isset($fecha_ini)){ echo $fecha_ini;}else{ echo '';} ?>&fecha_fin=<?php if(isset($fecha_fin)){ echo $fecha_fin;}else{ echo '';} ?>" target="_blank()" class="btn red">
                    <i class="fa fa-file-pdf-o"></i> Exportar</a>
                <button type="button" class="btn green btn_consulta" id="<?php echo $row['id'] ?>;1;<?php echo $row['saldoPrepago']?>;<?php echo $row['saldoEfectivo']?>">
                    <i class="fa fa-arrow-down"></i> Consignar</button>
                <button type="button" class="btn purple btn_consulta" id="<?php echo $row['id'] ?>;2;<?php echo $row['saldoPrepago']?>;<?php echo $row['saldoEfectivo']?>">
                    <i class="fa fa-arrow-up"></i> Retirar</button>
            </div>
    	</div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th> Fecha / Hora </th>
                        <th> Cajero </th>
                        <th class="hidden-xs"> Descripción del movimiento </th>
                        <th class="hidden-xs"> Referencia </th>
                        <th> Tipo de saldo</th>
                        <th class="hidden-xs"> Valor </th>
                        <th> Bonificación </th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                //CREAMOS LA CONSULTA PARA FECHAS
                if(!empty($fecha_ini))
                {
                    $consulta_add .= " AND m.fecha >= '".$fecha_ini."' AND m.fecha <= '".$fecha_fin."'";
                }
                else
                {
                    $consulta_add .= "  AND MONTH(m.fecha) = ".$mes_actual." AND YEAR(m.fecha) = ".$ano_actual;
                }
                //echo "SELECT UPPER(CONCAT_WS(' ',u.nom,u.ape1, u.ape2)) AS usuario, m.* FROM movimientos m JOIN usuarios u ON m.usuarioRegistra = u.id WHERE m.medico = ".$cliente." $consulta_add ORDER BY m.fecha DESC";
                $resultado= $mysqli->query("SELECT UPPER(CONCAT_WS(' ',u.nom,u.ape1, u.ape2)) AS usuario, m.* FROM movimientos m JOIN usuarios u ON m.usuarioRegistra = u.id WHERE m.medico = ".$cliente." $consulta_add ORDER BY m.fecha DESC");
                $num_reg = mysqli_num_rows($resultado);

                if ($num_reg > 0) {

					while($row = mysqli_fetch_array($resultado))
					{
					?>
	                    <tr>
	                        <td> <?php echo $row['fecha'].' ('.$row['hora'].')' ?> </td>
	                        <td> <?php echo $row['usuario'] ?> </td>
	                        <td class="hidden-xs"> <?php echo $row['des_mov'] ?> </td>
	                        <td class="hidden-xs"> <?php echo tipo_transaccion($row['referencia']) ?> </td>
                            <td> <?php echo tipo_saldo($row['tipoSaldo']) ?></td>
	                        <td class="hidden-xs <?php if($row['tipoMov'] == 2){ echo "font-red-mint"; }?>"> $<?php echo number_format($row['valMov'],0,',','.') ?> </td>                            
	                        <td> $<?php echo number_format($row['bonificacion'],0,',','.') ?> </td>
	                    </tr>
					<?php
					}
				}
				else {
					?>
					<tr><td colspan="6">No existen registros</td></tr>
					<?php
				}?>
                </tbody>
            </table>
        </div>        
    </div>
	
	
    

</div>
<?php 

?>