<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/utilidades.php');
$pagina = 'planeador';


//CONSULTAMOS TODOS LOS EVENTOS

//AGREGAR SOLO UN ASESOR
$cons_zonas = $cons_zonas_select = '';

if($_SESSION['rol_usu'] ==  1)
{
    $resultado = $mysqli->query("SELECT id as zona FROM zonas z WHERE id_vendedor = ".$_SESSION["idusuario"]); 
    $zn='';
                    
    while($row_zon= mysqli_fetch_array($resultado))
    {
        $zn.= $row_zon['zona'].','; 
    }
    $cons_zonas = ' AND m.zona IN ('.substr ($zn , 0, -1 ).')';
    $cons_zonas_select = ' WHERE id IN ('.substr ($zn , 0, -1 ).')';
}

///CONSULTA PARA TODOS LOS ASESORES
$resultado_agenda = $mysqli->query("SELECT a.id, UPPER(CONCAT_WS(' ',u.nom,u.ape1,u.ape2)) AS cliente, a.vendedor, a.observacion, a.color, a.inicio, a.fin FROM agendas a JOIN usuarios u ON a.medico = u.id  JOIN medicos m ON u.id = m.usuario_id WHERE a.inicio >= '".date('Y-01-01')." 00:00:00' $cons_zonas");    


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
                                <a href="#">Planeador</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Planeador de Visitas
                    </h3>
                    
                    <!-- ACA EMPIEZA EL CONTENIDO -->  
                    <div class="row">
                        <div class="col-md-12">
                            <div class="portlet light portlet-fit bordered calendar">
                                <div class="portlet-title">

                                </div>
                                <div class="portlet-body">
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12">
                                            <div id="calendar" class="has-toolbar"></div>
                                        </div>
                                    </div>

                                    <!-- MODAL PARA AGREGAR EVENTO -->
                                    <div class="modal fade" id="ModalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                      <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                       <!-- <form class="form-horizontal" method="POST" action="planeador_add_bd.php">-->
                                        <form action="#" id="form_add_cita" class="form-horizontal" enctype="" autocomplete="off">

                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Agendar</h4>
                                          </div>
                                          <div class="modal-body">
                                            <div class="form-group">
                                                <label for="color" class="col-sm-2 control-label">Zona</label>
                                                <div class="col-sm-10">
                                                    <select name="zona" class="form-control" id="zona">
                                                        <option value="">-Seleccione-</option>
                                                        <?php 
                                                        $resultado = $mysqli->query("SELECT id, des FROM zonas $cons_zonas_select"); 
                                                        while($row = mysqli_fetch_array($resultado))
                                                        {
                                                        ?>
                                                            <option style="" value="<?php echo $row['id'] ?>"><?php echo $row['des'] ?></option>
                                                        <?php 
                                                        }
                                                        ?>                                                      
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="color" class="col-sm-2 control-label">Cliente</label>
                                                <div class="col-sm-10">
                                                    <select name="cliente" class="form-control" id="cliente">
                                                      <option value="">-Seleccione-</option>                                                    
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="title" class="col-sm-2 control-label">Observación</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="observacion" class="form-control" id="observacion" placeholder="Observación">
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <label for="color" class="col-sm-2 control-label">Color</label>
                                                <div class="col-sm-10">
                                                    <select name="color" class="form-control" id="color">
                                                        <option value="">-Seleccione-</option>
                                                        <option style="color:#0071c5;" value="#0071c5">&#9724; Azul</option>
                                                        <option style="color:#40E0D0;" value="#40E0D0">&#9724; Turquesa</option>
                                                        <option style="color:#008000;" value="#008000">&#9724; Verde</option>                       
                                                        <option style="color:#FFD700;" value="#FFD700">&#9724; Amarillo</option>
                                                        <option style="color:#FF8C00;" value="#FF8C00">&#9724; Naranaja</option>
                                                        <option style="color:#FF0000;" value="#FF0000">&#9724; Rojo</option>                                                      
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="start" class="col-sm-2 control-label">Inicio</label>
                                                <div class="col-md-10">
                                                    <div class="input-group date form_datetime">
                                                        <input type="text" size="16" readonly="" class="form-control" id="inicio" name="inicio">
                                                        <span class="input-group-btn">
                                                            <button class="btn default date-set" type="button">
                                                            <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                          </div>
                                        </form>
                                        </div>
                                      </div>
                                    </div>

                                    <!-- MODAL PARA EDITAR EVENTO -->
                                    <div class="modal fade" id="ModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <form class="form-horizontal" method="POST" action="planeador_delete_bd.php">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel">Eliminar cita</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="title" class="col-sm-2 control-label">Medico</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="title" class="form-control" id="title" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="col-sm-2 control-label">Medico</label>
                                                            <div class="col-sm-10">
                                                                <textarea name="obs" id="obs" class="form-control" readonly></textarea>
                                                            </div> 
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="col-sm-2 control-label">Inicio</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="inicio" class="form-control" id="inicio" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="title" class="col-sm-2 control-label">Fin</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="fin" class="form-control" id="fin" readonly>
                                                            </div>
                                                        </div>
                                                        <!--<div class="form-group"> 
                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                <div class="checkbox">
                                                                    <label class="text-danger"><input type="checkbox"  name="delete"> Eliminar</label>
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                        <input type="hidden" name="hdd_id" class="form-control" id="hdd_id">
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary red">Eliminar</button>
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

        <script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/fullcalendar/lang/es.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.es.js" type="text/javascript"></script>
        <script src="assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>


        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        
        <script>

        $(document).ready(function() {
            
            $(".form_datetime").datetimepicker({
                language: 'es',
                autoclose: true,
                isRTL: App.isRTL(),
                format: "yyyy-mm-dd  hh:ii:ss",
                showMeridian: true,
                pickerPosition: (App.isRTL() ? "bottom-right" : "bottom-left"),
                todayBtn: true,
                
            });


            $('#calendar').fullCalendar({

                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                minTime: "06:00:00",
                maxTime: "21:00:00",
                defaultView: 'agendaDay',
                defaultDate: '<?php echo date('Y-m-d'); ?>',
                editable: true,
                eventLimit: false, // allow "more" link when too many events
                selectable: true,
                selectHelper: true,
                axisFormat: 'h:mm a',

                timeFormat: 'h:mm a -',

                select: function(start, end) {

                    $('#ModalAdd #inicio').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                    //$('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                    //$('#ModalAdd #dato_inicial').attr("data-date",moment(start).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd').modal('show');
                },
                eventRender: function(event, element) {
                    element.bind('dblclick', function() {
                        $('#ModalEdit #hdd_id').val(event.id);
                        $('#ModalEdit #title').val(event.title);
                        $('#ModalEdit #obs').val(event.obs);
                        $('#ModalEdit #inicio').val(event.start);
                        $('#ModalEdit #fin').val(event.end);
                        $('#ModalEdit').modal('show');
                    });
                },
                eventDrop: function(event, delta, revertFunc) { // si changement de position

                    edit(event);

                },
                eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

                    edit(event);

                },
                events: [
                <?php //foreach($events as $event): 
                
                while($events = mysqli_fetch_array($resultado_agenda))
                {
                    $usuario = explode(";", consulta_usuarios($events['vendedor']));
                    $start = explode(" ", $events['inicio']);
                    $end = explode(" ", $events['fin']);
                    if($start[1] == '00:00:00'){
                        $start = $start[0];
                    }else{
                        $start = $events['inicio'];
                    }
                    if($end[1] == '00:00:00'){
                        $end = $end[0];
                    }else{
                        $end = $events['fin'];
                    }
                ?>
                    {
                        id: '<?php echo $events['id']; ?>',
                        title: '<?php echo $events['cliente'].' ('.$usuario[0].')'; ?>',
                        obs: '<?php echo $events['observacion']; ?>',
                        start: '<?php echo $start; ?>',
                        end: '<?php echo $end; ?>',
                        color: '<?php echo $events['color']; ?>',
                    },
                <?php } ?>   
                ],
                
            });
            
            function edit(event){
                start = event.start.format('YYYY-MM-DD HH:mm:ss');
                if(event.end){
                    end = event.end.format('YYYY-MM-DD HH:mm:ss');
                }else{
                    end = start;
                }
                
                id =  event.id;
                
                Evento = [];
                Evento[0] = id;
                Evento[1] = start;
                Evento[2] = end;

                $.ajax({
                 url: 'planeador_edit_bd.php',
                 type: "POST",
                 data: {Evento:Evento},

                 success: function(rep) {
                    //console.log(rep)
                        if(rep == 'OK'){
                            alertify.alert('Cita movida');
                        }else{
                            alertify.alert('No se pudo mover la cita');
                        }
                    }
                });
            }


            //FORMULARIO DATOS BASICOS
            var form = $('#form_add_cita');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);


            form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
                    zona: {
                        required: true
                    },
                    cliente: {
                        required: true
                    },
                    inicio: {
                        required: true
                    },
                    observacion: {
                        minlength: 3,
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
                    var formData = new FormData(document.getElementById("form_add_cita"));
                    formData.append("dato", "valor");
                    
                   $.ajax({
                        url: "planeador_add_bd.php",
                        type: "post",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,

                    })
                    .done(function(res){
                        alertify.alert(res, function(ev) {
                            document.location.href = "planeador.php";
                        });
                    });
                    return false;
                }

            });


            //Para consulta 
           $("#zona").change(function () {
                   $("#zona option:selected").each(function () {
                    elegido=$(this).val();
                    $.post("ajax_paginas/ajax_medicosZona.php", { elegido: elegido }, function(data){
                    $("#cliente").html(data);
                    });            
                });
           })
            
        });

        </script>
    </body>

</html>