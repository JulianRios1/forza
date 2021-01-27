<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
$pagina = 'info_elementos_visitas';

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
                                <a href="#">Informe de Movimiento por Literaturas, Obsequios y Muestras Médicas</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title">Informe de Movimiento por Literaturas, Obsequios y Muestras Médicas</h3>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-body form">
                                                <div class="tab-content">
                                                    <form action="#" id="form_info_elementos_visitas" class="horizontal-form" autocomplete="off">
                                                        <div class="form-body">

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Fecha Inicial</label>
                                                                        <input type="text" id="fecha_inicial" class="form-control" placeholder="Escoja la fecha inicial">
                                                                    </div>
                                                                </div>   
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Fecha Final</label>
                                                                        <input type="text" id="fecha_final" class="form-control" placeholder="Escoja la fecha final">
                                                                    </div>
                                                                </div>
                                                            </div> 

                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Concepto</label>
                                                                        <select name="concepto" id="concepto" class="form-control">
                                                                            <option value="">-Seleccione-</option>
                                                                            <option value="1">Literatura</option>
                                                                            <option value="2">Obsequio</option>
                                                                            <option value="3">Muestra Médica</option>
                                                                        </select>
                                                                    </div>
                                                                </div>   
                                                                <div class="col-md-6" id="divLiteratura" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Literatura</label>
                                                                        <select id="literatura" name="literatura" class="form-control input-sm select2">
                                                                            <option value="">-Seleccione-</option>
                                                                            <?php 
                                                                            $resultado= $mysqli->query("SELECT id, descripcion AS nombre FROM literaturas WHERE estado = 0");
                                                                            while($row = mysqli_fetch_array($resultado))
                                                                            {
                                                                            ?>
                                                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                                                                            <?php 
                                                                            } ?>                                                                  
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" id="divObsequio" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Obsequio</label>
                                                                        <select id="obsequio" name="obsequio" class="form-control input-sm select2">
                                                                            <option value="">-Seleccione-</option>
                                                                            <?php 
                                                                            $resultado= $mysqli->query("SELECT id, descripcion AS nombre FROM obsequios WHERE estado = 0");
                                                                            while($row = mysqli_fetch_array($resultado))
                                                                            {
                                                                            ?>
                                                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                                                                            <?php 
                                                                            } ?>                                                                  
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6" id="divMuestraMedica" style="display:none;">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Muestra Médica</label>
                                                                        <select id="muestra_medica" name="muestra_medica" class="form-control input-sm select2">
                                                                            <option value="">-Seleccione-</option>
                                                                            <?php 
                                                                            $resultado= $mysqli->query("SELECT idproducto AS id, CONCAT(desproducto,' (',COALESCE(formafarmaceutica,''),')') AS nombre FROM productos WHERE oculto = 0 ORDER BY desproducto");
                                                                            while($row = mysqli_fetch_array($resultado))
                                                                            {
                                                                            ?>
                                                                            <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                                                                            <?php 
                                                                            } ?>                                                                  
                                                                        </select>
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

        <script src="assets/js/informe_elementos_visitas.js" type="text/javascript"></script>

    </body>

</html>