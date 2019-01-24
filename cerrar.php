<?php 
session_start();

if(isset($_SESSION['CodUsua']))
{
    /* Esto elimina todas las variables de unsa SESION :
      referencia de : https://www.w3schools.com/php/php_sessions.asp
      //session_unset();
    */
  session_unset();
	session_destroy(); /*TODO:Eliminara toda la SESION */
	header('location: login.php'); /* Para recargar la pagina y devolverle eñ control a login.php */
}


 ?>