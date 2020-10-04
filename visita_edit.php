<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = '';
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
                                <a href="#">Editar Visita</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Editar Visita
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
                                            //CONSULTAMOS LOS DATOS DE LA VISITA
                                            $resultado = $mysqli->query("SELECT * FROM visitas v WHERE id=".$id_visita);    
                                            $row = mysqli_fetch_array($resultado);


                                            //SACO LOS VALORES DE LA LITERATURAS
                                            $literarura = explode(";",$row['literatura']);
                                            $imp_literatura = '';
                                            
                                            for($i=0; $i<(sizeof($literarura)-1); $i++)
                                            {

                                                $resultado_lit = $mysqli->query("SELECT descripcion FROM literaturas 
                                                        WHERE id = ".$literarura[$i]);  
                                                $row2= mysqli_fetch_array($resultado_lit);
                                                
                                                $imp_literatura.= $row2['descripcion'].', ';
                                            }

                                            $obsequios = explode(";",$row['obsequios']);
                                            $imp_obsequios = '';
                                            
                                            for($i=0; $i<(sizeof($obsequios)-1); $i++)
                                            {

                                                $resultado_obs = $mysqli->query("SELECT descripcion FROM obsequios 
                                                            WHERE id = ".$obsequios[$i]);  
                                                $row3= mysqli_fetch_array($resultado_obs);
                                                    
                                                $imp_obsequios.= $row3['descripcion'].', ';
                                            
                                            }
                                            
                                            //SACO LOS VALORES DE LAS MUESTRA MEDICAS ENTREGADAS
                                            $muestra = explode(";",$row['muestra']);
                                            $imp_muestra = '';
                                            
                                            for($i=0; $i<(sizeof($muestra)-1); $i++)
                                            {

                                                $resultado_mue = $mysqli->query("SELECT desproducto, formafarmaceutica FROM productos
                                                                WHERE idproducto = ".$muestra[$i]);  
                                                $row4= mysqli_fetch_array($resultado_mue);
                                                    
                                                $imp_muestra.= $row4['desproducto'].'('.$row4['formafarmaceutica'].'), ';
                                            
                                            }
                                            
                                            //SACO EL TIPO DE CONTACTO
                                            $resultado_cat = $mysqli->query("SELECT id,descripcion FROM tipo_contactos WHERE id = ".$row['contacto']);  
                                            $row5 = mysqli_fetch_array($resultado_cat);


                                            /* DATOS DEL USUARIO */
                                            $usuario = explode(";", consulta_usuarios($row['usuario_id']));
                                            
                                            ?>
                                            <div class="portlet-body form">
                                                <form action="#" id="form_editar_visita" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
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
                                                                                     <b> <?php echo $usuario[0]?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Fecha</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                     <b><?php echo escribir_fecha(date('Y-m-d')) ?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Literatura</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                    <b><?php echo $imp_literatura ?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Obsequios</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                    <b><?php echo $imp_obsequios ?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Muestra Médica</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                    <b><?php echo $imp_muestra ?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Observación</label>
                                                                            <div class="col-md-10"><textarea name="observacion" id="observacion" cols="30" rows="3" class="form-control"><?php echo $row['observacion'] ?></textarea></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Acción</label>
                                                                            <div class="col-md-10"><textarea name="observacion" id="observacion" cols="30" rows="3" class="form-control"><?php echo $row['accion'] ?></textarea></div>
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
                                                                                        <option value="<?php echo $row_contacto['id']; ?>" <?php if($row5['id'] == $row_contacto['id']) { echo 'selected';} ?>><?php echo $row_contacto["descripcion"];?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Comentario</label>
                                                                            <div class="col-md-10"><textarea name="comentario" id="comentario" cols="30" rows="3" class="form-control"></textarea></div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="col-md-2 control-label">Revisada</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <div class="icheck-inline">
                                                                                        <label class="">
                                                                                            <div class="icheckbox_minimal-grey" style="position: relative;"><input type="checkbox" name="validar" class="icheck" style="position: absolute; opacity: 0;" value="1"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>  </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="margiv-top-10 form-actions">
                                                        <button type="submit" class="btn green">Guardar Cambios</button>
                                                        <a href="index.php" class="btn default"> Cancelar </a>
                                                        <input type="hidden" name="hdd_id" value="<?php echo $id_visita ?>">
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

        <script src="assets/pages/scripts/profile.min.js" type="text/javascript"></script>


        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

        <script>
            jQuery(document).ready(function() {
            

                ///////////////////////////////////////////////////////////////////////

                //SELECCIONA LOS CAMPOS DE LA IZQUIERDA A LA DERECHA MUESTRA MEDICA
                $('#select_muestra1').multiSelect();
                $('#select_muestra2').multiSelect({
                    selectableOptgroup: true
                });
                //FORMULARIO DATOS BASICOS
                var form = $('#form_editar_visita');
                var error = $('.alert-danger', form);
                var success = $('.alert-success', form);


                form.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
                        validar: {
                            required: true
                        },
                        comentario: {
                            minlength: 3
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
                        var formData = new FormData(document.getElementById("form_editar_visita"));
                        formData.append("dato", "valor");
                        
                       $.ajax({
                            url: "visita_edit_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                                document.location.href = "index.php";
                            });
                        });
                        return false;
                    }

                });

                 //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
                $('.select2me', form).change(function () {
                    form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
                });    

            
            });

        </script>
    </body>

</html>