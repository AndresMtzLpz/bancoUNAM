<?php 
	session_start();

	$errores = '';

		$usuario = $_SESSION['usuario']; #usuario = id_cliente
		$cuenta = $_POST['contentCuenta'];
		$monto = $_POST['contentMonto'];
		try {
			#conexion con la Base de Datos
			$conexion = new PDO('mysql:host=localhost;dbname=bancoUNAM','root','');
		} catch (PDOException $e) {
			echo "Error:" . $e->getMessage();
		}
		
		$sql = "SELECT saldo FROM tarjeta_cliente WHERE id_cliente = $usuario AND num_cuenta = $cuenta";

		$resultados = $conexion->query($sql);
		foreach ($resultados as $fila) {
			$saldo= $fila['saldo'];
		}
	
		echo $saldo;
		echo "";
		$saldo = $saldo + $monto;
		echo $saldo;


		#Se actualiza saldo
		$statement = $conexion->prepare("UPDATE tarjeta_cliente SET saldo = ? where id_cliente=? and num_cuenta=?");
		$statement->execute([$saldo,$usuario, $cuenta]);



		#Se crea registro deposito primero
		$statement = $conexion->prepare("INSERT INTO depositos_cliente (id_cliente,num_cuenta,cantidad_deposito, date_deposito,saldo_corte) 
			VALUES( ?,?,?,SYSDATE(),?)");
		$statement->execute([$usuario, $cuenta,$monto,$saldo]);


		header('Location: index.php');
	
	




?>