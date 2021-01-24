<?php session_start();

// Comprobamos tenga sesion, si no entonces redirigimos y MATAMOS LA EJECUCION DE LA PAGINA.
if (isset($_SESSION['usuario'])) {
	$usuario = $_SESSION['usuario']; #usuario = id_cliente
	try {
		$Tn = date('dmYGisu');
		//el nombre de la transaccion incluye dia, mes, año, hora, minuto, segundo y microsegundos
		//para que sea unica al momento de solicitarla
		#conexion con la Base de Datos
		$conexion = new PDO('mysql:host=localhost;dbname=bancoUNAM','root','')
		or die("Ha sucedido un error inexperado en la conexion de la base de datos");

		$clientes = array();
		#se hace una consulta de los datos del cliente y se almacenan los resultados
		$conexion->query("set transaction isolation level serializable name $Tn;");
		$sql = "SELECT datoscliente.nombre_cliente, datoscliente.id_cliente,tarjeta_cliente.num_cuenta, depositos_cliente.saldo_corte, 
			depositos_cliente.cantidad_deposito, depositos_cliente.date_deposito 
			FROM datoscliente JOIN depositos_cliente 
				ON datoscliente.id_cliente = depositos_cliente.id_cliente
			JOIN tarjeta_cliente
				ON tarjeta_cliente.id_cliente = depositos_cliente.id_cliente
			where datoscliente.id_cliente = $usuario 
			and depositos_cliente.num_cuenta = tarjeta_cliente.num_cuenta
			order by depositos_cliente.date_deposito  
			";

		$i = 0;
		$num_columnas =0;
		$resultados = $conexion->query($sql);
		foreach ($resultados as $fila) {
			$nombre_usuario= $fila['nombre_cliente']; #Este dato no es un array
			$id_cliente[$i] = $fila['id_cliente'];
			$num_cuenta[$i] = $fila['num_cuenta'];
			$saldo[$i] = $fila['saldo_corte'];
			$cantidad_deposito[$i] = $fila['cantidad_deposito'];
			$date_deposito[$i] = $fila['date_deposito'];
			$i = $i +1;
			$num_columnas = $num_columnas +1 ;
			#$datos= print_r ($fila, true);
			#echo $fila[0];
			
		}

		$conexion->query("commit and chain;"); //Indica que la transacción fue consumada.


		
	} catch (PDOException $e) {
		echo "Error:" . $e->getMessage();
		$conexion->query("rollback work and chain;"); //Indica que la transacción fue abortada.
	}
		require 'views/cliente.view.html';
//Creamos el JSON
//$clientes['clientes'] = $clientes;
$json_string = json_encode($clientes);
//echo $json_string;
//echo $conexion;
} else {
	header('Location: login.php');
	die();
}


?>