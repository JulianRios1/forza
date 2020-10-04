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
                    <i class="fa fa-star"></i>AÑO <?php echo $ano ?> </div>
            </div>
            
            <div class="portlet-body">
                <div class="table-scrollable">
                    <form action="#" id="form_porcentajes" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> Mes </th>
                                <th> Porcentaje </th>
                                <th> Pesos </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        $array_porcentajes = $array_pesos = array();
                        for($i=1; $i<=12; $i++)
                        {                                    

                        //Consultamos la tabla de porcentajes
                        $resultado= $mysqli->query("SELECT * FROM porcentajes_crecimiento WHERE zona = ".$zona." AND mes = ".$i." AND ano = ".$ano);
                        $row = mysqli_fetch_array($resultado);

                        ?>
                            <tr>
                                <td><?php echo traducir_nombre_mes($i)?></td>
                                <!--<td> <input type="text" name="porcentaje_<?php echo $i?>" id="porcentaje_<?php echo $i?>" placeholder="" class="form-control" value="<?php echo $row['porcentaje'] ?>" style="text-transform:uppercase" /> </td>-->
                                <td> <input type="text" name="array_porcentajes[<?php echo $i?>]" id="array_porcentajes[<?php echo $i?>]" placeholder="" class="form-control" value="<?php echo $row['porcentaje'] ?>" style="text-transform:uppercase" /> </td>
                                <td> <input type="text" name="array_pesos[<?php echo $i?>]" id="array_pesos[<?php echo $i?>]" placeholder="" class="form-control" value="<?php echo number_format($row['pesos'],0,',','.'); ?>" onchange="puntillos(this);" onkeyup="puntillos(this);" /> </td>
                            </tr>
                            <?php 
                            //$n++;
                        }
                        ?>
                       
                        </tbody>
                    </table>
                    <input type="hidden" name="hdd_ano" value="<?php echo $ano ?>">
                    <input type="hidden" name="hdd_zona" value="<?php echo $zona ?>">
                    </form>
                </div>
                 <div class="margiv-top-10 form-actions">

                    <button type="button" id="button" class="btn green">Guardar Cambios</button>
                </div>
            </div>
            
        </div>
    </div>
</div>