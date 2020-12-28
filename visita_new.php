<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = 'itinerario';
extract($_GET);
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
                                <a href="itinerario.php">Itinerario</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="#">Visita Nueva</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Nueva Visita
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
                                                    <span class="caption-subject font-blue-madison bold uppercase">Datos de la visita</span>
                                                </div>
                                            </div>
                                            <?php
                                            $resultado = $mysqli->query("SELECT u.*, m.tipo_cliente_celebre FROM usuarios u LEFT JOIN medicos m ON m.usuario_id = u.id  WHERE u.id = $id"); 
                                            $row = mysqli_fetch_array($resultado);
                                            ?>
                                            <div class="portlet-body form">
                                                <form action="#" id="form_visita_nueva" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active">

                                                            <div class="form-body">
                                                                <div class="alert alert-danger display-hide">
                                                                    <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                                <div class="alert alert-success display-hide">
                                                                    <button class="close" data-close="alert"></button> Listo! </div>

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Cliente</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                     <b> <?php echo $row['nom'].' '.$row['ape1'].' '.$row['ape2']?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Fecha</label>
                                                                            <div class="col-md-10">
                                                                            <?php 
                                                                            if($_SESSION["permiso_cambio_fecha"] == 1)
                                                                            {
                                                                            ?>                                  
                                                                                <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="">
                                                                                    <input type="text" name="fecha_visita"class="form-control" readonly value="<?php echo date('Y-m-d') ?>">
                                                                                    <span class="input-group-btn">
                                                                                        <button class="btn default" type="button">
                                                                                            <i class="fa fa-calendar"></i>
                                                                                        </button>
                                                                                    </span>
                                                                                </div>
                                                                                <?php
                                                                            }
                                                                            else
                                                                            {
                                                                                ?>
                                                                                <p class="form-control-static">
                                                                                     <b><?php echo escribir_fecha(date('Y-m-d')) ?></b>
                                                                                </p>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Literatura</label>
                                                                            <div class="col-md-10">
                                                                                <select multiple="multiple" class="multi-select" id="select_lite1" name="select_lite1[]">
                                                                                <?php 
                                                                                $resultado_lit = $mysqli->query("SELECT * FROM literaturas WHERE estado = 0 ORDER BY descripcion");
                                                                                while ($row_lit = mysqli_fetch_array($resultado_lit)) {
                                                                                    ?>
                                                                                    <option value="<?php echo $row_lit['id']; ?>"><?php echo $row_lit['descripcion']; ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Obsequios</label>
                                                                            <div class="col-md-10">
                                                                                <select multiple="multiple" class="multi-select" id="select_obse1" name="select_obse1[]">
                                                                                <?php 
                                                                                $resultado_obs = $mysqli->query("SELECT * FROM obsequios WHERE estado = 0 ORDER BY descripcion");
                                                                                while ($row_obs = mysqli_fetch_array($resultado_obs)) {
                                                                                    ?>
                                                                                    <option value="<?php echo $row_obs['id']; ?>"><?php echo $row_obs['descripcion']; ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Muestra Médica</label>
                                                                            <div class="col-md-10">
                                                                                <select multiple="multiple" class="multi-select" id="select_muestra1" name="select_muestra1[]">
                                                                                <?php 
                                                                                $resultado_mm = $mysqli->query("SELECT idproducto, desproducto, formafarmaceutica FROM productos WHERE oculto = 0 ORDER BY desproducto");
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

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Observación</label>
                                                                            <div class="col-md-10"><textarea name="observacion" id="observacion" cols="30" rows="3" class="form-control"></textarea></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Acción</label>
                                                                            <div class="col-md-10"><textarea name="accion" id="accion" cols="30" rows="3" class="form-control"></textarea></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Contacto</label>
                                                                            <div class="col-md-10">
                                                                                <select name="contacto" id="contacto" class="form-control">
                                                                                    <option value="">-Seleccione-</option>
                                                                                    <?php 
                                                                                    $resultado_contacto = $mysqli->query("SELECT * FROM tipo_contactos ORDER BY descripcion");
                                                                                    while ($row_contacto = mysqli_fetch_array($resultado_contacto)) {
                                                                                        ?>
                                                                                        <option value="<?php echo $row_contacto['id']; ?>"><?php echo $row_contacto["descripcion"];?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Prioridad</label>
                                                                            <div class="col-md-10">
                                                                                <select name="prioridad" id="prioridad" class="form-control">
                                                                                    <option value="">-Seleccione-</option>
                                                                                    <option value="MA">Muy Alta</option>
                                                                                    <option value="A">Alta</option>
                                                                                    <option value="M">Media</option>
                                                                                    <option value="B">Baja</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="margiv-top-10 form-actions">
                                                        <button type="submit" class="btn green">Guardar Cambios</button>
                                                        <a href="itinerario.php" class="btn default"> Cancelar </a>
                                                        <input type="hidden" name="hdd_id" value="<?php echo $id ?>">
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

        <script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
        <script src="assets/pages/scripts/profile.min.js" type="text/javascript"></script>


        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

        <script>
            jQuery(document).ready(function() {
                
                //SELECCIONA LOS CAMPOS DE LA IZQUIERDA A LA DERECHA LITERATURA
                $('#select_lite1').multiSelect();
                $('#select_lite2').multiSelect({
                    selectableOptgroup: true
                });

                //SELECCIONA LOS CAMPOS DE LA IZQUIERDA A LA DERECHA OBSEQUIOS
                $('#select_obse1').multiSelect();
                $('#select_obse2').multiSelect({
                    selectableOptgroup: true
                });


                ///////////////////////////////////////////////////////////////////////

                //SELECCIONA LOS CAMPOS DE LA IZQUIERDA A LA DERECHA MUESTRA MEDICA
                $('#select_muestra1').multiSelect();
                $('#select_muestra2').multiSelect({
                    selectableOptgroup: true
                });
                //FORMULARIO DATOS BASICOS
                var form = $('#form_visita_nueva');
                var error = $('.alert-danger', form);
                var success = $('.alert-success', form);


                form.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
                        contacto: {
                            required: true
                        },
                        prioridad: {
                            required: true
                        },
                        accion: {
                            minlength: 3,
                            required: true
                        },
                        observacion: {
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
                        var formData = new FormData(document.getElementById("form_visita_nueva"));
                        formData.append("dato", "valor");
                        
                       $.ajax({
                            url: "visita_new_add_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                                document.location.href = "itinerario.php";
                            });
                        });
                        return false;
                    }

                });

                 //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
                $('.select2me', form).change(function () {
                    form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
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

                $("#departamento2").change(function () {         
                    $("#departamento2 option:selected").each(function () {
                        
                        $("#municipio2").attr("disabled");
                        $("#municipio2").val("");
                                
                        var elegido=$(this).val();
                        //alert(elegido);
                        if( elegido != '')
                        {
                            $.post("municipios.php", { elegido: elegido }, function(data){
                                $("#municipio2").removeAttr("disabled");
                                $("#municipio2").html(data);
                                
                            });            
                        }
                        else
                        {
                            $("#municipio2").attr("disabled","");
                            $("#municipio2").val("");
                        }
                    });
                });

            
            });

        </script>
    </body>

</html>