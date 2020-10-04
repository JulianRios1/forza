<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
$pagina = 'itinerario';

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
                                <a href="#">Itinerario</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Itinerario de Visitas
                    </h3>
                    
                    <!-- ACA EMPIEZA EL CONTENIDO -->  
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Begin: life time stats -->
                            <div class="portlet light portlet-fit portlet-datatable bordered">
                                <div class="portlet-title">
                                    
                                    <div class="actions">
                                        
                                        <a href="cliente_new.php" class="btn btn-transparent grey-salsa btn-circle btn-sm "><i class="icon-plus"></i> Crear Cliente </a> 

                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="table-container">
                                        <table class="table table-striped table-bordered table-hover" id="admin_proyectos">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th> Nombre </th>
                                                    <th> Email </th>
                                                    <th> Dirección</th>
                                                    <!--<th> Teléfono </th>-->
                                                    <th> Celular </th>
                                                    <th> Zona </th>
                                                    <th> Clasificación</th>
                                                    <th> Barrio</th>
                                                    <th> Ventas </th>
                                                    <th> Última Visita </th>
                                                    <th> Último Pedido </th>
                                                    <!--<th> Lista Precios </th>-->
                                                    <th>  </th>
                                                    <th>  </th>
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

        
        <script>
        jQuery(document).ready(function(){
            
            //CONFIGURACION DE DATATABLE PARA ESTA PAGINA

            var table = $('#admin_proyectos');     

            var oTable = table.dataTable({
                
                initComplete: function () {
                    this.api().column(5).every( function () {
                        var column = this;
                        var select = $('<select><option value=""></option></select>')
                            .appendTo( $(column.header()).empty() )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );
                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                },

                "bDeferRender": true,           

                "ajax": {
                    "url": "listar_usuarios.php",
                    "type": "POST"
                },                  
                "columns": [
                    { "data": "icono" },
                    { "data": "nombre" },
                    { "data": "mail" },
                    { "data": "dir" },
                    //{ "data": "tel" },
                    { "data": "cel" },
                    { "data": "zona" },
                    { "data": "clasificacion" },
                    { "data": "barrio" },
                    { "data": "ventas" },
                    { "data": "ultima_visita" },
                    { "data": "ultimo_pedido" },
                    //{ "data": "lista" },
                    { "data": "visitar"},
                    { "data": "editar"}
                ],

                "language": {
                url: 'assets/global/plugins/datatables/lenguajes/spanish.json'
                },


                responsive: true,
                ordering: true,


                "order": [
                    [8, 'desc']
                ],
                
                "lengthMenu": [
                    [5, 10, 15, 20, -1],
                    [5, 10, 15, 20, "Todos"] 
                ],

                "pageLength": 10,



            });



            // handle datatable custom tools
            $('#admin_proyectos_tools > li > a.tool-action').on('click', function() {
                var action = $(this).attr('data-action');
                oTable.DataTable().button(action).trigger();
            });

        }); 
        </script>
    </body>

</html>