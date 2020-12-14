<?php 
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
include('../funciones/fechas.php');

//llamamos las variables globales
require_once('../global_var.php');

//CONSULTA LA CEDULA Y DEVUELVE EL NOMBRE
function consulta_usuarios($id)
{
	$cliente='';
	
	if($id != '')
	{
		require('../conexion.php');
		$resultado = $mysqli->query("SELECT CONCAT_WS(' ',u.nom,u.ape1,u.ape2) AS nom_usuario, u.avatar FROM usuarios u WHERE u.id = ".$id);
		$row = mysqli_fetch_array($resultado);
		$cliente = $row["nom_usuario"].';'.$row["avatar"];
	}
	return $cliente;
}


extract($_POST);

$error_ins = false;
$mysqli->autocommit(false);
$respuesta = new stdClass();

$session_id = session_id();

//INSERTAMOS EL PEDIDO
$insertar = "INSERT INTO `pedidos` (`usuario_idusuario`, `estadopedido`, `iva`, `total`, `descuento`, `fecpedido`, `observacion`, `usuarioRegistra`) VALUES ($id, 2, 0, $total, 0, CURRENT_TIMESTAMP(), '$obs', '".$_SESSION["idusuario"]."')";

if($mysqli->query($insertar))
{ 
	//CAPTURAMOS EL ID DEL PEDIDO QUE SE ACABA DE GRABAR
	$id_pedido_nuevo = $mysqli->insert_id;

	//CONSULTAMOS EL PEDIDO DE LA TABLA TEMPORAL
	$sql= $mysqli->query ("SELECT t.id_producto, t.cantidad_tmp, t.precio_tmp FROM pedido_tmp t WHERE t.session_id = '".$session_id."'");
	$num_reg = mysqli_num_rows($sql);
	while ($row_tmp=mysqli_fetch_array($sql))
	{
		$producto_tmp = $row_tmp['id_producto'];
		$cantidad_tmp = $row_tmp['cantidad_tmp'];
		$precio_tmp = $row_tmp['precio_tmp'];

		//INSERTAMOS EL PEDIDO EN LA TABLA PEDIDOS_PRODUCTOS
		$insertar_pedido = "INSERT INTO `pedidos_productos` (`producto_idproducto`, `pedido_idpedido`, `cantpedido_producto`, `valproducto`, `estado`) VALUES ( $producto_tmp, $id_pedido_nuevo, $cantidad_tmp, $precio_tmp, 0)";
		if($mysqli->query($insertar_pedido))
		{
            //ACTUALIZAMOS LA FECHA DEL ULTIMO PEDIDO EN LA TABLA MEDICOS
            $actualizar = "UPDATE `medicos` SET `fec_ult_pedido`= CURRENT_TIMESTAMP() WHERE usuario_id = $id";

            if($mysqli->query($actualizar))
            { 
                $error_ins = false; 
            }
            else{
                $error_ins = true;
                $mysqli->rollBack(); 
            }
		}
		else
		{
		  $error_ins = true;
		  $mysqli->rollBack(); 
		}
	//$insertar_pedido = "INSERT INTO  (, , , , ) VALUES (NULL, ".$v["identificador"].", $no_pedido , ".$_POST["hdd_cantidad".$i].", ".$_POST["hdd_precio".$i].")";
	}

	

}else{  
$error_ins = true;
$mysqli->rollBack();
}

$mysqli->commit();

if ($error_ins == true)
{
	echo $insertar.' - '.$insertar_pedido;
}
else {
	//ELIMINAMOS EL PEDIDO DE LA TABLA TEMPORAL
	$eliminar = "DELETE FROM pedido_tmp WHERE session_id = '".$session_id."'";
    $mysqli->query($eliminar);

	//ENVIAMOS EL EMAIL
	
	//CONSULTAMOS LOS DATOS DE LA ORDEN DE PEDIDO
	$resultado = $mysqli->query("SELECT p.idpedido, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS cliente, u.dir, u.cel, u.tel, u.mail, p.fecpedido, p.usuarioRegistra, p.estadopedido, p.observacion FROM pedidos p JOIN usuarios u ON p.usuario_idusuario = u.id WHERE p.idpedido = ".$id_pedido_nuevo);
	$row = mysqli_fetch_array($resultado);
	$dato = $row['fecpedido'];
	$fecha = date('Y-m-d',strtotime($dato));
	$hora = date('H:i:s',strtotime($dato));
	$usuario = explode(";", consulta_usuarios($row['usuarioRegistra']));



    $i=1;
    $subtotal = $total = $tabla = '';
    $resultado = $mysqli->query("SELECT pp.idpedido_producto, p.desproducto, c.descategoria, pp.cantpedido_producto, pp.valproducto FROM pedidos_productos pp JOIN productos p ON pp.producto_idproducto = p.idproducto JOIN categorias c ON p.categoria_idcategoria = c.idcategoria WHERE pp.pedido_idpedido = ".$id_pedido_nuevo);
    
    while($row_p = mysqli_fetch_array($resultado))
    {
	    $tabla.='
	        <tr>
	            <td>'.$i.'</td>
	            <td>'.$row_p['desproducto'].'</td>
	            <td class="hidden-xs">'.$row_p['descategoria'].'</td>
	            <td class="hidden-xs">'.$row_p['cantpedido_producto'].'</td>
	            <td class="hidden-xs">'.number_format($row_p['valproducto'],0,',','.').'</td>
	            <td> $'.number_format($subtotal = ($row_p['cantpedido_producto'] * $row_p['valproducto']),0,',','.').'</td>
	        </tr>
	    ';

    	$total += $subtotal;
    	$i++;
    }

    $to = $GLOBALS['mail_to'];
	$subject = "PROCESAR PEDIDO No. ".$row['idpedido'];

	$htmlContent = '
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>[SUBJECT]</title>
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
		
		<style type="text/css">
        *
        {
            border: 0;
            box-sizing: content-box;
            color: inherit;
            font-family: inherit;
            font-size: inherit;
            font-style: inherit;
            font-weight: inherit;
            line-height: inherit;
            list-style: none;
            margin: 0;
            padding: 0;
            text-decoration: none;
            vertical-align: top;
        }

        /* content editable */

        *[contenteditable] { border-radius: 0.25em; min-width: 1em; outline: 0; }

        *[contenteditable] { cursor: pointer; }

        *[contenteditable]:hover, *[contenteditable]:focus, td:hover *[contenteditable], td:focus *[contenteditable], img.hover { background: #DEF; box-shadow: 0 0 1em 0.5em #DEF; }

        span[contenteditable] { display: inline-block; }

        /* heading */

        h1 { font: bold 100% sans-serif; letter-spacing: 0.5em; text-align: center; text-transform: uppercase; }

        /* table */

        table { font-size: 75%; table-layout: fixed; width: 100%; }
        table { border-collapse: separate; border-spacing: 2px; }
        th, td { border-width: 1px; padding: 0.5em; position: relative; text-align: left; }
        th, td { border-radius: 0.25em; border-style: solid; }
        th { background: #EEE; border-color: #BBB; }
        td { border-color: #DDD; }

        /* page */

        html { font: 16px/1 "Open Sans", sans-serif; overflow: auto; padding: 0.5in; }
        html { background: #999; cursor: default; }

        body { box-sizing: border-box; height: 11in; margin: 0 auto; overflow: hidden; padding: 0.5in; width: 8.5in; }
        body { background: #FFF; border-radius: 1px; box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5); }

        /* header */

        header { margin: 0 0 3em; }
        header:after { clear: both; content: ""; display: table; }

        header h1 { background: #000; border-radius: 0.25em; color: #FFF; margin: 0 0 1em; padding: 0.5em 0; }
        header address { float: left; font-size: 75%; font-style: normal; line-height: 1.25; margin: 0 1em 1em 0; }
        header address p { margin: 0 0 0.25em; }
        header span, header img { display: block; float: right; }
        header span { margin: 0 0 1em 1em; max-height: 25%; max-width: 60%; position: relative; }
        header img { max-height: 100%; max-width: 100%; }
        header input { cursor: pointer; -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)"; height: 100%; left: 0; opacity: 0; position: absolute; top: 0; width: 100%; }

        /* article */

        article, article address, table.meta, table.inventory { margin: 0 0 3em; }
        article:after { clear: both; content: ""; display: table; }
        article h1 { clip: rect(0 0 0 0); position: absolute; }

        article address { float: left; font-size: 125%; font-weight: bold; }

        /* table meta & balance */

        table.meta, table.balance { float: right; width: 36%; }
        table.meta:after, table.balance:after { clear: both; content: ""; display: table; }

        /* table meta */

        table.meta th { width: 40%; }
        table.meta td { width: 60%; }

        /* table items */

        table.inventory { clear: both; width: 100%; }
        table.inventory th { font-weight: bold; text-align: center; }

        table.inventory td:nth-child(1) { width: 26%; }
        table.inventory td:nth-child(2) { width: 38%; }
        table.inventory td:nth-child(3) { text-align: right; width: 12%; }
        table.inventory td:nth-child(4) { text-align: right; width: 12%; }
        table.inventory td:nth-child(5) { text-align: right; width: 12%; }

        /* table balance */

        table.balance th, table.balance td { width: 50%; }
        table.balance td { text-align: right; }

        /* aside */

        aside h1 { border: none; border-width: 0 0 1px; margin: 0 0 1em; }
        aside h1 { border-color: #999; border-bottom-style: solid; }

        /* javascript */

        .add, .cut
        {
            border-width: 1px;
            display: block;
            font-size: .8rem;
            padding: 0.25em 0.5em;  
            float: left;
            text-align: center;
            width: 0.6em;
        }

        .add, .cut
        {
            background: #9AF;
            box-shadow: 0 1px 2px rgba(0,0,0,0.2);
            background-image: -moz-linear-gradient(#00ADEE 5%, #0078A5 100%);
            background-image: -webkit-linear-gradient(#00ADEE 5%, #0078A5 100%);
            border-radius: 0.5em;
            border-color: #0076A3;
            color: #FFF;
            cursor: pointer;
            font-weight: bold;
            text-shadow: 0 -1px 2px rgba(0,0,0,0.333);
        }

        .add { margin: -2.5em 0 0; }

        .add:hover { background: #00ADEE; }

        .cut { opacity: 0; position: absolute; top: 0; left: -1.5em; }
        .cut { -webkit-transition: opacity 100ms ease-in; }

        tr:hover .cut { opacity: 1; }

        @media print {
            * { -webkit-print-color-adjust: exact; }
            html { background: none; padding: 0; }
            body { box-shadow: none; margin: 0; }
            span:empty { display: none; }
            .add, .cut { display: none; }
        }

        @page { margin: 0; }
      </style>

	</head>

	<body> 
	<header>
	    <h1>PEDIDO</h1>
	    <address contenteditable>
	        <p> Orden '.$row['idpedido'].' / '.escribir_fecha($fecha).'</p>
	        <p><b>Realizado por: / '.$usuario[0].'></p>
	        <p><b>Estado:</b> '.estados_pedidos($row['estadopedido']).'</p>
	    </address>
	    <span><img src="'.$GLOBALS['server'].'/assets/layouts/layout/img/'.$_SESSION["logo_cliente"].'" alt="" /></span>
	</header>

	<article>
    <h1>CLIENTE</h1>
    <address contenteditable>
        <p>'.$row['cliente'].'</p>
        <p>'.$row['dir'].'</p>
        <p>'.$row['tel'].'</p>
        <p>'.$row['mail'].'</p>
    </address>
    <table class="meta">
        <tr>
            <th><span contenteditable>Orden </span></th>
            <td><span contenteditable>'.$row['idpedido'].'</span></td>
        </tr>
        <tr>
            <th><span contenteditable>Fecha y Hora:</span></th>
            <td><span contenteditable>'.$row['fecpedido'].'</span></td>
        </tr>

    </table>
    <table class="inventory">
        <thead>
            <tr>
                <th><span contenteditable>#</span></th>
                <th><span contenteditable>Producto</span></th>
                <th><span contenteditable>Categoría</span></th>
                <th><span contenteditable>Cantidad</span></th>
                <th><span contenteditable>Vlr Unitario</span></th>
                <th><span contenteditable>Total</span></th>
            </tr>
        </thead>
        <tbody>';
            
            $htmlContent.= $tabla.'

        </tbody>
    </table>

    <table class="balance">
        <tr>
            <th><span contenteditable>Total</span></th>
            <td><span data-prefix>$</span><span>'.number_format($total,0,',','.').'</span></td>
        </tr>
    </table>
</article>
<aside>
    <h1><span contenteditable>Observaciones</span></h1>
    <div contenteditable>
        <p>'.$row['observacion'].'</p>
    </div>
</aside>


	</body>
</html>
	';

    $correo_cucuta="";
    if($_SESSION["sede"] == 831 )
    {
        $correo_cucuta = ",sucursalcucuta@bihomedis.com";
    }

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";


	// Additional headers
	$headers .= 'From: '.$GLOBALS['company'].' <'.$GLOBALS['mail_from'].'>' . "\r\n";
	//$headers .= 'Cc: desarollo@imatiml.com'. "\r\n";
    $headers .= "Bcc: ".$GLOBALS['mail_to1'].",".$GLOBALS['mail_to2'].",".$GLOBALS['mail_to3']."$correo_cucuta\r\n"; 


	// Send email
	if(mail($to,$subject,$htmlContent,$headers)){
	  echo "0";
	}else{
	  echo "1";  
	}
	//echo $htmlContent;
}
?>