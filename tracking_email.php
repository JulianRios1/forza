<?php 
include('conexion.php');

extract($_GET);

function GetUserIP() {

    if (isset($_SERVER)) {

        if (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
            return $_SERVER["HTTP_X_FORWARDED_FOR"];
        
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
            return $_SERVER["HTTP_CLIENT_IP"];

        return $_SERVER["REMOTE_ADDR"];
    }

    if (getenv('HTTP_X_FORWARDED_FOR'))
        return getenv('HTTP_X_FORWARDED_FOR');

    if (getenv('HTTP_CLIENT_IP'))
        return getenv('HTTP_CLIENT_IP');

    return getenv('REMOTE_ADDR');
}

$insertar = "INSERT INTO `emailtracker` (usuario_id, ip, descripcion, fecha)VALUES(".$_GET['id'].", '".GetUserIP()."', '".$_GET['des']."',CURRENT_TIMESTAMP())";
$mysqli->query($insertar);
/*

$to = 'sauloandres@gmail.com';
			$subject = utf8_decode("En bihomedis te extrañamos");

			$htmlContent = $insertar;
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// Additional headers
$headers .= 'From: BIHOMEDIS <info@bihomedis.com>' . "\r\n";
//$headers .= 'Cc: gianniramirez@bihomedis.com' . "\r\n";


// Send email
mail($to,$subject,$htmlContent,$headers);*/
header ("Location: http://www.bihomedis.com/assets/layouts/layout/img/imagen_correo.jpg");
?>