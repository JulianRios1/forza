<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
$pagina = 'info_meta_vendedor';

?>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        
        <?php include('top_info.php');?>
        
        <div class="clearfix"> </div>

        <div class="page-container">

            <div class="page-sidebar-wrapper">
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
                                <a href="#">Monitoreo de las Metas del Mes</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title">Monitoreo de las Metas del Mes</h3>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-body form">
                                                <div class="tab-content">
                                                    <form action="#" id="form_info_meta_vendedor" class="horizontal-form" autocomplete="off">
                                                        <input type="hidden" id="rol" name="rol" value="<?php echo $_SESSION['rol_usu'] ?>">

                                                        <?php
                                                            if ($_SESSION["rol_usu"] == 4)//solo si es un usuario super admin
                                                            {
                                                        ?> 
                                                                <input type="hidden" id="id_vendedor" name="id_vendedor" value="">
                                                        <?php 
                                                            }else{//si es un vendedor
                                                        ?>
                                                                <input type="hidden" id="id_vendedor" name="id_vendedor" value="<?php echo $_SESSION["idusuario"] ?>">
                                                        <?php 
                                                            }
                                                        ?>

                                                        <input type="hidden" id="id_vendedor" name="id_vendedor" value="">
                                                        <div class="form-body">

                                                            <?php
                                                                if ($_SESSION["rol_usu"] == 4)//solo si es un usuario super admin
                                                                {
                                                            ?> 
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Vendedor</label>
                                                                            <select id="vendedor" name="vendedor" class="form-control input-sm select2" required>
                                                                                <option value="">-Seleccione-</option>
                                                                                <?php 
                                                                                $resultado= $mysqli->query("SELECT id, CONCAT('(',COALESCE(`documento`,''),') ',COALESCE(`nom`,''),' ',COALESCE(`ape1`,''),' ',COALESCE(`ape2`,'')) AS vendedor FROM usuarios WHERE idrol = 1");
                                                                                while($row = mysqli_fetch_array($resultado))
                                                                                {
                                                                                ?>
                                                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['vendedor'] ?></option>
                                                                                <?php 
                                                                                } ?>                                                                  
                                                                            </select>
                                                                        </div>
                                                                    </div>   
                                                                </div> 
                                                            <?php 
                                                                }
                                                            ?>

                                                            <div class="row">
                                                                <div class="col-md-6">

                                                                    <?php
                                                                        if ($_SESSION["rol_usu"] == 4)//solo si es un usuario super admin
                                                                        {
                                                                    ?> 
                                                                        <div class="form-group">
                                                                            <label class="control-label">Zona</label>
                                                                            <select id="zona" name="zona" class="form-control input-sm select2" required>
                                                                                
                                                                            </select>
                                                                        </div>
                                                                    <?php 
                                                                        }else{//si es un vendedor
                                                                    ?>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Zona</label>
                                                                            <select id="zona" name="zona" class="form-control input-sm select2" required>
                                                                                <option value="">-Seleccione-</option>
                                                                                <?php 
                                                                                $resultado= $mysqli->query("SELECT * FROM zonas WHERE id_vendedor = ".$_SESSION["idusuario"]);
                                                                                while($row = mysqli_fetch_array($resultado))
                                                                                {
                                                                                ?>
                                                                                <option value="<?php echo $row['id'] ?>"><?php echo $row['des'] ?></option>
                                                                                <?php 
                                                                                } ?>                                                                  
                                                                            </select>
                                                                        </div>
                                                                    <?php 
                                                                        }
                                                                    ?>
                                                                </div>   
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Mes/A??o</label>
                                                                        <input type="text" id="mes_ano" class="form-control" placeholder="Mes y a??o a registrar" required>
                                                                    </div>
                                                                </div>
                                                            </div> 

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Total Esperado Ventas: </label>
                                                                        <input type="number" id="total_esperado_ventas" class="form-control" value="" readonly>
                                                                    </div>
                                                                </div>   
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Total Ejecutado: </label>
                                                                        <input type="text" id="porcentaje_total_ejecutado" class="form-control" value="" style="font-weight:bold;" readonly>
                                                                    </div>
                                                                </div>
                                                            </div> 

                                                            <div class="margiv-top-10 form-actions">
                                                                <button type="submit" class="btn green">Consultar</button>
                                                            </div>

                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <table id="clientes_table" class="table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Cliente</th>
                                            <th>Mejor Venta</th>
                                            <th>Promedio Actual</th>
                                            <th>Pron??stico Vendedor</th>
                                            <th>Venta Actual</th>
                                            <th>% Cumplimiento</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
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
        
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        
        <script src="assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/gauge.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

        <script src="assets/js/informe_meta_vendedor.js" type="text/javascript"></script>

    </body>

</html>