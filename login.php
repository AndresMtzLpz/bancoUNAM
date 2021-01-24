<?php 

	session_start();

	if(isset($_SESSION['usuario'])){ //Si hay una sesión de "usuario" iniciada
		header('Location: index.php'); //se abre el perfil del usuario
		die();
	}

	$errores = '';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$usuario = filter_var($_POST['usuario'],FILTER_SANITIZE_STRING);
		$password = $_POST['password'];

		try {
			#conexion con la Base de Datos
			$conexion = new PDO('mysql:host=localhost;dbname=bancoUNAM','root','');
		} catch (PDOException $e) {
			echo "Error:" . $e->getMessage();
		}

		$statement = $conexion->prepare('
			SELECT * FROM datoscliente WHERE id_cliente = :usuario AND Contraseña = :password'
		);
		$statement->execute(array(
			':usuario' => $usuario,
			':password' =>$password
		));

		$resultado = $statement->fetch();

		if ($resultado !== false) { #Se comprueba si se pudo iniciar sesión como cliente
			$_SESSION['usuario'] = $usuario; #se inicia sesión y se redirige a index
			header('Location: index.php');
		} else { #si no se pudo iniciar como cliente, se compruena si los datos son de un admin
			$statement_admin = $conexion->prepare('
				SELECT * FROM accesoAdmin WHERE id_admin = :usuario AND contra_admin = :password'
			);
			$statement_admin->execute(array(
				':usuario' => $usuario,
				':password' =>$password
			));
			$resultado_admin = $statement_admin->fetch();

			if ($resultado_admin !== false) {
				$_SESSION['admin'] = $usuario;
				header('Location: index.php');
			} else {#Si no se pudo iniciar como admin tampoco, entonces los datos son incorrectos
				$errores .= '<li>Datos Incorrectos</li>';
			}
		}
	}
	require 'views/login.view.html';
?>