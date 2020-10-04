<?php 
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
include('../funciones/fechas.php');

extract($_POST);

?>
<div class='margin-top-20'>
    <div class="col-md-12">
        <div class="portlet box yellow">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-money"></i>Clientes</div>
                <div class="actions">
                    <?php
                    if (in_array(28, $_SESSION["permisos"]))
                    {
                    ?>
                    <div class="btn-group btn-group-devided">
                        <a href="informe_ventas_xls.php?ano=<?php echo $ano?>&zona=<?php echo $zona?>" target="_blank()" class="btn btn-circle green-jungle"><i class="fa fa-file-excel-o"></i> Exportar</a>
                    </div>
                    <?php 
                    }
                    ?>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th> Nit </th>
                                <th> Cliente </th>
                                <?php
                                for($i=1; $i<=12; $i++)
                                {
                                    ?>
                                    <th><strong><?php echo traducir_nombre_mes_corto($i)?></strong></th>
                                    <?php
                                }
                                ?>
                                
                                <th> PROM </th>
                                <th> TOTAL </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $zonas = '';
                        if($zona != 0)
                        {
                            $zonas = "WHERE m.zona = ".$zona;
                        }

                        $resultado = $mysqli->query("SELECT u.documento, CONCAT_WS(' ',u.nom,u.ape1,u.ape2) AS cliente FROM medicos m JOIN usuarios u ON m.usuario_id = u.id $zonas");
                                     
                        while($row = mysqli_fetch_array($resultado)){   

                            $total_anio = 0;
                            $array_ventas = array();
                            $j=0;
                            $promedio_ventas = 0;

                            //Calculamos el valor de los meses
                            for($i=1; $i<=12; $i++)
                            {

                                $resultado2 = $mysqli->query("SELECT compra FROM cartera_usuarios WHERE cliente_doc = '".$row["documento"]."' AND mes = $i AND ano = ".$ano);
                                $row2 = mysqli_fetch_array($resultado2);

                                $resultado2->close();

                                //Lleno el array con los valores
                                array_push($array_ventas,$row2['compra']);
                                //Sumamos los valores
                                $total_anio += $row2['compra'];
                                
                                if($row2['compra'] != 0)
                                {
                                    $j++;   
                                }           
                            } 

                            if($total_anio != 0)
                            { 
                            ?>
                                <tr>
                                    <td> <?php echo $row['documento'] ?> </td>
                                    <td> <?php echo $row['cliente'] ?></td>
                                    <?php
                                    foreach($array_ventas as $indice => $valor) 
                                    {
                                        if($j > 0)
                                        {
                                            if($ano < date('Y'))
                                            {
                                                $numPeriodos = 12;
                                            }
                                            else
                                            {
                                                $numPeriodos = date('m');
                                            }
                                            
                                            $promedio_ventas = ($total_anio / $numPeriodos);    
                                        }
                                        
                                        $color = '';
                                        $rango_promedio = (($promedio_ventas*85)/100);
                                        
                                        if($valor >= $promedio_ventas && $promedio_ventas != 0)
                                        {
                                            $color = 'class="success"';
                                        }
                                        
                                        if($valor <= $rango_promedio && $promedio_ventas != 0)
                                        {
                                            $color = 'class="danger"';
                                        }
                                        
                                        if(($valor < $promedio_ventas) && ($valor >= $rango_promedio) && ($promedio_ventas != 0))
                                        {
                                            $color = 'class="warning"';
                                        }
                                        ?>
                                        <td <?php echo $color; ?>><?php echo '$'.number_format($valor, 0, ",", ".")?></td> 
                                        <?php 
                                    }   
                                         
                                    ?>
                                    <td><?php echo '$'.number_format($promedio_ventas, 0, ",", ".")?></td>
                                    <td><?php echo '$'.number_format($total_anio, 0, ",", ".")?></td>
                                    <!--<td class="active"> active </td>
                                    <td class="success"> success </td>
                                    <td class="warning"> warning </td>
                                    <td class="danger"> danger </td>-->
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
</div>
