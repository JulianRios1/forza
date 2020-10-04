<?php 
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
include('../funciones/fechas.php');
include('../funciones/utilidades.php');

extract($_POST);

?>
<div class='margin-top-20'>
    <div class="col-md-12">
        <div class="portlet light bordered">

            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-male"></i>Informe Ventas Acumuladas
                </div>
                

            </div>
            <div class="portlet-body">

                    <!-- <table class="table table-striped table-hover"> -->
                    <table class="table table-striped table-bordered table-hover" id="sample_1">
                        <thead>
                            <tr>
                                <td>Cliente</td>
                                <td>Mejor Compra</td>
                                <td>Promedio</td>
                                <td>Compra del mes</td>
                                <td>Dif. Promedio</td>
                                <td>Dif. Compra</td>
                                <td>Contacto</td>                          
                            </tr>
                        </thead>
                        <tbody>
                        <?php
//SELECT nit, nommedico, dir, tel1, cel1, mail, genero, mes_cum, dia_cum FROM medicos WHERE especialidad = ".$_POST['especialidad'];  
                        $zona_consulta = '';
                        if($zona != 0)
                        {
                            $zona_consulta .= "AND m.zona = ".$zona;
                        }

                        $resultado= $mysqli->query("SELECT u.documento, CONCAT_WS(' ',u.nom,u.ape1,u.ape2) as nombre, m.contacto FROM medicos m JOIN usuarios u ON m.usuario_id = u.id WHERE m.habilitado = 1 $zona_consulta");

                        while ($row= mysqli_fetch_array($resultado))
                        { 
                            $promedio_ventas = $promedio_ventas_ant = $promedio_ventas_ant2 = $prom_total = $dif_promedio = $dif_compra = 0;
                            $vector_ventas = $vector_ventas_ant = $vector_ventas_ant2 = $clase_texto_p = $clase_texto_c = '';
                            $total_anio = $total_anio_ant = $total_anio_ant2 = 0;
                            $mejor_compra = $compra_mes = 0;
//COALESCE(SUM(caja_hoy), 0)
                            //Calculamos el valor de los meses del año actual
                            for($i=1; $i<=date('m'); $i++)
                            {
                                $resultado2 = $mysqli->query("SELECT c.compra FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND mes = $i AND ano = ".date('Y'));
                                $row2= mysqli_fetch_array($resultado2);

                                //COMPRUEBO QUE EL VALOR NO SEA CERO
                                if(mysqli_num_rows($resultado2)<1){
                                    $valor = 0;
                                }
                                else{
                                    $valor = $row2['compra'];
                                }

                                $total_anio += $row2['compra'];

                                if($valor > $mejor_compra)
                                {
                                    $mejor_compra = $valor;
                                }

                                $compra_mes = $valor;
         
                            } 
                            
                            $promedio_ventas = ($total_anio / date('m'));  
                            

                            //Calculamos el valor de los meses del año anterior
                            for($i=1; $i<=12; $i++)
                            {                                                                
                                $resultado3 = $mysqli->query("SELECT c.compra FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND mes = $i AND ano = ".(date('Y')-1));
                                $row3= mysqli_fetch_array($resultado3);

                                //COMPRUEBO QUE EL VALOR NO SEA CERO
                                if(mysqli_num_rows($resultado3)<1){
                                    $valor = 0;
                                }
                                else{
                                    $valor = $row3['compra'];
                                }
                                $total_anio_ant += $row3['compra'];

                                if($valor > $mejor_compra)
                                {
                                    $mejor_compra = $valor;
                                }
            
                            } 
                            $promedio_ventas_ant = ($total_anio_ant / 12); 
                            

                            //Calculamos el valor de los meses de dos años atras
                            for($i=1; $i<=12; $i++)
                            {
                                $resultado4 = $mysqli->query("SELECT c.compra FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND mes = $i AND ano = ".(date('Y')-2));
                                $row4= mysqli_fetch_array($resultado4);

                                //COMPRUEBO QUE EL VALOR NO SEA CERO
                                if(mysqli_num_rows($resultado4)<1){
                                    $valor = 0;
                                }
                                else{
                                    $valor = $row4['compra'];
                                }
                                $total_anio_ant2 += $row4['compra'];
                                if($valor > $mejor_compra)
                                {
                                    $mejor_compra = $valor;
                                }
                            } 
                            $promedio_ventas_ant2 = ($total_anio_ant2 / 12); 
                            
                            $prom_total =  round((($promedio_ventas + $promedio_ventas_ant + $promedio_ventas_ant2)/3),0); 
                            


                            $dif_promedio = $compra_mes-$prom_total;
                            if(regla_tres($dif_promedio,80) < $prom_total)
                            {
                                $clase_texto_p = 'style="color:#F00"';
                            }
                            else if(regla_tres($dif_promedio,81) >= $prom_total && regla_tres($dif_promedio,99) < $prom_total)
                            {
                                $clase_texto_p = 'style="color:#F3C200"';
                            }
                            if(regla_tres($dif_promedio,99) >= $prom_total)
                            {
                                $clase_texto_p = 'style="color:#26C281"';
                            }


                            $dif_compra = $compra_mes - $mejor_compra;
                            if(regla_tres($dif_promedio,80) < $mejor_compra)
                            {
                                $clase_texto_c = 'style="color:#F00"';
                            }
                            else if(regla_tres($dif_promedio,81) >= $mejor_compra && regla_tres($dif_promedio,99) < $mejor_compra)
                            {
                                $clase_texto_c = 'style="color:#F3C200"';
                            }
                            if(regla_tres($dif_promedio,99) >= $mejor_compra)
                            {
                                $clase_texto_c = 'style="color:#26C281"';
                            }


                            if ($prom_total > 0) {
                                ?>
                                <tr>
                                    <td> <?php echo $row['nombre']; ?></td>
                                    <td> <?php echo number_format($mejor_compra,0,',','.');?></td>
                                    <td> <?php echo number_format($prom_total,0,',','.');?></td>
                                    <td> <?php echo number_format($compra_mes,0,',','.'); ?></td>
                                    <td <?php echo $clase_texto_p; ?>> <?php echo number_format($dif_promedio,0,',','.'); ?></td>
                                    <td <?php echo $clase_texto_c; ?>> <?php echo number_format($dif_compra,0,',','.'); ?></td>
                                    <td> <?php echo $row['contacto']; ?></td>
                                </tr>
                                <?php
                            }
                            
                        }
                        ?>
                        </tbody>
                    </table>
                
            </div>
        </div>
    </div>
    
</div>

<script>
    jQuery(document).ready(function() {


        // INICIO DE TABLA
        var table = $('#sample_1');

        var oTable = table.dataTable({

            "language": {
                url: 'assets/global/plugins/datatables/lenguajes/spanish.json',
                decimal: ",",
                thousands: "."
            },

            <?php 
            if (in_array(100, $_SESSION["permisos"]))
            {
            ?>
            // setup buttons extentension: http://datatables.net/extensions/buttons/
            buttons: [
                { extend: 'pdf', className: 'btn green btn-outline' },
                { extend: 'excel', className: 'btn purple btn-outline ' }
            ],
            <?php
            }else{ ?> buttons:[],<?php
            }
            ?>

            // setup responsive extension: http://datatables.net/extensions/responsive/
            responsive: true,

            // setup colreorder extension: http://datatables.net/extensions/colreorder/
            colReorder: {
                reorderCallback: function () {
                    console.log( 'callback' );
                }
            },

            "order": [
                [1, 'desc']
            ],
            
            "lengthMenu": [
                [5, 10, 15, 20, -1],
                [5, 10, 15, 20, "Todos"] // change per page values here
            ],
            // set the initial value
            "pageLength": 15,

            "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

            // Uncomment below line("dom" parameter) to fix the dropdown overflow issue in the datatable cells. The default datatable layout
            // setup uses scrollable div(table-scrollable) with overflow:auto to enable vertical scroll(see: assets/global/plugins/datatables/plugins/bootstrap/dataTables.bootstrap.js). 
            // So when dropdowns used the scrollable div should be removed. 
            //"dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r>t<'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
        });
    });
</script>