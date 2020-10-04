<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = 'movimientos';

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
                                <a href="#">Movimientos</a>
                                <i class="fa fa-circle"></i>
                            </li>
                        </ul>
                    </div>


                    <h3 class="page-title"> Movimientos de Cuenta</h3>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="tab-pane">
                                                <form action="#" id="form_consultar" class="margin-bottom-20" enctype="multipart/form-data" autocomplete="off">
                                                    <div class="form-body">
                                                        <div class="alert alert-danger display-hide">
                                                            <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                        <div class="alert alert-success display-hide">
                                                            <button class="close" data-close="alert"></button> Listo! </div>
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group">
                                                                    <label for="span_small" class="control-label">Cliente</label>
                                                                    <select id="cliente" name="cliente" class="form-control input-sm select2">
                                                                        <option value="">-Seleccione-</option>
                                                                        <?php 
                                                                        $resultado= $mysqli->query("SELECT u.id, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS nombre FROM medicos m JOIN usuarios u ON m.usuario_id = u.id WHERE m.habilitado = 1 AND u.estado = 1 ORDER BY nombre");
                                                                        while($row = mysqli_fetch_array($resultado))
                                                                        {
                                                                        ?>
                                                                        <option value="<?php echo $row['id'] ?>"><?php echo $row['nombre'] ?></option>
                                                                        <?php 
                                                                        } ?>                                                                  
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="span_small" class="control-label">Filtrar por fecha</label>
                                                                    <div class="input-group input-large date-picker input-daterange" data-date="" data-date-format="yyyy-mm-dd">
                                                                        <input type="text" class="form-control" name="fecha_ini" id="fecha_ini">
                                                                        <span class="input-group-addon"> al </span>
                                                                        <input type="text" class="form-control" name="fecha_fin"> 
                                                                    </div>
                                                                </div>
                                                                <button type="submit" class="btn green">Consultar</button>
                                                            </div>                                                            
                                                        </div> 


                                                        <div class="row">
                                                            <div id="cargando" align="center" class="cbp"></div>
                                                            <div id="div_listar"></div>
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

        <!-- Modal para agregar movimientos. -->
        <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <form action="#" id="form_add_movimiento" class="form-horizontal" enctype="" autocomplete="off">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button> Listo! </div>
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">---</h4>
                        </div>
                        <div class="modal-body">

                            <div class="form-group">
                                <label for="color" class="col-sm-2 control-label">Tipo</label>
                                <div class="col-sm-10">
                                    <select name="tipo" class="form-control" id="tipo">
                                        <option value="">-Seleccione-</option>   
                                        <option value="1">Créditos</option>
                                        <option value="2">Saldo Efectivo</option>                                                 
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="tipo_consignacion">
                                <label for="color" class="col-sm-2 control-label">Tipo de pago</label>
                                <div class="col-sm-10">
                                    <select name="tipo_con" class="form-control" id="tipo_con">
                                        <?php
                                        for($i=0; $i<=3; $i++)
                                        {
                                            ?>
                                            <option value="<?php if($i != 0) { echo $i; }?>"><?php echo tipo_transaccion($i)?></option>
                                            <?php
                                        }
                                        ?>                                                     
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="tipo_retiro">
                                <label for="color" class="col-sm-2 control-label">Tipo de retiro</label>
                                <div class="col-sm-10">
                                    <select name="tipo_ret" class="form-control" id="tipo_ret">
                                        <option value="">-Seleccione-</option>
                                        <?php
                                        for($i=4; $i<=5; $i++)
                                        {
                                            ?>
                                            <option value="<?php if($i != 0) { echo $i; }?>"><?php echo tipo_transaccion($i)?></option>
                                            <?php
                                        }
                                        ?>                                                     
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Consignación</label>
                                <div class="col-sm-10">
                                    <input type="text" name="valor" class="form-control" id="valor" onchange="puntillos(this);" onkeyup="puntillos(this);">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="start" class="col-sm-2 control-label">Fecha</label>
                                <div class="col-md-10">
                                    <div class="input-group date date-picker" data-date-format="yyyy-mm-dd">
                                        <input type="text" size="16" readonly="" class="form-control" id="fecha" name="fecha" value="<?php echo date('Y-m-d'); ?>">
                                        <span class="input-group-btn">
                                            <button class="btn default date-set" type="button">
                                            <i class="fa fa-calendar"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">Descripción</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="descripcion" id="descripcion"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" name="hdd_id" id="hdd_id">
                            <input type="hidden" name="tipo_operacion" id="tipo_operacion">
                            <input type="hidden" name="saldo_prep" id="saldo_prep">
                            <input type="hidden" name="saldo_efec" id="saldo_efec">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" name="accion" id="accion">Guardar</button>
                        </div>
                    </form>
                    
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
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>


        <script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>


        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

        <script>
            jQuery(document).ready(function() {

                $('#cargando').hide();
                
                $('.date-picker').datepicker({
                    language: 'es',
                    rtl: App.isRTL(),
                    orientation: "left",
                    autoclose: true,
                    todayBtn: true,
                });


                /*=============================================
                =              Sacamos el cliente             =
                =============================================*/
                
                var placeholder = "Seleccione el Cliente";

                $(".select2, .select2-multiple").select2({
                    placeholder: placeholder,
                    width: null
                });
                
                /*================  FIN  ===================*/
                
                

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
                        cliente: {
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
                            url: "ajax_paginas/ajax_movimientos.php",
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
         
                
                /////////DATOS DEL MODAL */////////////////////
                $(document).on('click', '.btn_consulta', function(){

                    
                    var cadena = $(this).attr("id").split(";")
                    var id = cadena[0]; //CAPTURAMOS EL ID
                    var tipo_operacion = cadena[1]; //CAPTURAMOS EL TIPO DE OPERACION
                    var saldo_prep = cadena[2];
                    var saldo_efec = cadena[3];

                    if(id != '')
                    {
                        if(tipo_operacion == 1){
                            $('.modal-title').text("INGRESO");
                            $('#tipo_consignacion').show();
                            $('#tipo_retiro').hide();
                            $("#tipo_con").attr('disabled', false);
                            $("#tipo_ret").attr('disabled', true);
                        }
                        else if(tipo_operacion == 2){
                            $('.modal-title').text("RETIRO");
                            $('#tipo_consignacion').hide();
                            $('#tipo_retiro').show();
                            $("#tipo_con").attr('disabled', true);
                            $("#tipo_ret").attr('disabled', false);
                        }
                        $('#ModalAdd').modal('show'); 
                        $('#accion').val('crear');
                        $('#hdd_id').val(id);
                        $('#tipo_operacion').val(tipo_operacion);
                        $('#saldo_efec').val(saldo_efec);
                        $('#saldo_prep').val(saldo_prep);

                    }
                    

                });

                //CUANDO DAMOS CLIC EN EL BOTON GUARDAR  BUSCA LA OPCION
                $('#accion').click(function(){

                    var tipo_operacion = $('#tipo_operacion').val();

                    //FORMULARIO VALIDAR DATOS DEL MODAL
                    var accion = $('#accion').val(); 

                    var form = $('#form_add_movimiento');
                    var error = $('.alert-danger', form);
                    var success = $('.alert-success', form);
                    //alert(tipo_operacion);

                    form.validate({
                        errorElement: 'span', //
                        errorClass: 'help-block help-block-error', // 
                        focusInvalid: false, // 
                        ignore: "", // 

                        rules: {
                            tipo: {
                                required: true
                            },
                            
                            tipo_con: {
                                required: true
                            }, 
                            
                            tipo_ret: {
                                required: true                            
                            }, 
                            valor: {
                                required: true
                            },
                            fecha: {
                                required: true
                            },
                            descripcion: {
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

                            //var formulario = $('#form_add_movimiento').serializeArray();
                            //alert(formulario);
                            var formData = new FormData(document.getElementById("form_add_movimiento"));
                            formData.append("dato", "valor");
                            

                            $.ajax({
                                url: "ajax_paginas/ajax_movimiento_add_bd.php",
                                type: "post",
                                dataType: "html",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                

                            })
                            .done(function(res){
                                //console.log(res);
                                var respuesta = res.split(';');
                                alertify.alert(respuesta[0], function(ev) {

                                    //console.log(respuesta[1]);
                                    $('#ModalAdd').modal('hide');
                                    $('#tipo > option[value=""]').attr('selected', 'selected');
                                    $('#tipo_con > option[value=""]').attr('selected', 'selected');
                                    $('#tipo_ret > option[value=""]').attr('selected', 'selected');
                                    $('#valor').val('');
                                    $('#descripcion').val('');
                                    //var cliente = data;


                                    //******************************//
                                    $.ajax({
                                        url: 'ajax_paginas/ajax_movimientos.php',
                                        type: "POST",
                                        data: {cliente:respuesta[1]},

                                        success: function(data){
                                            $("#div_listar").html(data);
                                            $('#cargando').hide(); 
                                        }

                                    })
                                    /*if(respuesta[1] == 1){
                                        document.location.href = "comer_cotizador_print.php?cli="+respuesta[2];
                                    }
                                    else {
                                        document.location.href = "comer_inmuebles.php?proy="+respuesta[3];
                                    }*/
                                    
                                });
                            });
                            return false;
                        }

                    });

                });


                 

            
            });

        </script>
    </body>

</html>