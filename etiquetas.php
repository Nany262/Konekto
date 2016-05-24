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

function cambiaid($size){
		if(isset($_POST["anterior"])){
			$i=$_POST["i"];
			if($i>0){
				$i=$i-1;
			}
		}
		if(isset($_POST["siguiente"])){
			$i=$_POST["i"];
			if($i<$size){
				$i=$i+1;
			}
		}
		if(!isset($_POST["anterior"]) and !isset($_POST["siguiente"])){
			$i=0;
		}
		return $i;
	}

$usuario=$_SESSION["usuario"];
$instruccion="SELECT `Nombre`,`Nick`,`Entradas` FROM `usuarios` WHERE `Id_usuario`='$usuario'";
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
	        <li><a title="Cerrar" href="cerrar.php">Cerrar Sesión</a></li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

<?php
if(isset($_POST["etiqueta"])){
	$correo=$_POST["persona"];
	$foto=$_POST["foto"];

	$instruccion="SELECT `Id_usuario` FROM `usuarios` WHERE `Correo`='$correo'";
	$resultado=mysqli_query($conexion,$instruccion);
	$fila=mysqli_fetch_row($resultado);

	if($fila!=NULL){
		$instruccion="INSERT INTO `aparece`(`Id_usuario`, `Id_foto`,`Id_etiquetado`) VALUES ('$usuario','$foto','$fila[0]')";
		$resultado=mysqli_query($conexion,$instruccion);
		header("Location: inicio.php");
	}
	else{
		header("Location: inicio.php");
	}
}
else{

	$instruccion = "SELECT `Id_Foto`, `Id_usuario` FROM `aparece` WHERE Id_etiquetado='$usuario'";
	$resultado=mysqli_query($conexion,$instruccion);
	$size=sizeof($fila);
	$i=cambiaid($size);
	mysqli_data_seek($resultado,$i);
	$fila=mysqli_fetch_row($resultado);

?>
	<div class='container-fluid'>
		<form action='etiquetas.php' method='post'>
			<center><button class='btn btn-primary' name='anterior'>Anterior</button>
			<button class='btn btn-primary' name='siguiente'>Siguiente</button></center>
			<input type='hidden' name='i' value=<?php echo $i ?>>
		</form>
<?php
	if($fila!=NULL){
		$instruccion="SELECT `Nombre`, `Nick` FROM `usuarios` WHERE `Id_usuario`='$fila[1]'";
		$resultado=mysqli_query($conexion,$instruccion);
		$filaet=mysqli_fetch_row($resultado);
		echo "<center><h4>Etiquetador por: ".$filaet[0]."(".$filaet[1].")";
		echo "<center><img src='imagen.php?id=$fila[0] width='900' height='540'></center></div>";
	}
	else{	
		echo "<br><center><h4>No has sido etiquetado aún en alguna foto</h4></center></div>";
	}
}
mysqli_close($conexion);
?>
</body>
</html>
