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
                    <i class="fa fa-male"></i>LISTADO 
                </div>
                <div class="actions">
                    <div class="btn-group btn-group-devided">
                        <a href="informe_hijos_xls.php?&zona=<?php echo $zona?>" target="_blank()" class="btn btn-circle green-jungle"><i class="fa fa-file-excel-o"></i> Exportar</a>
                    </div>
                </div>
            </div>
            <div class="portlet-body">

                <div class="table-scrollable">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <td>Documento</td>
                                <td>Nombre</td>
                                <td>Genero</td>
                                <td>Fecha Cumpleaños </td>
                                <td>Compras</td>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $hombres = $mujeres = $sin_genero = 0;
                        $zona_consulta = '';
                        $ano_actual = date('Y');

                        if($zona != 0)
                        {
                            $zona_consulta .= "AND m.zona = ".$zona;
                        }

                        $resultado= $mysqli->query("SELECT u.documento, UPPER(CONCAT_WS(' ', u.nom,u.ape1,u.ape2)) AS nombre, m.genero, m.mes_cum, m.dia_cum FROM medicos m JOIN usuarios u ON m.usuario_id = u.id JOIN zonas z ON m.zona = z.id WHERE m.hijos = 1 $zona_consulta");

                        while ($row= mysqli_fetch_array($resultado))
                        { 

                            //CONSULTAMOS LAS COMPRAS
                            $resultado2= $mysqli->query("SELECT SUM(c.compra) AS compras FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND c.ano = $ano_actual");
                            $row2 = mysqli_fetch_array($resultado2);


                            if($row['genero'] == 'M'){ $hombres += 1;}
                            
                            if($row['genero'] == 'F'){ $mujeres += 1;}
                            
                            if($row['genero'] == ''){ $sin_genero += 1;}
                            ?>
                            <tr>
                                <td> <?php echo $row['documento']; ?></td>
                                <td> <?php echo $row['nombre']?> </td>
                                <td> <?php echo $row['genero']?></td>
                                <td> <?php echo traducir_nombre_mes($row['mes_cum']).' '.$row['dia_cum']?></td>
                                <td> <?php echo '$'.number_format($row2['compras'],0,',','.')?></td>
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
    <div class="col-lg-4">
        <div class="portlet light ">
            <div class="portlet-body">
                <div class="mt-element-list">
                    <div class="mt-list-head list-simple font-white bg-red">
                        <div class="list-head-title-container">
                            <h3 class="list-title">Consolidado</h3>
                        </div>
                    </div>
                    <div class="mt-list-container list-simple">
                        <ul>
                            <li class="mt-list-item">
                                <div class="list-icon-container done">
                                    <i class="fa fa-dot-circle-o"></i>
                                </div>
                                <div class="list-datetime"> <?php echo $hombres ?> </div>
                                <div class="list-item-content">
                                    <h3 class="uppercase"> Hombres</h3>
                                </div>
                            </li>
                            <li class="mt-list-item">
                                <div class="list-icon-container done">
                                    <i class="fa fa-dot-circle-o"></i>
                                </div>
                                <div class="list-datetime"> <?php echo $mujeres ?> </div>
                                <div class="list-item-content">
                                    <h3 class="uppercase"> Mujeres</h3>
                                </div>
                            </li>
                            <li class="mt-list-item">
                                <div class="list-icon-container done">
                                    <i class="fa fa-dot-circle-o"></i>
                                </div>
                                <div class="list-datetime"> <?php echo $sin_genero ?> </div>
                                <div class="list-item-content">
                                    <h3 class="uppercase"> sin especificar</h3>
                                </div>
                            </li>
                            <li class="mt-list-item">
                                <div class="list-datetime"> <?php echo ($hombres+$mujeres+$sin_genero) ?> </div>
                                <div class="list-item-content">
                                    <h3 class="uppercase"> Total</h3>
                                </div>
                            </li>
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
