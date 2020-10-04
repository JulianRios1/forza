<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = '';
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
                                <a href="banners.php">Banners</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="#">Nuevo Banner</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Nuevo Banner
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
                                                    <span class="caption-subject font-blue-madison bold uppercase">Datos</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">
                                                <div class="tab-content">
                                                    <form action="#" id="form_datos_basicos" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                        <div class="form-body">
                                                            <div class="alert alert-danger display-hide">
                                                                <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                            <div class="alert alert-success display-hide">
                                                                <button class="close" data-close="alert"></button> Listo! </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Nombre</label>
                                                                        <input type="text" name="nom" placeholder="" class="form-control" value="" style="text-transform:uppercase" />     
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Imagen</label> 
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                                <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                                            </div>
                                                                            <div>
                                                                                <span class="btn default btn-file">
                                                                                <span class="fileinput-new">
                                                                                Seleccione Imagen </span>
                                                                                <span class="fileinput-exists">
                                                                                Cambiar </span>
                                                                                <input type="file" name="foto" id="foto">
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">
                                                                                Eliminar </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Link</label>
                                                                        <input type="text" name="link" placeholder="" class="form-control" value=""  />     
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Estado</label>
                                                                        <select class="table-group-action-input form-control input-medium" name="estado">
                                                                            <option value="">-Escoja-</option>
                                                                            <?php 
                                                                            for ($i=1; $i <=2 ; $i++) { 
                                                                                ?>
                                                                                <option value="<?php echo $i ?>" <?php if($row['estado'] == $i){ echo 'selected';} ?>><?php echo estados($i) ?></option>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="margiv-top-10 form-actions">
                                                                <button type="submit" class="btn green">Guardar Cambios</button>
                                                                <a href="banners.php" class="btn default"> Regresar </a>
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

                // Generate a password string
                function randString(id){

                  var dataSet = $(id).attr('data-character-set').split(',');  
                  var possible = '';
                  if($.inArray('a-z', dataSet) >= 0){
                    possible += 'abcdefghijklmnopqrstuvwxyz';
                  }
                  if($.inArray('A-Z', dataSet) >= 0){
                    possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
                  }
                  if($.inArray('0-9', dataSet) >= 0){
                    possible += '0123456789';
                  }
                  if($.inArray('#', dataSet) >= 0){
                    possible += '![]{}()%&*$#^<>~@|';
                  }
                  var text = '';
                  for(var i=0; i < $(id).attr('data-size'); i++) {
                    text += possible.charAt(Math.floor(Math.random() * possible.length));
                  }
                  return text;
                }

                // Create a new password on page load
                $('input[rel="gp"]').each(function(){
                  //$(this).val(randString($(this)));
                });

                // Create a new password
                $(".getNewPass").click(function(){
                  var field = $(this).closest('div').find('input[rel="gp"]');
                  field.val(randString(field));
                });

                // Auto Select Pass On Focus
                $('input[rel="gp"]').on("click", function () {
                   $(this).select();
                });



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
                        nom: {
                            minlength: 3,
                            required: true
                        },
                        estado: {
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
                            url: "banner_add_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                                location.href='banners.php';
                            });
                        });
                        return false;
                    }

                });                

            
            });

        </script>
    </body>

</html>