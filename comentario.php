<?php

require 'conexion.php';
session_start();

if(!isset($_SESSION["usuario"])){
	session_destroy();
	header("Location: index.php");
}


if (isset($_GET["enviar"])){
	$usuario=$_SESSION["usuario"];
	$correo=$_GET["correo"];
	$texto=$_GET["comentario"];
	$filafoto=$_GET["filafoto"];

	$instruccion="SELECT `Id_usuario` FROM `usuarios` WHERE `Correo`='$correo'";
	$resultado=mysqli_query($conexion,$instruccion);
	$filaaux=mysqli_fetch_row($resultado);

	if ($filaaux!=NULL){
		$instruccion="INSERT INTO `comentarios`(`Texto`, `Id_usuario`, `Id_receptor`, `Id_Foto`) VALUES ('$texto','$usuario','$filaaux[0]','$filafoto')";
			$resultado=mysqli_query($conexion,$instruccion);
			header("Location: busqueda.php?correo=$correo");
	}
	else{
		header("Location: inicio.php");
	}	
}
mysqli_close($conexion);
?>