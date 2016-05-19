<!doctype <!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>Konekto</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="statics/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Orbitron:400,900' rel='stylesheet' type='text/css'>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</head>
<body>

<nav>
<ul>
	<li><a title="MPerfil" href="inicio.php">Mi Perfil</a></li>
	<li><a title="Cerrar" href="cerrar.php">Cerrar Sesión</a></li>
</ul>
</nav>

<?php
require 'conexion.php';
session_start();

if(!isset($_SESSION["usuario"])){
	session_destroy();
	header("Location: index.php");
}

$usuario=$_SESSION["usuario"];
$instruccion="SELECT `Nombre`,`Nick` FROM `usuarios` WHERE `Id_usuario`='$usuario'";
$resultado=mysqli_query($conexion,$instruccion);
$fila=mysqli_fetch_row($resultado);

echo "<h3>".$fila[0]."(".$fila[1].")"."</h3>";

if (isset($_POST["busca"])){

	$correo=$_POST["correo"];
	$instruccion="SELECT `Id_usuario`,`Nombre`,`Nick` FROM `usuarios` WHERE `Correo`='$correo'";
	$resultado=mysqli_query($conexion,$instruccion);
	$fila=mysqli_fetch_row($resultado);
	echo "<h3>".$fila[1]."(".$fila[2].")"."</h3>";
	if (sizeof($fila)==0){
		header("Location: inicio.php");// envia de nuevo a la pagina index
	}
	else{
		//Cargar las imagenes del usuario correspondiente
		echo "<img src='imagen.php?usuario=$fila[0]' alt='No se ha podido cargar la imagen'>";
	}
}


?>

</body>
</html>