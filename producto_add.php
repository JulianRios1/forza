<!DOCTYPE html>

<html lang="en">
<?php 

include('head.php');
include('includes/parametros.php');
$pagina = 'productos';

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
                                <a href="productos.php">Productos</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="#">Producto</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Producto Nuevo</h3>

                    <div class="row">
                        <div class="col-md-12">
                            <form action="#" id="form_datos_basicos" class="form-horizontal form-row-seperated" enctype="multipart/form-data" autocomplete="off">
                                <div class="alert alert-danger display-hide">
                                    <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                <div class="alert alert-success display-hide">
                                    <button class="close" data-close="alert"></button> Listo! </div>
                                <div class="portlet">
                                    <div class="portlet-title">

                                        <div class="actions btn-set">
                                            <a href="productos.php" name="back" class="btn btn-success">
                                                <i class="fa fa-angle-left"></i> Regresar</a>
                                            <button class="btn btn-success">
                                                <i class="fa fa-check"></i> Guardar</button>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tabbable-bordered">
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#tab1" data-toggle="tab"> General </a>
                                                </li>
                                                <li>
                                                    <a href="#tab2" data-toggle="tab"> Composición </a>
                                                </li>
                                                <li>
                                                    <a href="#tab3" data-toggle="tab"> Indicación </a>
                                                </li>
                                                <li>
                                                    <a href="#tab4" data-toggle="tab"> Presentación </a>
                                                </li>
                                                <li>
                                                    <a href="#tab5" data-toggle="tab"> Dosificación </a>
                                                </li>
                                                <li>
                                                    <a href="#tab6" data-toggle="tab"> Registro Invima </a>
                                                </li>
                                                <li>
                                                    <a href="#tab7" data-toggle="tab"> Contraindicaciones </a>
                                                </li>
                                                <li>
                                                    <a href="#tab8" data-toggle="tab"> Obs. CLínicas </a>
                                                </li>
                                                <li>
                                                    <a href="#tab9" data-toggle="tab"> Ind. Terapéutico MD </a>
                                                </li>
                                                <li>
                                                    <a href="#tab10" data-toggle="tab"> SEO </a>
                                                </li>
                                            </ul>
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab1">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Nombre:
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="nombre" placeholder=""> </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Imagen:</label>
                                                            <div class="col-md-10">
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
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Laboratorio:
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-10">
                                                                <select class="table-group-action-input form-control input-medium" name="laboratorio">
                                                                    <option value="">-Seleccione-</option>
                                                                    <?php 
                                                                    $resultado_mm = $mysqli->query("SELECT * FROM laboratorios ORDER BY nomlaboratorio");
                                                                    while ($row_mm = mysqli_fetch_array($resultado_mm)) {
                                                                        ?>
                                                                        <option value="<?php echo $row_mm['id']; ?>"><?php echo $row_mm["nomlaboratorio"]?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Categoría:
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-10">
                                                                <select class="table-group-action-input form-control input-medium" name="categoria">
                                                                    <option value="">-Seleccione-</option>
                                                                    <?php 
                                                                    $resultado_mm = $mysqli->query("SELECT * FROM categorias ORDER BY descategoria");
                                                                    while ($row_mm = mysqli_fetch_array($resultado_mm)) {
                                                                        ?>
                                                                        <option value="<?php echo $row_mm['idcategoria']; ?>"><?php echo $row_mm["descategoria"]?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Línea:
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-10">
                                                                <select class="table-group-action-input form-control input-medium" name="linea">
                                                                    <option value="">-Seleccione-</option>
                                                                    <?php 
                                                                    for ($i=1; $i <=2 ; $i++) { 
                                                                        ?>
                                                                        <option value="<?php echo $i ?>"><?php echo lineas($i) ?></option>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Precio:
                                                                <span class="required"> * </span>
                                                            </label>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="precio" placeholder="" onchange="puntillos(this);" onkeyup="puntillos(this);"> </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Promoción:</label>
                                                            <div class="col-md-10">
                                                                <div class="icheck-inline">
                                                                    <label class="">
                                                                        <div class="icheckbox_minimal-grey" style="position: relative;"><input type="checkbox" name="promocion" id="promocion" class="icheck" style="position: absolute; opacity: 0;" value="1"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>  </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Precio Promoción:</label>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="precio_promo" placeholder="" onchange="puntillos(this);" onkeyup="puntillos(this);"> </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Agotado:</label>
                                                            <div class="col-md-10">
                                                                <div class="icheck-inline">
                                                                    <label class="">
                                                                        <div class="icheckbox_minimal-grey" style="position: relative;"><input type="checkbox" name="agotado" id="agotado" class="icheck" style="position: absolute; opacity: 0;" value="1"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>  </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Ocultar:</label>
                                                            <div class="col-md-10">
                                                                <div class="icheck-inline">
                                                                    <label class="">
                                                                        <div class="icheckbox_minimal-grey" style="position: relative;"><input type="checkbox" name="inactivo" id="inactivo" class="icheck" style="position: absolute; opacity: 0;" value="1"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>  </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Producto del Mes:</label>
                                                            <div class="col-md-10">
                                                                <div class="icheck-inline">
                                                                    <label class="">
                                                                        <div class="icheckbox_minimal-grey" style="position: relative;"><input type="checkbox" name="destacado" id="destacado" class="icheck" style="position: absolute; opacity: 0;" value="1"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>  </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Meta Producto del Mes:</label>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="meta" placeholder="" value="">
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
                                                            <label class="col-md-2 control-label">Productos a recomendar:</label>
                                                            <div class="col-md-10">
                                                                <select multiple="multiple" class="multi-select" id="select_productos1" name="select_productos1[]">
                                                                <?php 
                                                                $resultado_mm = $mysqli->query("SELECT idproducto, desproducto, formafarmaceutica FROM productos ORDER BY desproducto");
                                                                while ($row_mm = mysqli_fetch_array($resultado_mm)) {
                                                                    ?>
                                                                    <option value="<?php echo $row_mm['idproducto']; ?>"><?php echo $row_mm["desproducto"].'('.$row_mm["formafarmaceutica"].')'?></option>
                                                                    <?php
                                                                }
                                                                ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                                                                                
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab2">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Descripción:</label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control maxlength-handler" rows="8" name="des_tab2"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab3">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Descripción:</label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control maxlength-handler" rows="8" name="des_tab3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab4">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Descripción:</label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control maxlength-handler" rows="8" name="des_tab4"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab5">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Descripción:</label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control maxlength-handler" rows="8" name="des_tab5"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab6">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Descripción:</label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control maxlength-handler" rows="8" name="des_tab6"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab7">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Descripción:</label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control max1length-handler" rows="8" name="des_tab7"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab8">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Descripción:</label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control maxlength-handler" rows="8" name="des_tab8"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab9">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Descripción:</label>
                                                            <div class="col-md-10">
                                                                <textarea class="form-control maxlength-handler" rows="8" name="des_tab9"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="tab10">
                                                    <div class="form-body">
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Title:</label>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="title" placeholder=""> </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="col-md-2 control-label">Description:</label>
                                                            <div class="col-md-10">
                                                                <input type="text" class="form-control" name="description" placeholder=""> </div>
                                                        </div>
                                                        <?php 
                                                        for ($i=1; $i<=6 ; $i++) { 
                                                            ?>
                                                            <div class="form-group">
                                                                <label class="col-md-2 control-label">(h<?php echo $i?>):</label>
                                                                <div class="col-md-10">
                                                                    <input type="text" class="form-control" name="h<?php echo $i?>" placeholder=""> </div>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>
                                                        
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
                        nombre:{
                            required: true
                        },
                        laboratorio: {
                            required : true
                        },
                        categoria: {
                            required : true
                        },
                        linea: {
                            required : true
                        },
                        precio: {
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
                            url: "producto_add_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                                location.href='productos.php';
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