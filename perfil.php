<?php 
session_start(); /* Iniciamos la session sobre perfil.php*/
require('funciones.php');
require('clases/clases.php'); /* Ruta relativa hacia clases.php en carpeta clases */
verificar_session();
require('header.php');


if (isset($_GET['CodUsua'])) {
	/*
	 El metodo get se recibe al intentar acceder al perfil de un usuario(ya sea desde una publicacion en el nombre de un usuario como vinculo o buscandolo en la seccion), por lo tanto cada usuario tiene un CodUsua univoco  
	 */
	$usuario = usuarios::usuario_por_codigo($_GET['CodUsua']);

	/*
	En usuarios::usuario_por_codigor , se procesa la instruccion SQL select * from usuarios where CodUsua = :CodUsua"); con el objetivo de retornar TODOS LOS ATRIBUTOS DE UN USUARIO , esta informacion se visualizara en el codigo html 
	hay una diferencia entre usuarios::verificar con SQL "select * from usuarios where usuario = :usuario", con usuarios::usuario_por_codigo, sql de "select * from usuarios where CodUsua = :CodUsua" en el 1era seleccionamos todos los registros por el $usuario, en cambio en usuarios::usuario_por_codigo se lo hace por CodUsua	.
	 */

	if (empty($usuario)) header('location: index.php');
	/*
	 Si el usuario esta vacio(no hay un usuario), retornamos a index.php 
	 */

	$verificar_amigos = amigos::verificar($_SESSION['CodUsua'], $_GET['CodUsua']);
	/*
	 amigos::verificar llama, enviando los argumentos y recibiendo los parametros en :
	 function verificar($usua_enviador, $usua_receptor), en esta funcion se ejecuta la instruccion SQL   "select * from amigos where (usua_enviador = :usua_enviador and usua_receptor = :usua_receptor) or (usua_enviador = :usua_receptor and usua_receptor = :usua_enviador) ");
	  con el objetivo de verificar si un usuario tanto si $_SESSION['CodUsua']como $_GET['CodUsua'] se han enviado solicitudes de amistad y ya son amigos registrados en la base de datos, el objetivo de esta funcion entonces sera mostrar si son amigos o "agregar", segun el ['status'] == true , en este caso implica que el usuario de perfil y el uusario de la SESSION son amigos, pero tambien hay la posibilidad de que la "solicitud enviada" o "editar perfil", todo esto depende de lo que nos retorne en amigos::verificar porque se controla las poisibilidades de ejecucion entorno al codigo html con el de php envedido en la seccion de html. 


	 $_SESSION['CodUsua'] siempre tendra el codigo del usuario que esta navegando en el computador mas $_GET['CodUsua'] es una variable que se recibira cada vez que se llame a perfil.php para procesados por usuario individual con respecto a $_SESSION['CodUsua']
	 Esta funcion tambien controla si se trata del uusario de SESSION o de un ususario como vinculo de alguna publicacion.
	 */
	$post = post::post_por_usuario($_GET['CodUsua']);	
	/*
	 En esta funcion de la clase post con la instruccion SQL "select U.CodUsua, U.nombre, U.foto_perfil, P.CodPost, P.contenido, P.img, P.url from usuarios U inner join post P on U.CodUsua = P.CodUsua where P.CodUsua = :CodUsua ORDER BY P.CodPost DESC");   obtenemos todos los valores relativos a una publicacion respectivamente del usuario del perfil

	 TODO: IMPORTANTE TODO:, ahora tanto en perfil.php como en pubicacion.php, un usuario que visite estas 2 secciones tendra la posibilidad de poner un me gusta, un comentario o visualizar la informacion, y a su vez notificaciones sobre esas acciones,  para controlar esas posibilidades es los siguientes condicionales isset($_GET['agregar'])) , isset($_POST['comentario']) , (isset($_GET['mg'])) , ´para cualquiera de estas acciones recargamos con header('location: index.php');  A EXCEPCION de la accion de "AGREGAR" a una persona para una solicitud de amistad, en ese caso, se debe redireccionar a header('location: perfil.php?CodUsua='.$_GET['CodUsua']); con la intencion de ver el mensaje de "solicitud enviada" y constatar que se ha efectuado la solicitud de amistad sobre el perfil del uusario(DIFERENTE al de session) actualmente visitado.
	 */
}

if (isset($_GET['agregar'])) {
	/*
desde el mismo perfil.php en el codigo embedido entre html y php de la seccion inferior, con <a href="perfil.php?CodUsua=<?php echo $_GET['CodUsua']; ?>&&agregar=
<?php echo $_GET['CodUsua']; ?>">Agregar</a> es en donde se envia al mismo perfil.php la variable $_GET['agregar'], un
ususario de SESSION que visite el perfil de un X usuario, tiene la posibilidad de enviar esta solicitud de amistad
*/
	amigos::agregar($_SESSION['CodUsua'], $_GET['CodUsua']);
	header('location: perfil.php?CodUsua=' . $_GET['CodUsua']);

}



if (isset($_POST['comentario'])) {
/*Primero se controla que el comentario no este vacio para luego ya sea las notificaciones o los me gusta para
agregrarlos a la base de datos y luego notificarlos en la seccion de cabecera(superior) */
	if (!empty($_POST['comentario'])) {
		comentarios::agregar($_POST['comentario'], $_SESSION['CodUsua'], $_POST['CodPost']);
		notificaciones::agregar(1, $_POST['CodPost'], $_SESSION['CodUsua']);


	header('location: index.php');
	}

}

if (isset($_GET['mg'])) {
	/*
	El valor recibido por mg con 0 implica que un usuario no ha seleccionado el OK(me gusta), y el 2 implica que es ya se
	ha seleccionado Ok, y es evidente que no se debe registrar mas de 1 OK por publicacion
	El valor de accion puede ser 1 o 0 , 1 para comentarios y 0 para me gusta, un dato que 0=false, de esta forma se
	procesa la accion de 0 en la base de datos
	*/
	if ($_GET['mg'] == 0) {
		mg::agregar($_GET['CodPost'], $_SESSION['CodUsua']);
		notificaciones::agregar(false, $_GET['CodPost'], $_SESSION['CodUsua']);


	}
	if ($_GET['mg'] == 2) {

	}
	header('location: index.php');

	/*
	OJO, aqui hay un bug, a diferencia de su homologo en index.php que cumple las mismas caracteriscticas, aqui en
	perfil.php pero hay un error que en perfil.php de no ubicar el header('location: index.php'); despues del todo, nos
	produce el error, a diferencia en index.php en el cual al hacer click en una publicacion que ya hemos puesto me gusta
	es evidente que no deberia ser necesario recargar la pagina como si se soluciona en index.php
	*/
}
if (isset($_GET['denuncia'])) {
	if ($_GET['denuncia'] == 0) {
		denuncias::agregar($_GET['CodPost'], $_SESSION['CodUsua']);
		header('location: index.php');
	}
	if ($_GET['denuncia'] == 2) {

	}
	header('location: index.php');
}

?>


<div id="perfil">
    <ul>
        <li><img src="<?php echo $usuario[0]['foto_perfil']; ?>" alt="<?php echo " El nombre del usuario es:" .
                $usuario[0]['nombre']; ?>" id="img"></li>
        <li>
            <h3>
                <?php echo $usuario[0]['nombre']; ?>
            </h3>
            <ul>
                <li><strong>Discapacidad Visual: </strong><span>
                        <?php echo $usuario[0]['discapacidad']; ?></span></li>
                <li><strong>Profesion: </strong><span>
                        <?php echo $usuario[0]['profesion']; ?></span></li>
                <li><strong>Pais: </strong> <span>
                        <?php echo $usuario[0]['pais']; ?></span></li>
                <li><strong>Amigos: </strong><span>
                        <?php if (!empty(amigos::cantidad_amigos($_GET['CodUsua'])))
							echo amigos::cantidad_amigos($_GET['CodUsua'])[0][0];
										/* [0][0]Tabla cero y campo cero */														
						    else echo 0;

						?>
																							
                    </span></li>
            </ul>
        </li>
        <?php /*SI CodUsua diferente de la misma variable como argumento pero de la SESSION evidentemente es que nos encontramos en otro perfil */ ?>
        <?php if ($_GET['CodUsua'] != $_SESSION['CodUsua']) : ?>
        <?php if (empty($verificar_amigos)) : ?>
        <li><a href="perfil.php?CodUsua=<?php echo $_GET['CodUsua']; ?>&&agregar=<?php echo $_GET['CodUsua']; ?>">Agregar</a></li>
        <?php elseif ($verificar_amigos[0]['status'] == true) : ?>
        <li><a href="#">Amigos</a></li>
        <?php else : ?>
        <li><a href="#">Solicitud enviada</a></li>
        <?php endif; ?>
        <?php else : ?>
        <?php /* Este else: implica que $_GET['CodUsua'] = $_SESSION['CodUsua'] entonces se trata del usuario de SESSION */ ?>
        <li><a href="editar_perfil.php">Editar</a><label for="subir-sms-oculto" onclick=""><strong>📢</strong></label>
	<h1 class="speech-post" style="display:none;" id="subir-sms-oculto"></h1></li>
		
        <?php /*
		 Hay 4 posibilidades debido al condicional $verificar_amigos, que se procesa en el codigo php superior debido a amigos::verificar, evidentemente el usuario de SESSION sera el unico que tendra la posibilidad de ver siempre "Editar" 
							 */
		?>
        <?php endif; ?>
    </ul>

</div>


<?php require('publicacion.php'); ?>
<?php /* Abajo de el header > perfil debemos ubicar abajo todas las publicaciones que impliquen al usuario CodUsuario de la pagina actual, porque puede darse el caso que estemos en el perfil de otro usuario y sus publicaciones solo son de aquellas en las cual el ha publicado*/ ?>

</body>

</html>