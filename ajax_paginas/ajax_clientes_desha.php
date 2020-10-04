<?php 
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
include('../funciones/fechas.php');

extract($_POST);

?>
<div class='margin-top-20'>
    <div class="col-md-12">
        <div class="portlet box purple-medium">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-unlock-alt"></i> 
                </div>
                
            </div>
            <div class="portlet-body">

                <div class="table-scrollable">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Nit</th>
                                <th>Nombre</th>
                                <th>Fecha Ultima Visita</th>
                                <th>Zona</th>
                                <th>Fecha último Pedido</th>
                                <th>Vlr última compra</th>
                                <th>Fecha última compra</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $i=1;
                        $zona_consulta = '';

                        if($zona != 0)
                        {
                            $zona_consulta .= "AND m.zona = ".$zona;
                        }

                        $resultado= $mysqli->query("SELECT u.documento, UPPER(CONCAT_WS(' ',u.nom,u.ape1,u.ape2)) AS nombre, m.fecha_ult_vis, z.des AS zona, m.fec_ult_pedido, m.valor_compras,CONCAT_WS('-',m.mes_compras,m.ano_compras) AS fecha_ult_compra FROM medicos m JOIN usuarios u ON u.id = m.usuario_id LEFT JOIN zonas z ON m.zona = z.id WHERE m.habilitado = 0 $zona_consulta ORDER BY nombre ");

                        while ($row= mysqli_fetch_array($resultado))
                        { 
                            ?>
                            <tr>
                                <td> <?php echo $i ?></td>
                                <td> <?php echo $row['documento']; ?></td>
                                <td> <?php echo $row['nombre']?> </td>
                                <td> <?php echo $row['fecha_ult_vis']; ?></td>
                                <td> <?php echo $row['zona']?></td>                            
                                <td> <?php echo $row['fec_ult_pedido'] ?></td>
                                <td> <?php echo number_format($row['valor_compras'],0,',','.') ?></td>
                                <td> <?php echo $row['fecha_ult_compra'] ?></td>
                            </tr>
                            <?php 
                            $i++;
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
