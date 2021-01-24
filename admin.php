<?php session_start();

// Comprobamos tenga sesion, si no entonces redirigimos y MATAMOS LA EJECUCION DE LA PAGINA.
if (isset($_SESSION['admin'])) {
  $admin = $_SESSION['admin'];
    require 'api_admin.php';
    require 'views/admin.view.html';
} else {
  header('Location: login.php');
  die();
}
?>