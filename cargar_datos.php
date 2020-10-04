<!DOCTYPE html>

<html lang="en">
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
$pagina = 'datos';

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
                                <a href="#">Cargar Datos</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Cargar Datos</h3>

                    <div class="row">
                        <div class="col-md-12">
                            <form action="#" id="form_datos_basicos" class="form-horizontal form-row-seperated" enctype="multipart/form-data" autocomplete="off">
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                <div class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button> Listo! </div>
                                <div class="portlet">
                                    <div class="portlet-title">

                                        
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tabbable-bordered">

                                            <div class="tab-content">
                                                <div>
                                                    <div class="form-body">

                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Año:
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-10">
                                                                <select class="table-group-action-input form-control input-medium" name="ano">
                                                                    <option value="">-Seleccione-</option>
                                                                    <?php
                                                                    for($i=0; $i<3; $i++)
                                                                    {
                                                                        ?>
                                                                        <option value="<?php echo date('Y')-$i?>"><?php echo date('Y')-$i?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Mes:
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-10">
                                                                <select class="table-group-action-input form-control input-medium" name="mes">
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
                                                        </div>
                                                        
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Archivo:</label>
                                                            <div class="col-md-10">
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="input-group input-large">
                                                                        <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                                                                            <i class="fa fa-file fileinput-exists"></i>&nbsp;
                                                                            <span class="fileinput-filename"> </span>
                                                                        </div>
                                                                        <span class="input-group-addon btn default btn-file">
                                                                            <span class="fileinput-new"> Adjuntar </span>
                                                                            <span class="fileinput-exists"> Cambiar </span>
                                                                            <input type="file" name="archivo_adjunto"> </span>
                                                                        <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Eliminar </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="actions btn-set">
                                                                
                                                                <button class="btn btn-success" style="margin-left: 100px">
                                                                    <i class="fa fa-check"></i> Cargar</button>
                                                            </div>
                                                        </div>
                                                        
                                                                                                                
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/fancybox/source/jquery.fancybox.pack.js" type="text/javascript"></script>
        <script src="assets/global/plugins/plupload/js/plupload.full.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        
        <script>
            jQuery(document).ready(function() {

                //SELECCIONA LOS CAMPOS DE LA IZQUIERDA A LA DERECHA LITERATURA
                $('#select_productos1').multiSelect();
                $('#select_productos2').multiSelect({
                    selectableOptgroup: true
                });


                //nombre,foto,laboratorio,categoria,linea,precio,promocion,precio_promo,agotado,inactivo,destacado,archivo_adjunto

                //FORMULARIO DATOS BASICOS
                var form = $('#form_datos_basicos');
                var error = $('.alert-danger', form);
                var success = $('.alert-success', form);


                form.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
                        ano:{
                            required: true
                        },
                        mes: {
                            required : true
                        },
                        archivo_adjunto: {
                            required : true
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
                        var formData = new FormData(document.getElementById("form_datos_basicos"));
                        formData.append("dato", "valor");
                        
                       $.ajax({
                            url: "cargar_datos_add_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                                location.href='cargar_datos.php';
                            });
                        });
                        return false;
                    }

                });                

            
            });

        </script>
    </body>

</html>