<?php
@session_start();
include('conexion.php');

//echo '---'.$_SESSION["idusuario"];

if(empty($_SESSION["idusuario"]))
{
    //header('Location:login.php?error=sp');   
    echo "<script>location.href='login.php?error=sp';</script>";
}
?>
  
<head>
    <meta charset="utf-8" />
    <title>FORZA CRM</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />

    
    <!--  -->
        <link href="assets/global/plugins/jquery-multi-select/css/multi-select.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/cubeportfolio/css/cubeportfolio.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/icheck/skins/all.css" rel="stylesheet" type="text/css" />

        
        <!-- Para las tablas dinamicas -->
        <link href="assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-touchspin/bootstrap.touchspin.css" rel="stylesheet" type="text/css" />
        
        <!-- Para fechas y horas -->
        <link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
        
        <link href="assets/pages/css/profile.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/pages/css/profile-2.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/plugins/bootstrap-summernote/summernote.css" rel="stylesheet" type="text/css" />    
         
    <link href="assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css" />        
    <link href="assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/morris/morris.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/global/plugins/jqvmap/jqvmap/jqvmap.css" rel="stylesheet" type="text/css" />

    <link href="assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />

    <link href="assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css" />
    <!--<link href="assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color" />-->
    <link href="assets/layouts/layout/css/themes/darkblue.css" rel="stylesheet" type="text/css" id="style_color" />
    <link href="assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css" />
    

    <link rel="shortcut icon" href="favicon.ico" /> 
</head>