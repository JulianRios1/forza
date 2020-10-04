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
                    <i class="fa fa-male"></i>Informe de Clientes Celebres
                </div>
                <!--<div class="actions">
                    <div class="btn-group btn-group-devided">
                        <a href="informe_especialidades_xls.php?especialidad=<?php echo $especialidad[0] ?>&esp_nom=<?php echo $especialidad[1] ?>" target="_blank()" class="btn btn-circle green-jungle"><i class="fa fa-file-excel-o"></i> Exportar</a>
                    </div>
                </div>-->
            </div>
            <div class="portlet-body">

                <div class="table-scrollable">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <td>Documento</td>
                                <td>Zona</td>
                                <td>Categoria</td>
                                <td>Normal</td>
                                <td>Especial</td>
                                <td>Logro</td>
                                <td>Bono</td>                          
                            </tr>
                        </thead>
                        <tbody>
                        <?php
//SELECT nit, nommedico, dir, tel1, cel1, mail, genero, mes_cum, dia_cum FROM medicos WHERE especialidad = ".$_POST['especialidad'];  


                        $resultado= $mysqli->query("SELECT u.documento, z.des AS zonaDes, tc.cliente_celebre, tc.rango1, tc.rango2, tc.compras, tc.bono FROM tabla_cierre_cli_celebres tc JOIN zonas z ON tc.zona = z.id JOIN medicos m ON tc.medico = m.usuario_id JOIN usuarios u ON m.usuario_id = u.id WHERE tc.ano = ".$ano." AND tc.trimestre = ".$trimestre);

                        while ($row= mysqli_fetch_array($resultado))
                        { 
                            ?>
                            <tr>
                                <td> <?php echo $row['documento']; ?></td>
                                <td> <?php echo $row['zonaDes']?> </td>
                                <td> <?php echo cliente_celebre($row['cliente_celebre'])?> </td>
                                <td> <?php echo number_format($row['rango1'],0,',','.')?> </td>
                                <td> <?php echo number_format($row['rango2'],0,',','.')?> </td>
                                <td> <?php echo number_format($row['compras'],0,',','.')?> </td>
                                <td> <?php echo number_format($row['bono'],0,',','.')?> </td>
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
</div>
