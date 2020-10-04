<?php 
include('../conexion.php');
include('../funciones/fechas.php');
include('../funciones/utilidades.php');

extract($_POST);
$num_dias_mes = dias_mes($mes,$ano);

?>
<div class="row margin-top-20">
    <div class="col-md-8">

        <div class="row">
            <div class="col-md-12">

                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-haze"></i>
                            <span class="caption-subject bold uppercase font-green-haze"> Visitas x Día</span>
                        </div>
                    </div>
                    <?php 
                    $datos_grafica = '';                        
                    $total_visitas = 0;
                    
                    for($i=1; $i<=$num_dias_mes; $i++)
                    {                   
                        $resultado = $mysqli->query("SELECT COUNT(usuario_id) AS no_visitas FROM visitas WHERE YEAR(fecha) = '$ano' AND MONTH(fecha) = '$mes' AND DAY(fecha) = '$i' AND contacto IN (2,3) AND id_vendedor = ".$vendedor);
                        $row= mysqli_fetch_array($resultado);
                        $total_visitas += $row['no_visitas'];

                        $datos_grafica .= '{"dia": '.$i.', "visitas": '.$row['no_visitas'].', "meta": 8},';
                    }
                    
                    $array_visitas=substr($datos_grafica,0,-1);

                    ?>
                    <div class="portlet-body">
                        <div id="chart_1" class="chart" style="height: 500px;"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-haze"></i>
                            <span class="caption-subject bold uppercase font-green-haze"> Efectividad</span>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div id="chartdiv" class="chart" style="height: 200px;"> </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bar-chart font-green-haze"></i>
                            <span class="caption-subject bold uppercase font-green-haze"> Tipos de contacto</span>
                        </div>
                    </div>
                    <?php 
                    /*=========================================================
                    =            CONSULTAMOS LOS TIPOS DE CONTACTO            =
                    =========================================================*/
                    $array_datos_visitas = '';
                    $resultado_ct = $mysqli->query("SELECT * FROM tipo_contactos ORDER BY descripcion");
                    
                    while($row_ct= mysqli_fetch_array($resultado_ct))
                    {
                        //CONSULTAMOS POR CADA UNO DE LOS TIPOS                        
                        $resultado_nv = $mysqli->query("SELECT COUNT(usuario_id) AS no_visitas FROM visitas WHERE YEAR(fecha) = '$ano' AND MONTH(fecha) = '$mes' AND contacto  = ".$row_ct['id']." AND id_vendedor = ".$vendedor);
                        $row_nv= mysqli_fetch_array($resultado_nv);
                        $array_datos_visitas .= '{"name": "'.$row_ct["descripcion"].'","points": '.$row_nv["no_visitas"].',"color":"'.color_random().'"},';
                        
                    }
                    $array_datos_visitas=substr($array_datos_visitas,0,-1);
                    //echo $array_datos_visitas;
                    /*=====  End of CONSULTAMOS LOS TIPOS DE CONTACTO  ======*/
                    ?>
                    <div class="portlet-body">
                        <div id="chartdiv2" class="chart" style="height: 200px;"> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <?php 
    //CONSULTAMOS LAS ZONAS DEL VENDEDOR
    //echo "SELECT * FROM zonas z WHERE z.id_vendedor = ".$vendedor;
    $resultado = $mysqli->query("SELECT * FROM zonas z WHERE z.id_vendedor = ".$vendedor);
    while ($row= mysqli_fetch_array($resultado)) {


        $rango1AN = $rango2AN = $rango3AN = $rango4AN = $rango5AN = $rango1AC = $rango2AC = $rango3AC = $rango4AC = $rango5AC  = $ventas = $pagos = 0;

        //CONSULTAMOS LOS CLIENTES DE LA ZONA
        //echo "SELECT u.documento FROM medicos m JOIN usuarios u ON m.usuario_id = u.id WHERE m.zona = ".$row['id'];
        $resultado2 = $mysqli->query("SELECT u.documento FROM medicos m JOIN usuarios u ON m.usuario_id = u.id WHERE m.zona = ".$row['id']);             
        while($row2= mysqli_fetch_array($resultado2))
        {
            //CONSULTAMOS LAS COMPRAS DEL CLIENTE DEL AÑO ACTUAL
            //echo "SELECT SUM(c.compra) as venta,  SUM(c.pago) AS pago FROM cartera_usuarios c WHERE c.cliente_doc = '".$row2['documento']."' AND mes = $mes AND ano = $ano ";
            $resul_comp_act = $mysqli->query("SELECT SUM(c.compra) as venta,  SUM(c.pago) AS pago FROM cartera_usuarios c WHERE c.cliente_doc = '".$row2['documento']."' AND mes = $mes AND ano = $ano ");             
            $row_comp_act= mysqli_fetch_array($resul_comp_act);

            $ventas += $row_comp_act['venta'];
            $pagos += $row_comp_act['pago'];


            if($row_comp_act['venta'] >= 3001000)
                $rango1AC++;
            else if($row_comp_act['venta'] >= 1001000 && $row_comp_act['venta'] <= 3000000 )
                $rango2AC++;
                else if($row_comp_act['venta'] >= 501000 && $row_comp_act['venta'] <= 1000000 )
                $rango3AC++;
                    else if($row_comp_act['venta'] >= 150000 && $row_comp_act['venta'] <= 500000 )
                    $rango4AC++;
                        else if($row_comp_act['venta'] < 150000 && $row_comp_act['venta'] != 0 )
                        $rango5AC++;
                        
                        
            //CONSULTAMOS LAS COMPRAS DEL CLIENTE DEL AÑO ANTERIOR
            $resul_comp_ant = $mysqli->query("SELECT SUM(compra) as venta FROM cartera_usuarios c WHERE c.cliente_doc = '".$row2['documento']."' AND mes = $mes AND ano = ".($ano-1));             
            $row_comp_ant= mysqli_fetch_array($resul_comp_ant);
            
            if($row_comp_ant['venta'] >= 3001000)
                $rango1AN++;
            else if($row_comp_ant['venta'] >= 1001000 && $row_comp_ant['venta'] <= 3000000 )
                $rango2AN++;
                else if($row_comp_ant['venta'] >= 501000 && $row_comp_ant['venta'] <= 1000000 )
                $rango3AN++;
                    else if($row_comp_ant['venta'] >= 150000 && $row_comp_ant['venta'] <= 500000 )
                    $rango4AN++;
                        else if($row_comp_ant['venta'] < 150000 && $row_comp_ant['venta'] != 0 )
                        $rango5AN++;            
        }
    ?>
    <div class="col-md-6">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-map font-blue"></i>
                    <span class="caption-subject font-blue bold uppercase"><?php echo $row['des'] ?></span>
                </div>
            </div>
            <div class="portlet-body"> 
                <div class="tabbable-line">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tab1_<?php echo $row['id'] ?>" data-toggle="tab" aria-expanded="true"> Logros</a>
                        </li>
                        <li class="">
                            <a href="#tab2_<?php echo $row['id'] ?>" data-toggle="tab" aria-expanded="false"> Rango Clientes </a>
                        </li>
                    </ul>        
                    <div class="tab-content"> 
                        <div class="tab-pane active" id="tab1_<?php echo $row['id'] ?>">
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                    <span class="label label-success"> VENTAS: </span>
                                    <h3>$<?php echo number_format($ventas,0,',','.'); ?></h3>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-6 text-stat">
                                    <span class="label label-danger"> COBROS: </span>
                                    <h3>$<?php echo number_format($pagos,0,',','.'); ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="tab2_<?php echo $row['id'] ?>">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover table-bordered">
                                    <thead>
                                        <tr>
                                            <th> Rango </th>
                                            <th> <?php echo ($ano-1) ?> </th>
                                            <th> <?php echo $ano ?> </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Premium</td>
                                            <td> <?php echo $rango1AN ?> </td>
                                            <td> <?php echo $rango1AC ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Alto potencial </td>
                                            <td> <?php echo $rango2AN ?> </td>
                                            <td> <?php echo $rango2AC ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Mediano potencial</td>
                                            <td> <?php echo $rango3AN ?> </td>
                                            <td> <?php echo $rango3AC ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Mínimo compra</td>
                                            <td> <?php echo $rango4AN ?> </td>
                                            <td> <?php echo $rango4AC ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Sin rango</td>
                                            <td> <?php echo $rango5AN ?> </td>
                                            <td> <?php echo $rango5AC ?> </td>
                                        </tr>
                                        <tr>
                                            <td>Total</td>
                                            <td> <?php echo ($rango1AN + $rango2AN + $rango3AN + $rango4AN + $rango5AN) ?> </td>
                                            <td> <?php echo ($rango1AC + $rango2AC + $rango3AC + $rango4AC + $rango5AC) ?> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End: life time stats -->
    </div>
    <?php
    }
    ?>
</div>

<script>
    var chart = AmCharts.makeChart("chart_1", {
        "type": "serial",
        "theme": "light",
        "pathToImages": App.getGlobalPluginsPath() + "amcharts/amcharts/images/",
        "autoMargins": false,
        "marginLeft": 30,
        "marginRight": 8,
        "marginTop": 10,
        "marginBottom": 26,

        "fontFamily": 'Open Sans',            
        "color":    '#888',
        
        "dataProvider": [<?php echo $array_visitas; ?>],
        "startDuration": 1,
        "graphs": [{
            "alphaField": "alpha",
            "balloonText": "<span style='font-size:13px;'>[[title]] [[category]]:<b>[[value]]</b> [[additional]]</span>",
            "dashLengthField": "dashLengthColumn",
            "fillAlphas": 1,
            "title": "Día",
            "type": "column",
            "valueField": "visitas"
        }, {
            "balloonText": "<span style='font-size:13px;'>[[title]]:<b>[[value]]</b> [[additional]]</span>",
            "bullet": "round",
            "dashLengthField": "dashLengthLine",
            "lineThickness": 3,
            "bulletSize": 7,
            "bulletBorderAlpha": 1,
            "bulletColor": "#FFFFFF",
            "useLineColorForBulletBorder": true,
            "bulletBorderThickness": 3,
            "fillAlphas": 0,
            "lineAlpha": 1,
            "title": "Meta",
            "valueField": "meta"
        }],
        "categoryField": "dia",
        "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "tickLength": 0
        }
    });


    var chart2 = AmCharts.makeChart("chartdiv",
    {
        "type": "gauge",
        "titles": [
        {
            "text": "Efectividad",
            "size": 15
        }],
        "axes": [
        {
            "startValue": 0,
            "axisThickness": 1,
            "endValue": 100,
            "valueInterval": 10,
            "bottomTextYOffset": -20,
            "bottomText": "0 %",
            "bands": [
            {
                "startValue": 0,
                "endValue": 50,
                "color": "#ea3838",
                "innerRadius": "95%"
            },
            {
                "startValue": 50,
                "endValue": 90,
                "color": "#ffac29",
                "innerRadius": "95%"
            },
            {
                "startValue": 90,
                "endValue": 100,
                "color": "#00CC00",
                "innerRadius": "95%"
            }]
        }],
        "arrows": [
        {}],
        "export":
        {
            "enabled": true
        }
    });

    <?php $por_visitas =  number_format(($total_visitas*100)/168, 2, ".", ",")?>
    var value = <?php echo $por_visitas?>;
    //var value = Math.round(Math.random() * 200);
    chart2.arrows[0].setValue(value);
    chart2.axes[0].setBottomText(value + " %");
    //}


    var chart = AmCharts.makeChart("chartdiv2",
    {
        "type": "serial",
        "theme": "light",
        "dataProvider": [<?php echo $array_datos_visitas ?>],
        "valueAxes": [{
            //"maximum": 800,
            "minimum": 0,
            "axisAlpha": 0,
            "dashLength": 4,
            "position": "left"
        }],
        "startDuration": 1,
        "graphs": [{
            "balloonText": "<span style='font-size:13px;'>[[category]]: <b>[[value]]</b></span>",
            "bulletOffset": 10,
            "bulletSize": 52,
            "colorField": "color",
            "cornerRadiusTop": 8,
            "fillAlphas": 0.8,
            "lineAlpha": 0,
            "type": "column",
            "valueField": "points"
        }],
        "marginTop": 0,
        "marginRight": 0,
        "marginLeft": 0,
        "marginBottom": 0,
        "autoMargins": false,
        "categoryField": "name",
        "categoryAxis": {
            "axisAlpha": 0,
            "gridAlpha": 0,
            "inside": true,
            "tickLength": 0,
            "labelRotation": 90
        },
        "export": {
            "enabled": true
         }
    });

</script>