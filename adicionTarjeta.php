<?php 
	session_start();

	$errores = '';

		$usuario = $_SESSION['usuario']; #usuario = id_cliente
		$cuenta = $_POST['contentCuenta'];
		$saldo = $_POST['contentSaldo'];
		try {
			#conexion con la Base de Datos
			$conexion = new PDO('mysql:host=localhost;dbname=bancoUNAM','root','');
		} catch (PDOException $e) {
			echo "Error:" . $e->getMessage();
		}

		#Se crea usuario primero
		$statement = $conexion->prepare("INSERT INTO tarjeta_cliente (`id_cliente`, `num_cuenta`, `saldo`) 
			VALUES( ?,?,?)");
		$statement->execute([$usuario, $cuenta, $saldo]);

		#Se crea registro deposito primero
		$statement = $conexion->prepare("INSERT INTO depositos_cliente (id_cliente,num_cuenta,cantidad_deposito, date_deposito,saldo_corte) 
			VALUES( ?,?,?,SYSDATE(),?)");
		$statement->execute([$usuario, $cuenta,$saldo,$saldo]);
		commit;

		header('Location: index.php');
	
	




?>