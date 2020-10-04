<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = 'info_novisitados';

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
                                <a href="#">Informe Medicos deshabilitados</a>
                            </li>
                        </ul>
                    </div>


                    <h3 class="page-title"> Medicos deshabilitados</h3>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="tab-pane">
                                                <form action="#" id="form_consultar" class="form-inline margin-bottom-20" enctype="multipart/form-data" autocomplete="off">
                                                    <div class="form-body">
                                                        <div class="alert alert-danger display-hide">
                                                            <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                        <div class="alert alert-success display-hide">
                                                            <button class="close" data-close="alert"></button> Listo! </div>
                                                        <div class="row">
                                                            <div class="col-md-12">

                                                                <div class="form-group">
                                                                    <label for="span_small" class="control-label">Zona</label>
                                                                    <select id="zona" name="zona" class="form-control input-md">
                                                                        <option value="">-Seleccione-</option>
                                                                        <?php
                                                                        $cons_zonas='';
                                                                        
                                                                        if($_SESSION['rol_usu'] !=  1)
                                                                        {
                                                                            ?>
                                                                            <option value="0">Todas</option>
                                                                            <?php
                                                                        }

                                                                        if($_SESSION['rol_usu'] ==  1)
                                                                        {
                                                                            $resultado = $mysqli->query("SELECT id as zona FROM zonas z WHERE id_vendedor = ".$_SESSION["idusuario"]); 
                                                                            $zn='';
                                                                                            
                                                                            while($row_zon= mysqli_fetch_array($resultado))
                                                                            {
                                                                                $zn.= $row_zon['zona'].','; 
                                                                            }
                                                                            $cons_zonas = ' WHERE id IN ('.substr ($zn , 0, -1 ).')';
                                                                        }

                                                                        $resultado= $mysqli->query("SELECT * FROM zonas $cons_zonas ORDER BY des");
                                                                        while ($row_zona = mysqli_fetch_array($resultado))
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $row_zona['id']?>"><?php echo $row_zona['des']?></option>
                                                                            <?php
                                                                        }
                                                                        ?>                                                                  
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn green">Consultar</button>
                                                            </div>                                                            
                                                        </div> 


                                                        <div class="row">
                                                            <div id="cargando" align="center" class="cbp"></div>
                                                            <div id="div_listar"></div>
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
        <script src="assets/global/plugins/decimales/decimales.js" type="text/javascript"></script>

        <script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>


        <script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>


        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

        <script>
            jQuery(document).ready(function() {

                $('#cargando').hide();

                $('.date-picker').datepicker({
                    language: 'es',
                    rtl: App.isRTL(),
                    orientation: "left",
                    autoclose: true,
                    todayBtn: true,
                });

                
                

                //FORMULARIO DE CONSULTAR 
                var form = $('#form_consultar');
                var error = $('.alert-danger', form);
                var success = $('.alert-success', form);


                form.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
                        zona: {
                            required: true
                        }
                    },

                    invalidHandler: function (event, validator) { //display error alert on form submit              
                        success.hide();
                        error.show();
                        App.scrollTo(error, -200);
                    },

                    errorPlacement: function (error, element) { // render error placement for each input type
                        var icon = $(element).parent('.input-icon').children('i');
                        icon.removeClass('fa-check').addClass("fa-warning");  
                        icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                    },

                    highlight: function (element) { // hightlight error inputs
                        $(element)
                            .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                    },

                    unhighlight: function (element) { // revert the change done by hightlight
                        
                    },

                    success: function (label, element) {
                        var icon = $(element).parent('.input-icon').children('i');
                        $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                        icon.removeClass("fa-warning").addClass("fa-check");
                    },

                    submitHandler: function (form) {
                        //success.show();
                        error.hide();

                        //var formulario = $('#add_participante').serializeArray();
                        var formData = new FormData(document.getElementById("form_consultar"));
                        formData.append("dato", "valor");
                        
                        $.ajax({
                            url: "ajax_paginas/ajax_clientes_desha.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            beforeSend: function(){
                                $("#cargando").show();
                                $("#div_listar").html("");
                            },
                            success: function(data){
                                $("#div_listar").html(data);
                                $('#cargando').hide();                                 
                            }

                        })

                        return false;
                    }

                });                 

            
            });

        </script>
    </body>

</html>