<?php 
/*El index es lo primero que se ejecuta al abrir la aplicación web
*/

session_start();

if(isset($_SESSION['usuario'])){ //Si hay una sesión de "usuario" iniciada
	header('Location: api_cliente.php'); //se abre el perfil del usuario
	die();
}	elseif(isset($_SESSION['admin'])){ //Si hay una sesión de "admin" iniciada
		header('Location: admin.php'); //se abre el perfil de administrador
		die();
	}else{
	header('Location: login.php'); //si no, se redirige a la página de login
}
?>