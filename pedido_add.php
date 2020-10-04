<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = 'nueva_orden';




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
                                <a href="pedidos.php">Ordenes</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <a href="#">Nueva Orden</a>
                            </li>
                        </ul>
                    </div>


                    <h3 class="page-title"> Nueva orden de pedido</h3>
                    <?php

                    //BORRAMOS EL PEDIDO QUE SE HALLA REALIZADO CON LA SESION ACTUAL

                    $session_id= session_id(); 

                    $eliminar = "DELETE FROM pedido_tmp WHERE session_id = '".$session_id."'";
                    $mysqli->query($eliminar);
                    ?>
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
                                                                <button type="submit" class="btn btn-info">
                                                                    <span class="glyphicon glyphicon-plus"></span> Agregar productos
                                                                </button>
                                                                <!--<button type="submit" class="btn green">Consultar</button>-->
                                                            </div>                                                            
                                                        </div> 


                                                        <div class="row margin-top-20">                                                            
                                                            <div id="resultados" class='col-md-8'></div>
                                                            <div class="col-md-4">
                                                                <div class="mt-element-list">
                                                                    <div class="mt-list-head list-simple ext-1 font-white bg-green-sharp">
                                                                        <div class="list-head-title-container">
                                                                            <h3 class="list-title">Productos del Mes</h3>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mt-list-container list-simple">
                                                                        <ul>
                                                                        <?php 
                                                                        $resultado= $mysqli->query("SELECT p.desproducto FROM productos p WHERE p.destacado = 1");
                                                                        while($row = mysqli_fetch_array($resultado))
                                                                        {
                                                                        ?>
                                                                            <li class="mt-list-item done">
                                                                                <div class="list-icon-container">
                                                                                    <i class="icon-check"></i>
                                                                                </div>

                                                                                <div class="list-item-content">
                                                                                    <h3 class="uppercase">
                                                                                        <?php echo $row['desproducto']; ?>
                                                                                    </h3>
                                                                                </div>
                                                                            </li>
                                                                        <?php 
                                                                        } ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div id="consulta"></div>
                                                            </div>
                                                        </div>

                                                        <!-- Modal -->
                                                        <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                          <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                              <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                <h4 class="modal-title" id="myModalLabel">Buscar productos</h4>
                                                              </div>
                                                              <div class="modal-body">
                                                                <form class="form-horizontal">
                                                                  <div class="form-group">
                                                                    <div class="col-sm-6">
                                                                      <input type="text" class="form-control" id="q" placeholder="Buscar productos" onkeyup="load(1)">
                                                                    </div>
                                                                    <button type="button" class="btn btn-default" onclick="load(1)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
                                                                  </div>
                                                                  <input type="hidden" name="hdd_cliente" id="hdd_cliente" value="">
                                                                </form>
                                                                <div id="cargando" align="center" class="cbp"></div>
                                                                <div class="outer_div" ></div><!-- Datos ajax Final -->
                                                              </div>
                                                              <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
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

                //load(1);

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
            
            });
            
            
            function load(page,id){

                
                var q= $("#q").val();
                //alert(id);
                if (isNaN(id)) { 
                    id = $("#hdd_cliente").val();
                }

                var parametros={"action":"ajax","page":page,"q":q,"cliente":id};
                $("#loader").fadeIn('slow');
                $.ajax({
                    url:'ajax_paginas/ajax_pedido_productos.php',
                    data: parametros,
                     beforeSend: function(objeto){
                     //$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
                     //$("#cargando").show();
                  },
                    success:function(data){
                        $(".outer_div").html(data).fadeIn('slow');
                        //$('#loader').html('');
                        $('#cargando').hide(); 
                        
                    }
                })
            }


            function agregar (id)
            {

                var precio_venta=$('#precio_venta_'+id).val();
                var cantidad=$('#cantidad_'+id).val();
                //Inicia validacion
                if (isNaN(cantidad))
                {
                    alert('Esto no es un numero');
                    document.getElementById('cantidad_'+id).focus();
                    return false;
                }
                if (isNaN(precio_venta))
                {
                    alert('Esto no es un numero');
                    document.getElementById('precio_venta_'+id).focus();
                    return false;
                }
                //Fin validacion
                var parametros={"id":id,"precio_venta":precio_venta,"cantidad":cantidad};   
                $.ajax({
                    type: "POST",
                    url: "ajax_paginas/ajax_agregar_pedido.php",
                    data: parametros,
                    beforeSend: function(objeto){
                        $("#resultados").html("Mensaje: Cargando...");
                    },
                    success: function(datos){
                        $("#resultados").html(datos);
                    }
                });
            }
            
            function eliminar (id)
            {
                
                $.ajax({
                    type: "GET",
                    url: "ajax_paginas/ajax_agregar_pedido.php",
                    data: "id="+id,
                     beforeSend: function(objeto){
                        $("#resultados").html("Mensaje: Cargando...");
                      },
                    success: function(datos){
                    $("#resultados").html(datos);
                    }
                });

            }
            
            $("#datos_pedido").submit(function(){
              var proveedor = $("#proveedor").val();
              var transporte = $("#transporte").val();
              var condiciones = $("#condiciones").val();
              var comentarios = $("#comentarios").val();
              if (proveedor>0)
             {
                VentanaCentrada('./pdf/documentos/pedido_pdf.php?proveedor='+proveedor+'&transporte='+transporte+'&condiciones='+condiciones+'&comentarios='+comentarios,'Pedido','','1024','768','true');  
             } else {
                 alert("Selecciona el proveedor");
                 return false;
             }
             
            });


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

                    var id_cliente = $("#cliente").val();

                    var id= $("#hdd_cliente").val();
                    //alert(id);
                    load(1,id_cliente);
                    $("#hdd_cliente").val(id_cliente);
                    $('#myModal').modal('show'); 
                    $("#cliente").prop('disabled', 'disabled');

                    return false;
                }

            });

            $("#cliente").change(function(){
                var elegido=$(this).val();
                //alert(elegido);
                if( elegido != '')
                {
                    $.post("ayuda_pedido.php", { elegido: elegido }, function(data){
                        $("#consulta").html(data);
                        
                    });            
                }
            });


        </script>
    </body>

</html>