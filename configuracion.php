<!DOCTYPE html>

<html lang="en">
    
<?php 

include('head.php');
include('funciones/utilidades.php');

//llamamos las variables globales
require_once('global_var.php');

$pagina = 'configuracion';

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
                                <a href="#">Configuración</a>
                            </li>
                        </ul>
                    </div>
                    <!-- CONSULTA DATOS DEL SISTEMA -->
                    <?php
                    $resultado = $mysqli->query("SELECT * FROM datos_basicos_empresa"); 
                    $row = mysqli_fetch_array($resultado);
                    ?>
                    <h3 class="page-title"> Configuración</h3>

                    <div class="row">
                        <div class="col-md-12">                            
                            <div class="portlet-body">
                                <div class="panel-group accordion scrollable" id="accordion2">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_1"> Datos Básicos </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_1" class="panel-collapse in">
                                            <div class="panel-body">
                                                <div class="tab-content">
                                                    <form action="#" id="form_datos_basicos" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                        <div class="form-body">
                                                            <div class="alert alert-danger display-hide">
                                                                <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                            <div class="alert alert-success display-hide">
                                                                <button class="close" data-close="alert"></button> Listo! </div>
                                                            
                                                            <?php
                                                            //CONSULTAMOS LOS DATOS BASICOS
                                                            $resultado = $mysqli->query("SELECT * FROM datos_basicos_empresa"); 
                                                            $row = mysqli_fetch_array($resultado);
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Nit</label>
                                                                        <input type="text" name="nit" placeholder="" class="form-control" value="<?php echo $row['nit'] ?>" /> 
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Razón Social</label>
                                                                        <input type="text" name="nom" placeholder="" class="form-control" value="<?php echo $row['razon_social'] ?>" style="text-transform:uppercase" />     
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Representante</label>
                                                                        <input type="text" name="rep" placeholder="" class="form-control" value="<?php echo $row['representante'] ?>" style="text-transform:uppercase" /> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Documento Representante</label>
                                                                        <input type="text" name="doc_rep" placeholder="" class="form-control" value="<?php echo $row['documento'] ?>" style="text-transform:uppercase" />
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Dirección</label>
                                                                        <input type="text" name="dir" placeholder="" class="form-control" value="<?php echo $row['direccion'] ?>" style="text-transform:uppercase" />
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Teléfono</label>
                                                                        <input type="text" name="tel" placeholder="" class="form-control" value="<?php echo $row['telefono'] ?>" style="text-transform:uppercase" /> 
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
                                                                                <option value="<?php echo $row_dep['id']?>" <?php if(consulta_departamento($row['ciudad']) == $row_dep['id']){ echo 'selected';} ?>><?php echo utf8_encode($row_dep['nombre_dep'])?></option>
                                                                            <?php 
                                                                            }
                                                                            ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Ciudad</label>
                                                                        <?php 
                                                                        if(!empty(consulta_departamento($row['ciudad'])))
                                                                        {
                                                                        ?>
                                                                        <select name="municipio" id="municipio" class="form-control">
                                                                            <?php 
                                                                            $resultado = $mysqli->query('SELECT * FROM municipios WHERE departamento_id = '.consulta_departamento($row['ciudad']).' ORDER BY nombreMunicipio');
                                                                            while($rowMun = mysqli_fetch_array($resultado))
                                                                            {
                                                                            ?>
                                                                                <option value="<?php echo $rowMun['id']?>" <?php if($row['ciudad'] == $rowMun['id']){ echo 'selected';} ?>><?php echo utf8_encode($rowMun['nombreMunicipio'])?></option>
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
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Web</label>
                                                                        <input type="text" name="web" placeholder="" class="form-control" value="<?php echo $row['web'] ?>" style="text-transform:lowercase;" /> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Email envio notificaciones</label>
                                                                        <input type="text" name="mail" placeholder="" class="form-control" value="<?php echo $row['correo_saliente'] ?>" style="text-transform:lowercase;" /> 
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Logo</label> 
                                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                            <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                                                                <?php
                                                                                if(!empty($row['logo']))
                                                                                {
                                                                                    ?>
                                                                                    <img src="<?php echo $GLOBALS['server'];?>/assets/layouts/layout/img/<?php echo $row['logo'];?>" alt=""/>
                                                                                    <?php
                                                                                }
                                                                                else
                                                                                {
                                                                                    ?>
                                                                                    <img src="http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt=""/>
                                                                                    <?php
                                                                                }
                                                                                ?>
                                                                                
                                                                            </div>
                                                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;">
                                                                            </div>
                                                                            <div>
                                                                                <span class="btn default btn-file">
                                                                                <span class="fileinput-new">
                                                                                Seleccione Imagen </span>
                                                                                <span class="fileinput-exists">
                                                                                Cambiar </span>
                                                                                <input type="file" name="foto" id="foto">
                                                                                </span>
                                                                                <a href="javascript:;" class="btn default fileinput-exists" data-dismiss="fileinput">
                                                                                Eliminar </a>
                                                                                <input type="hidden" name="hdd_foto" value="<?php echo $row['logo'];?>">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="margiv-top-10 form-actions">
                                                                <button type="submit" class="btn green">Guardar Cambios</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_2"> Tabla de descuentos </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_2" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="tab-content">
                                                    <form action="#" id="form_tabla_descuentos" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                        <div class="form-body">
                                                            <div class="alert alert-danger display-hide">
                                                                <button class="close" data-close="alert"></button> Aún faltan campos por diligenciar. </div>
                                                            <div class="alert alert-success display-hide">
                                                                <button class="close" data-close="alert"></button> Listo! </div>
                                                            
                                                            <?php
                                                            //CONSULTAMOS LA TABLA DE DESCUENTOS
                                                            $resultado = $mysqli->query("SELECT * FROM tabla_descuentos"); 
                                                            $row = mysqli_fetch_array($resultado);
                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Rango 1</label>
                                                                        <input type="text" name="r1" placeholder="" class="form-control" value="<?php echo number_format($row['rango1'],0,',','.')  ?>" onchange="puntillos(this);" onkeyup="puntillos(this);" /> 
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Rango 2</label>
                                                                        <input type="text" name="r2" placeholder="" class="form-control" value="<?php echo number_format($row['rango2'],0,',','.') ?>" onchange="puntillos(this);" onkeyup="puntillos(this);" />     
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Descuento 1</label>
                                                                        <input type="text" name="d1" placeholder="" class="form-control" value="<?php echo $row['descuento1'] ?>" /> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Rango 3</label>
                                                                        <input type="text" name="r3" placeholder="" class="form-control" value="<?php echo number_format($row['rango3'],0,',','.')  ?>" onchange="puntillos(this);" onkeyup="puntillos(this);" />
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-2">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Descuento 2</label>
                                                                        <input type="text" name="d2" placeholder="" class="form-control" value="<?php echo $row['descuento2'] ?>"  />
                                                                    </div>
                                                                </div>                                                            
                                                                
                                                            </div>



                                                            <div class="margiv-top-10 form-actions">
                                                                <button type="submit" class="btn green">Guardar Cambios</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_3"> Personalizar mensajes </a>
                                            </h4>
                                        </div>
                                        <?php 
                                        $consulta = $mysqli->query("SELECT * FROM texto_correos");
                                        
                                        ?>
                                        <div id="collapse_3" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="portlet-body form">
                                                    <form class="form-horizontal form-bordered" id="form_mensajes">
                                                        <?php 
                                                        $i=1;
                                                        while($row = mysqli_fetch_array($consulta))
                                                        {
                                                        ?>
                                                        <div class="form-body">
                                                            <div class="form-group last">
                                                                <label class="control-label col-md-2"><?php echo $row['descripcion'] ?></label>
                                                                <div class="col-md-10">
                                                                    <textarea name="msg_<?php echo $i?>" class="summernote"><?php echo $row['texto']  ?></textarea>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        $i++;
                                                        }
                                                        ?>
                                                        <div class="form-actions">
                                                            <div class="row">
                                                                <div class="col-md-offset-2 col-md-10">
                                                                    <button type="submit" class="btn green"><i class="fa fa-check"></i> Guardar</button>
                                                                    <input type="hidden" name="num_msg" value="<?php echo ($i-1) ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h4 class="panel-title">
                                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapse_4"> Parámetros </a>
                                            </h4>
                                        </div>
                                        <div id="collapse_4" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="tab-content">
                                                    <form action="#" id="form_parametros" class="horizontal-form" enctype="multipart/form-data" autocomplete="off">
                                                        <div class="form-body">                                                            
                                                            <?php
                                                            //CONSULTAMOS LA TABLA DE PARÁMETROS
                                                            $resultado = $mysqli->query("SELECT * FROM parametros"); 
                                                            $indice = 0;
                                                            $arraySelectDestinosPedido = array();
                                                            $arrayDestinosPedido = array();
                                                            $arrayLlegaCorreoVendedor = array();

                                                            while($row = mysqli_fetch_array($resultado)){
                                                                if($indice == 0){
                                                                    $arraySelectDestinosPedido = array($row['clave'],$row['valor'],$row['activo']);

                                                                    $arr1 = explode(';',$row['valor']);

                                                                    foreach($arr1 as $option){
                                                                        $arr2 = explode(',',$option);
                                                                        $arrayDestinosPedido[$arr2[0]] = $arr2[1];
                                                                    }
                                                                }else if($indice == 1){
                                                                    $arrayLlegaCorreoVendedor = array($row['clave'],$row['valor'],$row['activo']);
                                                                }

                                                                $indice ++;
                                                            }

                                                            ?>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label class="control-label">Lista de Destinos Pedido</label>
                                                                        <input type="checkbox" id="select_destinos_pedido" value="" <?php echo $arraySelectDestinosPedido[2] == 1 ? "checked" : "" ?>> 
                                                                        <br><br>
                                                                        <button class="btn btn-primary btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Nuevo" onclick="agregarDestino()"><i class="fa fa-plus"></i></button>
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col">Nombre</th>
                                                                                    <th scope="col">Email</th>
                                                                                    <th scope="col">Acción</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="destinos_pedido_body">
                                                                                <?php 
                                                                                    foreach ($arrayDestinosPedido as $clave=>$value){
                                                                                ?>
                                                                                        <tr>
                                                                                            <td><?php echo $value; ?></td>
                                                                                            <td><?php echo $clave; ?></td>
                                                                                            <td><button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="borrarDestino(this)"><i class="fa fa-trash"></i></button></td>
                                                                                        </tr>
                                                                                <?php 
                                                                                    }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                    <label class="control-label">Llega Correo a Vendedor en Pedido</label>
                                                                        <input type="checkbox" id="llega_correo_vendedor" value="" <?php echo $arrayLlegaCorreoVendedor[2] == 1 ? "checked" : "" ?>> 
                                                                    </div>
                                                                </div>    
                                                            </div>

                                                            <div class="margiv-top-10 form-actions">
                                                                <button type="button" class="btn green" onclick="guardarParametros()">Guardar Cambios</button>
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
        <script src="assets/global/plugins/decimales/decimales.js" type="text/javascript"></script>

        <script src="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/icheck/icheck.min.js" type="text/javascript"></script>

        <script src="assets/global/scripts/app.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>

        <script src="assets/pages/scripts/profile.min.js" type="text/javascript"></script>
        <script src="assets/global/plugins/bootstrap-summernote/summernote.min.js" type="text/javascript"></script>

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
                        nit: {
                            required: true
                        },
                        rep: {
                            required: true
                        },
                        doc_rep: {
                            required: true
                        },
                        departamento:{
                            required: true
                        },
                        mail: {
                            email: true
                        },
                        dir: {
                            minlength: 3,
                            required: true
                        },
                        tel: {
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
                            url: "configuracion_tab1.php",
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



               

                //DATOS FORMULARIO DE DATOS DEL CONTACTO
                var form2 = $('#form_tabla_descuentos');

                form2.validate({
                    errorElement: 'span', //default input error message container
                    errorClass: 'help-block help-block-error', // default input error message class
                    focusInvalid: false, // do not focus the last invalid input
                    ignore: "", // validate all fields including form hidden input
                    rules: {
                        r1:{
                            required: true
                        },
                        r2:{
                            required: true
                        },
                        d1:{
                            required: true
                        },
                        r3:{
                            required: true
                        },
                        d2:{
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
                        var formData = new FormData(document.getElementById("form_tabla_descuentos"));
                        formData.append("dato", "valor");
                        
                       $.ajax({
                            url: "configuracion_tab2.php",
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
                var form3 = $('#form_mensajes');

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
                        var formData = new FormData(document.getElementById("form_mensajes"));
                        formData.append("dato", "valor");
                        
                        $.ajax({
                            url: "configuracion_tab3.php",
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

                

                $('.summernote').summernote({
                    height: 200,
                  toolbar: [
                    // [groupName, [list of button]]
                    ['style', ['bold', 'italic', 'underline', 'clear']],

                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']]
                   
                  ]
                });
            });

            //EVENTOS DE LA SECCIÓN DE LOS PARÁMETROS
            function borrarDestino(btn){
                var row = btn.parentNode.parentNode;
                row.parentNode.removeChild(row);
            }

            function agregarDestino(){
                var body = $('#destinos_pedido_body');
                var ultimoNombre = $(".nombre_destino").last().val();
                var ultimoCorreo = $(".correo_destino").last().val();

                if(ultimoNombre == undefined && ultimoCorreo == undefined){
                    body.append('<tr><td><input type="text" class="form-control nombre_destino" value=""/></td><td><input type="text" class="form-control correo_destino" value=""/></td><td><button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="borrarDestino(this)"><i class="fa fa-trash"></i></button></td></tr>');
                }else{
                    if(ultimoNombre != "" && ultimoCorreo != ""){
                        if(isEmail(ultimoCorreo)){
                            $(".nombre_destino").last().prop('readonly', true);
                            $(".correo_destino").last().prop('readonly', true);
                            body.append('<tr><td><input type="text" class="form-control nombre_destino" value=""/></td><td><input type="text" class="form-control correo_destino" value=""/></td><td><button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="borrarDestino(this)"><i class="fa fa-trash"></i></button></td></tr>');
                        }else{
                            alert("Ingrese por favor un correo válido.");
                        }
                    }else{
                        alert("Debe llenar todos los campos para agregar un nuevo destino.");
                    }
                }
            }

            function isEmail(email) {
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                return regex.test(email);
            }

            function guardarParametros(){
                var ultimoNombre = $(".nombre_destino").last().val();
                var ultimoCorreo = $(".correo_destino").last().val();

                if(ultimoNombre == undefined && ultimoCorreo == undefined){
                    salvarDatos();
                }else{
                    if(ultimoNombre != "" && ultimoCorreo != ""){
                        if(isEmail(ultimoCorreo)){
                            salvarDatos();
                        }else{
                            alert("Ingrese por favor un correo válido.");
                        }
                    }else{
                        alert("Debe llenar todos los campos para guardar los parámetros.");
                    }
                }
            }

            function salvarDatos(){

                var datos = [];
                var datosCadena = "";

                var arrayDataParametros = [];
                var checkSelectDestinosPedido = 0;
                var checkLlegaCorreoVendedor = 0;

                $('#destinos_pedido_body tr').each(function() { 
                    if($(this).find("td").eq(0).eq(0).text() != ""){
                        datos.push(""+$(this).find("td").eq(1).eq(0).text()+","+$(this).find("td").eq(0).eq(0).text());
                    }else{
                        datos.push(""+$(this).find("td:eq(1) input[type='text']").val()+","+$(this).find("td:eq(0) input[type='text']").val());
                    } 
                });

                datosCadena = datos.join(';');

                if($('#select_destinos_pedido').is(':checked')){
                    checkSelectDestinosPedido = 1;
                }

                if($('#llega_correo_vendedor').is(':checked')){
                    checkLlegaCorreoVendedor = 1;
                }

                arrayDataParametros = [['SELECT_DESTINOS_PEDIDO',datosCadena,checkSelectDestinosPedido],['LLEGA_CORREO_VENDEDOR','N/A',checkLlegaCorreoVendedor]];

                $.ajax({
                    type: "POST",
                    url: "configuracion_tab4.php",
                    data: {'arrayDataParametros':arrayDataParametros},
                    beforeSend: function(objeto){
                        //
                    },
                    success: function(datos){
                        alert(datos);
                        location.reload();
                    }
                });
            }

        </script>
    </body>
    <table ></table>

</html>