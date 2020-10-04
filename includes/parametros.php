<?php
//funcion para devolver el estado
function estado($valor)
{
	switch ($valor)
	{
		case 1: return "Inactivo";
		case 0: return "Activo";
		default: return "[Sin definir]";
	}
}

function estado_usuarios($valor)
{
	switch ($valor)
	{
		case 1: return "Activo";
		case 0: return "Inactivo";
		default: return "[Sin definir]";
	}
}


//funcion para devolver si esta oculto o visible
function oculto_visible($valor)
{
	switch ($valor)
	{
		case 0: return "Visible";
		case 1: return "Oculto";
		default: return "[Sin definir]";
	}
}

//funcion para devolver el valor correcto para el tipo de observacion
function lineas($valor)
{
	switch ($valor)
	{
		case 1: return "L&iacute;nea humana";
		case 2: return "L&iacute;nea veterinaria";
		default: return "[Sin definir]";
	}
}

//funcion para devolver los estados basicos
function estados($valor)
{
	switch ($valor)
	{
		case 1: return "Activado";
		case 2: return "Desactivado";
		default: return "[Sin definir]";
	}
}

//funcion para devolver los estados de los pedidos
function estados_pedidos($valor)
{
	switch ($valor)
	{
		case 1: return "Incompleto";
		case 2: return "Pendiente";
		case 3: return "Cancelado";
		case 4: return "Rechazado";
		case 5: return "Enviado";
		default: return "[Sin definir]";
	}
}

//funcion para devolver el tipo de transacción
function tipo_transaccion($valor)
{
	switch ($valor)
	{
		case 1: return "Efectivo";
		case 2: return "Consignaci&oacute;n";
		case 3: return "Bono";
		case 4: return "Pago factura";
		case 5: return "Retiro de efectivo";
		default: return "-Seleccione-";
	}
}

//funcion para devolver si esta Habilitado o Inhabilitado
function tipo_saldo($valor)
{
	switch ($valor)
	{
		case 1: return "Credito";
		case 2: return "Efectivo";
		default: return "[Sin definir]";
	}
}

//funcion para devolver el tipo de cliente celebre
function cliente_celebre($valor)
{
	switch ($valor)
	{
		case 1: return "Oro";
		case 2: return "Diamante";
		case 3: return "Platino";
		case 4: return "Rub&iacute;";
		case 5: return "Plata";
		default: return "- Sin definir -";
	}
}


//funcion para devolver el valor del estado de lso domicilios
function estados_domicilios($valor)
{
	switch ($valor)
	{
		case 1: return "Pendiente";
		case 2: return "Devuelto";
		case 3: return "Entregado";
		default: return "[Sin definir]";
	}
}

//funcion para devolver el tipo del caso
function tipoCaso($valor)
{
	switch ($valor)
	{
		case 1: return "Humano";
		case 2: return "Veterinario";
		default: return "[Sin definir]";
	}
}

//funcion para devolver el genero
function genero($valor)
{
	switch ($valor)
	{
		case 'F': return "Femenino";
		case 'M': return "Masculino";
		default: return "[Sin definir]";
	}
}

//funcion para devolver si es SI o NO
function sino($valor)
{
	switch ($valor)
	{
		case 1: return "Si";
		case 0: return "No";
		default: return "[Sin definir]";
	}
}

//funcion para devolver si esta Habilitado o Inhabilitado
function habilitado($valor)
{
	switch ($valor)
	{
		case 1: return "Habilitado";
		case 0: return "Inhabilitado";
		default: return "[Sin definir]";
	}
}
?>