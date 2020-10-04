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
                    <i class="fa fa-star"></i></div>
            </div>
            <form action="#" id="form_datos_basicos" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-striped table-hover" id="tabla_clientes_new">
                        <thead>
                            <tr>
                                <th> Documento </th>
                                <th> Cliente </th>
                                <th> Dirección </th>
                                <th> Teléfono </th>
                                <th> Contacto </th>
                                <th>  </th>
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
                        


                        //Consultamos los clientes nuevos
                        $resultado= $mysqli->query("SELECT u.id, u.documento, CONCAT_WS(' ',u.nom, u.ape1, u.ape2) AS cliente, u.dir, u.tel, m.contacto FROM usuarios u JOIN medicos m ON u.id = m.usuario_id WHERE u.idrol = 5 AND m.cliente_nuevo = 1 $zona_consulta  AND m.fechaCreacion >= DATE_SUB(NOW(),INTERVAL 300 MONTH)");

                        while ($row= mysqli_fetch_array($resultado))
                        {                                    
                        
                        ?>
                            <tr>
                                <td> <?php echo $row['documento']; ?></td>
                                <td> <?php echo $row['cliente']?> </td>
                                <td> <?php echo $row['dir']?> </td>
                                <td> <?php echo $row['tel']?> </td>
                                <td> <?php echo $row['contacto']?> </td>
                                <td> 
                                    
                                    <div class="md-checkbox">
                                        <input type="checkbox" id="<?php echo $row['id'] ?>" name="chkOrder_<?php echo $row['id'];  ?>" value="" class="md-check validar">
                                        <label for="<?php echo $row['id'] ?>">
                                            <span></span>
                                            <span class="check"></span>
                                            <span class="box"></span></label>
                                    </div>

                                </td>
                            </tr>
                            <?php 
                            $n++;
                        }
                        ?>
                        
                        </tbody>
                    </table>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>