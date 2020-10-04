<?php
@session_start();
include ("conexion.php");

/*=============================================
=     Si es un vendedor sacamos las zonas    =
=============================================*/
$cons_zonas = '';

if($_SESSION['rol_usu'] ==  1)
{
    $resultado = $mysqli->query("SELECT id as zona FROM zonas z WHERE id_vendedor = ".$_SESSION["idusuario"]); 
    $zn='';
                    
    while($row_zon= mysqli_fetch_array($resultado))
    {
        $zn.= $row_zon['zona'].','; 
    }
    $cons_zonas = ' AND m.zona IN ('.substr ($zn , 0, -1 ).')';
    
}


/*=====   Fin del comentario   ======*/

$resultado = $mysqli->query("SELECT u.id, u.documento, u.nom, u.ape1, u.ape2, u.mail, u.dir, u.tel, u.cel, z.des AS zona, m.barrio1, m.fecha_ult_vis, m.listaPrecios, m.fec_ult_pedido, m.valor_compras, m.mes_compras, m.ano_compras FROM usuarios u JOIN medicos m ON m.usuario_id = u.id JOIN zonas z ON m.zona = z.id WHERE u.idrol = 5 AND u.estado = 1 AND m.habilitado = 1 $cons_zonas");

$tabla = "";

while($row = mysqli_fetch_array($resultado)){		


	//SACAMOS LA FECHA DE LA ULTIMA VISITA
	$fecha = $row['fecha_ult_vis']; 
	$array_estrellado = '';
	$compras = $estrellas_off = $estrellas_on = 0;

	if(date('Y') == $row['ano_compras'] && date('m') == $row['mes_compras'])
	{
		$compras = $row['valor_compras'];
	}
	else{
		$compras = 0;
	}
	
	//AREGLAR LA CONSULTA
	/*$resul = $mysqli->query("SELECT SUM(c.compra) AS compras FROM cartera_usuarios c WHERE c.cliente_doc = '".$row['documento']."' AND c.ano = ".date('Y')." AND c.mes = ".date('m'));
	$row2 = mysqli_fetch_array($resul);*/

	

	if($compras >= 90000 && $compras < 180000)
	{
		$estrellas_on = 1;
		$estrellas_off = 4;
	}
	else if($compras >= 180000 && $compras < 800000)
	{
		$estrellas_on = 2;
		$estrellas_off = 3;
	}
	else if($compras >= 800000 && $compras < 1500000)
	{
		$estrellas_on = 3;
		$estrellas_off = 2;
	}
	else if($compras >= 1500000 && $compras < 3000000)
	{
		$estrellas_on = 4;
		$estrellas_off = 1;
	}
	else if($compras >= 3000000)
	{
		$estrellas_on = 5;
		$estrellas_off = 0;
	}
	else {
		$estrellas_on = 0;
		$estrellas_off = 5;
	}

	//LLENAMOS DE ESTRELLAS EL CAMPO
	for($i=1; $i<=$estrellas_on; $i++)
	{
		$array_estrellado .= '<i class=\"fa fa-star\"></i>';
	}

	for($i=1; $i<=$estrellas_off; $i++)
	{
		$array_estrellado .= '<i class=\"fa fa-star-o\"></i>';
	}


	$visitas_no_contar=0;
    
    $resul3 = $mysqli->query("SELECT * FROM visitas WHERE usuario_id = ".$row['id']." AND MONTH(fecha) = ". date('m')." AND YEAR(fecha) = ".date('Y'));
    $num_visitas = mysqli_num_rows($resul3);

    while($row3 = mysqli_fetch_array($resul3))
    {
        if(($row3['contacto'] == 1) || ($row3['contacto'] == 4))
        {
            $visitas_no_contar +=1;
        }
    }
    

    //list($anio, $mes, $dia) = explode("-",$fecha);
    
    if($num_visitas > 0)
    {
		if($num_visitas == $visitas_no_contar)
		{
			$icono = '<i class=\"font-red-thunderbird fa fa-thumbs-down\" ></i>';
			//echo '<img src="../imagenes/no_check.png" width="16" height="16" />';
		}
		else
		{     
			$icono = '<i class=\"font-green-meadow fa fa-thumbs-up\" ></i>';   
        	//echo '<img src="../imagenes/check.png" width="16" height="16" />';
		}
    }
    else
    {
    	$icono = '<i class=\"font-red-thunderbird fa fa-thumbs-down\" ></i>';
        //echo '<img src="../imagenes/no_check.png" width="16" height="16" />';
    }


	$editar = '<a href=\"cliente_view.php?id='.$row['id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Ver\" class=\"btn btn-primary btn-xs\"><i class=\"fa fa-eye\"></i></a>';
	$visitar = '<a href=\"visita_new.php?id='.$row['id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Visitar\" class=\"btn btn-primary btn-xs purple\" ><i class=\"fa fa-suitcase\"></i></a>';
	//$visitar = '<i class=\"fa fa-star\"></i><i class=\"fa fa-star\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i><i class=\"fa fa-star-o\"></i>';
	//$eliminar = '<a href=\"usuario_view.php?id='.$row['id'].'\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Editar\" class=\"btn btn-primary btn-xs\"><i class=\"fa fa-edit\"></i></a>';
	
	

	$tabla.='{
			  "icono":"'.$icono.'",
			  "documento":"'.$row['documento'].'",
			  "nombre":"'.ltrim(strtoupper($row['nom'].' '.$row['ape1'].' '.$row['ape2'])).'",
			  "mail":"'.strtolower($row['mail']).'",
			  "dir":"'.$row['dir'].'",

			  "cel":"'.$row['cel'].'",
			  "zona":"'.$row['zona'].'",
			  "clasificacion":"'.$array_estrellado.'",
			  "barrio":"'.$row['barrio1'].'",
			  "ventas":"$'.number_format($compras,0).'",
			  "ultima_visita":"'.$fecha.'",		
			  "ultimo_pedido":"'.$row['fec_ult_pedido'].'",		  
			  "visitar":"'.$visitar.'",
			  "editar":"'.$editar.'"
			},';	
}	

//eliminamos la coma que sobra
$tabla = substr($tabla,0, strlen($tabla) - 1);
echo '{"data":['.$tabla.']}';	
?>