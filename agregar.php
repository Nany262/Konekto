<?php
require 'conexion.php';

session_start();

if(!isset($_SESSION["usuario"])){
	session_destroy();
	header("Location: index.php");
}

if(isset($_POST["agregar"])){
			$usuario_agrega=$_POST["usuario1"];
			$usuario_agregado=$_POST["usuario2"];
			$correo=$_POST["correo"];
			$instruccion="INSERT INTO `amigos`(`Id_usuario`, `Id_friend`) VALUES ('$usuario_agrega','$usuario_agregado')";
			$resultado=mysqli_query($conexion,$instruccion);
			echo $correo;
			header("Location: busqueda.php?correo=$correo");
			}
mysqli_close($conexion);
?>