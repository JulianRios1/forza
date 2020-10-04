<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
$pagina = 'zonas';

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
                                <a href="#">Zonas</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Zonas
                    </h3>
                    
                    <!-- ACA EMPIEZA EL CONTENIDO -->  
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Begin: life time stats -->
                            <div class="portlet light portlet-fit portlet-datatable bordered">
                                <div class="portlet-title">
                                    
                                    <div class="actions">
                                        <button type="button" class="btn btn-transparent grey-salsa btn-circle btn-sm nueva"><i class="icon-plus"></i> Nueva Zona</button>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-container">
                                        <table class="table table-striped table-bordered table-hover" id="tabla_zonas">
                                            <thead>
                                                <tr>
                                                    <th> Zona </th>
                                                    <th> Vendedor </th>
                                                    <th> Línea</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- End: life time stats -->
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div id="customerModal" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <form action="#" id="form_zonas" class="horizontal-form" enctype="" autocomplete="off">
                                    
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">---</h4>
                                    </div>

                                    <div class="alert alert-danger display-hide">
                                        <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                    <div class="alert alert-success display-hide">
                                        <button class="close" data-close="alert"></button> Listo! </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label class="control-label">Nombre de la zona</label>
                                            <input type="text" name="des" id="des" class="form-control" />                                            
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="control-label">Visitador</label>
                                            <select name="vendedor" id="vendedor" class="form-control">
                                                <option value="">-Seleccione-</option>
                                                <?php 
                                                $resultado = $mysqli->query("SELECT u.id, UPPER(CONCAT_WS(' ',u.nom,u.ape1,u.ape2)) AS vendedor FROM usuarios u WHERE u.idrol = 1 AND u.estado = 1");
                                                while($row_usu = mysqli_fetch_array($resultado))
                                                {
                                                ?>
                                                    <option value="<?php echo $row_usu['id']?>"><?php echo $row_usu['vendedor']?></option>
                                                <?php 
                                                }
                                                ?>
                                            </select>                                          
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Línea</label>
                                            <select name="linea" id="linea" class="form-control">
                                                <option value="">-Seleccione-</option>
                                                <?php 
                                                for ($i=1; $i <= 2; $i++) { 
                                                ?>
                                                    <option value="<?php echo $i?>"><?php echo lineas($i)?></option>
                                                <?php 
                                                }
                                                ?>
                                            </select>                                           
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="hdd_id" id="hdd_id" />
                                        <input type="submit" name="action" id="action" class="btn btn-success" />
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </form>
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

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        
        <script>
        jQuery(document).ready(function(){
            
            //CONFIGURACION DE DATATABLE PARA ESTA PAGINA

            var table = $('#tabla_zonas');     
            var oTable = table.dataTable({

                "bDeferRender": true,           

                "ajax": {
                    "url": "ajax_paginas/ajax_zonas.php",
                    "type": "POST"
                },                  
                "columns": [
                    { "data": "zona" },
                    { "data": "vendedor" },
                    { "data": "linea" },
                    { "data": "editar"},
                    { "data": "eliminar"}
                    //{ "data": "eliminar"}
                ],

                "language": {
                url: 'assets/global/plugins/datatables/lenguajes/spanish.json'
                },

                responsive: true,
                ordering: true,

                "order": [
                    [0, 'asc']
                ],
                
                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "Todos"] 
                ],

                "pageLength": 10,

            });

            //recargamos la tabla con un boton
            $("#mi-boton").click(function() {
                //alert('');
                $('#tabla_zonas').DataTable().ajax.reload();
            });


            $('#action').click(function(){
                var des = $('#des').val(); //Get the value of first name textbox.
                var vendedor = $('#vendedor').val(); 
                var id = $('#customer_id').val();
                var action = $('#action').val();  

                if(action != '') //This condition will check both variable has some value
                {
                    var form = $('#form_zonas');
                    var error = $('.alert-danger', form);
                    var success = $('.alert-success', form);


                    form.validate({
                        errorElement: 'span', //
                        errorClass: 'help-block help-block-error', // 
                        focusInvalid: false, // 
                        ignore: "", // 

                        rules: {
                            des: {
                                required: true
                            },                            
                            vendedor: {
                                required: true
                            },                     
                            linea: {
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
                            var formData = new FormData(document.getElementById("form_zonas"));
                            formData.append("dato", "valor");
                            

                            $.ajax({
                                url: "ajax_paginas/zonas_modal_bd.php",
                                type: "post",
                                dataType: "html",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                success: function(data){
                                    /*$("#div_listar").html(data);
                                    $('#cargando').hide(); */
                                    //console.log(data);
                                    $('#customerModal').modal('hide');
                                    $('#vendedor > option[value=""]').attr('selected', 'selected');
                                    $('#linea > option[value=""]').attr('selected', 'selected');
                                    $('#des').val('');
                                    //ACTUALIZAMOS LA TABLA
                                    $('#tabla_zonas').DataTable().ajax.reload();
                                    

                                }

                            })
                            .done(function(res){
                                alertify.alert(res, function(ev) {                                    
                                });
                            });
                            return false;
                        }

                    });
                }
                else
                {
                    alert("No hay datos"); 
                }
            });

            /*============================================
            =            VISUALIZAMOS LA ZONA            =
            ============================================*/
            $(document).on('click', '.ver', function(){
                var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
                var action = "mostrar";   //We have define action variable value is equal to select
                //alert(action);
                    $.ajax({
                        url:"ajax_paginas/zonas_modal_bd.php",  
                        method:"POST",   
                        data:{id:id, action:action},
                        dataType:"json",
                        success:function(data){
                        console.log(data);
                            $('#customerModal').modal('show'); 
                            $('.modal-title').text("Editar Zona");
                            $('#action').val("Actualizar");
                            $('#vendedor option[value='+ data.id_vendedor +']').attr('selected','selected');
                            $('#linea option[value='+ data.linea +']').attr('selected','selected');
                            $('#des').val(data.des); 
                            $('#hdd_id').val(id); 
                            //$('#last_name').val(data.last_name);  //It will assign value of modal last name textbox
                        }
                    });
            });
            
            
            /*=====  End of Actualizamos la zona  ======*/

            /*==============================================
            =            CREAMOS UNA ZONA NUEVA            =
            ==============================================*/
            
            $(document).on('click', '.nueva', function(){
                $('#customerModal').modal('show'); 
                $('.modal-title').text("Nueva Zona");
                $('#action').val("Guardar");
                $('#des').val('');
                $('#vendedor > option[value=""]').attr('selected', 'selected');
                $('#linea > option[value=""]').attr('selected', 'selected');

            });
            
            /*=====  End of CREAMOS UNA ZONA NUEVA  ======*/
            
            
            /*===========================================
            =            ELIMINAMOS UNA ZONA            =
            ===========================================*/
            
            $(document).on('click', '.eliminar', function(){
                var id = $(this).attr("id");
                var action = "Eliminar";

                alertify.confirm("Seguro desea eliminar la zona?", function (asc) {
                    if (asc) {

                       $.ajax({
                            url:"ajax_paginas/zonas_modal_bd.php",   
                            method:"POST",  
                            data:{id:id, action:action},
                            dataType:"html",   

                            success:function(data){
                                //console.log(data);
                                $('#action').val("");
                                $('#des').val('');
                                $('#vendedor > option[value=""]').attr('selected', 'selected');
                                $('#linea > option[value=""]').attr('selected', 'selected');
                                $('#tabla_zonas').DataTable().ajax.reload();
                            }

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                            });
                        });

                    } else {
                       $('#tabla_zonas').DataTable().ajax.reload();
                    }
                }, "Default Value"); 

            });
            
            /*=====  End of ELIMINAMOS UNA ZONA  ======*/
            
            
        }); 
        </script>
    </body>

</html>