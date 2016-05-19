<?php
require 'conexion.php';
   
session_start();

if(!isset($_SESSION["usuario"])){
	session_destroy();
	header("Location: index.php");
}
$usuario=$_GET['usuario'];
$instruccion = "SELECT `Foto` FROM fotografias WHERE Id_usuario='$usuario'";
//con mysql_query la ejecutamos en nuestra base de datos indicada anteriormente
//de lo contrario mostraremos el error que ocaciono la consulta y detendremos la ejecucion.
$resultado= mysqli_query($conexion,$instruccion) or die(mysqli_error());

//ruta va a obtener un valor parecido a "imagenes/nombre_imagen.jpg" por ejemplo
while($datos = mysqli_fetch_assoc($resultado)){
	$imagen = $datos['Foto'];
	echo $imagen;
	}
?>