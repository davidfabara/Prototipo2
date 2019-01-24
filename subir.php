<?php /*<!--El proposito de esta seccion de codigo es mostrarnos la interfaz incluido la foto de perfil, el nombre del usuario y el espacio para subir contenido y archivo --> */ ?>
<button id="boton_mostrar_subir" class="boton">Subir publicacion</button>
<div class="subir" style="display:none;">

    <div class="publi-info-perfil">
    <label for="subir-sms-oculto" onclick=""><strong>📢</strong></label>
	<h1 class="speech-post" style="display:none;" id="subir-sms-oculto"></h1>
        <table>
            <tr>
                <td><a href="#"><img src="<?php echo $_SESSION['foto_perfil']; ?>" alt="" class="publi-img-perfil"></a>
                </td>
                <td><a href="perfil.php?CodUsua=<?php echo $_SESSION['CodUsua'] ?>" class="nombre-usuario">
                        <?php echo $_SESSION['nombre']; ?></a>
                </td>
                <?php /* 	<!--Le he agregado un acceso al perfil del usuario pero solo en la seccion de subir contenidos en el icono de perfil del mismo usuario de la actual sesion, y tambien una descripcion de la foto de perfil para accesibilidad , en la siguiente parte tambien se establece un vinculo al perfil del usuario para el nombre-->
				
				<!--Cuando vamos a subir contenido, se cargara en la parte superior la foto de perfil y el nombre del usuario , luego en el FORM action, se receptara input type text y el archivo a subir-->*/?>
            </tr>
        </table>
    </div>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
        <center>
            <table width="90%" border="1">
                <center>
                    <caption><strong>Introducir datos</strong></caption>
                </center>
                <tbody>
                    <tr>
                        <td>
                            <label for="titulo"><strong>Titulo:</strong></label></td>
                        <td>
                            <input type="text" name="titulo" id="titulo" class="contenidos" placeholder="Escribir titulo "
                                required><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="autor"><strong>Autor/es:</strong></label>
                        </td>
                        <td>
                            <input type="text" name="autor" id="autor" class="contenidos" placeholder="<?php echo $_SESSION['nombre']?>"><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="fecha"><strong>Fecha de publicacion:</strong></label></td>
                        <td>
                            <input type="text" name="fecha" id="fecha" class="contenidos" placeholder="<?php echo fechaPost();?>"><br></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="categoria"><strong>Categoria:</strong>
                            </label>
                        </td>
                        <td>
                            <select name="categoria" id="categoria" class="categoria">
                                <option id="opcion" class="opcion" selected>Ciencias generales</option>
                                <option class="opcion" id="opcion">Ingenieria</option>
                                <option class="opcion" id="opcion">Ciencias Sociales</option>
                                <option class="opcion" id="opcion">Biologia, Medicina</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="resumen" class="label_contenidos"><strong>Resumen:</strong></label>
                        </td>
                        <td>
                            <div>
                                <textarea name="resumen" id="resumen" class="contenidos" rows="4" cols="40" placeholder="escribir el resumen"></textarea><br>

                                <input type="button" value="Citar" class="boton" id="citarRe" onclick="citar('resumen','cita_resumen','div_resumen')">

                                <div class="div_resumen"></div>

                                <input type="hidden" name="todoResumen" value="mostrarTodo('resumen','cita_resumen','div_resumen')">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="introduccion"><strong>Introduccion:</strong></label>
                        </td>
                        <td>
                            <textarea name="introduccion" id="introduccion" class="contenidos" rows="4" cols="40"
                                placeholder="escribir la introduccion"></textarea><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="contenido"><strong>Contenido:</strong></label>
                        </td>
                        <td>
                            <textarea name="contenido" id="contenido" class="contenidos" rows="4" cols="40" placeholder="escribir el contenido"></textarea><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="conclusiones"><strong>Conclusiones:</strong></label>
                        </td>
                        <td>
                            <textarea name="conclusiones" id="conclusiones" class="contenidos" rows="4" cols="40"
                                placeholder="escribir las conclusiones"></textarea><br>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="bibliografia"><strong>Bibliografia:</strong></label>
                        </td>
                        <td>
                            <textarea name="bibliografia" id="conclusiones" class="contenidos" rows="4" cols="40"
                                placeholder="escribir la bibliografia"></textarea><br>
                        </td>
                    </tr>
                    <tr>

                        <td>
                            <label for="archivo"><strong>Subir archivo/o nueva version:</strong></label>
                        </td>
                        <td>
                            <input type="file" name="archivo" id="archivo" class="boton"><br>
                        </td>

                    </tr>
                </tbody>
            </table>
        </center>
        <?php /*
				 <!-- Aqui  el class="boton-subir icon-camera se cargan 2 estilos a la vez el primero del archivo style.css de la carpeta css y el segundo de icomoon, tambien  &nbsp;  genera un espacio en blanco en html--> este label apunta al archivo file como un label 
				 */
			?>
        <?php 
			/*
			 <!-- El"display: none" es para que no se muestre el icono por defecto del sistema de subir un archivo, en el label for="archivo" estamos referenciando a "archivo"y por lo que tenemos otro icono que cumplira esta misma funcionalidad, por defecto el valoy de display puede ser block o inline--> 
			 */
			?>
        <center>
            <table width="90%" border="1">
                <tbody>
                    <tr>
                        <td><input id="descripcionArchivos" type="button" value="Descripcion Archivos"></td>
                        <td>
                            <div id="addDescripcionArchivos"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><input id="referencia" type="button" value="referencia"></td>
                        <td>
                            <div id="addReferencia"></div>
                        </td>
                    </tr>
                    <tr>
                        <td><input id="tabla" type="button" value="tabla"></td>
                        <td>
                            <div id="addtabla"></div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>
        <?php /* TODO: MODIFICAR INCOMPLETO TODO: */ ?>
        <?php /*if(filesize($_FILES['archivo']['name'])>=0):*/?>
        <?php 
			/*
			echo  
			"<input type=". "text".'name="alt"'.' placeholder ="Descripcion de archivo">'; 
			*/
			?>
        <?php /*endif;*/?>
        <?php /* <input type="hidden" name="publicar"> */ ?>
        <center><input type="submit" value="Publicar" name="publicar" class="boton"></center>
        <?php /* <!--input type="hidden se envia al enviar el formulario (en este caso al presionar enter), lo que sucede es que esta variable a manera de boton se envia (junto con las otras variables con sus respectivos valores)y se procesará como un hilo de la publicacion actual su objetivo sera validar (isset($_POST['publicar']) and !empty($_FILES) and !empty($_POST['contenido'] presente en index.php que con require se ha invocado a este subir.php donde se encuentra este input type="hidden"  ejm : https://www.w3schools.com/tags/que tryit.asp?filename=tryhtml5_input_type_hidden  --> */ 
		?>
    </form>
</div>
</div>