<?php 
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
include('../funciones/fechas.php');

extract($_POST);

?>
<div class='margin-top-20'>
    <div class="col-md-12">
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-star"></i>AÑO <?php echo $ano ?> - TRIMESTRE <?php echo $trimestre ?> </div>
            </div>
            
            <div class="portlet-body">
                <div class="table-scrollable">
                    <form action="#" id="form_cliente_celebre" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> Documento </th>
                                    <th> Cliente </th>
                                    <th> Zona </th>
                                    <th> Categoria </th>
                                    <th> Normal </th>
                                    <th> Especial </th>
                                    <th> Logro </th>
                                    <th> Bono </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            $n = 1;
                            $zona_consulta = '';

                            if($zona != 0)
                            {
                                $zona_consulta .= "AND m.zona = ".$zona;
                            }
                            
                            //VALORES POR TRIMESTRES
                            if($trimestre == 1)
                            {
                                $mesIni = 1;
                                $mesFin = 3;
                            }
                            else if($trimestre == 2)
                            {
                                $mesIni = 4;
                                $mesFin = 6;
                            }
                            else if($trimestre == 3)
                            {
                                $mesIni = 7;
                                $mesFin = 9;
                            }
                            else if($trimestre == 4)
                            {
                                $mesIni = 10;
                                $mesFin = 12;
                            }

                            //Consultamos la tabla de clientes celebres
                            $resultado2= $mysqli->query("SELECT * FROM tabla_valores_cli_celebres WHERE ano = ".$ano);
                            $row2 = mysqli_fetch_array($resultado2);



                            $resultado= $mysqli->query("SELECT m.usuario_id, u.documento,CONCAT_WS(' ',u.nom,u.ape1, ape2) AS cliente, z.des AS zonaDes, m.tipo_cliente_celebre FROM usuarios u JOIN medicos m ON u.id = m.usuario_id JOIN zonas z ON m.zona = z.id WHERE u.idrol = 5 AND m.habilitado = 1 $zona_consulta");
                             
                            while ($row= mysqli_fetch_array($resultado))
                            {                                    
                            
                            $total_trimestre = 0;
                            $array_ventas = array();
                            $j=0;
                            $promedio_ventas = 0;

                            //CONSULTAMOS LAS COMPRAS DEL CLIENTE
                            $resultado3= $mysqli->query("SELECT COALESCE(SUM(compra),0) AS compra FROM cartera_usuarios c WHERE c.cliente_doc = '".$row["documento"]."' AND mes BETWEEN $mesIni AND $mesFin AND ano = ".$ano);
                            $row3 = mysqli_fetch_array($resultado3);
                            $total_trimestre = $row3['compra'];
                            ?>
                                <tr>
                                    <td> <?php echo $row['documento']; ?>
                                        <input name="cliente[]" type="hidden" id="cliente_[]" value="<?php echo $row["usuario_id"]?>" />
                                    </td>
                                    <td> <?php echo $row['cliente']?> </td>
                                    <td> <?php echo $row['zonaDes']?> </td>
                                    <td> 
                                        <select name="categoria[]" id="categoria[]" class="form-control">  
                                            <option value="0" <?php if($row['tipo_cliente_celebre'] == 0){ echo 'selected';}?>>- Sin definir -</option>
                                            <?php
                                            for($k=1; $k<=5; $k++)
                                            {
                                            ?>
                                                <option value="<?php echo $k?>" <?php if($row['tipo_cliente_celebre'] == $k){ echo 'selected';}?>><?php echo cliente_celebre($k)?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td> 
                                        <?php  
                                        if($row['tipo_cliente_celebre']!=0)
                                        {        
                                            echo '$'.number_format($row2['cat'.$row['tipo_cliente_celebre'].'_1'], 0, ",", ".");
                                            $valor_mostrar = $row2['cat'.$row['tipo_cliente_celebre'].'_1'];
                                        }
                                        else
                                        {
                                            echo 'Sin Asignar';
                                            $valor_mostrar = 0;
                                        }
                                        ?>
                                        <input type="hidden" name="rango1[]" id="rango1[]" value="<?php echo $valor_mostrar ?>" /> 
                                    </td>
                                    <td> 
                                        <?php  
                                        if($row['tipo_cliente_celebre']!=0)
                                        {        
                                            echo '$'.number_format($row2['cat'.$row['tipo_cliente_celebre'].'_2'], 0, ",", ".");
                                            $valor_mostrar = $row2['cat'.$row['tipo_cliente_celebre'].'_2'];
                                        }
                                        else
                                        {
                                            echo 'Sin Asignar';
                                            $valor_mostrar = 0;
                                        }
                                        ?>
                                        <input type="hidden" name="rango2[]" id="rango2[]" value="<?php echo $valor_mostrar?>" />
                                    </td>
                                    <td> 
                                        <?php echo '$'.number_format($total_trimestre, 0, ",", ".")?>
                                        <input type="hidden" name="total[]" id="total[]" value="<?php echo $total_trimestre?>" />
                                    </td>
                                    <td>
                                        <?php
                                        $bono = 0;
                                        
                                        if($row['tipo_cliente_celebre'] != 0)
                                        {
                                            if($total_trimestre >= $row2['cat'.$row['tipo_cliente_celebre'].'_1'] && $total_trimestre < $row2['cat'.$row['tipo_cliente_celebre'].'_2'])
                                            {   
                                                $bono = ($total_trimestre * $row2['porcentaje1'])/100;
                                            }
                                            
                                            if($total_trimestre >= $row2['cat'.$row['tipo_cliente_celebre'].'_2'])
                                            {   
                                                $bono = ($total_trimestre * $row2['porcentaje2'])/100;              
                                            }
                                        }
                                        echo  '$'.number_format(ceil($bono), 0, ",", ".");
                                        ?>
                                        <input type="hidden" name="bono[]" id="bono[]" value="<?php echo $bono?>" />
                                    </td>
                                </tr>
                                <?php 
                                $n++;
                            }
                            ?>
                            </tbody>
                        </table>
                        <input type="hidden" name="hdd_trimestre" value="<?php echo $trimestre?>" />
                        <input type="hidden" name="hdd_ano" value="<?php echo $ano?>" />
                        <input type="hidden" name="hdd_zona" value="<?php echo $zona?>" />
                        <input type="hidden" name="valor_boton" id="valor_boton" value="">
                    </form>
                </div>
                    
                <div class="margiv-top-10 form-actions">

                    <button type="button" id="enviar_datos" class="btn green" value="1">Guardar Cambios</button>
                    <button type="button" id="enviar_datos" class="btn green" value="2">Guardar y cerrar trimestre</button>
                </div>    
            </div>
        </div>
    </div>
</div>
