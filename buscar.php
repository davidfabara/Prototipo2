<?php 
session_start();
require('funciones.php');
require('clases/clases.php');
require('header.php');
verificar_session();


if(isset($_GET['busqueda']))
{
	$nombre = $usuario = $_GET['busqueda'];
	
	/*Como no tenemos una funcion que nos ayude para buscar por el nombre completo de este o por el usuario(que no contiene espacios), ubicamos las siguientes instrucciones:  */
	$con = conexion("root", "");
	$consulta = $con->prepare("select * from usuarios where nombre like :nombre or usuario like :usuario");
	$consulta->execute(array(':nombre' => "%$nombre%", ':usuario'=>"%$usuario%"));
	/* Para q se reconozca ponemos a "%$nombre%" como un array asociativo sobre ':nombre', si lo ponemos sobre la consulta SQL nos podria dar conflictos por anidamiento de comillas dobles.Recordando que las comillas dobles reconocen variables dentro de ellas, por ellopermiten procesar la variable $nombre y el % implica que puede estar buscada por fragmentos de ese nombre puesto en busqueda tanto en la parte izq como der.,y la posibilidad de que existan mas usuarios con el mismo nombre */
	$resultados = $consulta->fetchAll();
}


/* Se procesaran todas las variables filtradas en la consulta SQL, sobre el array asociativo $resultados */
 ?>
	
	<div class="resultados-busqueda">
		<h1>Resultados de usuarios:</h1>
		<?php if(!empty($resultados)): ?>
			<?php foreach($resultados as $r): ?>
				<div class="usuarios">
					<div class="img">
						<a href="perfil.php?CodUsua=<?php echo $r['CodUsua']; ?>"><img src="<?php echo $r['foto_perfil']; ?>" alt="Foto de perfil de <?php echo $r['nombre']; ?>"></a>
					</div>
					<?php /* Al momento de mostrar resultados, se visualizara la foto de perfil y el nombre, y esa foto de perfil como la imagen representara un enlace hacia el perfil de dicho usuario de los resultados de busqueda */?>
					<div class="nombre">
						<a href="perfil.php?CodUsua=<?php echo $r['CodUsua']; ?>"><?php echo $r['nombre']; ?></a>
						<?php /*Nos aparecera un  enlace que nos permitira acceder como un hipervinculo  a el perfil de un usuario, el resultado se mostrara con la foto de perfil asociada al nombre con ese vinculo al perfil especifico de el usuario que busquemos en las busquedas, como los RESULTADOS de busqueda pueden implicar a mas de un usuario con el mismo nombre pero con diferente CodUsua, lo que pasa es que existe un foreach que nos permite iterar $resultados as $r para acceder de la misma manera(anterior expuesta) a cada usuario que coincida */?>
					</div>							
				</div>
			<?php endforeach; ?>
		<?php else: ?>
			<h1 class="no-resultados">No se encontraron usuarios con esa descripción</h1><br><hr><br>
			
		<?php endif; ?>		
	</div>


	<div class="busqueda-titulo">
			<center>
			<form action="index.php" method="get" id="buscar_completo">
				<h1>Buscar por titulo o por categoria: </h1>
				
				<input type="text" name="buscar" value="<?php echo $_GET['busqueda'] ?>">
				<?php /*  Si hacemos "enter" el formulario devolvera el control a buscar.php, en ese archivo  se recibe  $_GET['busqueda'] y si existe un usuario de mostrara,los existentes segun coincidencias de busqueda, pero tambien se cargara en el elemento value una busqueda lista sobre el titulo de publicaciones */
				?>
			</form>
			</center>
	</div>
	
</body>

</html>