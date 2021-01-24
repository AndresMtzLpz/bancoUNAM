<?php

$server = "localhost";
$user = "root";
$pass = "";
$bd = "bancoUNAM";

//Creamos la conexión
$conexion = mysqli_connect($server, $user, $pass,$bd) 
or die("Ha sucedido un error inexperado en la conexion de la base de datos");

//generamos la consulta
$sql = "SELECT datoscliente.id_cliente, datoscliente.nombre_cliente, datoscliente.A_Paterno_cliente, datoscliente.Telefono, datoscliente.edad_cliente,datoscliente.Email, tarjeta_cliente.num_cuenta FROM datoscliente left join tarjeta_cliente on datoscliente.id_cliente=tarjeta_cliente.id_cliente;";
mysqli_set_charset($conexion, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($conexion, $sql)) die();



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
	//$cantidad_deposito[$i] = $fila['cantidad_deposito'];
	//$date_deposito[$i] = $fila['date_deposito'];
	$i = $i +1;
	$num_columnas = $num_columnas +1 ;
	#$datos= print_r ($fila, true);
	#echo $fila[0];
	
}

    $sql2 = "SELECT nombre_admin from datosadmin where id_admin = $admin ";		
	$resultados2 = $conexion->query($sql2);
	foreach ($resultados2 as $fila) {
		$nombre_admin= $fila['nombre_admin']; 
	
		
	}
	


//desconectamos la base de datos
$close = mysqli_close($conexion) 
or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
  

//Creamos el JSON
//$clientes['clientes'] = $clientes;
$json_string = json_encode($fila);
//echo $json_string;
//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
	

?>