<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = '';

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
                                <a href="#">Cliente Nuevo</a>
                            </li>
                        </ul>
                    </div>

                    <h3 class="page-title"> Nuevo Cliente
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
                                                    <span class="caption-subject font-blue-madison bold uppercase">Cuenta</span>
                                                </div>
                                                <ul class="nav nav-tabs">
                                                    <li class="active">
                                                        <a href="#tab_1_1" data-toggle="tab">Datos Básicos</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_2" data-toggle="tab">Contacto</a>
                                                    </li>
                                                    <li>
                                                        <a href="#tab_1_3" data-toggle="tab">Inscripción Contacto Web</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <form action="#" id="form_cliente_nuevo" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                <div class="portlet-body form">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab_1_1">

                                                                <div class="form-body">
                                                                    <div class="alert alert-danger display-hide">
                                                                        <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                                    <div class="alert alert-success display-hide">
                                                                        <button class="close" data-close="alert"></button> Listo! </div>


                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Tipo Documento</label>
                                                                                <select name="tipo_documento" id="tipo_documento" class="form-control">
                                                                                    <option value="">Seleccione</option>
                                                                                    <?php 
                                                                                    $resultado_td = $mysqli->query("SELECT * FROM tipos_documentos ORDER BY tipo");
                                                                                    while($row_td = mysqli_fetch_array($resultado_td))
                                                                                    {
                                                                                    ?>
                                                                                        <option value="<?php echo $row_td['id']?>"><?php echo $row_td['tipo']?></option>
                                                                                    <?php 
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">No. Documento</label>
                                                                                <input type="text" name="documento" placeholder="" class="form-control" value="" /> 
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Especialidad</label>
                                                                                <select name="especialidad" id="especialidad" class="form-control">
                                                                                    <option value="">-Seleccione-</option>
                                                                                    <?php 
                                                                                    $resultado_es = $mysqli->query("SELECT * FROM especialidades ORDER BY descripcion");
                                                                                    while($row_es = mysqli_fetch_array($resultado_es))
                                                                                    {
                                                                                    ?>
                                                                                        <option value="<?php echo $row_es['id']?>"><?php echo $row_es['descripcion']?></option>
                                                                                    <?php 
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Nombre</label>
                                                                                <input type="text" name="nom" placeholder="" class="form-control" value="" style="text-transform:uppercase" />     
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Primer Apellido</label>
                                                                                <input type="text" name="ape1" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Segundo Apellido</label>
                                                                                <input type="text" name="ape2" placeholder="" class="form-control" value="" style="text-transform:uppercase" />
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Genero</label>
                                                                                <select name="genero" id="genero" class="form-control">
                                                                                    <option value="">-Seleccione-</option>
                                                                                    <option value="F">Femenino</option>
                                                                                    <option value="M">Masculino</option>
                                                                                    <option value="E">Empresa</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Dirección</label>
                                                                                <input type="text" name="dir" placeholder="" class="form-control" value="" style="text-transform:uppercase" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Barrio</label>
                                                                                <input type="text" name="barrio1" placeholder="" class="form-control" value="" style="text-transform:uppercase" />
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Teléfono</label>
                                                                                <input type="text" name="tel" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Departamento</label>
                                                                                <select name="departamento" id="departamento" class="form-control">
                                                                                    <option value="">-Seleccione-</option>
                                                                                    <?php 
                                                                                    $resultado_dep = $mysqli->query("SELECT * FROM departamentos ORDER BY nombre_dep");
                                                                                    while($row_dep = mysqli_fetch_array($resultado_dep))
                                                                                    {
                                                                                    ?>
                                                                                        <option value="<?php echo $row_dep['id']?>"><?php echo $row_dep['nombre_dep']?></option>
                                                                                    <?php 
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Municipio</label>
                                                                                <select name="municipio" id="municipio" class="form-control" disabled="true">
                                                                                    <option value="">-Seleccione-</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Celular</label>
                                                                                <input type="text" name="cel" placeholder="" class="form-control" value="" style="text-transform:uppercase" />  
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Email</label>
                                                                                <input type="text" name="mail" placeholder="" class="form-control" value="" style="text-transform:lowercase;" /> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Zona</label>
                                                                                <select name="zona" id="zona" class="form-control">
                                                                                    <option value="">-Seleccione-</option>
                                                                                    <?php
                                                                                    $resultado_rol = $mysqli->query("SELECT idrol FROM usuarios WHERE id = ".$_SESSION["idusuario"]);
                                                                                    $resultado_rol_arr= mysqli_fetch_array($resultado_rol);
                                                                                    $rol = $resultado_rol_arr["idrol"];

                                                                                    if($rol != 1){
                                                                                        $query = "SELECT id, des FROM zonas ORDER BY des";
                                                                                    }else{
                                                                                        $query = "SELECT id, des FROM zonas WHERE id_vendedor = ".$_SESSION["idusuario"]." ORDER BY des";
                                                                                    }
                                                                                    
                                                                                    $resultado_zona = $mysqli->query($query);
                                                                                    while($row_zona = mysqli_fetch_array($resultado_zona))
                                                                                    {
                                                                                    ?>
                                                                                        <option value="<?php echo $row_zona['id']?>"><?php echo $row_zona['des']?></option>
                                                                                    <?php 
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Lista de Precios</label>
                                                                                <select name="lista" id="lista" class="form-control">
                                                                                    <!--<option value="">-Seleccione-</option>-->
                                                                                    <?php 
                                                                                    for($i=1; $i<=8; $i++)
                                                                                    {
                                                                                    ?>
                                                                                        <option value="<?php echo $i?>" <?php if($i == 5){echo 'selected';} ?>><?php echo 'Lista '.$i?></option>
                                                                                    <?php 
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label>Cliente Especial</label>
                                                                                <div class="input-group">
                                                                                    <div class="icheck-list">
                                                                                        <label class="">
                                                                                            <div class="icheckbox_flat-green checked" style="position: relative;"><input type="checkbox" class="icheck" name="cli_esp" data-checkbox="icheckbox_flat-green" value="1" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label>Medios preferidos para recibir información</label>
                                                                                <div class="input-group">
                                                                                    <div class="icheck-list">
                                                                                        <label><div class="icheckbox_flat-green checked" style="position: relative;"><input type="checkbox" class="icheck" name="mi_correo" data-checkbox="icheckbox_flat-green" value="correo" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>Email</label>
                                                                                        <label><div class="icheckbox_flat-green checked" style="position: relative;"><input type="checkbox" class="icheck" name="mi_llamada" data-checkbox="icheckbox_flat-green" value="llamada" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>Llamada</label>
                                                                                        <label><div class="icheckbox_flat-green checked" style="position: relative;"><input type="checkbox" class="icheck" name="mi_sms" data-checkbox="icheckbox_flat-green" value="sms" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>Mensaje de texto</label>
                                                                                        <label><div class="icheckbox_flat-green checked" style="position: relative;"><input type="checkbox" class="icheck" name="mi_whatsapp" data-checkbox="icheckbox_flat-green" value="whatsapp" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>WhatsApp</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                    </div>

                                                                    <hr>
                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Teléfono Alterno</label>
                                                                                <input type="text" name="tel2" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Dirección Alterna</label>
                                                                                <input type="text" name="dir2" placeholder="" class="form-control" value="" style="text-transform:uppercase" />
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Barrio</label>
                                                                                <input type="text" name="barrio2" placeholder="" class="form-control" value="" style="text-transform:uppercase" />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                            
                                                                    <div class="row">                                                                    
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Departamento</label>
                                                                                <select name="departamento2" id="departamento2" class="form-control">
                                                                                    <option value="">-Seleccione-</option>
                                                                                    <?php 
                                                                                    $resultado_dep = $mysqli->query("SELECT * FROM departamentos ORDER BY nombre_dep");
                                                                                    while($row_dep = mysqli_fetch_array($resultado_dep))
                                                                                    {
                                                                                    ?>
                                                                                        <option value="<?php echo $row_dep['id']?>"><?php echo $row_dep['nombre_dep']?></option>
                                                                                    <?php 
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Municipio</label>
                                                                                <select name="municipio2" id="municipio2" class="form-control" disabled="true">
                                                                                    <option value="">-Seleccione-</option>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Horario</label>
                                                                                <input type="text" name="horario" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Mes Cumpleaños</label>
                                                                                <select name="mes" id="mes" class="form-control">
                                                                                    <option value="NULL">-Seleccione-</option>
                                                                                    <?php 
                                                                                    for ($i=1; $i <= 12; $i++) { 
                                                                                        ?>
                                                                                        <option value="<?php echo $i?>"><?php echo traducir_nombre_mes_corto($i) ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Día Cumpleaños</label>                                                                            
                                                                                <select name="dia" id="" class="form-control">
                                                                                    <option value="NULL">-Seleccione-</option>
                                                                                    <?php 
                                                                                    for ($i=1; $i <= 31; $i++) { 
                                                                                        ?>
                                                                                        <option value="<?php echo $i; ?>"><?php echo $i ?></option>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Hijos</label>                                                                            
                                                                                <select name="hijos" id="hijos" class="form-control">  
                                                                                    <option value="NULL">-Seleccione-</option>
                                                                                    <option value="1">Si</option>
                                                                                    <option value="2">No</option> 
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Condiciones</label>
                                                                                <textarea name="condiciones" id="condiciones" cols="30" rows="3" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Hobby</label>
                                                                                <textarea name="hobby" id="hobby" cols="30" rows="3" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Proyecto</label>
                                                                                <textarea name="proyecto" id="proyecto" cols="30" rows="3" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Observaciones</label>
                                                                                <textarea name="observacion" id="observacion" cols="30" rows="3" class="form-control"></textarea>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    
                                                                </div>

                                                        </div>
                                                        <div class="tab-pane" id="tab_1_2">
                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Contacto</label>
                                                                            <input type="text" name="contacto" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Mes Cumpleaños</label>
                                                                            <select name="mes_contacto" id="" class="form-control">
                                                                                <option value="NULL">-Seleccione-</option>
                                                                                <?php 
                                                                                for ($i=1; $i <= 12; $i++) { 
                                                                                    ?>
                                                                                    <option value="<?php echo $i?>"><?php echo traducir_nombre_mes_corto($i) ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Día Cumpleaños</label>                                                                            
                                                                            <select name="dia_contacto" id="" class="form-control">
                                                                                <option value="NULL">-Seleccione-</option>
                                                                                <?php 
                                                                                for ($i=1; $i <= 31; $i++) { 
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>"><?php echo $i ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="tab-pane" id="tab_1_3">
                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="icheck-inline">
                                                                                    <label class="">
                                                                                        <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                            <input name="act_directorio" type="checkbox" class="icheck" value="1" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                                                                        </div> 
                                                                                        Activar en directorio 
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Universidad de Egreso </label>
                                                                            <input type="text" name="univ_egresado" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Titulo</label>
                                                                            <input type="text" name="titulo" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Especialización </label>
                                                                            <input type="text" name="especializacion" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Universidad</label>
                                                                            <input type="text" name="univ_especial" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Especialización </label>
                                                                            <input type="text" name="especializacion2" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Universidad</label>
                                                                            <input type="text" name="univ_especial2" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Especialización </label>
                                                                            <input type="text" name="especializacion3" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Universidad</label>
                                                                            <input type="text" name="univ_especial3" placeholder="" class="form-control" value="" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Reseña</label>
                                                                            <textarea name="resena" id="resena" cols="30" rows="3" class="form-control" style="text-transform:uppercase"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="margiv-top-10 form-actions">
                                                    <button type="submit" id="btnSubmit" class="btn green">Guardar Cambios</button>
                                                    <a href="itinerario.php" class="btn default"> Cancelar </a>
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

        <script src="assets/pages/scripts/profile.min.js" type="text/javascript"></script>

        <script src="assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>

        <script>
            jQuery(document).ready(function() {


                //FORMULARIO DATOS BASICOS
                var form = $('#form_cliente_nuevo');
                var error = $('.alert-danger', form);
                var success = $('.alert-success', form);


                form.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
                        nom: {
                            minlength: 3,
                            required: true
                        },
                        tipo_documento: {
                            required: true
                        },
                        
                        especialidad: {
                            required: true
                        },
                        genero: {
                            required: true
                        },
                        mail: {
                            email: true
                        },
                        dir: {
                            minlength: 3,
                            required: true
                        },
                        departamento: {
                            required: true
                        },
                        horario: {
                            minlength: 3,
                            required: true
                        },
                        zona: {
                            required: true
                        },
                        observacion: {
                            minlength: 3,
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
                        $("#btnSubmit").prop('disabled', true);
                        //success.show();
                        error.hide();

                        //var formulario = $('#add_participante').serializeArray();
                        var formData = new FormData(document.getElementById("form_cliente_nuevo"));
                        formData.append("dato", "valor");

                       $.ajax({
                            url: "cliente_add_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                                document.location.href = "itinerario.php";
                            });
                        });
                        return false;
                    }

                });

                 //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
                $('.select2me', form).change(function () {
                    form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
                });


                
                //Carga municipios dependiendo del departamento seleccionado
                $("#departamento").change(function () {         
                    $("#departamento option:selected").each(function () {
                        
                        $("#municipio").attr("disabled");
                        $("#municipio").val("");
                                
                        var elegido=$(this).val();
                        //alert(elegido);
                        if( elegido != '')
                        {
                            $.post("municipios.php", { elegido: elegido }, function(data){
                                $("#municipio").removeAttr("disabled");
                                $("#municipio").html(data);
                                
                            });            
                        }
                        else
                        {
                            $("#municipio").attr("disabled","");
                            $("#municipio").val("");
                        }
                    });
                });

                $("#departamento2").change(function () {         
                    $("#departamento2 option:selected").each(function () {
                        
                        $("#municipio2").attr("disabled");
                        $("#municipio2").val("");
                                
                        var elegido=$(this).val();
                        //alert(elegido);
                        if( elegido != '')
                        {
                            $.post("municipios.php", { elegido: elegido }, function(data){
                                $("#municipio2").removeAttr("disabled");
                                $("#municipio2").html(data);
                                
                            });            
                        }
                        else
                        {
                            $("#municipio2").attr("disabled","");
                            $("#municipio2").val("");
                        }
                    });
                });
            
            });

        </script>
    </body>

</html>