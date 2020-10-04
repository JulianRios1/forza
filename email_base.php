<?php
@session_start();
include('conexion.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
extract($_POST);
  
$id = 19155;
//CONSULTAMOS LOS DATOS DE LA ORDEN DE PEDIDO
$resultado = $mysqli->query("SELECT p.idpedido, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS cliente, u.dir, u.cel, u.tel, u.mail, p.fecpedido, p.usuarioRegistra, p.estadopedido, p.observacion FROM pedidos p JOIN usuarios u ON p.usuario_idusuario = u.id WHERE p.idpedido = ".$id);
$row = mysqli_fetch_array($resultado);
$dato = $row['fecpedido'];
$fecha = date('Y-m-d',strtotime($dato));
$hora = date('H:i:s',strtotime($dato));
$usuario = explode(";", consulta_usuarios($row['usuarioRegistra']));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
      <title>Pedido <?php echo $row['idpedido'] ?></title>
      <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
      <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
      <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
      <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <link href="assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
      <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

      <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
      <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

      <link href="assets/pages/css/invoice.min.css" rel="stylesheet" type="text/css" />

      <link href="assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
      <link href="assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />
      <link href="assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    </head>
<body> 
<div class="page-content-wrapper">
  <div class="page-content">
    <div class="invoice">
        <div class="row invoice-logo">
            <div class="col-xs-6 invoice-logo-space">
                <img src="assets/layouts/layout/img/<?php echo $_SESSION["logo_cliente"]; ?>" class="img-responsive" alt="" /> </div>
            <div class="col-xs-6">
                <p> Orden #<?php echo $row['idpedido'] ?> / <?php echo escribir_fecha($fecha)?></p>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-xs-6">
                <h3>Cliente:</h3>
                <ul class="list-unstyled">
                    <li> <?php echo $row['cliente'] ?> </li>
                    <li> <?php echo $row['dir'] ?> </li>
                    <li> <?php echo $row['tel'] ?> </li>
                    <li> <?php echo $row['mail'] ?>  </li>
                </ul>
            </div>

            <div class="col-xs-6 invoice-payment">
                <h3>Detalle de la Orden:</h3>
                <ul class="list-unstyled">
                    <li>
                        <strong>Orden #:</strong> <?php echo $id ?> </li>
                    <li>
                        <strong>Fecha y Hora:</strong> <?php echo $row['fecpedido'] ?> </li>
                    <li>
                        <strong>Realizado por:</strong> <?php echo $usuario[0]?> </li>
                    <li>
                        <strong>Estado:</strong> <?php echo estados_pedidos($row['estadopedido']) ?> </li>
                </ul>

            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Prodcuto </th>
                            <th class="hidden-xs"> Categoria </th>
                            <th class="hidden-xs"> Cantidad </th>
                            <th class="hidden-xs"> Vlr Unitario </th>
                            <th> Total </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                    $subtotal = $total = '';
                    $resultado = $mysqli->query("SELECT pp.idpedido_producto, p.desproducto, c.descategoria, pp.cantpedido_producto, pp.valproducto FROM pedidos_productos pp JOIN productos p ON pp.producto_idproducto = p.idproducto JOIN categorias c ON p.categoria_idcategoria = c.idcategoria WHERE pp.pedido_idpedido = ".$id);
                    
                    while($row_p = mysqli_fetch_array($resultado))
                    {
                    ?>
                        <tr>
                            <td> <?php echo $i ?> </td>
                            <td> <?php echo $row_p['desproducto'] ?> </td>
                            <td class="hidden-xs"> <?php echo $row_p['descategoria'] ?> </td>
                            <td class="hidden-xs"> <?php echo $row_p['cantpedido_producto'] ?> </td>
                            <td class="hidden-xs"> $<?php echo number_format($row_p['valproducto'],0,',','.') ?></td>
                            <td> $<?php echo number_format($subtotal = ($row_p['cantpedido_producto'] * $row_p['valproducto']),0,',','.') ?> </td>
                        </tr>
                    <?php 
                    $total += $subtotal;
                    $i++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="note note-warning">
            <p> Observaciones: <?php echo $row['observacion'] ?> </p>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <div class="well">
                    <address>
                        <strong><?php echo $_SESSION["razon_social"] ?></strong>
                        <br/> <?php echo $_SESSION["direccion_empresa"] ?>
                        <br/> <?php echo $_SESSION["telefono_empresa"] ?>

                </div>
            </div>
            <div class="col-xs-8 invoice-block">
                <ul class="list-unstyled amounts">
                    <li>
                        <strong>Sub - Total:</strong> $<?php echo number_format($total,0,',','.'); ?> </li>
                    <li>
                        <strong>IVA:</strong> $0 </li>
                    <li>
                        <strong>Total:</strong> $<?php echo number_format($total,0,',','.'); ?> </li>
                </ul>
                <br/>
            </div>
        </div>
    </div>
  </div>
</div>

<footer>
  
</footer>
<script type="text/javascript">

</script>
</body>
</html>