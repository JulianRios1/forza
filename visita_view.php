<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = '';
extract($_GET);
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
                                <a href="#">Visita</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Visita
                    </h3>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="profile-content">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="portlet light ">
                                            <div class="portlet-title tabbable-line">
                                                <div class="caption caption-md">
                                                    <i class="icon-globe theme-font hide"></i>
                                                    <span class="caption-subject font-blue-madison bold uppercase">Datos de la visita</span>
                                                </div>
                                            </div>
                                            <?php
                                            //CONSULTAMOS LOS DATOS DE LA VISITA
                                            $resultado = $mysqli->query("SELECT * FROM visitas v WHERE id=".$id_visita);    
                                            $row = mysqli_fetch_array($resultado);


                                            //SACO LOS VALORES DE LA LITERATURAS
                                            $literarura = explode(";",$row['literatura']);
                                            $imp_literatura = '';
                                            
                                            for($i=0; $i<(sizeof($literarura)-1); $i++)
                                            {

                                                $resultado_lit = $mysqli->query("SELECT descripcion FROM literaturas 
                                                        WHERE id = ".$literarura[$i]);  
                                                $row2= mysqli_fetch_array($resultado_lit);
                                                
                                                $imp_literatura.= $row2['descripcion'].', ';
                                            }

                                            $obsequios = explode(";",$row['obsequios']);
                                            $imp_obsequios = '';
                                            
                                            for($i=0; $i<(sizeof($obsequios)-1); $i++)
                                            {

                                                $resultado_obs = $mysqli->query("SELECT descripcion FROM obsequios 
                                                            WHERE id = ".$obsequios[$i]);  
                                                $row3= mysqli_fetch_array($resultado_obs);
                                                    
                                                $imp_obsequios.= $row3['descripcion'].', ';
                                            
                                            }
                                            
                                            //SACO LOS VALORES DE LAS MUESTRA MEDICAS ENTREGADAS
                                            $muestra = explode(";",$row['muestra']);
                                            $imp_muestra = '';
                                            
                                            for($i=0; $i<(sizeof($muestra)-1); $i++)
                                            {

                                                $resultado_mue = $mysqli->query("SELECT desproducto, formafarmaceutica FROM productos
                                                                WHERE idproducto = ".$muestra[$i]);  
                                                $row4= mysqli_fetch_array($resultado_mue);
                                                    
                                                $imp_muestra.= $row4['desproducto'].'('.$row4['formafarmaceutica'].'), ';
                                            
                                            }
                                            
                                            //SACO EL TIPO DE CONTACTO
                                            $resultado_cat = $mysqli->query("SELECT descripcion FROM tipo_contactos WHERE id = ".$row['contacto']);  
                                            $row5 = mysqli_fetch_array($resultado_cat);


                                            /* DATOS DEL USUARIO */
                                            $usuario = explode(";", consulta_usuarios($row['usuario_id']));

                                            //LA PRIORIDAD DE LA VISITA
                                            $prioridad = null;
                                            switch ($row['prioridad']) {
                                                case 'MA':
                                                    $prioridad = 'Muy Alta';
                                                    break;
                                                case 'A':
                                                    $prioridad = 'Alta';
                                                    break;
                                                case 'M':
                                                    $prioridad = 'Media';
                                                    break;
                                                case 'B':
                                                    $prioridad = 'Baja';
                                                    break;
                                                default:
                                                    $prioridad = 'No Registra';
                                            }
                                            
                                            ?>
                                            <div class="portlet-body form">
                                                <form action="#" id="form_visita_view" class="form-horizontal" enctype="multipart/form-data" autocomplete="off">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active">

                                                            <div class="form-body">

                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Cliente</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                     <b> <?php echo $usuario[0]?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Fecha</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                     <b><?php echo escribir_fecha(date('Y-m-d')) ?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Literatura</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                    <b><?php echo $imp_literatura ?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Obsequios</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                    <b><?php echo $imp_obsequios ?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Muestra Médica</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                    <b><?php echo $imp_muestra ?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Observación</label>
                                                                            <div class="col-md-10 note note-success">
                                                                                <p class="form-control-static">
                                                                                    <?php echo $row['observacion'] ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Acción</label>
                                                                            <div class="col-md-10 note note-info">
                                                                                <p class="form-control-static">
                                                                                    <?php echo $row['accion'] ?>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Contacto</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                    <b><?php echo $row5['descripcion'] ?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label class="control-label col-md-2">Prioridad</label>
                                                                            <div class="col-md-10">
                                                                                <p class="form-control-static">
                                                                                    <b><?php echo $prioridad ?></b>
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="margiv-top-10 form-actions">
                                                        <a href="visita_edit.php?id_visita=<?php echo $id_visita ?>"  class="btn green">Editar visita</a>
                                                        <a href="index.php" class="btn default"> Cancelar </a>
                                                        <input type="hidden" name="hdd_id" value="<?php echo $id_visita ?>">
                                                    </div>
                                                </form>
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
        <script src="assets/global/plugins/alertity/js/alertify.js" type="text/javascript"></script>

        <script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js" type="text/javascript"></script>
        <script src="assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/profile.min.js" type="text/javascript"></script>


        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

    </body>

</html>