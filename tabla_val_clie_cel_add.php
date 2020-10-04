<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
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
                                <a href="tabla_val_cli_cel.php">Valores clientes celebres</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="#">Nuevo Año</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Nuevo Año
                    </h3>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">

                                            <div class="portlet-body form">
                                                <div class="tab-content">
                                                    <form action="#" id="form_tabla_datos" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                        <div class="form-body">
                                                            <div class="alert alert-danger display-hide">
                                                                <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                            <div class="alert alert-success display-hide">
                                                                <button class="close" data-close="alert"></button> Listo! </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Año</label>                                                                            
                                                                        <select name="ano" id="ano" class="form-control"> 
                                                                        <?php 

                                                                        //CONSULTAMOS QUE AÑOS YA ESTAN CREADOS
                                                                        $anos_reg = array();

                                                                        $resultado = $mysqli->query("SELECT id,ano FROM tabla_valores_cli_celebres t ORDER BY t.ano DESC");
                                                                        while($row = mysqli_fetch_array($resultado))
                                                                        {
                                                                            array_push($anos_reg, $row["ano"]);
                                                                        }

                                                                        for ($i=(date('Y')-3); $i <= (date('Y')+3) ; $i++) 
                                                                        { 
                                                                            if (!in_array($i, $anos_reg))
                                                                            {
                                                                                ?>
                                                                                <option value="<?php echo $i ?>" <?php if($i==date('Y')){echo 'selected';}?>><?php echo $i ?></option>
                                                                                <?php
                                                                            }
                                                                        }
                                                                        ?> 
                                                                        </select>
                                                                    </div>
                                                                </div>   
                                                            </div> 
                                                            <div class="row">
                                                                <div class="table-scrollable">
                                                                    <table class="table table-striped table-hover">
                                                                        <thead>
                                                                            <tr>
                                                                                <th> </th>
                                                                                <th> Rango 1 </th>
                                                                                <th> Rango 2 </th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td> Porcentaje % </td>
                                                                                <td> <input type="text" name="porc1" id="porc1" placeholder="" class="form-control" value=""/> </td>
                                                                                <td> <input type="text" name="porc2" id="porc2" placeholder="" class="form-control" value=""/> </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> Contado </td>
                                                                                <td> <input type="text" name="val_1_1" id="val_1_1" placeholder="" class="form-control" value="" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                                                                                <td> <input type="text" name="val_1_2" id="val_1_2" placeholder="" class="form-control" value="" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> A 15 días </td>
                                                                                <td> <input type="text" name="val_2_1" id="val_2_1" placeholder="" class="form-control" value="" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                                                                                <td> <input type="text" name="val_2_2" id="val_2_2" placeholder="" class="form-control" value="" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> A 30 días </td>
                                                                                <td> <input type="text" name="val_3_1" id="val_3_1" placeholder="" class="form-control" value="" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                                                                                <td> <input type="text" name="val_3_2" id="val_3_2" placeholder="" class="form-control" value="" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> A 45 días </td>
                                                                                <td> <input type="text" name="val_4_1" id="val_4_1" placeholder="" class="form-control" value="" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                                                                                <td> <input type="text" name="val_4_2" id="val_4_2" placeholder="" class="form-control" value="" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td> A 60 días </td>
                                                                                <td> <input type="text" name="val_5_1" id="val_5_1" placeholder="" class="form-control" value="" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                                                                                <td> <input type="text" name="val_5_2" id="val_5_2" placeholder="" class="form-control" value="" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <div class="margiv-top-10 form-actions">
                                                                <button type="submit" class="btn green">Guardar Cambios</button>
                                                                <a href="tabla_val_cli_cel.php" class="btn default"> Regresar </a>
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
        <script src="assets/global/plugins/decimales/decimales.js" type="text/javascript"></script>

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
                var form = $('#form_tabla_datos');
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

                        /*var formulario = $('#form_tabla_datos').serializeArray();
                        alert(formulario);*/
                        var formData = new FormData(document.getElementById("form_tabla_datos"));
                        formData.append("dato", "valor");
                        
                       $.ajax({
                            url: "ajax_paginas/ajax_tabla_val_cli_cel_add_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                                location.href='tabla_val_cli_cel.php';
                            });
                        });
                        return false;
                    }

                });
 

            
            });

        </script>
    </body>

</html>