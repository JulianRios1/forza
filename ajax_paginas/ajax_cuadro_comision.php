<?php 
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
include('../funciones/fechas.php');

extract($_POST);
echo "<div class='margin-top-20'>";
/*----------  Consultamos las zonas  ----------*/
$cons_zonas = $cons_zonas_select = '';

if($_SESSION['rol_usu'] ==  1)
{
    $resultado = $mysqli->query("SELECT id as zona FROM zonas z WHERE id_vendedor = ".$_SESSION["idusuario"]); 
    $zn='';
                    
    while($row_zon= mysqli_fetch_array($resultado))
    {
        $zn.= $row_zon['zona'].','; 
    }
    $cons_zonas_select = ' WHERE id IN ('.substr ($zn , 0, -1 ).')';
}

$resultado= $mysqli->query("SELECT * FROM zonas $cons_zonas ORDER BY des");
while ($row_zona = mysqli_fetch_array($resultado))
{
?>
<div class="col-md-6">
    <div class="portlet box green">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-calculator"></i>ZONA <?php echo strtoupper($row_zona['des'])?> </div>
            <div class="tools">
                <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                <a href="javascript:;" class="remove" data-original-title="" title=""> </a>
            </div>
        </div>
        <div class="portlet-body">
            <div class="table-scrollable">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th> Mes </th>
                            <th colspan="2"> Ventas </th>
                            <th colspan="2"> Cobros </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    for($i=1; $i<13; $i++)
                    {

                        $resultado1= $mysqli->query("SELECT SUM(compra) AS compra FROM cartera_usuarios c JOIN usuarios u ON  c.cliente_doc = u.documento JOIN medicos m ON m.usuario_id = u.id WHERE m.zona = ".$row_zona['id']." AND c.mes = ".$i." AND c.ano = ".($ano-1));
                        $row = mysqli_fetch_array($resultado1);

                        //Consulto el porcentaje de cremiento
                        $resul= $mysqli->query("SELECT * FROM porcentajes_crecimiento WHERE zona = ".$row_zona['id']." AND mes = ".$i." AND ano = ".$ano);
                        $row2 = mysqli_fetch_array($resul);


                        //$meta1 = $registro['compra']+(($registro['compra']*$regis2['porcentaje'])/100)+$regis2['pesos'] ;
                        $meta1 = $row2['pesos'] ;
                        //echo 'Compras='.$registro['compra'].' - Crecimiento $'.$meta1.' - % '.$regis2['porcentaje'].'<br>';
                        $meta2 = ($meta1*90)/100;
                        $meta3 = ($meta1*80)/100;

                        $cobro1 = ($meta1 * 90)/100;
                        $cobro2 = ($meta2 * 90)/100;
                        $cobro3 = ($meta3 * 90)/100;
                        ?>
                        <tr>
                            <td rowspan="3"> <?php echo traducir_nombre_mes_corto($i); ?></td>
                            <td> <?php echo '$'.number_format($meta1, 0, ",", ".")?> </td>
                            <td> En Adelante </td>
                            <td><?php echo '$'.number_format($cobro1, 0, ",", ".")?></td>
                            <td>En Adelante</td>
                        </tr>
                        <tr>
                            <td><?php echo '$'.number_format($meta2, 0, ",", ".")?></td>
                            <td><?php echo '$'.number_format($meta1 - 1, 0, ",", ".")?></td>
                            <td><?php echo '$'.number_format($cobro2, 0, ",", ".")?></td>
                            <td><?php echo '$'.number_format($cobro1 - 1, 0, ",", ".")?></td>
                        </tr>
                        <tr>
                            <td><?php echo '$'.number_format($meta3, 0, ",", ".")?></td>
                            <td><?php echo '$'.number_format(($meta2) - 1, 0, ",", ".")?></td>
                            <td><?php echo '$'.number_format($cobro3, 0, ",", ".")?></td>
                            <td><?php echo '$'.number_format($cobro2 - 1, 0, ",", ".")?></td>
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
<?php 
}
echo "</div>";
?>