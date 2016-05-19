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

?>

<nav>
<ul>
	<li><a title="Perfil" href="inicio.php">Perfil</a></li>
	<li><a title="Amigos" href="#">Lista de Amigos</a></li>
	<li><a title="Aparece" href="#">Etiquetas</a></li>
	<li><a title="Cerrar" href="cerrar.php">Cerrar Sesión</a></li>
</ul>
</nav>

<form action="busqueda.php" method="post">
	<label><input class= "form-control" type="email" name="correo" placeholder="Buscar personas"></label>
	<button class="btn btn-primary" name="busca">Buscar</button>
</form>

<form action="subirimg.php" method="post" enctype="multipart/form-data">
    <input type="file" name="foto"><br>
    <label><input class="form-control" type="text" name="nombre" placeholder="Nombre" pattern="{1,20}" required></label><br>
    <label><textarea type="text" name="descripcion" placeholder="Descripcion"></textarea></label><br>
    <br><button class="btn btn-primary" name="imagen">Subir Fotos</button>
    </form>


<?php
//Cargar las imagenes del usuario correspondiente
echo "<img src='imagen.php?usuario=$usuario' alt='No se ha podido cargar la imagen'>"
?>

</body>
</html>