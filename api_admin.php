<?php 
try {
	$Tn = date('dmYGisu');
	//el nombre de la transaccion incluye dia, mes, año, hora, minuto, segundo y microsegundos para que sea unica al momento de solicitar la conexion a BD

	//Creamos la conexión

	$conexion = new PDO('mysql:host=localhost;dbname=bancoUNAM','root','')
	or die("Ha sucedido un error inexperado en la conexion de la base de datos");

	#se hace una consulta de los datos del cliente y se almacenan los resultados
	//Se utiliza el identificador único
	$conexion->query("set transaction isolation level serializable name $Tn;");
	//generamos la consulta
	$sql = "SELECT datoscliente.id_cliente, datoscliente.nombre_cliente, 
		datoscliente.A_Paterno_cliente, datoscliente.Telefono, datoscliente.edad_cliente,
		datoscliente.Email, tarjeta_cliente.num_cuenta 
		FROM datoscliente left join tarjeta_cliente 
		on datoscliente.id_cliente=tarjeta_cliente.id_cliente;";


	if(!$result =$conexion->query($sql)) die();

	//Variables para recorrer la lista del query
	$clientes = array();
	$i = 0;
	$num_columnas =0;
	$resultados = $conexion->query($sql);
		foreach ($resultados as $fila) {
			$nombre_cliente[$i]= $fila['nombre_cliente']; 
			$apellidoP_cliente[$i]= $fila['A_Paterno_cliente'];
			$id_cliente[$i] = $fila['id_cliente'];
			$telefono[$i] = $fila['Telefono'];
			$email[$i] = $fila['Email'];
			$edad_cliente[$i]= $fila['edad_cliente'];
			$num_cuenta[$i]= $fila['num_cuenta'];
			$i = $i +1;
			$num_columnas = $num_columnas +1 ;

	//Se insertan los datos dentro de clientes para colocarlo en JSON
			$clientes[$i] = array('nombre_cliente' => $nombre_cliente,
				'A_Paterno_cliente' => $apellidoP_cliente,
				'id_cliente'=>  $id_cliente,
				'Telefono' => $telefono,
				'Email' => $email,
				'edad_cliente' => $edad_cliente,
				'num_cuenta'=> $num_cuenta);
			
		}

	$sql2 = "SELECT nombre_admin from datosadmin where id_admin = $admin ";		
	$resultados2 = $conexion->query($sql2);
		foreach ($resultados2 as $fila) {
			$nombre_admin= $fila['nombre_admin']; 	
		}


	


} catch (PDOException $e) {
	echo "Error:" . $e->getMessage();
	$conexion->query("rollback work and chain;"); //Indica que la transacción fue abortada.
	
	$logFile = fopen("log.txt", 'a') or die("Error creando archivo");
	fwrite($logFile, "\n".date("d/m/Y H:i:s").$e."\n") or die("Error escribiendo en el archivo");fclose($logFile);

}

		  

//Creamos el JSON
//$clientes['clientes'] = $clientes;
$json_string = json_encode($clientes[$num_columnas - 1]);
echo $json_string;
//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/

$logFile = fopen("log.txt", 'a') or die("Error creando archivo");
fwrite($logFile, "\n".date("d/m/Y H:i:s").json_encode($clientes[$num_columnas - 1])."\n") or die("Error escribiendo en el archivo");fclose($logFile);

?>