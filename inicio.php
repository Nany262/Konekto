<!doctype <!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>Konekto</title>
</head>
<body>

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

<?php

//CONFIRMACION DE QUE EL USUARIO ESTE EN LA BASE DE DATOS

if (isset($_POST["datos"])){
//Toma los datos del formulario creado en html y los guarda en variables para manejarlos en php
	$correo=$_POST["correo"];
	$pass=$_POST["pass"];
//Instruccion de verificacion y consulta
	$instruccion="SELECT `Correo`,`Clave` FROM `usuarios` WHERE `Correo`='$correo' and `Clave`='$pass'";
	$resultado=mysqli_query($conexion,$instruccion);
	$fila=mysqli_fetch_row($resultado);
//Si en la base de datos no existe el usuario se devuelve a la pagina de index.php
	if (sizeof($fila)==0){
		session_destroy(); //cancela procesos
		header("Location: http://localhost/Konekto/index.php");// envia de nuevo a la pagina index
	}
	else
		{echo ":P";}
}

?>

</body>
</html>