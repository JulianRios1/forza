<?php 
@session_start();

include('../conexion.php');
include('../funciones/fechas.php');
include('../funciones/utilidades.php');

extract($_POST);


//CONSULTAMOS LA TABLA DE DESCUENTOS
$consulta = $mysqli->query("SELECT * FROM tabla_descuentos");
$row_des = mysqli_fetch_array($consulta);
?>
<div class="row margin-top-20">
    <div class="col-md-12">

        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bubble font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">CLIENTES</span>
                        </div>
                    </div>                                
                    <div class="portlet-body">
                        <div class="scroller" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                            <table class="table table-striped table-hover" id="tabla_clientes_new">
                                <thead>
                                    <tr>
                                        <th> Documento </th>
                                        <th> Cliente </th>
                                        <th> Zona</th>
                                        <th> Recaudo </th>
                                        <th> Descuento <?php echo number_format($row_des['descuento1'],1).'%' ?></th>
                                        <th> Descuento <?php echo number_format($row_des['descuento2'],1).'%' ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                $rango1 = $rango2 = $sin_rango = 0;

                                //CONSULTAMOS LOS CLIENTES CON CONDICIONES ESPECIALES DE DESCUENTO
                                $zona_consulta = '';
                                if($zona != 0)
                                {
                                    $zona_consulta .= "AND m.zona = ".$zona;
                                }

                                $resultado = $mysqli->query("SELECT u.documento, CONCAT_WS(' ',u.nom, u.ape1, u.ape2) AS nombre, c.pago, z.des AS zona FROM medicos m JOIN usuarios u ON m.usuario_id = u.id JOIN cartera_usuarios c ON c.cliente_doc = u.documento JOIN zonas z ON z.id = m.zona WHERE m.cliente_descuento = 1 AND m.habilitado = 1 AND c.ano = ".date('Y')." AND c.mes = ".date('m')." $zona_consulta ");
                                $num_productos = mysqli_num_rows($resultado);

                                    while($row= mysqli_fetch_array($resultado))
                                    { 
                                        $meta1 = $meta2 = '';
                                        $meta1 = 'Falta '.number_format(($row_des['rango1'] - $row['pago']),0,',','.');
                                        $meta2 = 'Falta '.number_format(($row_des['rango3'] - $row['pago']),0,',','.');
                                        $sin_rango ++;


                                        if($row['pago'] >= $row_des['rango1'] && $row['pago'] <= $row_des['rango2'] )    
                                        {
                                            $meta1='<p class="font-green-dark bold">Cumple</p>';  
                                            $sin_rango --;
                                            $rango1 ++;                                          
                                        }
                                        elseif ($row['pago'] >= $row_des['rango3'] ) {
                                            $meta2='<p class="font-green-dark bold">Cumple</p>';
                                            $meta1='<p class="font-green-dark bold">Cumple</p>';
                                            $sin_rango --;
                                            $rango2 ++; 
                                        }
                                        
                                       
                                        ?>
                                        <tr>
                                            <td> <?php echo $row['documento']; ?></td>
                                            <td> <?php echo $row['nombre']?> </td>
                                            <td> <?php echo $row['zona']?> </td>
                                            <td> <?php echo number_format($row['pago'],0,',','.')?> </td>
                                            <td> <?php echo $meta1?> </td>
                                            <td> <?php echo $meta2?> </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>                                  
                        </div>
                    </div>

                    
                </div>
            </div>

            <div class="col-md-4 col-sm-4">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bubble font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">GRAFICA</span>
                        </div>
                    </div>                                
                    <div class="portlet-body">
                        <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                         
                                <div id="chartprod_meta" class="chart" style="height: 320px;"> </div>

                                  
                        </div>
                    </div>
                    
                </div>
            </div>   

        </div>
    </div>
</div>


<script>


    //GRAFICA DE PRODUCTOS META
    var chart = AmCharts.makeChart( "chartprod_meta", {
      "type": "funnel",
      "theme": "light",
      "dataProvider": [ {
        "title": "No cumplen",
        "value": <?php echo $sin_rango ?>
      }, {
        "title": "Descuento <?php echo number_format($row_des['descuento1'],1).'%' ?>",
        "value": <?php echo $rango1 ?>
      }, {
        "title": "Descuento <?php echo number_format($row_des['descuento2'],1).'%' ?>",
        "value": <?php echo $rango2 ?>
      } ],
      "balloon": {
        "fixedPosition": true
      },
      "valueField": "value",
      "titleField": "title",
      "marginRight": 150,
      "marginLeft": 50,
      "startX": -500,
      "rotate": true,
      "labelPosition": "right",
      "balloonText": "[[title]]: [[value]]n[[description]]",
      "export": {
        "enabled": true
      }
    } );


</script>