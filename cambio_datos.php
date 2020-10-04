<?php 

@session_start();
include ("conexion.php");


//Método con str_shuffle() 
function random_numero($length) { 
    return substr(str_shuffle("0123456789"), 0, $length); 
}

//Genero email aleatorio
function generate_emails($number, $username_length,$cliente) {
if (is_numeric($number) && $number != 0) {
	if ($number > 1000) { //put hard limit on generate request
		$number = 1000; 
	}
	$generated_email_addresses = array(); 
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
	$char_count = count($characters); 
	$tld = array("com", "com.co", "co"); 
	for ($i=0; $i<$number; $i++){
		$randomName = ''; 
		for($j=0; $j<$username_length; $j++){
		$randomName .= $characters[rand(0, strlen($characters) -1)];
	}
		$k = array_rand($tld); 
		$extension = $tld[$k]; 
		//$fullAddress = $randomName . "@" ."forzaempresarial.".$extension; 
		$fullAddress = str_replace(' ', '', $cliente) . "@" ."forzaempresarial.".$extension; 
		$generated_emails[] = $fullAddress; 	
		//echo "<br />$fullAddress<br />"; 
		return $fullAddress;

		}
		
	}

}

//CAMBIAMOS LOS NOMBRES DE LOS MEDICOS

$resultado = $mysqli->query("SELECT * FROM `usuarios` WHERE `idrol`=5 ");

$num_registros = mysqli_num_rows($resultado);
$contador = 1;
$porcentaje = 0;
$direccion=$tel=$cel=$email='';

while($row = mysqli_fetch_array($resultado)){	

	$cliente_new = 'Cliente '.$contador;
	$direccion = 'Calle '.rand(1,99).' # '.rand(1,999).'-'.rand(1,999);
	$tel = '6'.random_numero(6);
	$cel = '3'.rand(0,2).rand(0,9).random_numero(7);


	$number = 10002; 
	$username_length = 24; 
	$email = generate_emails($number, $username_length,$cliente_new);

	$actualizar = "UPDATE `usuarios` SET `nom`= UPPER('$cliente_new'), ape1='FORZA', ape2='', dir='$direccion', barrio='Sin Definir', tel='$tel', cel='$cel', mail='$email' WHERE id = ".$row['id'];

  	if($mysqli->query($actualizar))
  	{
  		$porcentaje = ($contador*100)/$num_registros;
  		echo round($porcentaje,2).'% <br>';
  	}

	//echo $row['nom'].'<br>';

	$contador ++;
}


?>