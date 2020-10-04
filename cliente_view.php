<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
$pagina = 'itinerario';
extract ($_GET);

?>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">

        <?php include('top_info.php');?>

        <div class="clearfix"> </div>

        <div class="page-container">

            <div class="page-sidebar-wrapper">
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
                                <a href="itinerario.php">Itinerario</a>
                                <i class="fa fa-circle"></i>
                            </li>
                            <li>
                                <span>Cliente</span>
                            </li>
                        </ul>

                    </div>

                    <h3 class="page-title"> Cliente
                        <small></small>
                    </h3>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="profile-sidebar">
                                <div class="portlet light  ">
                                    <!-- CONSULTA DEL CLIENTE -->
                                    <?php
                                    $resultado = $mysqli->query("SELECT u.*, m.tipo_cliente_celebre, m.cliente_especial FROM usuarios u LEFT JOIN medicos m ON m.usuario_id = u.id  WHERE u.id = $id"); 
                                    $row = mysqli_fetch_array($resultado);
                                    ?>

                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name" id="nombre_cliente"> <?php echo $row['nom'].' '.$row['ape1'].' '.$row['ape2']?> </div>
                                        <div class="profile-usertitle-job"> <?php echo $row['documento']?> </div>
                                    </div>

                                    <div>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-globe"></i>
                                            <?php echo $row['dir']; ?>
                                        </div>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-phone"></i>
                                            <?php echo $row['tel']; ?>
                                        </div>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-mobile"></i>
                                            <?php echo $row['cel']; ?>
                                        </div>
                                        <div class="margin-top-20 profile-desc-link">
                                            <i class="fa fa-envelope"></i>
                                            <?php echo $row['mail']; ?>
                                        </div>
                                        <?php 
                                        if ($row['cliente_especial'] == 1) {
                                            ?>
                                            <div class="margin-top-20 profile-desc-link">
                                                <i class="fa fa-trophy font-green-jungle"></i>
                                                Cliente Especial
                                            </div>
                                            <?php 
                                        }
                                        ?>
                                        <?php
                                        /*$fechaactual = getdate();

                                        echo "Hoy es: $fechaactual[weekday], $fechaactual[mday] de $fechaactual[month] de $fechaactual[year]";


                                        date_default_timezone_set('c');

                                        if (date_default_timezone_get()) {
                                            echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';
                                        }

                                        if (ini_get('date.timezone')) {
                                            echo 'date.timezone: ' . ini_get('date.timezone');
                                        }*/
                                        ?>
                                    </div>
                                    
                                </div>

                                <div class="portlet light profile-sidebar-portlet ">
                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li class="active">
                                                <a href="#">
                                                    <i class="icon-home"></i> Perfil </a>
                                            </li>
                                            <li>
                                                <a href="cliente_edit.php?id=<?php echo $id ?>">
                                                    <i class="icon-settings"></i> Editar Perfil </a>
                                            </li>
                                            <li>
                                                <a href="visita_new.php?id=<?php echo $id ?>">
                                                    <i class="icon-briefcase"></i> Visitar Cliente </a>
                                            </li>
                                        </ul>
                                    </div>      
                                </div>
                            </div>

                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">INFORMES</span>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tab_info_1" data-toggle="tab"> Ventas</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_info_2" data-toggle="tab"> Cliente Celebre </a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_info_3" data-toggle="tab"> Productos mayor rotación </a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_info_4" data-toggle="tab"> Rotación Productos </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab_info_1">
                                                        <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                            <?php 
                                                            //SACAMOS LOS DATOS A MOSTRAR EN LA GRAFICA
                                                            $compras = 0;
                                                            $ano_actual = date('Y');
                                                            $total_anio = $total_anio_ant = $total_anio_ant2 = 0;
                                                            $array_ventas = $array_ventas_ant = $array_ventas_ant2 = array();
                                                            $vector_ventas = $vector_ventas_ant = $vector_ventas_ant2 = '';
                                                            $j = $k = 0;
                                                            $promedio_ventas = $promedio_ventas_ant = $promedio_ventas_ant2 = 0;

                                                            //Calculamos el valor de los meses del año actual
                                                            for($i=1; $i<=12; $i++)
                                                            {
                                                                $resultado2 = $mysqli->query("SELECT c.compra FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND mes = $i AND ano = ".date('Y'));
                                                                $row2= mysqli_fetch_array($resultado2);

                                                                //COMPRUEBO QUE EL VALOR NO SEA CERO
                                                                if(mysqli_num_rows($resultado2)<1){
                                                                    $valor = 0;
                                                                }
                                                                else{
                                                                    $valor = $row2['compra'];
                                                                }

                                                                //Lleno el array con los valores
                                                                $vector_ventas .= "['".traducir_nombre_mes_corto($i)."',".$valor."],";
                                                                //Sumamos los valores
                                                                $total_anio += $row2['compra'];

                                                                if($row2['compra'] != 0)
                                                                {
                                                                    $j++;   
                                                                }           
                                                            } 
                                                            $promedio_ventas = ($total_anio / date('m'));  

                                                            //Calculamos el valor de los meses del año anterior
                                                            for($i=1; $i<=12; $i++)
                                                            {                                                                
                                                                $resultado3 = $mysqli->query("SELECT c.compra FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND mes = $i AND ano = ".(date('Y')-1));
                                                                $row3= mysqli_fetch_array($resultado3);

                                                                //COMPRUEBO QUE EL VALOR NO SEA CERO
                                                                if(mysqli_num_rows($resultado3)<1){
                                                                    $valor = 0;
                                                                }
                                                                else{
                                                                    $valor = $row3['compra'];
                                                                }

                                                                //Lleno el array con los valores
                                                                $vector_ventas_ant .= "['".traducir_nombre_mes_corto($i)."',".$valor."],";
                                                                //Sumamos los valores
                                                                $total_anio_ant += $row3['compra'];
                                                                
                                                                if($row3['compra'] != 0)
                                                                {
                                                                    $k++;   
                                                                }           
                                                            } 

                                                            $promedio_ventas_ant = ($total_anio_ant / 12); 

                                                            //Calculamos el valor de los meses de dos años atras
                                                            for($i=1; $i<=12; $i++)
                                                            {
                                                                $resultado4 = $mysqli->query("SELECT c.compra FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND mes = $i AND ano = ".(date('Y')-2));
                                                                $row4= mysqli_fetch_array($resultado4);

                                                                //COMPRUEBO QUE EL VALOR NO SEA CERO
                                                                if(mysqli_num_rows($resultado4)<1){
                                                                    $valor = 0;
                                                                }
                                                                else{
                                                                    $valor = $row4['compra'];
                                                                }

                                                                //Lleno el array con los valores
                                                                $vector_ventas_ant2 .= "['".traducir_nombre_mes_corto($i)."',".$valor."],";
                                                                //Sumamos los valores
                                                                $total_anio_ant2 += $row4['compra'];
                                                                
                                                                if($row4['compra'] != 0)
                                                                {
                                                                    $k++;   
                                                                }           
                                                            } 
                                                            
                                                            $promedio_ventas_ant2 = ($total_anio_ant2 / 12);  
                                                            /*echo '<pre>';

                                                            print_r($array_ventas_ant);
                                                            echo '</pre>';*/

                                                            ?>
                                                            <div id="site_activities_loading">
                                                            <img src="assets/global/img/loading.gif" alt="loading" /> </div>
                                                            <div id="site_activities_content" class="display-none">
                                                                <div id="site_activities" style="height: 228px;"> </div>
                                                            </div>
                                                            <div style="margin: 20px 0 10px 30px">
                                                                <div class="row">
                                                                    <div class="col-md-4 col-sm-4 col-xs-4 text-stat">
                                                                        <span class="label label-sm bg-red-mint"> <?php echo 'Promedio '.($ano_actual-2) ?> </span>
                                                                        <h3>$<?php echo number_format($promedio_ventas_ant2,0,',','.'); ?></h3>
                                                                    </div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4 text-stat">
                                                                        <span class="label label-sm bg-blue" style="background-color: #d12610"> <?php echo 'Promedio '.($ano_actual-1) ?> </span><!-- ["#d12610", "#37b7f3", "#52e136"],-->
                                                                        <h3>$<?php echo number_format($promedio_ventas_ant,0,',','.'); ?></h3>
                                                                    </div>

                                                                    <div class="col-md-4 col-sm-4 col-xs-4 text-stat">
                                                                        <span class="label label-sm bg-green-jungle"> <?php echo 'Promedio '.$ano_actual ?> </span><!-- ["#d12610", "#37b7f3", "#52e136"],-->
                                                                        <h3>$<?php echo number_format($promedio_ventas,0,',','.'); ?></h3>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tab_info_2">
                                                        <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                        <?php
                                                        $total_trimestre = 0;
                                                        
                                                        //Consultamos la tabla de clientes celebres    
                                                        $resultado_tab_cli = $mysqli->query("SELECT * FROM tabla_valores_cli_celebres WHERE ano = ".date('Y'));    
                                                        $registro_tab_cli = mysqli_fetch_array($resultado_tab_cli) ; 
                                                    
                                                        if(date('n') >= 1 && date('n') <= 3)
                                                        {
                                                            $mesIni = 1;
                                                            $mesFin = 3;
                                                        }
                                                        else if(date('n') >= 4 && date('n') <= 6)
                                                        {
                                                            $mesIni = 4;
                                                            $mesFin = 6;
                                                        }
                                                        else if(date('n') >= 7 && date('n') <= 9)
                                                        {
                                                            $mesIni = 7;
                                                            $mesFin = 9;
                                                        }
                                                        else if(date('n') >= 10 && date('n') <= 12)
                                                        {
                                                            $mesIni = 10;
                                                            $mesFin = 12;
                                                        }
                                                        
                                                        //Calculamos el valor de los meses
                                                        for($i=$mesIni; $i<=$mesFin; $i++)
                                                        {
                                                            $resultado2 = $mysqli->query("SELECT compra FROM cartera_usuarios WHERE cliente_doc = '".$row['documento']."' AND mes = $i AND ano = ".date('Y'));    
                                                            $registro2 = mysqli_fetch_array($resultado2) ; 
                                                            
                                                            //Lleno el array con los valores
                                                            array_push($array_ventas,$registro2['compra']);
                                                            //Sumamos los valores
                                                            $total_trimestre += $registro2['compra'];
                                                            
                                                            if($registro2['compra'] != 0)
                                                            {
                                                                $j++;   
                                                            }           
                                                        } 
                                                        ?>

                                                        <table class="table table-striped table-hover table-bordered">
                                                        <tbody>
                                                            <tr>
                                                                <td>Categoria</td>
                                                                <td><?php echo cliente_celebre($row['tipo_cliente_celebre'])?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Normal</td>
                                                                <td><?php echo '$'.number_format($registro_tab_cli['cat'.$row['tipo_cliente_celebre'].'_1'], 0, ",", ".")?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Especial</td>
                                                                <td><?php echo '$'.number_format($registro_tab_cli['cat'.$row['tipo_cliente_celebre'].'_2'], 0, ",", ".")?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Como Va?</td>
                                                                <td><?php echo '$'.number_format($total_trimestre, 0, ",", ".")?></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Bono</td>
                                                                <td>
                                                                <?php
                                                                $bono = 0;

                                                                if($row['tipo_cliente_celebre'] != 0)
                                                                {
                                                                    if($total_trimestre >= $registro_tab_cli['cat'.$row['tipo_cliente_celebre'].'_1'] && $total_trimestre < $registro_tab_cli['cat'.$row['tipo_cliente_celebre'].'_2'])
                                                                    {   
                                                                        $bono = ($total_trimestre * $registro_tab_cli['porcentaje1'])/100;
                                                                    }
                                                                    
                                                                    if($total_trimestre >= $registro_tab_cli['cat'.$row['tipo_cliente_celebre'].'_2'])
                                                                    {   
                                                                        $bono = ($total_trimestre * $registro_tab_cli['porcentaje2'])/100;              
                                                                    }
                                                                }
                                                                echo  '$'.number_format(ceil($bono), 0, ",", ".");
                                                                ?>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tab_info_3">

                                                        <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                            <ul class="feeds">                                                                
                                                            <?php
                                                            $consultaProd = $mysqli->query("SELECT SUM(pp.cantpedido_producto) as cantidadSuma, pp.producto_idproducto, pr.desproducto, c.descategoria 
                                                            FROM pedidos_productos pp JOIN pedidos p ON pp.pedido_idpedido = p.idpedido 
                                                            JOIN productos pr ON pp.producto_idproducto = pr.idproducto 
                                                            JOIN categorias c  ON pr.categoria_idcategoria = c.idcategoria 
                                                            WHERE p.usuario_idusuario = $id AND p.estadopedido != 3 AND p.estadopedido != 4 
                                                            GROUP BY pp.producto_idproducto ORDER BY cantidadSuma DESC LIMIT 0,12");    

                                                        
                                                            while($registroProd = mysqli_fetch_array($consultaProd))
                                                            {
                                                                ?>
                                                                <li>
                                                                    <div class="col1">
                                                                        <div class="cont">
                                                                            <div class="cont-col2">
                                                                                <div class="desc"><?php echo $registroProd['desproducto']." (".$registroProd['descategoria'].") "?></div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <?php
                                                            }
                                                            ?> 
                                                            </ul>                                                            
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tab_info_4">
                                                        <div class="portlet-title margin-bottom-20 scroller" style="height: 320px;" >
                                                            <div class="portlet-body form">

                                                                <form action="#" id="form_consulta" class="form-horizontal">
                                                                    <div class="form-body">

                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Mes</label>
                                                                                    <div class="col-md-9">
                                                                                        <select id="mes" name="mes" class="form-control">
                                                                                            <option value="">-Seleccione-</option>
                                                                                            <?php
                                                                                            for($i=1; $i<=12; $i++)
                                                                                            {
                                                                                                ?>
                                                                                                <option value="<?php echo $i?>"><?php echo traducir_nombre_mes($i)?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>                                                                     
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        <!--/row-->
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Año</label>
                                                                                    <div class="col-md-9">
                                                                                        <select id="ano" name="ano" class="form-control">
                                                                                            <option value="">-Seleccione-</option>
                                                                                            <?php
                                                                                            for($i=0; $i<3; $i++)
                                                                                            {
                                                                                                ?>
                                                                                                <option value="<?php echo (date('Y')-$i)?>"><?php echo (date('Y')-$i)?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>                                                                  
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label class="control-label col-md-3">Linea</label>
                                                                                    <div class="col-md-9">
                                                                                        <select id="linea" name="linea" class="form-control">
                                                                                            <option value="" selected="">Cualquiera</option>
                                                                                            <?php
                                                                                            for($i=1; $i<3; $i++)
                                                                                            {
                                                                                                ?>
                                                                                                <option value="<?php echo $i?>"><?php echo lineas($i)?></option>
                                                                                                <?php
                                                                                            }
                                                                                            ?>                                                                  
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                    <div class="form-actions">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="row">
                                                                                    <div class="col-md-offset-3 col-md-9">
                                                                                        <button type="submit" class="btn red">Consultar <i class="fa fa-file-pdf-o"></i></button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6"> </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" id="hdd_id" value="<?php echo $id ?>">
                                                                </form>
                                                                
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class="portlet light ">
                                            <div class="portlet-title">
                                                <div class="caption caption-md">
                                                    <i class="icon-bar-chart theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Historial de Visitas</span>
                                                </div>
                                            </div>
                                            <div class="portlet-body">
                                                <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
                                                    <div class="general-item-list">
                                                        <?php 
                                                        $resultado = $mysqli->query("SELECT v.id, v.observacion, v.fecha, v.estado, v.id_vendedor, CONCAT_WS(' ', u.nom,u.ape1,u.ape2) as vendedor, u.avatar FROM visitas v JOIN usuarios u ON u.id = v.id_vendedor WHERE v.usuario_id = $id ORDER BY v.fecha DESC");
                                                        while($row_visitas = mysqli_fetch_array($resultado))
                                                        {
                                                        ?>
                                                        <div class="item">
                                                            <div class="item-head">
                                                                <div class="item-details">
                                                                    <img class="item-pic" src="assets/avatars/img/<?php echo $row_visitas['avatar']?>">
                                                                  
                                                                    <a href="#emp-modal" id="getEmployee" class="item-name primary-link" data-toggle="modal" data-id="<?php echo $row_visitas['id']?>"><?php echo ucwords($row_visitas['vendedor'])?></a>

                                                                    <span class="item-label"><?php echo $row_visitas['fecha']?></span>
                                                                </div>
                                                                    <span class="item-status">
                                                                        <?php 
                                                                        if($row_visitas['estado'] == 1)
                                                                        {
                                                                            ?>
                                                                            <span class="badge badge-empty badge-success"></span> Revisada
                                                                            <?php 
                                                                        }else {
                                                                            ?>
                                                                            <span class="badge badge-empty badge-danger"></span> Nueva
                                                                            <?php
                                                                        }
                                                                        ?>
                                                                    </span>                                                               
                                                            </div>
                                                            <div class="item-body"> <?php echo $row_visitas['observacion']?> </div>
                                                        </div>
                                                        <?php
                                                        }
                                                        ?>
                                                        <!-- MODAL DE VISITAS -->


                                                        <div id="emp-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                           <div class="modal-dialog"> 
                                                              <div class="modal-content">                  
                                                                 <div class="modal-header"> 
                                                                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">*</button> 
                                                                     <h4 class="modal-title">
                                                                     Datos de la Visita
                                                                     </h4> 
                                                                 </div>          
                                                                 <div class="modal-body">                       
                                                                     <div id="employee_data-loader" style="display: none; text-align: center;">
                                                                         <img src="assets/global/img/loading.gif"> 
                                                                     </div>                       
                                                                     <div id="employee-detail">                                        
                                                                         <div class="row"> 
                                                                             <div class="col-md-12">                         
                                                                             <div class="table-responsive">                             
                                                                             <table class="table table-striped table-bordered">
                                                                             <tr>
                                                                                <th>Fecha</th>
                                                                                <td id="modal_fecha"></td>
                                                                             </tr>                                     
                                                                             <tr>
                                                                                <th>Literatura</th>
                                                                                <td id="modal_literatura"></td>
                                                                             </tr>                                         
                                                                             <tr>
                                                                                <th>Obsequios</th>
                                                                                <td id="modal_obsequios"></td>
                                                                             </tr>                                         
                                                                             <tr>
                                                                                <th>Muestra Médica</th>
                                                                                <td id="modal_muestra"></td>
                                                                             </tr>   
                                                                             <tr>
                                                                                <th>Contacto</th>
                                                                                <td id="modal_contacto"></td>
                                                                             </tr>   
                                                                             <tr>
                                                                                 <th>Observación</th>
                                                                                 <td id="modal_observacion"></td>
                                                                             </tr> 
                                                                             <tr>
                                                                                 <th>Acción</th>
                                                                                 <td id="modal_accion"></td>
                                                                             </tr> 
                                                                             <tr>
                                                                                 <th>Comentario</th>
                                                                                 <td id="modal_comentario"></td>
                                                                             </tr>                                                                                          
                                                                             </table>                                
                                                                             </div>                                       
                                                                           </div> 
                                                                      </div>                       
                                                                     </div>                              
                                                                 </div>           
                                                               <div class="modal-footer"> 
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>  
                                                               </div>              
                                                              </div> 
                                                           </div>
                                                        </div>
                                                        <!-- FIN MODAL-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ULTIMOS PEDIDOS -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-line">
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
                                                                    <th>
                                                                        No. Pedido
                                                                    </th>
                                                                    <th>
                                                                        Fecha
                                                                    </th>
                                                                    <th>
                                                                        Estado
                                                                    </th>
                                                                    <th>
                                                                        Valor
                                                                    </th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php 
                                                                $resultado = $mysqli->query("SELECT * FROM pedidos p WHERE p.usuario_idusuario = $id ORDER BY p.fecpedido DESC LIMIT 0,10");
                                                                $num_pedidos = mysqli_num_rows($resultado);

                                                                if($num_pedidos > 0)
                                                                {
                                                                    while($row_pedidos = mysqli_fetch_array($resultado))
                                                                    {
                                                                    ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo $row_pedidos['idpedido'] ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row_pedidos["fecpedido"]?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo estados_pedidos($row_pedidos["estadopedido"])?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo '$'.number_format($row_pedidos["total"], 0, ",", ".")?>
                                                                        </td>
                                                                    </tr>
                                                                    <?php 
                                                                    }
                                                                }
                                                                else{
                                                                    echo '<tr><td colspan="4">';
                                                                    echo 'No existen pedidos';
                                                                    echo '</td></tr>';
                                                                }
                                                                ?>  
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

        <script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>

    

        <script src="assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script>
    

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>




        <script>
        $(document).ready(function(){   

            

            $(document).on('click', '#getEmployee', function(e){  
            e.preventDefault();  
            var empid = $(this).data('id');    
            $('#employee-detail').hide();
            $('#employee_data-loader').show();  
                $.ajax({
                  url: 'consulta_modal_visitas.php',
                  type: 'POST',
                  data: 'empid='+empid,
                  dataType: 'json',
                  cache: false
                })
                .done(function(data){
                  //console.log(data.employee_name); 
                  $('#employee-detail').hide();
                  $('#employee-detail').show();
                  $('#modal_fecha').html(data.fecha);
                  $('#modal_literatura').html(data.literatura);
                  $('#modal_obsequios').html(data.obsequios);
                  $('#modal_muestra').html(data.muestras);
                  $('#modal_contacto').html(data.contacto);  
                  $('#modal_observacion').html(data.observacion);  
                  $('#modal_accion').html(data.accion);  
                  $('#modal_comentario').html(data.comentario);    
                  $('#employee_data-loader').hide();
                })
                .fail(function(){
                  $('#employee-detail').html('Error, Please try again...');
                  $('#employee_data-loader').hide();
                });
            }); 
        });

        jQuery(document).ready(function() {

            $('#cargando').hide();

            //FORMULARIO DATOS BASICOS
            var form = $('#form_consulta');
            var error = $('.alert-danger', form);
            var success = $('.alert-success', form);


            form.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "", // validate all fields including form hidden input
                rules: {
                    ano: {
                        required: true
                    },
                    mes: {
                        required: true
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success.hide();
                    error.show();
                    App.scrollTo(error, -200);
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    //success.show();
                    error.hide();
                    var id = $('#hdd_id').val(); 
                    var nombre_cliente = $('#nombre_cliente').html(); 
                    var ano = $('#ano').val(); 
                    var mes = $('#mes').val(); 
                    var linea = $('#linea').val(); 

                    window.open('listado_productos_cliente.php?cliente='+id+'&nom='+nombre_cliente+'&ano='+ano+'&mes='+mes+'&linea='+linea);

                    return false;
                }

            });

            if (!jQuery.plot) {
                return;
            }

            function addCommas(nStr)
            {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + '.' + '$2');
                }
                return x1 + x2;
            }

            function showChartTooltip(x, y, xValue, yValue) {
                $('<div id="tooltip" class="chart-tooltip">' + addCommas(yValue) + '<\/div>').css({
                    position: 'absolute',
                    display: 'none',
                    top: y - 40,
                    left: x - 40,
                    border: '0px solid #ccc',
                    padding: '2px 6px',
                    'background-color': '#fff'
                }).appendTo("body").fadeIn(200);
            }

            var data = [];
            var totalPoints = 250;

            if ($('#site_activities').size() != 0) {
                //site activities
                var previousPoint2 = null;
                $('#site_activities_loading').hide();
                $('#site_activities_content').show();

                var data1 = [<?php echo $vector_ventas ?>];
                var data2 = [<?php echo $vector_ventas_ant ?>];
                var data3 = [<?php echo $vector_ventas_ant2 ?>];

                var plot = $.plot($("#site_activities"), [{
                    data: data1,
                    label: <?php echo $ano_actual ?>,
                    lines: {
                        lineWidth: 1,
                    },
                    shadowSize: 0

                }, {
                    data: data2,
                    label: <?php echo $ano_actual-1 ?>,
                    lines: {
                        lineWidth: 1,
                    },
                    shadowSize: 0
                }, {
                    data: data3,
                    label: <?php echo $ano_actual-2 ?>,
                    lines: {
                        lineWidth: 1,
                    },
                    shadowSize: 0
                }], {
                    series: {
                        lines: {
                            show: true,
                            lineWidth: 2,
                            fill: true,
                            fillColor: {
                                colors: [{
                                    opacity: 0.05
                                }, {
                                    opacity: 0.01
                                }]
                            }
                        },
                        points: {
                            show: true,
                            fill: true,
                            radius: 4,
                            fillColor: "#9ACAE6",
                            lineWidth: 2
                        },
                        shadowSize: 2
                    },
                    grid: {
                        hoverable: true,
                        clickable: true,
                        tickColor: "#eee",
                        borderColor: "#eee",
                        borderWidth: 1
                    },
                    colors: ["#26C281", "#3598DC", "#E43A45"],
                    xaxis: {
                            tickLength: 0,
                            tickDecimals: 0,
                            mode: "categories",
                            min: 0,
                            font: {
                                lineHeight: 18,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        yaxis: {
                            ticks: 5,
                            tickDecimals: 0,
                            tickColor: "#eee",
                            font: {
                                lineHeight: 14,
                                style: "normal",
                                variant: "small-caps",
                                color: "#6F7B8A"
                            }
                        },
                        grid: {
                            hoverable: true,
                            clickable: true,
                            tickColor: "#eee",
                            borderColor: "#eee",
                            borderWidth: 1
                        }
                });

                $("#site_activities").bind("plothover", function(event, pos, item) {
                    //console.log(item);
                    $("#x").text(pos.x.toFixed(2));
                    $("#y").text(pos.y.toFixed(2));
                    if (item) {

                        //if (previousPoint2 != item.dataIndex) {
                            previousPoint2 = item.dataIndex;
                            $("#tooltip").remove();
                            var x = item.datapoint[0].toFixed(2),
                                y = item.datapoint[1].toFixed(2);
                            //alert(item.pageX+'-'+item.pageY+'---'+previousPoint2+'!='+item.dataIndex);   
                            showChartTooltip(item.pageX, item.pageY, item.datapoint[0], '$' + item.datapoint[1] );
                            
                        //}
                    }
                });

                $('#site_activities').bind("mouseleave", function() {
                    $("#tooltip").remove();
                });
            }
        });
        </script>
            
    </body>
    
</html>