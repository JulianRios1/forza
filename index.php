<!DOCTYPE html>

<html lang="en">

<?php 

include('head.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
include('includes/parametros.php');
$pagina = 'inicio';


?>
    
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
        
        <?php include('top_info.php');?>

        <div class="clearfix"> </div>

        <div class="page-container">

            <div class="page-sidebar-wrapper ">
                <?php include('menu_lat.php');?>    
            </div>

            <div class="page-content-wrapper">

                <div class="page-content">

                    <div class="page-bar">
                        <ul class="page-breadcrumb">
                            <li>
                                <a href="index.php">Inicio</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Dashboard</span>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Dashboard
                        <small></small>
                    </h3>
                     
                    <!-- ACA EMPIEZA EL CONTENIDO -->   

                    <div class="row">
                        
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bubble font-red-sunglo"></i>
                                        <span class="caption-subject font-red-sunglo bold uppercase">PRODUCTOS DEL MES</span>
                                    </div>
                                </div>                                
                                <div class="portlet-body">
                                    <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                        <div class="tabbable tabbable-tabdrop">
                                            <?php 
                                            echo date('Y');
                                            //CONSULTAMOS LOS PRODUCTOS DEL MES
                                            $array_productos = $array_datos = array();
                                            $i_prod = 1;
                                            $resultado = $mysqli->query("SELECT p.idproducto, UPPER(p.desproducto) AS nombre, p.meta_producto FROM productos p WHERE p.destacado = 1 AND p.agotado = 0 AND p.oculto = 0 ORDER BY p.desproducto");
                                            $num_productos = mysqli_num_rows($resultado);
                                            ?>
                                            <ul class="nav nav-pills">
                                                <?php 
                                                while($row= mysqli_fetch_array($resultado))
                                                {     
                                                    array_push($array_productos, array("id"=>$row['idproducto'], "nombre"=>$row['nombre']));
                                                    $array_vacio = '';
                                                    //CONSULTAMOS LAS ZONAS
                                                    $resultado_zonas = $mysqli->query("SELECT * FROM zonas ORDER BY des");
                                                    while($row_zonas = mysqli_fetch_array($resultado_zonas))
                                                    {
                                                                                                               

                                                        //CONSULTAMOS LAS CANTIDADES DE LOS PRODUCTOS VENDIDAS POR ZONA
                                                        $resultado_ventas = $mysqli->query("SELECT COALESCE(SUM(pp.cantpedido_producto),0) AS cantidad FROM pedidos_productos pp JOIN pedidos p ON pp.pedido_idpedido = p.idpedido JOIN medicos m ON p.usuario_idusuario = m.usuario_id WHERE pp.producto_idproducto = ".$row['idproducto']." AND m.zona =".$row_zonas['id']." AND YEAR(p.fecpedido) = ".date('Y')." AND MONTH(p.fecpedido) = ".date('m'));
                                                        $row_ventas = mysqli_fetch_array($resultado_ventas);

                                                        $array_vacio .= '{"name": "'.$row_zonas["des"].'","points": '.$row_ventas['cantidad'].',"color":"'.color_random().'"},';
                                                    }  

                                                    //LLENAMOS EL ARRAY
                                                    $array_datos[$i_prod] = $array_vacio ;


                                                    ?>
                                                    <li <?php if($i_prod == 1) echo 'class="active"'; ?>>
                                                        <a href="#tab_prod_<?php echo $i_prod?>" data-toggle="tab"> <?php echo $row['nombre'] ?></a>
                                                    </li>
                                                    <?php
                                                    $i_prod ++;
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                        <?php                                         
                                        for ($i=1; $i <=$num_productos ; $i++) { 
                                            ?>
                                            <div class="tab-pane <?php if($i == 1) echo 'active'; ?>" id="tab_prod_<?php echo $i?>">                                            
                                                <div id="chartprod_<?php echo $i?>" class="chart" style="height: 270px;"> </div>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                        </div>                                                
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bubble font-red-sunglo"></i>
                                        <span class="caption-subject font-red-sunglo bold uppercase">COMPARATIVOS PRODUCTOS DEL MES</span>
                                    </div>
                                </div>                                
                                <div class="portlet-body">

                                    <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                        <?php 
                                        //CONSULTAMOS LOS PRODUCTOS DEL MES
                                        //echo 'saulo'.$array_productos[0]['nombre'];
                                        $array_meta = '';

                                        $resultado = $mysqli->query("SELECT p.idproducto, UPPER(p.desproducto) AS nombre, p.meta_producto FROM productos p WHERE p.destacado = 1 AND p.agotado = 0 AND p.oculto = 0 ORDER BY p.desproducto");

                                        $num_productos = mysqli_num_rows($resultado);

                                            while($row= mysqli_fetch_array($resultado))
                                            {     
                                                

                                                //CONSULTAMOS LAS CANTIDADES DE LOS PRODUCTOS VENDIDAS POR ZONA
                                                $resultado_ventas = $mysqli->query("SELECT COALESCE(SUM(pp.cantpedido_producto),0) AS cantidad FROM pedidos_productos pp JOIN pedidos p ON pp.pedido_idpedido = p.idpedido JOIN medicos m ON p.usuario_idusuario = m.usuario_id WHERE pp.producto_idproducto = ".$row['idproducto']." AND YEAR(p.fecpedido) = ".date('Y')." AND MONTH(p.fecpedido) = ".date('m'));
                                                $row_ventas = mysqli_fetch_array($resultado_ventas);

                                                $array_meta.= '{"name": "'.$row["nombre"].'","points": '.$row_ventas['cantidad'].', "meta":'.$row['meta_producto'].',"color":"'.color_random().'"},';
                                            }
                                            ?>
                                     
                                            <div id="chartprod_meta" class="chart" style="height: 320px;"> </div>

                                              
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bubble font-red-sunglo"></i>
                                        <span class="caption-subject font-red-sunglo bold uppercase">Modelo comercial</span>
                                    </div>
                                </div>                                
                                <div class="portlet-body">
                                    <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                        <div class="tabbable tabbable-tabdrop">
                                            <?php 

                                            $cons_zonas = '';

                                            if($_SESSION['rol_usu'] ==  1)
                                            {
                                                $resultado_zonas = $mysqli->query("SELECT * FROM zonas z WHERE id_vendedor = ".$_SESSION["idusuario"]);                                             
                                            } else {
                                                $resultado_zonas = $mysqli->query("SELECT * FROM zonas ORDER BY des");
                                            }

                                            //CONSULTAMOS LAS ZONAS
                                            
                                            $num_zonas = mysqli_num_rows($resultado_zonas);
                                            $k=0;
                                            $array_zonas = array();
                                            ?>
                                            <ul class="nav nav-tabs">
                                                <?php 
                                                while($row_zonas= mysqli_fetch_array($resultado_zonas))
                                                {     

                                                    //LLENAMOS EL ARRAY
                                                    $array_zonas[] = $row_zonas['id'];
                                                    $k++;


                                                    ?>
                                                    <li <?php if($k == 1) echo 'class="active"'; ?>>
                                                        <a href="#tab_zona_<?php echo $k?>" data-toggle="tab"> <?php echo $row_zonas['des'] ?></a>
                                                    </li>
                                                    <?php
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="tab-content">
                                        <?php    
                                        //CONSULTAMOS LOS PRODUCTOS DEL MES
                                        //$array_productos ='';
                                        /*$resultado = $mysqli->query("SELECT p.idproducto FROM productos p WHERE p.destacado = 1 AND p.agotado = 0 AND p.oculto = 0 ORDER BY p.desproducto");
                                        while($registro = mysqli_fetch_array($resultado))
                                        {
                                            $array_productos .= $registro['idproducto'].',';

                                        }*/

                                        //

                                        if(!empty($array_productos))
                                        {
                                            $array_prod_mes_id = '';
                                            foreach($array_productos as $valor) {
                                                $array_prod_mes_id .= $valor['id'].',';
                                            }
                                            $array_prod_mes_id = substr ($array_prod_mes_id, 0, strlen($array_prod_mes_id) - 1);

                                            for ($i=1; $i <=sizeof($array_zonas) ; $i++) { 
                                                ?>
                                                <div class="tab-pane <?php if($i == 1) echo 'active'; ?>" id="tab_zona_<?php echo $i?>">                                                                                            
                                                    <div class="scroller" style="height: 250px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                    <?php
                                                
                                                    //CONTADOR DE MEDICOS QUE PREESCRIBEN EL PRODUCTO DEL MES              
                                                    $result = $mysqli->query("SELECT COUNT(pp.idpedido_producto) AS nro_clientes FROM pedidos_productos pp JOIN pedidos p ON pp.pedido_idpedido = p.idpedido JOIN medicos m ON p.usuario_idusuario = m.usuario_id WHERE pp.producto_idproducto IN($array_prod_mes_id) AND YEAR(p.fecpedido) = ".date('Y')." AND MONTH(p.fecpedido) = ".date('m')." AND m.zona = ".$array_zonas[$i-1]);
                                                    $row = mysqli_fetch_array($result);

                                                    ////////////////////////////////////////////////////////

                                                    $contador_mayor_180 = $clientes_visitados = $ingresos_web = 0 ;

                                                    $resultado2 = $mysqli->query("SELECT u.id, u.documento, YEAR(m.fecha_ult_vis) AS ano_ult_visita, MONTH(m.fecha_ult_vis) AS mes_ult_visita, m.valor_compras, m.ano_compras, m.mes_compras FROM medicos m JOIN usuarios u ON m.usuario_id = u.id AND m.habilitado = 1 AND u.idrol = 5 WHERE m.zona = ".$array_zonas[$i-1]);    
                                                    $num_medicos = mysqli_num_rows($resultado2);
                                                    while($registro2 = mysqli_fetch_array($resultado2))
                                                    {
                                                        if($registro2['ano_ult_visita'] == date('Y') AND $registro2['mes_ult_visita'] == date('m')){
                                                            $clientes_visitados ++;
                                                        }


                                                        if($registro2['valor_compras'] >= 216000)
                                                        {
                                                            //echo $registro2['ano_compras'] ."==". date('Y')." && ". ($registro2['mes_compras'] ." == ". date('m'));
                                                            if(($registro2['ano_compras'] == date('Y')) && ($registro2['mes_compras'] == date('m')))
                                                            {
                                                                $contador_mayor_180 ++;
                                                            }
                                                        }
                                                    }


                                                    //CONSULTAMOS SI EL CLIENTE INGRESA AL NATURCOM
                                                    //echo "SELECT b.fecha FROM bitacora_acceso b JOIN medicos m ON m.usuario_id = b.usuario_id WHERE YEAR(b.fecha) = ".." AND MONTH(b.fecha) = ".date('m')." AND b.usuario_id = ".$registro2['id']."<br>";
                                                    //
                                                    $resultado_bitacora = $mysqli->query("SELECT m.usuario_id FROM bitacora_acceso b JOIN medicos m ON m.usuario_id = b.usuario_id WHERE YEAR(b.fecha) = ".date('Y')." AND MONTH(b.fecha) = ".date('m')." AND m.zona = ".$array_zonas[$i-1]." GROUP BY m.usuario_id");  
                                                    $num_ingresos = mysqli_num_rows($resultado_bitacora);  
                                                    $ingresos_web = $num_ingresos;
                                                    
                                                    ?>

                                                        <table class="table table-striped table-hover table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <td>Clientes en el modelo 168X216mil </td>
                                                                    <td><b><?php echo $contador_mayor_180; ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tienes en tu base de datos <b><?php echo $num_medicos ?></b> clientes</td>
                                                                    <td>Has visitado <b><?php echo $clientes_visitados?></b> clientes</td>
                                                                </tr>
                                                                <tr>
                                                                    <td># de clientes que prescriben productos del mes</td>
                                                                    <td><b><?php echo $row['nro_clientes'] ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td># de clientes que ingresan a naturcom.co</td>
                                                                    <td><a href="#" class="datos_edit" data-toggle="modal" data-id='<?php echo $array_zonas[$i-1] ?>'><b><?php echo $ingresos_web ?></b></a></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </div>                                                
                                    </div>
                                </div>

                                <!--
                                Modal para mostrar los clientes que compran en naturcom
                                -->
                                <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="" role="dialog" aria-labelledby="myModalLabel">
                                  <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Clientes</h4>
                                      </div>
                                      <div class="modal-body">
                                        <form class="form-horizontal">
                                          
                                          <input type="hidden" name="hdd_cliente" id="hdd_cliente" value="">
                                        </form>
                                        <div id="cargando" align="center" class="cbp"></div>
                                        <div class="outer_div" ></div><!-- Datos ajax Final -->
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <!--
                                Modal para mostrar los clientes que compran en naturcom
                                -->

                            </div>
                        </div>

                        <?php
                        if (in_array(1, $_SESSION["permisos"]))
                        {
                        ?>
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title tabbable-line">
                                    <div class="caption">
                                        <i class="icon-bubble font-red-sunglo"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">Últimas Visitas</span>
                                    </div>
                                </div>
                                
                                <div class="portlet-body">
                                    <ul class="nav nav-tabs">
                                        <li class="active">
                                            <a href="#tab_zona_ma" data-toggle="tab">Prioridad Muy Alta</a>
                                        </li>
                                        <li>
                                            <a href="#tab_zona_a" data-toggle="tab">Alta</a>
                                        </li>
                                        <li>
                                            <a href="#tab_zona_m" data-toggle="tab">Media</a>
                                        </li>
                                        <li>
                                            <a href="#tab_zona_b" data-toggle="tab">Baja</a>
                                        </li>
                                    </ul>
                                    <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab_zona_ma">
                                                <?php
                                                $resultado = $mysqli->query("SELECT v.id, v.usuario_id, v.id_vendedor, v.observacion, v.fecha, v.hora, z.des AS zona, u.avatar  FROM visitas v JOIN medicos m ON v.usuario_id = m.usuario_id JOIN zonas z ON m.zona = z.id JOIN usuarios u ON m.usuario_id = u.id WHERE v.estado = 0 AND prioridad = 'MA' ORDER BY v.fecha DESC"); 
                                                
                                                while($row = mysqli_fetch_array($resultado))
                                                {
                                                    $usuario = explode(";", consulta_usuarios($row['usuario_id']));
                                                    $vendedor = explode(";", consulta_usuarios($row['id_vendedor']));
                                                ?>
                                                <div class="mt-comments">
                                                    <div class="mt-comment">
                                                        <div class="mt-comment-img">
                                                            <img src="assets/avatars/img/<?php echo $usuario[1];?>" /> </div>
                                                        <div class="mt-comment-body">
                                                            <div class="mt-comment-info">
                                                                <span class="mt-comment-author"><?php echo $usuario[0].' (Zona '.$row['zona'].')'?></span>
                                                                <span class="mt-comment-date"><?php echo calcula_tiempo(strtotime(date($row['fecha'].' '.$row['hora'])));?></span>
                                                            </div>
                                                            <?php echo date($row['fecha'].' '.$row['hora']) ?>
                                                            <div class="mt-comment-text"> <?php echo $row['observacion']; ?> </div>
                                                            <div class="mt-comment-details">
                                                                <span class="mt-comment-status mt-comment-status-pending"><?php echo $vendedor[0]; ?></span>
                                                                <ul class="mt-comment-actions">
                                                                    <li>
                                                                        <a href="visita_view.php?id_visita=<?php echo $row['id']?>">Visualizar</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <?php 
                                                } ?>
                                            </div>

                                            <div class="tab-pane" id="tab_zona_a">
                                                <?php
                                                $resultado2 = $mysqli->query("SELECT v.id, v.usuario_id, v.id_vendedor, v.observacion, v.fecha, v.hora, z.des AS zona, u.avatar  FROM visitas v JOIN medicos m ON v.usuario_id = m.usuario_id JOIN zonas z ON m.zona = z.id JOIN usuarios u ON m.usuario_id = u.id WHERE v.estado = 0 AND prioridad = 'A' ORDER BY v.fecha DESC"); 
                                                
                                                while($row2 = mysqli_fetch_array($resultado2))
                                                {
                                                    $usuario2 = explode(";", consulta_usuarios($row2['usuario_id']));
                                                    $vendedor2 = explode(";", consulta_usuarios($row2['id_vendedor']));
                                                ?>
                                                <div class="mt-comments">
                                                    <div class="mt-comment">
                                                        <div class="mt-comment-img">
                                                            <img src="assets/avatars/img/<?php echo $usuario2[1];?>" /> </div>
                                                        <div class="mt-comment-body">
                                                            <div class="mt-comment-info">
                                                                <span class="mt-comment-author"><?php echo $usuario2[0].' (Zona '.$row2['zona'].')'?></span>
                                                                <span class="mt-comment-date"><?php echo calcula_tiempo(strtotime(date($row2['fecha'].' '.$row2['hora'])));?></span>
                                                            </div>
                                                            <?php echo date($row2['fecha'].' '.$row2['hora']) ?>
                                                            <div class="mt-comment-text"> <?php echo $row2['observacion']; ?> </div>
                                                            <div class="mt-comment-details">
                                                                <span class="mt-comment-status mt-comment-status-pending"><?php echo $vendedor2[0]; ?></span>
                                                                <ul class="mt-comment-actions">
                                                                    <li>
                                                                        <a href="visita_view.php?id_visita=<?php echo $row2['id']?>">Visualizar</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <?php 
                                                } ?>
                                            </div>

                                            <div class="tab-pane" id="tab_zona_m">
                                                <?php
                                                $resultado3 = $mysqli->query("SELECT v.id, v.usuario_id, v.id_vendedor, v.observacion, v.fecha, v.hora, z.des AS zona, u.avatar  FROM visitas v JOIN medicos m ON v.usuario_id = m.usuario_id JOIN zonas z ON m.zona = z.id JOIN usuarios u ON m.usuario_id = u.id WHERE v.estado = 0 AND prioridad = 'M' ORDER BY v.fecha DESC"); 
                                                
                                                while($row3 = mysqli_fetch_array($resultado3))
                                                {
                                                    $usuario3 = explode(";", consulta_usuarios($row3['usuario_id']));
                                                    $vendedor3 = explode(";", consulta_usuarios($row3['id_vendedor']));
                                                ?>
                                                <div class="mt-comments">
                                                    <div class="mt-comment">
                                                        <div class="mt-comment-img">
                                                            <img src="assets/avatars/img/<?php echo $usuario3[1];?>" /> </div>
                                                        <div class="mt-comment-body">
                                                            <div class="mt-comment-info">
                                                                <span class="mt-comment-author"><?php echo $usuario3[0].' (Zona '.$row3['zona'].')'?></span>
                                                                <span class="mt-comment-date"><?php echo calcula_tiempo(strtotime(date($row3['fecha'].' '.$row3['hora'])));?></span>
                                                            </div>
                                                            <?php echo date($row3['fecha'].' '.$row3['hora']) ?>
                                                            <div class="mt-comment-text"> <?php echo $row3['observacion']; ?> </div>
                                                            <div class="mt-comment-details">
                                                                <span class="mt-comment-status mt-comment-status-pending"><?php echo $vendedor3[0]; ?></span>
                                                                <ul class="mt-comment-actions">
                                                                    <li>
                                                                        <a href="visita_view.php?id_visita=<?php echo $row3['id']?>">Visualizar</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <?php 
                                                } ?>
                                            </div>

                                            <div class="tab-pane" id="tab_zona_b">
                                                <?php
                                                $resultado4 = $mysqli->query("SELECT v.id, v.usuario_id, v.id_vendedor, v.observacion, v.fecha, v.hora, z.des AS zona, u.avatar  FROM visitas v JOIN medicos m ON v.usuario_id = m.usuario_id JOIN zonas z ON m.zona = z.id JOIN usuarios u ON m.usuario_id = u.id WHERE v.estado = 0 AND prioridad = 'B' ORDER BY v.fecha DESC"); 
                                                
                                                while($row4 = mysqli_fetch_array($resultado4))
                                                {
                                                    $usuario4 = explode(";", consulta_usuarios($row4['usuario_id']));
                                                    $vendedor4 = explode(";", consulta_usuarios($row4['id_vendedor']));
                                                ?>
                                                <div class="mt-comments">
                                                    <div class="mt-comment">
                                                        <div class="mt-comment-img">
                                                            <img src="assets/avatars/img/<?php echo $usuario4[1];?>" /> </div>
                                                        <div class="mt-comment-body">
                                                            <div class="mt-comment-info">
                                                                <span class="mt-comment-author"><?php echo $usuario4[0].' (Zona '.$row4['zona'].')'?></span>
                                                                <span class="mt-comment-date"><?php echo calcula_tiempo(strtotime(date($row4['fecha'].' '.$row4['hora'])));?></span>
                                                            </div>
                                                            <?php echo date($row4['fecha'].' '.$row4['hora']) ?>
                                                            <div class="mt-comment-text"> <?php echo $row4['observacion']; ?> </div>
                                                            <div class="mt-comment-details">
                                                                <span class="mt-comment-status mt-comment-status-pending"><?php echo $vendedor4[0]; ?></span>
                                                                <ul class="mt-comment-actions">
                                                                    <li>
                                                                        <a href="visita_view.php?id_visita=<?php echo $row4['id']?>">Visualizar</a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <?php 
                                                } ?>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }
                        ?>

                        <?php
                        if (in_array(2, $_SESSION["permisos"]))
                        {
                        ?>
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bubble font-red-sunglo"></i>
                                        <span class="caption-subject font-red-sunglo bold uppercase">COMENTARIOS DE VISITAS</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                        <?php
                                        /*----------  Consultamos si es vendedor y obtenemos las zonas  ----------*/
                                        $cons_zonas = '';

                                        if($_SESSION['rol_usu'] ==  1)
                                        {
                                            $resultado = $mysqli->query("SELECT id as zona FROM zonas z WHERE id_vendedor = ".$_SESSION["idusuario"]); 
                                            $zn='';
                                                            
                                            while($row_zon= mysqli_fetch_array($resultado))
                                            {
                                                $zn.= $row_zon['zona'].','; 
                                            }
                                            $cons_zonas = ' AND m.zona IN ('.substr ($zn , 0, -1 ).')';
                                            
                                        }

                                        $resultado = $mysqli->query("SELECT v.id, v.fecha, v.hora, v.observacion, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS usuario, v.comentario, v.id_vendedor, v.usuario_id_com, DATE(v.fecha_ver_com) 
AS fecha_com, TIME(v.fecha_ver_com) AS hora_com FROM visitas v JOIN medicos m ON m.usuario_id = v.usuario_id 
JOIN zonas z ON m.zona = z.id JOIN usuarios u ON v.usuario_id = u.id WHERE v.comentario != '' AND DATEDIFF(CURDATE(), v.fecha) <= 10 $cons_zonas ORDER BY v.fecha_ver_com DESC"); 
                                        
                                        while($row = mysqli_fetch_array($resultado))
                                        {
                                            //SEPARAMOS LOS DATOS DEL NOMBRE Y EL AVATAR
                                            $vendedor = explode(";", consulta_usuarios($row['id_vendedor']));
                                            $usuario_com = explode(";", consulta_usuarios($row['usuario_id_com']));
                                            
                                        ?>
                                        <ul class="chats">
                                            <li class="in">
                                                <img class="avatar" alt="" src="assets/avatars/img/<?php echo $vendedor[1] ?>">
                                                <div class="message">
                                                    <span class="arrow"> </span>
                                                    <span class="text-warning"><?php echo $row['usuario'];?></span><br>
                                                    <span class="text-info"><?php echo $vendedor[0] ?></span>
                                                    <span class="datetime"> el <?php echo $row['fecha'] .' ('.$row['hora'].')'?></span>
                                                    <span class="body"> <?php echo $row['observacion'] ?> </span>
                                                </div>
                                            </li>
                                            <li class="out">
                                                <img class="avatar" alt="" src="assets/avatars/img/<?php echo $usuario_com[1] ?>">
                                                <div class="message">
                                                    <span class="arrow"> </span>
                                                    <span class="font-green-sharp"><?php echo $usuario_com[0] ?></span>
                                                    <span class="datetime"> el <?php echo $row['fecha_com'] .' ('.$row['hora_com'].')'?></span>
                                                    <span class="body"> <?php echo $row['comentario'] ?> </span>
                                                </div>
                                            </li>
                                        </ul>
                                        <?php   } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }
                        ?>


                        <?php
                        if (in_array(126, $_SESSION["permisos"]))
                        {
                        ?>
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">SALDOS DE CLIENTES </span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>
                                                            No. Documento
                                                        </th>
                                                        <th>
                                                            Nombre
                                                        </th>
                                                        <th>
                                                            Crédito
                                                        </th>
                                                        <th>
                                                            Efectivo
                                                        </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $cons_zonas = '';

                                                        if($_SESSION['rol_usu'] ==  1)
                                                        {
                                                            $resultado = $mysqli->query("SELECT id as zona FROM zonas z WHERE id_vendedor = ".$_SESSION["idusuario"]); 
                                                            $zn='';
                                                                            
                                                            while($row_zon= mysqli_fetch_array($resultado))
                                                            {
                                                                $zn.= $row_zon['zona'].','; 
                                                            }
                                                            $cons_zonas = ' AND m.zona IN ('.substr ($zn , 0, -1 ).')';
                                                            
                                                        }

                                                        $resultado = $mysqli->query("SELECT u.documento, CONCAT_WS(' ',u.nom,u.ape1, u.ape2) AS medico, m.saldoPrepago, m.saldoEfectivo, z.des AS zona FROM medicos m JOIN usuarios u ON m.usuario_id = u.id JOIN zonas z ON z.id = m.zona WHERE (m.saldoPrepago > 0 OR m.saldoEfectivo > 0) AND m.habilitado = 1 AND u.estado = 1 $cons_zonas ORDER BY medico ASC");
                                                        $num_pedidos = mysqli_num_rows($resultado);


                                                        while($row = mysqli_fetch_array($resultado))
                                                        {
                                                        ?>
                                                        <tr>
                                                            <td>
                                                                <?php echo $row['documento'] ?>
                                                            </td>
                                                            <td>
                                                                <?php echo strtoupper($row["medico"])?>
                                                            </td>
                                                            <td>
                                                                <?php echo number_format($row["saldoPrepago"], 0, ",", ".")?>
                                                            </td>
                                                            <td>
                                                                <?php echo '$'.number_format($row["saldoEfectivo"], 0, ",", ".")?>
                                                            </td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }
                        ?>
                        

                        <?php
                        if (in_array(3, $_SESSION["permisos"]))
                        {
                        ?>
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">CLIENTES NUEVOS </span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                            <div class="table-responsive" id="result">
                                            </div>    
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal para revisar clientes nuevos. -->
                                <div id="customerModal" class="modal container fade">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title"></h4>
                                        </div>
                                        <div class="modal-body">

                                            <form class="form-horizontal" role="form">
                                                <div class="form-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Tipo Documento:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="tipo"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Documento:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="documento"> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Especialidad:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="especialidad"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Nombre:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="nombre"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Genero:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="genero"></p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Dirección:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="dir"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Barrio:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="barrio"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Teléfono:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="tel"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Ciudad:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="ciudad"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Celular:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="cel"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Email:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="mail"> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Zona:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="zona"> </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Horario:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="horario"></p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Hijos:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="hijos"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/span-->
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Mes Cumpleaños:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="mcum"></p>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Día Cumpleaños:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="dcump"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Condiciones:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="condiciones"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Hobby:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="hobby"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Proyecto:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="proyecto"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="control-label col-md-4">Observaciones:</label>
                                                                <div class="col-md-8">
                                                                    <p class="form-control-static" id="observaciones"></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="control-label col-md-4">Cliente guardado en el sistema:</label>
                                                            <div class="col-md-8">
                                                                <div class="icheck-inline">
                                                                    <label class="">
                                                                        <div class="icheckbox_minimal-grey" style="position: relative;"><input type="checkbox" name="validar" id="validar" class="icheck" style="position: absolute; opacity: 0;" value="1"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>  </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="customer_id" id="customer_id" />
                                            <input type="submit" name="action" id="action" class="btn btn-success" />
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <?php 
                        }
                        ?>

                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">Últimos Pedidos </span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>No. Pedido</th>
                                                        <th>Fecha Pedido</th>
                                                        <th>Cliente</th>
                                                        <th>Valor Total</th>
                                                        <th>Estado</th>
                                                        <th>Observaciones</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $resultado = $mysqli->query("SELECT p.idpedido, p.fecpedido, p.total, p.estadopedido, p.observacion, UPPER(CONCAT_WS(' ',u.nom, u.ape1, u.ape2)) AS usuario FROM pedidos p JOIN usuarios u ON u.id = p.usuario_idusuario AND p.estadopedido != 5 AND p.estadopedido != 4  AND p.fecpedido >= DATE_SUB(NOW(), INTERVAL 3 MONTH) ORDER BY p.fecpedido DESC");
                                                        $num_pedidos = mysqli_num_rows($resultado);


                                                        while($row = mysqli_fetch_array($resultado))
                                                        {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $row['idpedido'] ?></td>
                                                            <td><?php echo $row['fecpedido'] ?></td>
                                                            <td><?php echo $row["usuario"]?></td>
                                                            <td><?php echo $row["total"]?></td>
                                                            <td><?php echo estados_pedidos($row["estadopedido"])?></td>
                                                            <td><?php echo $row["observacion"]?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        if (in_array(4, $_SESSION["permisos"]))
                        {
                        ?>
                        <div class="col-md-6 col-sm-6">
                            <div class="portlet light bordered">
                                <div class="portlet-title">
                                    <div class="caption caption-md">
                                        <i class="icon-globe theme-font hide"></i>
                                        <span class="caption-subject font-blue-madison bold uppercase">CUMPLEAÑOS DEL MES</span>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="tab-content">
                                        <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                            <div class="table-scrollable">
                                                <table class="table table-striped table-hover table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th>Cliente</th>
                                                        <th>Dirección</th>
                                                        <th>Teléfono</th>
                                                        <th> Fecha </th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        $cons_zonas = '';

                                                        if($_SESSION['rol_usu'] ==  1)
                                                        {
                                                            $resultado = $mysqli->query("SELECT id as zona FROM zonas z WHERE id_vendedor = ".$_SESSION["idusuario"]); 
                                                            $zn='';
                                                                            
                                                            while($row_zon= mysqli_fetch_array($resultado))
                                                            {
                                                                $zn.= $row_zon['zona'].','; 
                                                            }
                                                            $cons_zonas = ' AND m.zona IN ('.substr ($zn , 0, -1 ).')';
                                                            
                                                        }
                                                        $resultado = $mysqli->query("SELECT UPPER(CONCAT_WS(' ',u.nom,u.ape1,u.ape2)) AS cliente, u.dir, u.tel, m.mes_cum, m.dia_cum FROM medicos m JOIN usuarios u ON m.usuario_id = u.id WHERE m.mes_cum = ".date('m')." AND m.dia_cum >= ".date('d')." $cons_zonas ORDER BY m.dia_cum");
                                                        $num_pedidos = mysqli_num_rows($resultado);


                                                        while($row = mysqli_fetch_array($resultado))
                                                        {
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $row['cliente'] ?></td>
                                                            <td><?php echo $row['dir'] ?></td>
                                                            <td><?php echo $row['tel'] ?></td>
                                                            <td><?php echo $row['dia_cum'].' '.traducir_nombre_mes($row['mes_cum']) ?></td>
                                                        </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                        }
                        ?>
                    </div>    
                </div>
            </div>
        </div>
        
        <?php
        include('footer.php');
        ?>


        <script src="assets/global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        
        <script src="assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js" type="text/javascript"></script>
        <script src="assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/morris/raphael-min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/themes/light.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/themes/patterns.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/themes/chalk.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/ammap/maps/js/worldLow.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amstockcharts/amstock.js" type="text/javascript"></script>
        <script src="assets/global/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/amcharts/amcharts/plugins/dataloader/dataloader.min.js"></script>
        <script src="assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/alertity/js/alertify.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        
        <script>
        $(document).ready(function(){

        /*=================================================
        = Ajax que administra el modal de clientes nuevos =
        ==================================================*/
        
        fetchUser(); //This function will load all data on web page when page load
        function fetchUser() // Funcion que llama la tabla en el div result
        {
            
            var action = "cargar";
            $.ajax({
                url : "ajax_paginas/dashboard_ajax_clientes_nuevos.php", //Request send to "action.php page"
                method:"POST", //Using of Post method for send data
                data:{action:action}, //action variable data has been send to server
                success:function(data){
                    $('#result').html(data); //It will display data under div tag with id result
                }
            });
        }

        $(document).on('click', '.consultar', function(){
            var id = $(this).attr("id"); //This code will fetch any customer id from attribute id with help of attr() JQuery method
            var action = "consulta";
            //alert(action);
            $.ajax({
                url:"ajax_paginas/dashboard_ajax_clientes_nuevos.php",   //Request send to "action.php page"
                method:"POST",    //Using of Post method for send data
                data:{id:id, action:action},//Send data to server
                dataType:"json",   //Here we have define json data type, so server will send data in json format.

                success:function(data){
                    //console.log(data);
                    $('#customerModal').modal('show');   //It will display modal on webpage
                    $('.modal-title').text("CLIENTE NUEVO"); //This code will change this class text to Update records
                    $('#action').val("Guardar");     //This code will change Button value to Update
                    $('#customer_id').val(id);     //It will define value of id variable to this customer id hidden field
                    $('#tipo').text(data.tipo); 
                    $('#documento').text(data.documento); 
                    $('#nombre').text(data.nombre);  
                    $('#especialidad').text(data.especialidad); 
                    $('#genero').text(data.genero); 
                    $('#dir').text(data.dir); 
                    $('#barrio').text(data.barrio); 
                    $('#tel').text(data.tel); 
                    $('#ciudad').text(data.ciudad); 
                    $('#cel').text(data.cel); 
                    $('#mail').text(data.mail); 
                    $('#zona').text(data.zona);
                    $('#horario').text(data.horario);
                    $('#hijos').text(data.hijos);
                    $('#mcum').text(data.mcum);
                    $('#dcump').text(data.dcump);
                    $('#condiciones').text(data.condiciones);
                    $('#hobby').text(data.hobby);
                    $('#proyecto').text(data.proyecto);
                    $('#observaciones').text(data.observaciones); 
                }
            });
        });

        //
        $('#action').click(function(){

            var validar = $('#validar').prop('checked');
            var id = $('#customer_id').val(); 
            var action = $('#action').val(); 
            //alert(validar+'-'+id);
            if(validar != '' && id != '') //Son obligatorios
            {
                $.ajax({
                    url : "ajax_paginas/dashboard_ajax_clientes_nuevos.php",   
                    method:"POST",    
                    data:{validar:validar, id:id, action:action}, 
                    success:function(data){
                        //alert(data);   
                        $('#customerModal').modal('hide'); //Ocultamos el modal
                        fetchUser();    // recargamos el modulo
                    }
                })
                .done(function(res){
                    alertify.alert(res, function(ev) {

                    });
                });
            }
            else
            {
                alertify.alert("No ha validado el cliente", function(ev) {
                });

            }
        });
        

        $('.datos_edit').click(function (e) {
            e.preventDefault();
            zona = $(this).data('id');
            
            $('#myModal').modal('show'); 

            //dashboard_ajax_clientes_ingresan_web.php
            var parametros={"action":"ajax","zona":zona};
            $("#loader").fadeIn('slow');
            $.ajax({
                url:'ajax_paginas/dashboard_ajax_clientes_ingresan_web.php',
                data: parametros,
                 beforeSend: function(objeto){
                 //$('#loader').html('<img src="./img/ajax-loader.gif"> Cargando...');
                 //$("#cargando").show();
              },
                success:function(data){
                    $(".outer_div").html(data).fadeIn('slow');
                    //$('#loader').html('');
                    $('#cargando').hide(); 
                    
                }
            })
        });
        /*==================  FIN =================*/
        
        <?php 
        for($j=1; $j<=$num_productos; $j++)
        {
            ?>
            var chart = AmCharts.makeChart("chartprod_<?php echo $j?>",
            {
                "type": "serial",
                "theme": "light",
                "dataProvider": [<?php echo $array_datos[$j];?>],
                "valueAxes": [{
                    //"maximum": 800,
                    "minimum": 0,
                    "axisAlpha": 0,
                    "dashLength": 4,
                    "position": "left"
                }],
                "startDuration": 1,
                "graphs": [{
                    "balloonText": "<span style='font-size:13px;'>[[category]]: <b>[[value]]</b></span>",
                    "bulletOffset": 10,
                    "bulletSize": 52,
                    "colorField": "color",
                    "cornerRadiusTop": 5,
                    "fillAlphas": 0.8,
                    "lineAlpha": 0,
                    "type": "column",
                    "valueField": "points"
                }],
                "marginTop": 0,
                "marginRight": 0,
                "marginLeft": 0,
                "marginBottom": 0,
                "autoMargins": true,
                "categoryField": "name",
                "categoryAxis": {
                    "axisAlpha": 0,
                    "gridAlpha": 0,
                    "inside": true,
                    "tickLength": 0,
                    "labelRotation": 90
                },
                "export": {
                    "enabled": true
                 }
            });
            <?php 
        }
        ?>

        //GRAFICA DE PRODUCTOS META
        var chart = AmCharts.makeChart("chartprod_meta",
        {
            "type": "serial",
            "theme": "light",
            "dataProvider": [<?php echo $array_meta;?>],
            "valueAxes": [{
                //"maximum": 800,
                "minimum": 0,
                "axisAlpha": 0,
                "dashLength": 4,
                "position": "left"
            }],
            "startDuration": 1,
            "graphs": [{
                "balloonText": "<span style='font-size:13px;'>[[category]]: <b>[[value]]</b></span>",
                "bulletOffset": 10,
                "bulletSize": 52,
                "colorField": "color",
                "cornerRadiusTop": 5,
                "fillAlphas": 0.8,
                "lineAlpha": 0,
                "type": "column",
                "valueField": "points"
            }, {
                "balloonText": "<span style='font-size:13px;'>[[title]]:<b>[[value]]</b> [[additional]]</span>",
                "bullet": "round",
                "dashLengthField": "dashLengthLine",
                "lineThickness": 3,
                "bulletSize": 7,
                "bulletBorderAlpha": 1,
                "bulletColor": "#FFFFFF",
                "useLineColorForBulletBorder": true,
                "bulletBorderThickness": 3,
                "fillAlphas": 0,
                "lineAlpha": 1,
                "title": "Meta",
                "valueField": "meta"
            }],
            "marginTop": 0,
            "marginRight": 0,
            "marginLeft": 0,
            "marginBottom": 0,
            "autoMargins": true,
            "categoryField": "name",
            "categoryAxis": {
                "axisAlpha": 0,
                "gridAlpha": 0,
                "inside": true,
                "tickLength": 0,
                "labelRotation": 90
            },
            "export": {
                "enabled": true
             }
        });
});
        </script>
        
    </body>

</html>