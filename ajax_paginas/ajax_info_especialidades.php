<?php 
@session_start();
include('../conexion.php');
include('../includes/parametros.php');
include('../funciones/fechas.php');

extract($_POST);

$especialidad = explode(";", $especialidad);
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
                        <a href="informe_especialidades_xls.php?especialidad=<?php echo $especialidad[0] ?>&esp_nom=<?php echo $especialidad[1] ?>" target="_blank()" class="btn btn-circle green-jungle"><i class="fa fa-file-excel-o"></i> Exportar</a>
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
                                <td>Dirección</td>
                                <td>Ciudad</td>
                                <td>Departamento</td>
                                <td>Teléfono</td>
                                <td>Celular</td>
                                <td>E-mail</td>
                                <td>Genero</td>
                                <td>Fecha Cumpleaños</td>                                
                            </tr>
                        </thead>
                        <tbody>
                        <?php
//SELECT nit, nommedico, dir, tel1, cel1, mail, genero, mes_cum, dia_cum FROM medicos WHERE especialidad = ".$_POST['especialidad'];  


                        $resultado= $mysqli->query("SELECT u.documento, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS nombre, u.dir, u.tel, u.cel, u.mail, m.genero, m.mes_cum, m.dia_cum, mun.nombreMunicipio AS municipio, d.nombre_dep AS departamento FROM medicos m JOIN usuarios u ON m.usuario_id = u.id LEFT JOIN municipios mun ON u.ciudad_actual = mun.id LEFT JOIN departamentos d ON mun.departamento_id = d.id  WHERE especialidad = $especialidad[0]");

                        while ($row= mysqli_fetch_array($resultado))
                        { 
                            ?>
                            <tr>
                                <td> <?php echo $row['documento']; ?></td>
                                <td> <?php echo $row['nombre']?> </td>
                                <td> <?php echo $row['dir']?> </td>
                                <td> <?php echo $row['municipio']?> </td>
                                <td> <?php echo $row['departamento'] ?></td>
                                <td> <?php echo $row['tel']?> </td>
                                <td> <?php echo $row['cel']?> </td>
                                <td> <?php echo $row['mail']?> </td>
                                <td> <?php echo $row['genero']?></td>
                                <td> <?php echo traducir_nombre_mes($row['mes_cum']).' '.$row['dia_cum']?> </td>
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
