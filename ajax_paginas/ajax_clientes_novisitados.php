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
                    <i class="fa fa-star"></i>AÑO <?php echo $ano ?> - MES <?php echo strtoupper(traducir_nombre_mes($mes)) ?> 
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided">
                        <a href="informe_novisitados_xls.php?ano=<?php echo $ano?>&mes=<?php echo $mes?>&zona=<?php echo $zona?>" target="_blank()" class="btn btn-circle green-jungle"><i class="fa fa-file-excel-o"></i> Exportar</a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">

                <div class="table-scrollable">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <td>Nit</td>
                                <td>Nombre</td>
                                <td>Fecha Ultima Visita</td>
                                <td>Zona</td>
                                <td>Compras (<?php echo $ano?>)</td>
                                <td>Compras (<?php echo $ano-1?>)</td>
                                <td></td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                        $zona_consulta = '';

                        if($zona != 0)
                        {
                            $zona_consulta .= "AND m.zona = ".$zona;
                        }
                        $fecha_busqueda = date($ano.'-'.$mes.'-01');

                        $resultado= $mysqli->query("SELECT u.id, u.documento, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS nombre, m.fecha_ult_vis, z.des FROM medicos m JOIN usuarios u ON m.usuario_id = u.id JOIN zonas z ON m.zona = z.id WHERE m.fechaCreacion < '$fecha_busqueda' $zona_consulta AND m.habilitado = 1 ORDER BY m.fecha_ult_vis DESC");

                        while ($row= mysqli_fetch_array($resultado))
                        { 

                            //CONSULTAMOS SI LO VISITARON EN EL MES
                            //echo "SELECT COUNT(v.id) AS n_visitas FROM visitas v WHERE v.usuario_id = ".$row['id']." AND MONTH(v.fecha) = $mes AND YEAR(v.fecha) = $ano GROUP BY v.usuario_id";
                            $resultado2= $mysqli->query("SELECT COUNT(v.id) AS n_visitas FROM visitas v WHERE v.usuario_id = ".$row['id']." AND MONTH(v.fecha) = $mes AND YEAR(v.fecha) = $ano GROUP BY v.usuario_id");
                            $num_reg = mysqli_num_rows($resultado2);
                            $row2 = mysqli_fetch_array($resultado2);
                                    
                            if ($num_reg == 0) 
                            {

                                //Consultamos las compras hechas por cada cliente del año seleccionado
                                //echo "SELECT SUM(c.compra) AS compras FROM cartera_usuarios c WHERE c.cliente_doc = '' AND c.ano = 2017 AND c.mes <= 1";
                                $resultado3= $mysqli->query("SELECT SUM(c.compra) AS compras FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND c.ano = $ano AND c.mes <= $mes");
                                $row3 = mysqli_fetch_array($resultado3);
                                //echo "SELECT SUM(c.compra) AS compras FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND c.ano = ".($ano-1)." AND c.mes <= $mes";
                                $resultado4= $mysqli->query("SELECT SUM(c.compra) AS compras FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND c.ano = ".($ano-1));
                                $row4 = mysqli_fetch_array($resultado4);

                                ?>
                                <tr>
                                    <td> <?php echo $row['documento']; ?></td>
                                    <td> <?php echo $row['nombre']?> </td>
                                    <td> <?php echo $row['fecha_ult_vis']; ?></td>
                                    <td> <?php echo $row['des']?></td>
                                    <td> <?php echo '$'.number_format($row3['compras'], 0, ",", ".") ?></td>
                                    <td> <?php echo '$'.number_format($row4['compras'], 0, ",", ".") ?></td>
                                    <td></td>
                                    <td></td>
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
