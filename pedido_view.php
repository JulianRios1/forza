<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = 'ordenes';

extract($_GET);

//CONSULTAMOS LOS DATOS DE LA ORDEN DE PEDIDO
$resultado = $mysqli->query("SELECT p.idpedido, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS cliente, u.dir, u.cel, u.tel, u.mail, p.fecpedido, p.usuarioRegistra, p.estadopedido, p.observacion FROM pedidos p JOIN usuarios u ON p.usuario_idusuario = u.id WHERE p.idpedido = ".$id);
$row = mysqli_fetch_array($resultado);

$dato = $row['fecpedido'];
$fecha = date('Y-m-d',strtotime($dato));
$hora = date('H:i:s',strtotime($dato));
$usuario = explode(";", consulta_usuarios($row['usuarioRegistra']));

?>

    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        
        <?php include('top_info.php');?>
        
        <div class="clearfix"> </div>

        <div class="page-container">

            <div class="page-sidebar-wrapper ">
                <?php include('menu_lat.php');?>    
            </div>

            <div class="page-content-wrapper">

                <div class="page-content">

                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.php">Inicio</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="pedidos.php">Ordenes</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="#">Orden de Pedido</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Orden de Pedido
                    </h3>
                    
                    <!-- ACA EMPIEZA EL CONTENIDO -->  
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Begin: life time stats -->
                            <div class="portlet light portlet-fit portlet-datatable bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-settings font-dark"></i>
                                        <span class="caption-subject font-dark sbold uppercase"> Orden #<?php echo $id; ?>
                                            <span class="hidden-xs">| <?php echo escribir_fecha($fecha)?>, <?php echo $hora; ?> </span>
                                        </span>
                                    </div>
                                    <div class="actions btn-set">
                                        <button type="button" name="regresar" class="btn btn-secondary-outline" onclick="window.location.href='pedidos.php'">
                                            <i class="fa fa-angle-left"></i> Regresar</button>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-pane active">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="portlet grey-cascade box">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-cogs"></i>Datos del Cliente </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name"> Nombre: </div>
                                                            <div class="col-md-7 value"> <?php echo $row['cliente'] ?></div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name"> Dirección: </div>
                                                            <div class="col-md-7 value"> <?php echo $row['dir'] ?> </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name"> Teléfono: </div>
                                                            <div class="col-md-7 value"> <?php echo $row['tel'] ?></div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name"> Email: </div>
                                                            <div class="col-md-7 value"> <?php echo $row['mail'] ?> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="portlet grey-cascade box">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-cogs"></i>Datos de la Orden </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name"> Orden #: </div>
                                                            <div class="col-md-7 value"> <?php echo $id ?></div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name"> Fecha y Hora: </div>
                                                            <div class="col-md-7 value"> <?php echo $row['fecpedido'] ?> </div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name"> Realizado por: </div>
                                                            <div class="col-md-7 value"><?php echo $usuario[0]?></div>
                                                        </div>
                                                        <div class="row static-info">
                                                            <div class="col-md-5 name"> Estado: </div>
                                                            <div class="col-md-7 value"> 
                                                                <select class="form-control" id="estado" name="estado">
                                                                    <?php
                                                                    for ($i=1; $i <= 5; $i++)
                                                                    {
                                                                    ?>
                                                                      <option value="<?php echo $i?>" <?php if($row['estadopedido'] == $i){ echo 'selected';}?>><?php echo estados_pedidos($i)?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 col-sm-12">
                                                <div class="portlet grey-cascade box">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="fa fa-cogs"></i>Productos </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="table-responsive">
                                                            <table class="table table-hover table-bordered table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th> Revisado </th>                 
                                                                        <th> Producto </th>
                                                                        <th> Categoria </th>
                                                                        <th> Cantidad </th>
                                                                        <th> Vlr Unitario </th>
                                                                        <th> Total </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    $subtotal = 0;
                                                                    $resultado = $mysqli->query("SELECT pp.idpedido_producto, p.desproducto, c.descategoria, pp.cantpedido_producto, pp.valproducto FROM pedidos_productos pp JOIN productos p ON pp.producto_idproducto = p.idproducto JOIN categorias c ON p.categoria_idcategoria = c.idcategoria WHERE pp.pedido_idpedido = ".$id);
                                                                    
                                                                    while($row_p = mysqli_fetch_array($resultado))
                                                                    {
                                                                    ?>
                                                                    <tr>
                                                                        <td>  </td>
                                                                        <td> <?php echo $row_p['desproducto'] ?> </td>
                                                                        <td> <?php echo $row_p['descategoria'] ?> </td>
                                                                        <td> <?php echo $row_p['cantpedido_producto'] ?> </td>
                                                                        <td> <?php echo number_format($row_p['valproducto'],0,',','.'); ?> </td>
                                                                        <td> <?php echo number_format($total = ($row_p['cantpedido_producto'] * $row_p['valproducto']),0,',','.');?> </td>
                                                                    </tr>
                                                                    <?php 
                                                                    $subtotal += $total;
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="note note-warning">
                                            <p> <strong>Observaciones:</strong> <?php echo $row['observacion'] ?> </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6"> </div>
                                            <div class="col-md-6">
                                                <div class="well">
                                                    <!--<div class="row static-info align-reverse">
                                                        <div class="col-md-8 name"> Sub Total: </div>
                                                        <div class="col-md-3 value"> $<?php echo number_format($subtotal,0,',','.'); ?></div>
                                                    </div>-->
                                                    <div class="row static-info align-reverse">
                                                        <div class="col-md-8 name"> Total: </div>
                                                        <div class="col-md-3 value"> $<?php echo number_format($subtotal,0,',','.'); ?></div>
                                                        <input type="hidden" name="hdd_pedido" id="hdd_pedido" value="<?php echo $id ?>">                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End: life time stats -->
                        </div>
                    </div>

            </div>

        </div>

        <?php
        include('footer.php');
        ?>


        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/alertity/js/alertify.js" type="text/javascript"></script>

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        
        <script>
        jQuery(document).ready(function(){
            
            $("#estado").change(function () {         
                $("#estado option:selected").each(function () {

                    var elegido=$(this).val();
                    var id = $("#hdd_pedido").val();
                    //alert(id);
                    $.ajax({
                        url : "ajax_paginas/ajax_cambiar_estado_pedido.php",   
                        method:"POST",    
                        data: {elegido:elegido, id:id},

                    })
                    .done(function(res){
                        alertify.alert(res, function(ev) {

                        });
                    });                
                    return false;

                });
            });
        }); 
        </script>
    </body>

</html>