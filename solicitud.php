<?php 
require('funciones.php');
require('clases/clases.php');


if( isset($_GET['CodAm']) and isset($_GET['accion']))
{
	if(($_GET['accion']) == 1)
	{ /* ==1 implica que se ha seleccionado el icono de visto para aceptar la solicitud de contacto, de lo contrario se elimina la solicitud de la base de datos*/
		amigos::aceptar($_GET['CodAm']);
	}
	if(($_GET['accion']) == 2)
	{
		amigos::eliminar_solicitud($_GET['CodAm']);
	}
	header('location: index.php');
}

 ?>
