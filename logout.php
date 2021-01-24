<?php 

session_start();

session_destroy(); #mata la sesion
$_SESSION = array(); #se asegura de limpiar la sesión
header('Location: login.php');

?>