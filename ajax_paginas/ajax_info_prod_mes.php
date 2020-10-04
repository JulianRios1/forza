<?php 
@session_start();

include('../conexion.php');
include('../funciones/fechas.php');
include('../funciones/utilidades.php');

extract($_POST);
$num_dias_mes = dias_mes($mes,$ano);

?>
<div class="row margin-top-20">
    <div class="col-md-12">

        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-bubble font-red-sunglo"></i>
                            <span class="caption-subject font-red-sunglo bold uppercase">COMPARATIVOS PRODUCTOS DEL MES</span>
                        </div>
                    </div>                                
                    <div class="portlet-body">
                        <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                            <?php 
                            //CONSULTAMOS LOS PRODUCTOS DEL MES
                            $array_meta = '';
                            $array_productos = array();

                            $resultado = $mysqli->query("SELECT t.producto, t.meta, p.desproducto AS nombre FROM tabla_info_prod_mes t JOIN productos p ON t.producto = p.idproducto WHERE t.ano = $ano AND t.mes = $mes");
                            $num_productos = mysqli_num_rows($resultado);

                                while($row= mysqli_fetch_array($resultado))
                                {     
                                    array_push($array_productos, array("id"=>$row['producto'], "nombre"=>$row['nombre']));

                                    //CONSULTAMOS LAS CANTIDADES DE LOS PRODUCTOS VENDIDAS POR ZONA                                   
                                    $resultado_ventas = $mysqli->query("SELECT COALESCE(SUM(pp.cantpedido_producto),0) AS cantidad FROM pedidos_productos pp JOIN pedidos p ON pp.pedido_idpedido = p.idpedido JOIN medicos m ON p.usuario_idusuario = m.usuario_id WHERE pp.producto_idproducto = ".$row['producto']." AND YEAR(p.fecpedido) = ".$ano." AND MONTH(p.fecpedido) = ".$mes);
                                    $row_ventas = mysqli_fetch_array($resultado_ventas);

                                    $array_meta.= '{"name": "'.$row["nombre"].'","points": '.$row_ventas['cantidad'].', "meta":'.$row['meta'].',"color":"'.color_random().'"},';
                                }
                                ?>
                         
                                <div id="chartprod_meta" class="chart" style="height: 320px;"> </div>

                                  
                        </div>
                    </div>

                    
                </div>
            </div>            
        </div>
    </div>
    
    <div class="col-md-12">
        <div class="row">
            <?php 
            
            $cons_zonas = '';

            if($_SESSION['rol_usu'] ==  1)
            {
                $resultado_zonas = $mysqli->query("SELECT * FROM zonas z WHERE z.id_vendedor = ".$_SESSION["idusuario"]);                                             
            } else {
                $resultado_zonas = $mysqli->query("SELECT * FROM zonas z ORDER BY z.des");
            }

            while($row_z = mysqli_fetch_array($resultado_zonas))
            {
            ?>
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-map font-green-haze"></i>
                            <span class="caption-subject bold uppercase font-green-haze"> <?php echo $row_z['des'] ?></span>
                        </div>
                    </div>
                    <div class="scroller" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                    
                        <table class="table table-striped table-hover table-bordered">
                            <tbody>
                                <?php 
                                foreach ($array_productos as $rows) {
                                    $rows['id'];
                                    $rows['nombre'];

                                    //CONSULTAMOS LAS CANTIDADES COMPRADAS DEL PRODUTO
                                    $result_cant = $mysqli->query("SELECT COALESCE(SUM(pp.cantpedido_producto),0) AS cantidad FROM pedidos_productos pp JOIN pedidos p ON pp.pedido_idpedido = p.idpedido 
JOIN medicos m ON p.usuario_idusuario = m.usuario_id WHERE pp.producto_idproducto = ".$rows['id']." AND m.zona = ".$row_z['id']." AND YEAR(p.fecpedido) = ".$ano." AND MONTH(p.fecpedido) = ".$mes);
                                    $row_prd = mysqli_fetch_array($result_cant);
                                ?>
                                <tr>
                                    <td> <?php echo $rows['nombre'] ?> </td>
                                    <td><a href="#" class="datos_edit" data-toggle="modal" data-id='<?php echo $row_z['id'] ?>' data-prod='<?php echo $rows['id'] ?>' data-ano='<?php echo $ano ?>' data-mes='<?php echo $mes ?>'><b><?php echo $row_prd['cantidad'] ?></b></a></td>
                                </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <?php 
            }
            ?>
        </div>
    </div>
</div>


<script>


    //GRAFICA DE PRODUCTOS META
    var chart = AmCharts.makeChart("chartprod_meta",
    {
        "type": "serial",
        "theme": "light",
        "dataProvider": [<?php echo $array_meta;?>],
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
            "cornerRadiusTop": 5,
            "fillAlphas": 0.8,
            "lineAlpha": 0,
            "type": "column",
            "valueField": "points"
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
        "marginTop": 0,
        "marginRight": 0,
        "marginLeft": 0,
        "marginBottom": 0,
        "autoMargins": true,
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

    $('.datos_edit').click(function (e) {

        e.preventDefault();
        zona = $(this).data('id');
        producto = $(this).data('prod');
        ano = $(this).data('ano'); 
        mes = $(this).data('mes');
        
        $('#myModal').modal('show'); 

        //dashboard_ajax_clientes_ingresan_web.php
        var parametros={"action":"ajax","zona":zona,"producto":producto,"ano":ano,"mes":mes};
        //$("#loader").fadeIn('slow');
        $.ajax({
            url:'ajax_paginas/ajax_clientes_compran_prod_mes.php',
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
    }); 

</script>