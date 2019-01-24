<?php 

function conexion($usuario, $pass)
{
	try {

		$con = new PDO('mysql:host=localhost;dbname=red_social', $usuario, $pass);
		return $con; // Se crea una instancia de PDO para con $con asignarle la conexion a la base de datos tanto usuario como contraseña podrian establecer unicidad
		
	} catch (PDOException $e) {
		return $e->getMessage();
	}
}


function datos_vacios($datos)
{
	$vacio = false;
	$tam = count($datos); // contará el tamaño total del arreglo recibido
	for($c = 0; $c < $tam; $c++) 
	{
		if(empty($datos[$c])) /*Con este condicional nos aseguramos que si algun dato de los suministrados en el formulario de registro en el que alguno este vacio, simplemente se asignara vacio en true y se saldra del condicional con "breack;" puesto que a penas se detecte un valor vacio, se debe rapidamente informar */
		{
			$vacio = true;
			break;
		}
	}

	return $vacio; // Se retornará el valor booleano de la variable $vacio si alguno de los elementos del array $datos es vacio se retornará false, true en caso contrario
}


function limpiar($limpio) /*TODO:Ver video seccion 8 clase 70(por la mitad), utiliza esta funcion limpiar para borrar la contraseña, pero aqui en este codigo no lo usa.*/
			{
				$limpio = htmlspecialchars($limpio); //quita caracteres de html
				$limpio = trim($limpio); //quita espacios
				$limpio = stripcslashes($limpio); /*TODO:quitar barras invertidas, 	OJO, ME PARECE QUE ES $limpio y no $limpi0 */
				return $limpio;
			}
		

function verificar_session()
{
	if(!isset($_SESSION['CodUsua']))
	{ 
		/*Si no hay usuario que haya iniciado una sesion, simplemente se redirecciona a login.php inmediatamente */
		header('location: login.php');
	}
}
function fechaPost(){
	/* retorna una fecha con anio, mes, dia y horas y minutos de la publicacion */
	date_default_timezone_set('America/New_York');
	setlocale(LC_ALL,"hu_HU.UTF8");
	$fecha=(strftime("%Y/%m/%e %H:%M"));

	return $fecha;
}

		
	

 ?>