<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
$pagina = 'ordenes';

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
                                <a href="#">Pedidos</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Ordenes de Pedido
                    </h3>
                    
                    <!-- ACA EMPIEZA EL CONTENIDO -->  
                    <div class="row">
                        <div class="col-md-12">

                            <div class="portlet light portlet-fit portlet-datatable bordered">

                                <div class="portlet-body">
                                    <div class="table-container">
                                        <table class="table table-striped table-bordered table-hover table-checkable" id="datatable_orders">
                                            <thead>
                                                <tr role="row" class="heading">
                                                    <th width="5%"> Pedido </th>
                                                    <th width="15%"> Usuario </th>
                                                    <th width="15%"> Estado </th>
                                                    <th width="10%"> Total </th>
                                                    <th width="10%"> Fecha y Hora </th>
                                                    <th width="10%"> </th>
                                                </tr>
                                            </thead>
                                            <tbody> </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
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

        <script src="assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        
        <script>
        jQuery(document).ready(function(){
            

            $('.date-picker').datepicker({
                rtl: App.isRTL(),
                autoclose: true
            });


            //CONFIGURACION DE DATATABLE PARA ESTA PAGINA

            //CONFIGURACION DE DATATABLE PARA ESTA PAGINA

            var table = $('#datatable_orders');     

            var oTable = table.dataTable({
                
                "bDeferRender": true,           

                "ajax": {
                    "url": "ajax_paginas/ajax_pedidos.php",
                    "type": "POST"
                },                  
                "columns": [
                    { "data": "idpedido" },
                    { "data": "nombre" },
                    { "data": "estado" },
                    { "data": "total" },
                    { "data": "fecha" },
                    { "data": "editar"}
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

        }); 
        </script>
    </body>

</html>