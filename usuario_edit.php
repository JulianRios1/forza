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
                                <a href="usuarios.php">Usuarios</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="#">Editar Usuario</a>
                            </li>
                        </ul>
                    </div>
                    <!-- CONSULTA DEL CLIENTE -->
                    <?php
                    $resultado = $mysqli->query("SELECT u.*, m.habilitado FROM usuarios u LEFT JOIN medicos m ON m.usuario_id = u.id WHERE u.id = $id"); 
                    $row = mysqli_fetch_array($resultado);
                    ?>
                    <h3 class="page-title"> Editar Usuario
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
                                                    <span class="caption-subject font-blue-madison bold uppercase">Cuenta</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body form">
                                                <div class="tab-content">
                                                    <form action="#" id="form_datos_basicos" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                        <div class="form-body">
                                                            <div class="alert alert-danger display-hide">
                                                                <button class="close" data-close="alert"></button> A??n faltan campos por diligenciar. </div>
                                                            <div class="alert alert-success display-hide">
                                                                <button class="close" data-close="alert"></button> Listo! </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Estado</label>                                                                            
                                                                        <select name="estado" id="estado" class="form-control">  
                                                                            <option value="1" <?php if($row['estado'] == 1){ echo 'selected';}?>>Activo</option>
                                                                            <option value="0" <?php if($row['estado'] == 0){ echo 'selected';}?>>Inactivo</option> 
                                                                        </select>
                                                                    </div>
                                                                </div>   
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Habilitado Intinerario</label>                                                                            
                                                                        <select name="habilitado" id="habilitado" class="form-control">  
                                                                            <option value="1" <?php if($row['habilitado'] == 1){ echo 'selected';}?>>Habilitado</option>
                                                                            <option value="0" <?php if($row['habilitado'] == 0){ echo 'selected';}?>>Inhabilitado</option> 
                                                                        </select>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Rol</label>
                                                                        <select name="rol" id="rol" class="form-control">
                                                                            <?php 
                                                                            $resultado_rol = $mysqli->query("SELECT * FROM roles ORDER BY nomrol");
                                                                            while($row_rol = mysqli_fetch_array($resultado_rol))
                                                                            {
                                                                            ?>
                                                                                <option value="<?php echo $row_rol['id']?>" <?php if($row['idrol'] == $row_rol['id']){ echo 'selected';} ?>><?php echo $row_rol['nomrol']?></option>
                                                                            <?php 
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Tipo Documento</label>
                                                                        <select name="tipo_documento" id="tipo_documento" class="form-control">
                                                                            <option value="">Seleccione</option>
                                                                            <?php 
                                                                            $resultado_td = $mysqli->query("SELECT * FROM tipos_documentos ORDER BY tipo");
                                                                            while($row_td = mysqli_fetch_array($resultado_td))
                                                                            {
                                                                            ?>
                                                                                <option value="<?php echo $row_td['id']?>" <?php if($row['tipo_documento'] == $row_td['id']){ echo 'selected';} ?>><?php echo utf8_encode($row_td['tipo'])?></option>
                                                                            <?php 
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">No. Documento</label>
                                                                        <input type="text" name="documento" placeholder="" class="form-control" value="<?php echo $row['documento'] ?>" /> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Nombre</label>
                                                                        <input type="text" name="nom" placeholder="" class="form-control" value="<?php echo $row['nom'] ?>" style="text-transform:uppercase" />     
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Primer Apellido</label>
                                                                        <input type="text" name="ape1" placeholder="" class="form-control" value="<?php echo $row['ape1'] ?>" style="text-transform:uppercase" /> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Segundo Apellido</label>
                                                                        <input type="text" name="ape2" placeholder="" class="form-control" value="<?php echo $row['ape2'] ?>" style="text-transform:uppercase" />
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Direcci??n</label>
                                                                        <input type="text" name="dir" placeholder="" class="form-control" value="<?php echo $row['dir'] ?>" style="text-transform:uppercase" />
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Celular</label>
                                                                        <input type="text" name="cel" placeholder="" class="form-control" value="<?php echo $row['cel'] ?>" style="text-transform:uppercase" />  
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Tel??fono</label>
                                                                        <input type="text" name="tel" placeholder="" class="form-control" value="<?php echo $row['tel'] ?>" style="text-transform:uppercase" /> 
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Departamento</label>
                                                                        <select name="departamento" id="departamento" class="form-control">
                                                                            <option value="">-Seleccione-</option>
                                                                            <?php 
                                                                            $resultado_dep = $mysqli->query("SELECT * FROM departamentos ORDER BY nombre_dep");
                                                                            while($row_dep = mysqli_fetch_array($resultado_dep))
                                                                            {
                                                                            ?>
                                                                                <option value="<?php echo $row_dep['id']?>" <?php if(consulta_departamento($row['ciudad_actual']) == $row_dep['id']){ echo 'selected';} ?>><?php echo utf8_encode($row_dep['nombre_dep'])?></option>
                                                                            <?php 
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Ciudad Actual</label>
                                                                        <?php 
                                                                        if(!empty(consulta_departamento($row['ciudad_actual'])))
                                                                        {
                                                                        ?>
                                                                        <select name="municipio" id="municipio" class="form-control">
                                                                            <?php 
                                                                            $resultado = $mysqli->query('SELECT * FROM municipios WHERE departamento_id = '.consulta_departamento($row['ciudad_actual']).' ORDER BY nombreMunicipio');
                                                                            while($rowMun = mysqli_fetch_array($resultado))
                                                                            {
                                                                            ?>
                                                                                <option value="<?php echo $rowMun['id']?>" <?php if($row['ciudad_actual'] == $rowMun['id']){ echo 'selected';} ?>><?php echo utf8_encode($rowMun['nombreMunicipio'])?></option>
                                                                            <?php 
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                        <?php 
                                                                        }
                                                                        else {
                                                                        ?>
                                                                        <select name="municipio" id="municipio" class="form-control" disabled="true">
                                                                            <option value="">-Seleccione-</option>
                                                                        </select>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Email</label>
                                                                        <input type="text" name="mail" placeholder="" class="form-control" value="<?php echo $row['mail'] ?>" style="text-transform:lowercase;" /> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Puntos</label>
                                                                        <input type="text" name="puntos" placeholder="" class="form-control" value="<?php echo $row['puntos'] ?>" /> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Cambiar fecha intinerario</label>                                                                            
                                                                        <select name="cambiar_fecha_visita" id="cambiar_fecha_visita" class="form-control">  
                                                                            <option value="1" <?php if($row['cambiar_fecha_visita'] == 1){ echo 'selected';}?>>Habilitado</option>
                                                                            <option value="0" <?php if($row['cambiar_fecha_visita'] == 0){ echo 'selected';}?>>Inhabilitado</option> 
                                                                        </select>
                                                                    </div>
                                                                </div> 
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label>Enviar email cliente nuevo</label>
                                                                        <div class="input-group">
                                                                            <div class="icheck-list">
                                                                                <label class="">
                                                                                    <div class="icheckbox_flat-green checked" style="position: relative;"><input type="checkbox" class="icheck" name="enviar_email" data-checkbox="icheckbox_flat-green" value="1" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <label class="control-label">Avatar</label> 
                                                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                        <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                        <?php
                                                                        if(!empty($row['avatar']))
                                                                        {
                                                                            ?>
                                                                            <img src="assets/avatars/img/<?php echo $row['avatar'];?>" alt=""/>
                                                                            <?php
                                                                        }
                                                                        else
                                                                        {
                                                                            ?>
                                                                            <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                            
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
                                                                            <input type="hidden" name="hdd_foto" value="<?php echo $row['avatar'];?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr>
                                                            <div class="row">
                                                                
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Usuario</label>
                                                                            <div class="input-icon right">
                                                                                <i class="icon-exclamation-sign"></i>
                                                                                <input type="text" class="form-control" name="usuario" id="usuario" value="<?php echo $row['usu'] ?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Contrase??a</label>
                                                                        <div class="input-group">
                                                                            <div class="input-icon">
                                                                                <i class="fa fa-lock fa-fw"></i>
                                                                                <input id="newpassword" class="form-control" type="text" name="pass" placeholder="password"  rel="gp" data-size="8" data-character-set="a-z,A-Z,0-9,#"> </div>
                                                                                <span class="input-group-btn">
                                                                                    <button class="btn btn-success getNewPass" type="button">
                                                                                        <i class="fa fa-arrow-left fa-fw "></i> Random</button>
                                                                                </span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                            <div class="margiv-top-10 form-actions">
                                                                <button type="submit" class="btn green">Guardar Cambios</button>
                                                                <a href="usuarios.php" class="btn default"> Regresar </a>
                                                                <input type="hidden" name="hdd_id" value="<?php echo $id ?>">
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
                        tipo_documento: {
                            required: true
                        },
                        mail: {
                            email: true
                        },
                        direccion: {
                            minlength: 3,
                            required: true
                        },
                        usuario: {
                            minlength: 5,
                            nowhitespace: true
                        },
                        pass: {
                            minlength: 8
                        },
                        departamento: {
                            required: true
                        },
                        municipio: {
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
                            url: "usuario_edit_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                                location.href='usuarios.php';
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
                            input.popover('destroy');
                            input.popover({
                                'html': true,
                                'placement': (App.isRTL() ? 'left' : 'right'),
                                'container': 'body',
                                'content': res.message,
                            });
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