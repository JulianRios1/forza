<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('includes/parametros.php');
include('funciones/fechas.php');
include('funciones/utilidades.php');
$pagina = '';
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
                                <a href="cliente_view.php?id=<?php echo $id ?>">Cliente</a>
                            </li>
                        </ul>
                    </div>
                    <!-- CONSULTA DEL CLIENTE -->
                    <?php
                    $resultado = $mysqli->query("SELECT u.*, m.*  FROM usuarios u LEFT JOIN medicos m ON m.usuario_id = u.id  WHERE u.id = $id"); 
                    $row = mysqli_fetch_array($resultado);
                    ?>
                    <h3 class="page-title"> Editar Cliente | 
                        <small><?php echo $row['nom'].' '.$row['ape1'].' '.$row['ape2']?></small>
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
                                            <div class="portlet-body form">
                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="tab_1_1">
                                                        <form action="#" id="form_datos_basicos" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                            <div class="form-body">
                                                                <div class="alert alert-danger display-hide">
                                                                    <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                                <div class="alert alert-success display-hide">
                                                                    <button class="close" data-close="alert"></button> Listo! </div>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Habilitado</label>                                                                            
                                                                            <select name="habilitado" id="habilitado" class="form-control">  
                                                                                <option value="1" <?php if($row['habilitado'] == 1){ echo 'selected';}?>>Habilitado</option>
                                                                                <option value="0" <?php if($row['habilitado'] == 0){ echo 'selected';}?>>Inhabilitado</option> 
                                                                            </select>
                                                                        </div>
                                                                    </div>   
                                                                </div> 
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
                                                                                    <option value="<?php echo $row_td['id']?>" <?php if($row['tipo_documento'] == $row_td['id']){ echo 'selected';} ?>><?php echo $row_td['tipo']?></option>
                                                                                <?php 
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">No. Documento</label>
                                                                            <input type="text" name="documento" placeholder="" class="form-control" value="<?php echo $row['documento'] ?>" /> 
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
                                                                                    <option value="<?php echo $row_es['id']?>" <?php if($row['especialidad'] == $row_es['id']){ echo 'selected';} ?>><?php echo $row_es['descripcion']?></option>
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
                                                                            <input type="text" name="nom" placeholder="" class="form-control" value="<?php echo $row['nom'] ?>" style="text-transform:uppercase" />     
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Primer Apellido</label>
                                                                            <input type="text" name="ape1" placeholder="" class="form-control" value="<?php echo $row['ape1'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Segundo Apellido</label>
                                                                            <input type="text" name="ape2" placeholder="" class="form-control" value="<?php echo $row['ape2'] ?>" style="text-transform:uppercase" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Genero</label>
                                                                            <select name="genero" id="genero" class="form-control">
                                                                                <option value="">-Seleccione-</option>
                                                                                <option value="F" <?php if($row['genero'] == 'F'){ echo 'selected';}?>>Femenino</option>
                                                                                <option value="M" <?php if($row['genero'] == 'M'){ echo 'selected';}?>>Masculino</option>
                                                                                <option value="E" <?php if($row['genero'] == 'E'){ echo 'selected';}?>>Empresa</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Dirección</label>
                                                                            <input type="text" name="dir" placeholder="" class="form-control" value="<?php echo $row['dir'] ?>" style="text-transform:uppercase" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Barrio</label>
                                                                            <input type="text" name="barrio1" placeholder="" class="form-control" value="<?php echo $row['barrio'] ?>" style="text-transform:uppercase" />
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Teléfono</label>
                                                                            <input type="text" name="tel" placeholder="" class="form-control" value="<?php echo $row['tel'] ?>" style="text-transform:uppercase" /> 
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
                                                                                    <option value="<?php echo $row_dep['id']?>" <?php if(consulta_departamento($row['ciudad_actual']) == $row_dep['id']){ echo 'selected';} ?>><?php echo $row_dep['nombre_dep']?></option>
                                                                                <?php 
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Municipio</label>
                                                                            <?php 
                                                                            if(!empty(consulta_departamento($row['ciudad_actual'])))
                                                                            {
                                                                            ?>
                                                                            <select name="municipio" id="municipio" class="form-control">
                                                                                <?php 
                                                                                $resultado = $mysqli->query('SELECT * FROM municipios WHERE departamento_id = '.consulta_departamento($row['ciudad_actual']).' ORDER BY nombreMunicipio');
                                                                                while($rowMun = mysqli_fetch_array($resultado))
                                                                                {
                                                                                ?>
                                                                                    <option value="<?php echo $rowMun['id']?>" <?php if($row['ciudad_actual'] == $rowMun['id']){ echo 'selected';} ?>><?php echo $rowMun['nombreMunicipio']?></option>
                                                                                <?php 
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php 
                                                                            }
                                                                            else {
                                                                            ?>
                                                                            <select name="municipio" id="municipio" class="form-control" disabled="true">
                                                                                <option value="">-Seleccione-</option>
                                                                            </select>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Celular</label>
                                                                            <input type="text" name="cel" placeholder="" class="form-control" value="<?php echo $row['cel'] ?>" style="text-transform:uppercase" />  
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Email</label>
                                                                            <input type="text" name="mail" placeholder="" class="form-control" value="<?php echo $row['mail'] ?>" style="text-transform:lowercase;" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Zona</label>
                                                                            <select name="zona" id="zona" class="form-control">
                                                                                <option value="">-Seleccione-</option>
                                                                                <?php 
                                                                                $resultado_zona = $mysqli->query("SELECT id, des FROM zonas WHERE id_vendedor = ".$_SESSION["idusuario"]." ORDER BY des");
                                                                                while($row_zona = mysqli_fetch_array($resultado_zona))
                                                                                {
                                                                                ?>
                                                                                    <option value="<?php echo $row_zona['id']?>" <?php if($row['zona'] == $row_zona['id']){ echo 'selected';} ?>><?php echo $row_zona['des']?></option>
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
                                                                                <option value="">-Seleccione-</option>
                                                                                <?php 
                                                                                for($i=1; $i<=8; $i++)
                                                                                {
                                                                                ?>
                                                                                    <option value="<?php echo $i?>" <?php if($row['listaPrecios'] == $i) echo 'selected'; ?>><?php echo 'Lista '.$i?></option>
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
                                                                                        <div class="icheckbox_flat-green checked" style="position: relative;"><input type="checkbox" class="icheck" name="cli_esp" data-checkbox="icheckbox_flat-green" value="1" <?php if($row["cliente_especial"] == 1) { echo "checked";} ?> style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label>Cliente descuento preferencial</label>
                                                                            <div class="input-group">
                                                                                <div class="icheck-list">
                                                                                    <label class="">
                                                                                        <div class="icheckbox_flat-green checked" style="position: relative;"><input type="checkbox" class="icheck" name="cli_des" data-checkbox="icheckbox_flat-green" value="1" <?php if($row["cliente_descuento"] == 1) { echo "checked";} ?> style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
        
                                                                
                                                                <!--
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                -->
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Teléfono Alterno</label>
                                                                            <input type="text" name="tel2" placeholder="" class="form-control" value="<?php echo $row['tel2'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Dirección Alterna</label>
                                                                            <input type="text" name="dir2" placeholder="" class="form-control" value="<?php echo $row['dir2'] ?>" style="text-transform:uppercase" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Barrio</label>
                                                                            <input type="text" name="barrio2" placeholder="" class="form-control" value="<?php echo $row['barrio2'] ?>" style="text-transform:uppercase" />
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
                                                                                    <option value="<?php echo $row_dep['id']?>" <?php if(consulta_departamento($row['ciudaddir2']) == $row_dep['id']){ echo 'selected';} ?>><?php echo $row_dep['nombre_dep']?></option>
                                                                                <?php 
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Municipio</label>
                                                                            <?php 
                                                                            if(!empty(consulta_departamento($row['ciudaddir2'])))
                                                                            {
                                                                            ?>
                                                                            <select name="municipio2" id="municipio2" class="form-control">
                                                                                <?php 
                                                                                $resultado = $mysqli->query('SELECT * FROM municipios WHERE departamento_id = '.consulta_departamento($row['ciudaddir2']).' ORDER BY nombreMunicipio');
                                                                                while($rowMun = mysqli_fetch_array($resultado))
                                                                                {
                                                                                ?>
                                                                                    <option value="<?php echo $rowMun['id']?>" <?php if($row['ciudaddir2'] == $rowMun['id']){ echo 'selected';} ?>><?php echo $rowMun['nombreMunicipio']?></option>
                                                                                <?php 
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                            <?php 
                                                                            }
                                                                            else {
                                                                            ?>
                                                                            <select name="municipio2" id="municipio2" class="form-control" disabled="true">
                                                                                <option value="">-Seleccione-</option>
                                                                            </select>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Horario</label>
                                                                            <input type="text" name="horario" placeholder="" class="form-control" value="<?php echo $row['hor'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Mes Cumpleaños</label>
                                                                            <select name="mes" id="" class="form-control">
                                                                                <option value="">-Seleccione-</option>
                                                                                <?php 
                                                                                for ($i=1; $i <= 12; $i++) { 
                                                                                    ?>
                                                                                    <option value="<?php echo $i?>" <?php if($row['mes_cum'] == $i){ echo 'selected';} ?>><?php echo traducir_nombre_mes_corto($i) ?></option>
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
                                                                                <option value="">-Seleccione-</option>
                                                                                <?php 
                                                                                for ($i=1; $i <= 31; $i++) { 
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if($row['dia_cum'] == $i){ echo 'selected';} ?>><?php echo $i ?></option>
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
                                                                                <option value="1" <?php if($row['hijos'] == 1){ echo 'selected';}?>>Si</option>
                                                                                <option value="2" <?php if($row['hijos'] == 2){ echo 'selected';}?>>No</option> 
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Condiciones</label>
                                                                            <textarea name="condiciones" id="condiciones" cols="30" rows="3" class="form-control"><?php echo $row['cond']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Hobby</label>
                                                                            <textarea name="hobby" id="hobby" cols="30" rows="3" class="form-control"><?php echo $row['hobby']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Proyecto</label>
                                                                            <textarea name="proyecto" id="proyecto" cols="30" rows="3" class="form-control"><?php echo $row['proyecto']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Observaciones</label>
                                                                            <textarea name="observacion" id="observacion" cols="30" rows="3" class="form-control"><?php echo $row['observacion']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="margiv-top-10 form-actions">
                                                                    <button type="submit" class="btn green">Guardar Cambios</button>
                                                                    <a href="cliente_view.php?id=<?php echo $id ?>" class="btn default"> Regresar </a>
                                                                    <input type="hidden" name="hdd_id" value="<?php echo $id ?>">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane" id="tab_1_2">
                                                        <form action="#" id="form_datos_contacto" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Contacto</label>
                                                                            <input type="text" name="contacto" placeholder="" class="form-control" value="<?php echo $row['contacto'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Mes Cumpleaños</label>
                                                                            <select name="mes_contacto" id="" class="form-control">
                                                                                <option value="">-Seleccione-</option>
                                                                                <?php 
                                                                                for ($i=1; $i <= 12; $i++) { 
                                                                                    ?>
                                                                                    <option value="<?php echo $i?>" <?php if($row['con_mes'] == $i){ echo 'selected';} ?>><?php echo traducir_nombre_mes_corto($i) ?></option>
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
                                                                                <option value="">-Seleccione-</option>
                                                                                <?php 
                                                                                for ($i=1; $i <= 31; $i++) { 
                                                                                    ?>
                                                                                    <option value="<?php echo $i; ?>" <?php if($row['con_dia'] == $i){ echo 'selected';} ?>><?php echo $i ?></option>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="margiv-top-10 form-actions">
                                                                    <button type="submit" class="btn green">Guardar Cambios</button>
                                                                    <a href="cliente_view.php?id=<?php echo $id ?>" class="btn default"> Regresar </a>
                                                                    <input type="hidden" name="hdd_id" value="<?php echo $id ?>">
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>

                                                    <div class="tab-pane" id="tab_1_3">
                                                        <form action="#" id="form_datos_inscripcion" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                            <div class="form-body">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <div class="input-group">
                                                                                <div class="icheck-inline">
                                                                                    <label class="">
                                                                                        <div class="icheckbox_minimal-grey" style="position: relative;">
                                                                                            <input name="act_directorio" type="checkbox" class="icheck" value="1" style="position: absolute; opacity: 0;" <?php if($row["directorio"] == 1) { echo "checked";} ?>><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
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
                                                                            <input type="text" name="univ_egresado" placeholder="" class="form-control" value="<?php echo $row['univ_egresado'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Titulo</label>
                                                                            <input type="text" name="titulo" placeholder="" class="form-control" value="<?php echo $row['titulo'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Especialización </label>
                                                                            <input type="text" name="especializacion" placeholder="" class="form-control" value="<?php echo $row['especializacion'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Universidad</label>
                                                                            <input type="text" name="univ_especial" placeholder="" class="form-control" value="<?php echo $row['univ_especial'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Especialización </label>
                                                                            <input type="text" name="especializacion2" placeholder="" class="form-control" value="<?php echo $row['especializacion2'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Universidad</label>
                                                                            <input type="text" name="univ_especial2" placeholder="" class="form-control" value="<?php echo $row['univ_especial2'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                               
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Especialización </label>
                                                                            <input type="text" name="especializacion3" placeholder="" class="form-control" value="<?php echo $row['especializacion3'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="form-group">Universidad</label>
                                                                            <input type="text" name="univ_especial3" placeholder="" class="form-control" value="<?php echo $row['univ_especial3'] ?>" style="text-transform:uppercase" /> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Reseña</label>
                                                                            <textarea name="resena" id="resena" cols="30" rows="3" class="form-control" style="text-transform:uppercase"><?php echo $row['resena']; ?></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="margiv-top-10 form-actions">
                                                                    <button type="submit" class="btn green">Guardar Cambios</button>
                                                                    <a href="cliente_view.php?id=<?php echo $id ?>" class="btn default"> Regresar </a>
                                                                    <input type="hidden" name="hdd_id" value="<?php echo $id ?>">
                                                                </div>
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
                var form = $('#form_datos_basicos');
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
                        zona: {
                            required: true
                        },
                        lista: {
                            required: true
                        },
                        mail: {
                            email: true
                        },
                        direccion: {
                            minlength: 3,
                            required: true
                        },
                        genero: {
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

                        //var formulario = $('#add_participante').serializeArray();
                        var formData = new FormData(document.getElementById("form_datos_basicos"));
                        formData.append("dato", "valor");
                        
                       $.ajax({
                            url: "cliente_edit_tab1_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {
                            });
                        });
                        return false;
                    }

                });

                 //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
                $('.select2me', form).change(function () {
                    form.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
                });



               

                //DATOS FORMULARIO DE DATOS DEL CONTACTO
                var form2 = $('#form_datos_contacto');

                form2.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
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

                        //var formulario = $('#add_participante').serializeArray();
                        var formData = new FormData(document.getElementById("form_datos_contacto"));
                        formData.append("dato", "valor");
                        
                       $.ajax({
                            url: "cliente_edit_tab2_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {

                            });
                        });
                        return false;
                    }
                });


                
                //DATOS FORMULARIO DE INSCRIPCION A LA WEB DE MEDICOS
                var form3 = $('#form_datos_inscripcion');

                form3.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
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

                        //var formulario = $('#add_participante').serializeArray();
                        var formData = new FormData(document.getElementById("form_datos_inscripcion"));
                        formData.append("dato", "valor");
                        
                        $.ajax({
                            url: "cliente_edit_tab3_bd.php",
                            type: "post",
                            dataType: "html",
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,

                        })
                        .done(function(res){
                            alertify.alert(res, function(ev) {

                            });
                        });
                        return false;
                    }
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