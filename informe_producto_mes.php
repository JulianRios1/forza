<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = 'info_prod_mes';

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
                                <a href="#">Informe Producto del Mes</a>
                            </li>
                        </ul>
                    </div>


                    <h3 class="page-title"> Informe Producto del Mes</h3>

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
                                                            <button class="close" data-close="alert"></button> A??n faltan campos por diligenciar. </div>
                                                        <div class="alert alert-success display-hide">
                                                            <button class="close" data-close="alert"></button> Listo! </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="span_small" class="control-label">A??o</label>
                                                                    <select id="ano" name="ano" class="form-control input-md">
                                                                        <option value="">-Seleccione-</option>
                                                                        <?php
                                                                        for($i=0; $i<3; $i++)
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo (date('Y')-$i)?>"><?php echo (date('Y')-$i)?></option>
                                                                            <?php
                                                                        }
                                                                        ?>                                                                  
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="span_small" class="control-label">Mes</label>
                                                                    <select id="mes" name="mes" class="form-control input-md">
                                                                        <option value="">-Seleccione-</option>
                                                                        <?php
                                                                        for($i=1; $i<=12; $i++)
                                                                        {
                                                                            ?>
                                                                            <option value="<?php echo $i?>"><?php echo traducir_nombre_mes($i)?></option>
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
                                                            <!--
                                                            Modal para mostrar los clientes que compran en naturcom
                                                            -->
                                                            <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="" role="dialog" aria-labelledby="myModalLabel">
                                                              <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                  <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title" id="myModalLabel">Clientes</h4>
                                                                  </div>
                                                                  <div class="modal-body">
                                                                    <form class="form-horizontal">
                                                                      
                                                                      <input type="hidden" name="hdd_cliente" id="hdd_cliente" value="">
                                                                    </form>
                                                                    
                                                                    <div class="outer_div" ></div><!-- Datos ajax Final -->
                                                                  </div>
                                                                  <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                  </div>
                                                                </div>
                                                              </div>
                                                            </div>
                                                            <!--
                                                            Modal para mostrar los clientes que compran en naturcom
                                                            -->
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

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

        <script>
            jQuery(document).ready(function() {

                $('#cargando').hide();
                
                
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
                        ano: {
                            required: true
                        },
                        mes: {
                            required: true
                        },
                        vendedor: {
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
                            url: "ajax_paginas/ajax_info_prod_mes.php",
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