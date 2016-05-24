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
<body background-color="#616161">

<?php

require 'conexion.php';

session_start();

if(!isset($_SESSION["usuario"])){
	session_destroy();
	header("Location: index.php");
}

$usuario=$_SESSION["usuario"];
$instruccion="SELECT `Nombre`,`Nick`,`Entradas`, `Correo` FROM `usuarios` WHERE `Id_usuario`='$usuario'";
$resultado=mysqli_query($conexion,$instruccion);
$fila=mysqli_fetch_row($resultado);

echo "<div class='container-fluid title'>
		  <h3>".$fila[0]." (".$fila[1].")"."</h3>
		  <h4><font color='#FFF'>Cantidad de entradas a tu perfil: ".$fila[2]."</font></h4>
		  </div>";
?>
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      	<li><a title="Perfil" href="inicio.php">Perfil</a></li>
        <li><a title="Amigos" href="amigos.php">Lista de Amigos</a></li>
        <li><a title="Aparece" href="etiquetas.php">Etiquetas</a></li>
        <li><a title="Subir" href="subir_imagenes.php">Opciones Imagen</a></li>
      </ul>
      <form action="busqueda.php" method="GET" class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input class= "form-control" type="email" name="correo" placeholder="Buscar personas">
        </div>
        <button class="btn btn-default" name="busca">Buscar</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
      	<li><a title="Actualizar" href="actualizar.php">Actualizar Datos</a></li>
        <li><a title="Cerrar" href="cerrar.php">Cerrar Sesión</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="row">
	<div class="col-md-5">
		<div class="container-fluid">
			<h6><font color="#9C27B0">Actualizar</font></h6>
			<h4>Nombre: </h4>
			<form class="form-inline" action="actualizar.php" method="post">
				<div class="form-group">
					<input class="form-control" type="text" name="nombre" placeholder="Nombre" pattern="[a-zA-Z]{1,20}" required title="No se permiten caracteres numericos">
					<button class="btn btn-default" name="actualiza1">Actualizar</button>
				</div>
			</form>
			<h4>Nick: </h4>
			<form class="form-inline" action="actualizar.php" method="post">
				<div class="form-group">
					<input class="form-control" type="text" name="nick" placeholder="Nick" pattern="[a-zA-Z0-9]{1,10}" required title="Maximo 10 caracteres">
					<button class="btn btn-default" name="actualiza2">Actualizar</button>
				</div>
			</form>
			<h4>Correo: </h4>
			<form class="form-inline" action="actualizar.php" method="post">
				<div class="form-group">
					<input class="form-control" type="email" name="correo" placeholder="Correo Electronico" pattern="{1,}" required>
					<button class="btn btn-default" name="actualiza3">Actualizar</button>
				</div>
			</form>
		</div>
	</div>
	<div class="col-md-3">
		<div class="container-fluid">
			<h6><font color="#9C27B0">Datos Actuales</font></h6>
			<h4>Nombre: </h4><?php echo $fila[0] ?>
			<h4>Nick: </h4><?php echo $fila[1] ?>
			<h4>Correo: </h4><?php echo $fila[3]?>
		</div>
	</div>
</div>

<?php
if(isset($_POST["actualiza1"])){
	$nom=$_POST["nombre"];
	$instruccion="UPDATE `usuarios` SET `Nombre`='$nom' WHERE `Id_usuario`='$usuario'";
	$resultado=mysqli_query($conexion,$instruccion);
	header("Location: actualizar.php");

}

if(isset($_POST["actualiza2"])){
	$nick=$_POST["nick"];
	$instruccion="UPDATE `usuarios` SET `Nick`='$nick' WHERE `Id_usuario`='$usuario'";
	$resultado=mysqli_query($conexion,$instruccion);
	header("Location: actualizar.php");
}

if(isset($_POST["actualiza3"])){
	$correo=$_POST["correo"];
	$instruccion="UPDATE `usuarios` SET `Correo`='$correo' WHERE `Id_usuario`='$usuario'";
	$resultado=mysqli_query($conexion,$instruccion);
	header("Location: actualizar.php");
}
?>
</body>
</html>