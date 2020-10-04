<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
$pagina = 'roles';

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
                                <a href="#">Roles</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Configuración de Roles y Permisos</h3>
                    
                    <!-- ACA EMPIEZA EL CONTENIDO -->  
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Begin: life time stats -->
                            <div class="portlet light portlet-fit portlet-datatable bordered">
                                <div class="portlet-title">
                                    
                                    <div class="actions">
                                        <a href="rol_add.php" class="btn btn-transparent grey-salsa btn-circle btn-sm nueva"><i class="icon-plus"></i> Nuevo Rol </a> 
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-container">
                                        <table class="table table-striped table-bordered table-hover" id="tabla_especialidades">
                                            <thead>
                                                <tr>
                                                    <th> Descripción </th>
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

                                <form action="#" id="form_especialidades" class="horizontal-form" enctype="" autocomplete="off">
                                    
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
                                            <label class="control-label">Especialidad</label>
                                            <input type="text" name="des" id="des" class="form-control" />                                            
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="hdd_id" id="hdd_id" />
                                        <input type="submit" name="action" id="action" class="btn btn-success" />
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

            var table = $('#tabla_especialidades');     
            var oTable = table.dataTable({

                "bDeferRender": true,           

                "ajax": {
                    "url": "ajax_paginas/ajax_roles.php",
                    "type": "POST"
                },                  
                "columns": [
                    { "data": "rol" },
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


            /*===========================================
            =            ELIMINAMOS EL ROL           =
            ===========================================*/
            
            $(document).on('click', '.eliminar', function(){
                var id = $(this).attr("id");
                var action = "Eliminar";

                alertify.confirm("Seguro desea eliminar el rol?", function (asc) {
                    if (asc) {

                       $.ajax({
                            url:"rol_delete_bd.php",   
                            method:"POST",  
                            data:{id:id, action:action},
                            dataType:"html",   

                            success:function(data){
                                //console.log(data);
                                alertify.alert(data, function(ev) {
                                    //document.location.href = "usuarios.php";
                                    $('#tabla_especialidades').DataTable().ajax.reload();
                                }); 
                            }

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {                                
                            });
                        });

                    } else {
                       $('#tabla_especialidades').DataTable().ajax.reload();
                    }
                }, "Default Value"); 

            });
            
        }); 
        </script>
    </body>

</html>