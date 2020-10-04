<?php

       if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
if(!$captcha){
          echo '<h2>Porfavor Ingresa el captcha.</h2>';
		  echo '<a href="Index.php">Clic aqui para regresar</a>';
          exit;
        }
		
	$url = 'http://www.google.com/recaptcha/api/siteverify';
	
	$privatekey = "6Le7qyIUAAAAAKChe3ViC4-yLsUuzRu-yp5VzspK";

	$response = file_get_contents($url."?secret=".$privatekey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
	$data = json_decode($response,true);
	if (isset($data->success) AND $data->success==true) {
          echo '<h2>Eres un Spamer</h2>';
		  echo '<a href="Index.php">Clic aqui para regresar</a>';
        } else {
          echo '<h2>Gracias por comentar.</h2>';
		  echo '<a href="Index.php">Clic aqui para regresar</a>';
        }
?>

