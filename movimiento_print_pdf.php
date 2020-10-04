<?php
include('conexion.php');
include('funciones/fechas.php');
include('includes/parametros.php');

extract($_GET);
$mes_actual = date('m');
$ano_actual = date('Y');
$consulta_add = '';

if(!empty($fecha_ini))
{
	$consulta_add .= " AND m.fecha >= '".$fecha_ini."' AND m.fecha <= '".$fecha_fin."'";
	$fecha_incial = $fecha_ini;
	$fecha_final = $fecha_fin;
}
else
{
	$consulta_add .= "  AND MONTH(m.fecha) = ".$mes_actual." AND YEAR(m.fecha) = ".$ano_actual;
	$fecha_incial = date('Y-m-01');
	$fecha_final = date('Y-m-'.ultimo_dia(date('Y'),date('m')));
}


$resultado= $mysqli->query("SELECT u.id, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS nombre, u.dir, u.cel, u.tel, u.mail, m.saldoPrepago, m.saldoEfectivo FROM usuarios u JOIN medicos m ON m.usuario_id = u.id WHERE u.id = ".$cliente);
$row = mysqli_fetch_array($resultado);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Informe General </title>
	<style>
		*
		{
			margin:0;
			padding:0;
			font-family:Arial;
			font-size:10pt;
			color:#000;
		}
		body
		{
			width:100%;
			font-family:Arial;
			font-size:10pt;
			margin:0;
			padding:0;
		}
		table
		{

			border-spacing:0;
			border-collapse: collapse; 
		}

		#invoice_body table
		{
			border-left: 1px solid #ccc;
			border-top: 1px solid #ccc;
		}

		#invoice_body .resumen
		{
			border-right: 1px solid #ccc;
			border-bottom: 1px solid #ccc;
			padding: 5px;
		}
		
		#invoice_body .datos{
			padding: 5px;
			border-right: 1px solid #ccc;
		}
	</style>
    
    
</head>
<body>
<div id="wrapper">
    
    <div class="logo">
    	<img src="assets/layouts/layout/img/logo_grande.png" width="160px" style="padding-top: 50px;">
    </div>
    <div style="text-align:center; padding:0px;"><b>ESTADO DE CUENTA</b></div>

    	<div style="margin: 20px 0">
	    	<table width="98%">
	    		<tr>
	    			<td style="border: none;" width="50%">
						<p><?php echo $row['nombre'] ?></p>
						<p><?php echo $row['dir'] ?></p>
						<p><?php echo $row['tel'] ?></p>
	    			</td>
	    			<td style="border: 1px solid #ccc;padding: 5px" width="50%" valign="top">
						<div style="">
							<p><span style="margin-right: 10px">DESDE <?php echo $fecha_incial ?></span><span style="margin-left: 10px;">HASTA <?php echo $fecha_final ?></span></p><br>
							<p>Fecha Impresión: <?php echo date('d-m-Y') ?></p>
						</div>
	    			</td>
	    		</tr>
	    	</table>	
    	</div>

        <div id="invoice_body">
        <table style="width:98%">
            <tr style="background:#eee;" class="resumen">
                <td colspan="5" class="resumen" style=" text-align:left; padding-left:10px;" align="center"><b>RESUMEN</b></td>
            </tr>
            <tr>
            	<td colspan="5" class="resumen">
					<div style="float: left;"><?php echo 'Saldo Credito: $'.number_format($row['saldoPrepago'],0,',','.'); ?></div>
					<div style="float: left;"><?php echo 'Saldo Efectivo: $'.number_format($row['saldoEfectivo'],0,',','.'); ?></div>
					<div style="float: left;"><?php echo 'Saldo Total: $'.number_format($row['saldoPrepago']+$row['saldoEfectivo'],0,',','.'); ?></div>
            	</td>
            </tr>
            <tr style="background:#eee;">
            	<td class="resumen" width="60px">Fecha</td>
            	<td class="resumen" width="250px;">Descripción</td>
            	<td class="resumen">Referencia</td>
            	<td class="resumen">Valor</td>
            	<td class="resumen">Bonificación</td>
            </tr>
            <?php
        	$resultado= $mysqli->query("SELECT UPPER(CONCAT_WS(' ',u.nom,u.ape1, u.ape2)) AS cliente, m.* FROM movimientos m JOIN usuarios u ON m.usuarioRegistra = u.id WHERE m.medico = ".$cliente." $consulta_add ORDER BY m.fecha DESC");
            $num_reg = mysqli_num_rows($resultado);

            if ($num_reg > 0) {

				while($row = mysqli_fetch_array($resultado))
				{
				?>
	            <tr>
	            	<td class="datos"><?php echo $row['fecha'] ?></td>
	            	<td class="datos"><?php echo $row['des_mov'] ?></td>
	            	<td class="datos"><?php echo tipo_transaccion($row['referencia']) ?></td>
	                <td class="datos">
	                <?php 
	                if($row['tipoMov'] == 2)
					{
						$valMov = ($row['valMov']*-1);
					}
					else
					{
						$valMov = $row['valMov'];	
					}

					echo '$'.number_format($valMov,0,',','.');
					?></td>
	                <td class="datos"><?php echo '$'.number_format($row['bonificacion'],0,',','.'); ?></td>
	            </tr>

	            <?php 
	            }
	         }
	         else
	         {
	         	?>
				<tr><td colspan="5" class="datos">No hay registros</td></tr>
	         	<?php
	         }
	         ?>
			<tr><td colspan="5" style="border-top: 1px solid #ccc"></td></tr>
        </table>
        </div>
        <br />

	</div>
	
	
	<htmlpagefooter name="footer">
		<hr />
		<div id="footer">	
			<table>
				<tr><td>&copy; FORZA CRM </td></tr>
			</table>
		</div>
	</htmlpagefooter>
	<sethtmlpagefooter name="footer" value="on" />
	
</body>
</html>