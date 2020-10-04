<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = 'tabla_val_cli_cel';

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
                                <a href="#">Valores clientes celebres</a>
                            </li>
                        </ul>
                    </div>


                    <h3 class="page-title"> Valores clientes celebres</h3>

                    <div class="row">
                        <div class="col-md-12">
                            <!-- Begin: life time stats -->
                            <div class="portlet light portlet-fit portlet-datatable bordered">
                                <div class="portlet-title">
                                    
                                    <div class="actions">
                                        <a href="tabla_val_clie_cel_add.php" class="btn btn-transparent grey-salsa btn-circle btn-sm "><i class="icon-plus"></i> Agregar Año </a> 
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-container">
                                        <table class="table table-striped table-bordered table-hover" id="clientes_celebres">
                                            <thead>
                                                <tr>
                                                    <th> Año </th>
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

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

        <script>
        jQuery(document).ready(function(){
            
            //CONFIGURACION DE DATATABLE PARA ESTA PAGINA

            var table = $('#clientes_celebres');     

            var oTable = table.dataTable({
                
                "bDeferRender": true,           

                "ajax": {
                    "url": "ajax_paginas/ajax_tabla_val_cli_cel.php",
                    "type": "POST"
                },                  
                "columns": [
                    { "data": "ano" },
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
                    [0, 'desc']
                ],
                
                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "Todos"] 
                ],

                "pageLength": 10,



            });



            $(document).on('click', '.eliminar', function(){
                var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
                
                alertify.confirm("Seguro desea eliminar el año?", function (asc) {
                    if (asc) {

                        $.ajax({
                            url:"tabla_val_clie_cel_delete.php",   
                            method:"POST",  
                            data:{id:id},
                            dataType:"html",   

                            success:function(data){
                                //console.log(data);
                                alertify.alert(data, function(ev) {
                                    //document.location.href = "usuarios.php";
                                    $('#clientes_celebres').DataTable().ajax.reload();
                                }); 
                            }
                        });

                    } else {
                       
                    }
                }, "Default Value"); 

            });

        }); 
        </script>
    </body>

</html>