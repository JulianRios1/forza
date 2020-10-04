<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('funciones/utilidades.php');


$pagina = 'configuracion';

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
                                <a href="#">Configuración</a>
                            </li>
                        </ul>
                    </div>
                    <!-- CONSULTA DATOS DEL SISTEMA -->
                    <?php
                    $resultado = $mysqli->query("SELECT * FROM datos_basicos_empresa"); 
                    $row = mysqli_fetch_array($resultado);
                    ?>
                    <h3 class="page-title"> Configuración</h3>

                    <div class="row">
                        <div class="col-md-12">                            
                            <div class="portlet-body">
                                <div class="panel-group accordion scrollable" id="accordion2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_1"> Datos Básicos </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_1" class="panel-collapse in">
                                            <div class="panel-body">
                                                <div class="tab-content">
                                                    <form action="#" id="form_datos_basicos" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                        <div class="form-body">
                                                            <div class="alert alert-danger display-hide">
                                                                <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                            <div class="alert alert-success display-hide">
                                                                <button class="close" data-close="alert"></button> Listo! </div>
                                                            
                                                            <?php
                                                            //CONSULTAMOS LOS DATOS BASICOS
                                                            $resultado = $mysqli->query("SELECT * FROM datos_basicos_empresa"); 
                                                            $row = mysqli_fetch_array($resultado);
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Nit</label>
                                                                        <input type="text" name="nit" placeholder="" class="form-control" value="<?php echo $row['nit'] ?>" /> 
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Razón Social</label>
                                                                        <input type="text" name="nom" placeholder="" class="form-control" value="<?php echo $row['razon_social'] ?>" style="text-transform:uppercase" />     
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Representante</label>
                                                                        <input type="text" name="rep" placeholder="" class="form-control" value="<?php echo $row['representante'] ?>" style="text-transform:uppercase" /> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Documento Representante</label>
                                                                        <input type="text" name="doc_rep" placeholder="" class="form-control" value="<?php echo $row['documento'] ?>" style="text-transform:uppercase" />
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Dirección</label>
                                                                        <input type="text" name="dir" placeholder="" class="form-control" value="<?php echo $row['direccion'] ?>" style="text-transform:uppercase" />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Teléfono</label>
                                                                        <input type="text" name="tel" placeholder="" class="form-control" value="<?php echo $row['telefono'] ?>" style="text-transform:uppercase" /> 
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
                                                                                <option value="<?php echo $row_dep['id']?>" <?php if(consulta_departamento($row['ciudad']) == $row_dep['id']){ echo 'selected';} ?>><?php echo utf8_encode($row_dep['nombre_dep'])?></option>
                                                                            <?php 
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Ciudad</label>
                                                                        <?php 
                                                                        if(!empty(consulta_departamento($row['ciudad'])))
                                                                        {
                                                                        ?>
                                                                        <select name="municipio" id="municipio" class="form-control">
                                                                            <?php 
                                                                            $resultado = $mysqli->query('SELECT * FROM municipios WHERE departamento_id = '.consulta_departamento($row['ciudad']).' ORDER BY nombreMunicipio');
                                                                            while($rowMun = mysqli_fetch_array($resultado))
                                                                            {
                                                                            ?>
                                                                                <option value="<?php echo $rowMun['id']?>" <?php if($row['ciudad'] == $rowMun['id']){ echo 'selected';} ?>><?php echo utf8_encode($rowMun['nombreMunicipio'])?></option>
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
                                                                        <label class="control-label">Web</label>
                                                                        <input type="text" name="web" placeholder="" class="form-control" value="<?php echo $row['web'] ?>" style="text-transform:lowercase;" /> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Email envio notificaciones</label>
                                                                        <input type="text" name="mail" placeholder="" class="form-control" value="<?php echo $row['correo_saliente'] ?>" style="text-transform:lowercase;" /> 
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Logo</label> 
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                                <?php
                                                                                if(!empty($row['logo']))
                                                                                {
                                                                                    ?>
                                                                                    <img src="assets/layouts/layout/img/<?php echo $row['logo'];?>" alt=""/>
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
                                                                                <input type="hidden" name="hdd_foto" value="<?php echo $row['logo'];?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="margiv-top-10 form-actions">
                                                                <button type="submit" class="btn green">Guardar Cambios</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2"> Tabla de descuentos </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_2" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="tab-content">
                                                    <form action="#" id="form_tabla_descuentos" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                        <div class="form-body">
                                                            <div class="alert alert-danger display-hide">
                                                                <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                            <div class="alert alert-success display-hide">
                                                                <button class="close" data-close="alert"></button> Listo! </div>
                                                            
                                                            <?php
                                                            //CONSULTAMOS LA TABLA DE DESCUENTOS
                                                            $resultado = $mysqli->query("SELECT * FROM tabla_descuentos"); 
                                                            $row = mysqli_fetch_array($resultado);
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Rango 1</label>
                                                                        <input type="text" name="r1" placeholder="" class="form-control" value="<?php echo number_format($row['rango1'],0,',','.')  ?>" onchange="puntillos(this);" onkeyup="puntillos(this);" /> 
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Rango 2</label>
                                                                        <input type="text" name="r2" placeholder="" class="form-control" value="<?php echo number_format($row['rango2'],0,',','.') ?>" onchange="puntillos(this);" onkeyup="puntillos(this);" />     
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Descuento 1</label>
                                                                        <input type="text" name="d1" placeholder="" class="form-control" value="<?php echo $row['descuento1'] ?>" /> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Rango 3</label>
                                                                        <input type="text" name="r3" placeholder="" class="form-control" value="<?php echo number_format($row['rango3'],0,',','.')  ?>" onchange="puntillos(this);" onkeyup="puntillos(this);" />
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Descuento 2</label>
                                                                        <input type="text" name="d2" placeholder="" class="form-control" value="<?php echo $row['descuento2'] ?>"  />
                                                                    </div>
                                                                </div>                                                            
                                                                
                                                            </div>



                                                            <div class="margiv-top-10 form-actions">
                                                                <button type="submit" class="btn green">Guardar Cambios</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_3"> Personalizar mensajes </a>
                                            </h4>
                                        </div>
                                        <?php 
                                        $consulta = $mysqli->query("SELECT * FROM texto_correos");
                                        
                                        ?>
                                        <div id="collapse_3" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="portlet-body form">
                                                    <form class="form-horizontal form-bordered" id="form_mensajes">
                                                        <?php 
                                                        $i=1;
                                                        while($row = mysqli_fetch_array($consulta))
                                                        {
                                                        ?>
                                                        <div class="form-body">
                                                            <div class="form-group last">
                                                                <label class="control-label col-md-2"><?php echo $row['descripcion'] ?></label>
                                                                <div class="col-md-10">
                                                                    <textarea name="msg_<?php echo $i?>" class="summernote"><?php echo $row['texto']  ?></textarea>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $i++;
                                                        }
                                                        ?>
                                                        <div class="form-actions">
                                                            <div class="row">
                                                                <div class="col-md-offset-2 col-md-10">
                                                                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Guardar</button>
                                                                    <input type="hidden" name="num_msg" value="<?php echo ($i-1) ?>">
                                                                </div>
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
        <script src="assets/global/plugins/decimales/decimales.js" type="text/javascript"></script>

        <script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/profile.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>

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
                        nom: {
                            minlength: 3,
                            required: true
                        },
                        nit: {
                            required: true
                        },
                        rep: {
                            required: true
                        },
                        doc_rep: {
                            required: true
                        },
                        departamento:{
                            required: true
                        },
                        mail: {
                            email: true
                        },
                        dir: {
                            minlength: 3,
                            required: true
                        },
                        tel: {
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
                            url: "configuracion_tab1.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                            });
                        });
                        return false;
                    }

                });



               

                //DATOS FORMULARIO DE DATOS DEL CONTACTO
                var form2 = $('#form_tabla_descuentos');

                form2.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
                        r1:{
                            required: true
                        },
                        r2:{
                            required: true
                        },
                        d1:{
                            required: true
                        },
                        r3:{
                            required: true
                        },
                        d2:{
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
                        var formData = new FormData(document.getElementById("form_tabla_descuentos"));
                        formData.append("dato", "valor");
                        
                       $.ajax({
                            url: "configuracion_tab2.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {

                            });
                        });
                        return false;
                    }
                });


                
                //DATOS FORMULARIO DE INSCRIPCION A LA WEB DE MEDICOS
                var form3 = $('#form_mensajes');

                form3.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
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
                        var formData = new FormData(document.getElementById("form_mensajes"));
                        formData.append("dato", "valor");
                        
                        $.ajax({
                            url: "configuracion_tab3.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {

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

                

                $('.summernote').summernote({
                    height: 200,
                  toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],

                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']]
                   
                  ]
                });
            });

        </script>
    </body>
    <table ></table>

</html>