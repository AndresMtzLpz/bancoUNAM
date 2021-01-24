<?php 

	$errores = '';

		$nombre = filter_var($_POST['contentName'],FILTER_SANITIZE_STRING);
		$apaterno = filter_var($_POST['contentAPaterno'],FILTER_SANITIZE_STRING);
		$amaterno = filter_var($_POST['contentAMaterno'],FILTER_SANITIZE_STRING);
		$password = $_POST['contentContra'];
		$telefono = $_POST['contentNumber'];
		$email = $_POST['contentEmail'];
		$edad = $_POST['contentEdad'];

		try {
			#conexion con la Base de Datos
			$conexion = new PDO('mysql:host=localhost;dbname=bancoUNAM','root','');
		} catch (PDOException $e) {
			echo "Error:" . $e->getMessage();
		}

		#Se crea usuario primero
		$statement = $conexion->prepare("INSERT INTO datosCliente (`nombre_cliente`, `A_Paterno_cliente`, `A_Materno_cliente`,
			`Contraseña`,`Telefono`,`Email`, `edad_cliente`) VALUES( ?,?,?,?,?,?,?)");
		$statement->execute([$nombre, $apaterno, $amaterno,$password,$telefono,$email,$edad]);


		header('Location: index.php');


?>