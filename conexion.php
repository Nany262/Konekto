<?php
//Datos necesarios para conectar la base de datos con php
	$db_host="localhost";
	$db_nombre="konekto";
	$db_usuario="root";
	$db_password="";

//Funcion que realiza la conexion y su respectivo error si no se logra la conexion 
	$conexion=mysqli_connect($db_host,$db_usuario,$db_password,$db_nombre);
	if (mysqli_connect_errno()){
		echo "No se puede conectar";
		exit();
	}
?>