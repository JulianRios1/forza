<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = '';
extract ($_GET);

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
                                <a href="roles.php">Roles</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="#">Nuevo Rol</a>
                            </li>
                        </ul>
                    </div>
                    <!-- CONSULTA DE PERMISOS -->

                       
                    <h3 class="page-title"> Nuevo Rol
                    </h3>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">ROL</span>
                                                </div>
                                            </div>
                                            <form action="#" id="form_datos_basicos" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                            
                            
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label">Nombre Rol</label>
                                                    <input type="text" name="nomrol" placeholder="" class="form-control" value="" /> 
                                                </div>
                                            </div>
                                            <div class="form-group form-md-checkboxes">
                                                <?php
                                                $resultado = $mysqli->query("SELECT catpermiso from permisos GROUP BY catpermiso"); 
                                                $numreg = mysqli_num_rows($resultado);

                                                $j=0;
                                                while($row = mysqli_fetch_array($resultado))
                                                {
                                                ?> 
                                                <label for="form_control_1"><?php echo $row['catpermiso'] ?></label>
                                                <div class="md-checkbox-inline">
                                                    <div class="row">
                                                        <?php 
                                                        
                                                        

                                                        $resultado_permisos = $mysqli->query("SELECT * FROM permisos WHERE catpermiso = '".$row['catpermiso']."' ORDER BY id"); 
                                                        while($row3 = mysqli_fetch_array($resultado_permisos))
                                                        {
                                                        ?>
                                                        <div class="col-md-4">
                                                            <div class="md-checkbox">
                                                                <input type="checkbox" id="<?php echo $j ?>" name="chk_permisos[]" value="<?php echo $row3["id"]?>" class="md-check">
                                                                <label for="<?php echo $j ?>">
                                                                    <span></span>
                                                                    <span class="check"></span>
                                                                    <span class="box"></span> <?php echo utf8_encode($row3['nompermiso']) ?> </label>
                                                            </div>
                                                        </div>
                                                        <?php 
                                                            $j++;
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                                <?php } ?>
        
                                            </div>
                                            <div class="margiv-top-10 form-actions">
                                                <button type="submit" class="btn green">Guardar Cambios</button>
                                                <a href="roles.php" class="btn default"> Regresar </a>
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

        <script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>

        <script src="assets/global/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-pwstrength/pwstrength-bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/autosize/autosize.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/profile.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>


        <script>
            jQuery(document).ready(function() {




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
                        nomrol: {
                            minlength: 3,
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
                        var formData = new FormData(document.getElementById("form_datos_basicos"));
                        formData.append("dato", "valor");
                        
                       $.ajax({
                            url: "rol_edit_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                                location.href='roles.php';
                            });
                        });
                        return false;
                    }

                });


                //Carga municipios dependiendo del departamento seleccionado
                $("#departamento").change(function () {         
                    $("#departamento option:selected").each(function () {
                        
                        $("#municipio").attr("disabled");
                        $("#municipio").val("");
                                
                        var elegido=$(this).val();
                        //alert(elegido);
                        if( elegido != '')
                        {
                            $.post("municipios.php", { elegido: elegido }, function(data){
                                $("#municipio").removeAttr("disabled");
                                $("#municipio").html(data);
                                
                            });            
                        }
                        else
                        {
                            $("#municipio").attr("disabled","");
                            $("#municipio").val("");
                        }
                    });
                });



                //CONSULTAMOS SI EL USUARIO YA ESTA CREADO
                $("#usuario").change(function () {
                    var input = $(this);

                    if (input.val() === "") {
                        input.closest('.form-group').removeClass('has-error').removeClass('has-success');
                        $('.fa-check, fa-warning', input.closest('.form-group')).remove();

                        return;
                    }

                    input.attr("readonly", true).
                    attr("disabled", true).
                    addClass("spinner");

                    $.post('ajax_paginas/ajax_consultar_usuario_existe.php', {
                        username: input.val()
                    }, function (res) {

                        input.attr("readonly", false).
                        attr("disabled", false).
                        removeClass("spinner");

                        // change popover font color based on the result
                        if (res.status == 'OK') {
                            input.closest('.form-group').removeClass('has-error').addClass('has-success');
                            $('.fa-warning', input.closest('.form-group')).remove();
                            input.before('<i class="fa fa-check"></i>');
                            input.popover('show');
                            input.data('bs.popover').tip().removeClass('error').addClass('success');
                        } else {
                            input.closest('.form-group').removeClass('has-success').addClass('has-error');
                            $('.fa-check', input.closest('.form-group')).remove();
                            input.before('<i class="fa fa-warning"></i>');

                            input.popover('destroy');
                            input.popover({
                                'html': true,
                                'placement': (App.isRTL() ? 'left' : 'right'),
                                'container': 'body',
                                'content': res.message,
                            });
                            input.popover('show');
                            input.data('bs.popover').tip().removeClass('success').addClass('error');

                            App.setLastPopedPopover(input);
                        }

                    }, 'json');

                });

                

            
            });

        </script>
    </body>

</html>