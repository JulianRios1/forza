<?php
//MySQL connection parameters
/*$dbhost = 'localhost';
$dbuser = 'root';
$dbpsw = '';
$dbname = 'bihomedis_web';*/
include('../conexion.php');



 ///Connects to mysql server
$connessione = @mysql_connect($hostname,$bd_usuario,$bd_clave);

$filename = 'estructura_'.date('Y-m-d').'.sql';

//Set encoding
mysql_query("SET CHARSET utf8");
mysql_query("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");

//Includes class
require_once('FKMySQLDump.php');


//Creates a new instance of FKMySQLDump: it exports without compress and base-16 file
$dumper = new FKMySQLDump($bd_nombre,$filename,false,false);

$params = array(
	//'skip_structure' => TRUE,
	'skip_data' => TRUE,
);

//Make dump
$dumper->doFKDump($params);

//////////////////////////////////////////////////////////////////////
///ENVIAMOS EMAIL/////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////



require('pclzip/pclzip.lib.php');
$nombre_zip = 'estructura_'.date('Y-m-d').'.zip';
$zip = new PclZip($nombre_zip);
$zip->create($filename);

//ELIMINANOS EL ARCHIVO SQL
unlink($filename);


//Variables para los campos de texto
$nombre = strip_tags('Saulo Valderrama');
$email = strip_tags('sauloandres@gmail.com');


//$content = chunk_split(base64_encode(file_get_contents('estructura.sql')));


$path = '';
//$file = $path . "/" . $filename;
$file = $nombre_zip;

$mailto = 'backups@sacompsystem.com';
$subject = 'Backup Base de datos Forza Bihomedis';
$message = 'Estructura de la base de datos de la fecha '.date('Y/m/d');

$content = file_get_contents($file);
$content = chunk_split(base64_encode($content));

// a random hash will be necessary to send mixed content
$separator = md5(time());

// carriage return type (RFC)
$eol = "\r\n";

// main header (multipart mandatory)
$headers = "From: Backup Forza <backup@forza.com.co>" . $eol;
$headers .= "MIME-Version: 1.0" . $eol;
$headers .= "Content-Type: multipart/mixed; boundary=\"" . $separator . "\"" . $eol;
$headers .= "Content-Transfer-Encoding: 7bit" . $eol;
$headers .= "This is a MIME encoded message." . $eol;

// message
$body = "--" . $separator . $eol;
$body .= "Content-Type: text/plain; charset=\"iso-8859-1\"" . $eol;
$body .= "Content-Transfer-Encoding: 8bit" . $eol;
$body .= $message . $eol;

// attachment
$body .= "--" . $separator . $eol;
$body .= "Content-Type: application/octet-stream; name=\"" . $file . "\"" . $eol;
$body .= "Content-Transfer-Encoding: base64" . $eol;
$body .= "Content-Disposition: attachment" . $eol;
$body .= $content . $eol;
$body .= "--" . $separator . "--";

//SEND Mail
if (mail($mailto, $subject, $body, $headers)) {
    echo "mail send ... OK"; // or use booleans here
    

} else {
    echo "mail send ... ERROR!";
    print_r( error_get_last() );
}
?>