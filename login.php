
<?php 
session_start();
require('funciones.php'); /*El archivo q contiene las funciones de la  conexion a la base de datos */
require('clases/clases.php');


	if(isset($_POST['acceder']))
	{
		$pass = hash('sha512', $_POST['pass']);

		 /* La funcion hash sirve para encriptar un valor pasado como argumento en este caso la contraseña pass , el primer parametro es el algoritmo sha512, convierte el argumento pasado en un string de 128 caracteres*/

		$datos = array(limpiar($_POST['usuario']), $pass); 

		/* 
		A diferencia de registro.php aqui el array $datos, solo contiene el ususario y el password  y LO LIMPIAMOS en ese mismo instante con la funcion limpiar, el password NO necesita limpiarse porque ya se ha sido encriptado con "hash"
		*/

		if(datos_vacios($datos) == false)
		{
			if(strpos($datos[0], " ") == false)
			{ 
				/*strpos para controlar en su argumento " " con esto si existen espacios (en blanco) esta funcion retornara verdadero de ahi que == false*/

				$resultados = usuarios::verificar($datos[0]);

				/*
				$resultados es un arreglo bidimensional asociativo debido al retorno de "return $resultado; en la funcion verificar de la clase usuario, $resultados contiene todo el registro para un usuario $datos[0] eso implica nombre, usuario, pass, etc; es un array bidimensional asociativo que el primer indice cero contiene todos los elementos de ese registro, me parece que el indice 0 implica porque de todos los registros de todos los usuarios solo se retorna un valor y por logica es indice cero"
				*/
				if(empty($resultados) == false)
				{
					if($datos[1] == $resultados[0]["pass"])
					{
						/*
						 SESIONES : https://www.w3schools.com/php/php_sessions.asp        Una sesión es una forma de almacenar información (en variables) que se utilizará en varias páginas.A diferencia de una cookie, la información no se almacena en la computadora de los usuarios.las variables de sesión duran hasta que el usuario cierra el navegador.
						*/
						$_SESSION['discapacidad'] = $resultados[0]["discapacidad"];
						/* La variable de session de discapacidad nos permitira cargar estilos segun discapacidad y su edicion en tiempo de ejecucion requerira una actualizacion de su valor de session */
						$_SESSION['CodUsua'] = $resultados[0]["CodUsua"];
						/* indice [0] implica a la tabla 0*/
						$_SESSION['nombre'] = $resultados[0]["nombre"];
						
						/* NO HAY limite para las variables de SESION, el argumento a manera de indice de arreglo puede ser cualquiera, la ventaja de la SESION es que esta escuchando en todo momento y pueden ser accedeidas esas variables desde cualquier pagina web con la sesion actual  */

						$_SESSION['foto_perfil'] = $resultados[0]['foto_perfil'];
						header('location: index.php');
						/* TODO:Si nosotros usamos header('location: index.php'); nos redirecciona a index.php , si usamos "require" la ventaja es que ejecutamos los "echo" y codigo visualizable(anterior) y demas procesos que queremos se quede en pantalla, el require solo ubica debajo de lo anterior ( si es cod html), si es (cod de proceso, solo se ejecuta)el código del archivo index.php y por supuesto el codigo html del mismo incluido la cabecera, pero "header", despues de procesar el códido anterior a esta instruccion,"require" no seria adecuado en este caso, header carga index.html inmediatamente y limpiando todo el codigo anterior, es como recargar la pagina pero procesando todo el codigo anterior a header. y devolviendo el valor a index.html (lo mas adecuado) */ 
					}
				}
			}
		}
	}

 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="css/login.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/annyang/2.6.0/annyang.min.js"></script>
		<script src=" http://code.responsivevoice.org/responsivevoice.js"></script>
		<script src="javascript/accesibilidad_login.js"></script>
</head>
<body>
	<div class="contenedor-form">
	<?php /*Notar que usamos los mismos estilos en login.php asi lo queremos usando la misma clase referenciada tambien desde login.php asi como registro.php*/ ?>
	<p id="login-sms-oculto" onclick="ejecutar_ayuda_login()"><strong>📢</strong></p>

	<h1>Login</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<label for="login-usuario"><strong>Usuario:</strong></label>
		<input type="text" name="usuario" id="login-usuario" class="input-control" placeholder="<?php echo "usuario";/*Funciona exactamente que placeholder=usuario */ ?>"> 
		<label for="password-input"><strong>Password:</strong></label>
			<input type="password" name="pass" class="input-control" placeholder="Password" id="password-input">
			<input type="submit" value="Acceder" id='submit-input' name="acceder"  class="log-btn">
		</form>
		<div class="registrar">
		<?php /*Notar que usamos los mismos estilos en login.css para dar ese color verde obscuro al icono de acceder*/ ?>
			<a id="link_a_registro" href="registro.php">Eres nuevo?</a>
			<?php /*Un link vinculable hacia registro.php en el caso de pese a estar en login, poder registrarse*/ ?>
		</div>
	</div>
</body>
</html>