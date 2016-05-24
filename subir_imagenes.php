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
$instruccion="SELECT `Nombre`,`Nick`,`Entradas` FROM `usuarios` WHERE `Id_usuario`='$usuario'";
$resultado=mysqli_query($conexion,$instruccion);
$fila=mysqli_fetch_row($resultado);
echo "<div class='container-fluid title'>
		  <h3>".$fila[0]." (".$fila[1].")"."</h3>
		  <h4><font color='#FFF'>Cantidad de entradas a tu perfil: ".$fila[2]."</font></h4>
		  </div>";

function elimina(){
	require 'conexion.php';
	if(isset($_POST["cambio"])){
		$eliminado= $_POST["id_foto"];
		$instruccion = "DELETE FROM `fotografias` WHERE `Id_foto`='$eliminado'";
		$resultado = mysqli_query($conexion,$instruccion);
		$instruccion = "DELETE FROM `aparece` WHERE `Id_foto`='$eliminado'";
		$resultado = mysqli_query($conexion,$instruccion);
		$instruccion = "DELETE FROM `comentario` WHERE `Id_foto`='$eliminado'";
		$resultado = mysqli_query($conexion,$instruccion);
	}
		mysqli_close($conexion);
}	


function usuarios(){
	require 'conexion.php';
	$usuario=$_SESSION["usuario"];
	$instruccion="SELECT `Nombre`, `Descripcion`, `Id_Foto` FROM `fotografias` WHERE `Id_usuario`='$usuario'";
	$resultado=mysqli_query($conexion,$instruccion);
	while($fila=mysqli_fetch_row($resultado)){
		if($fila!=NULL){
		echo "<tr>";
		echo "<td>".$fila[0]."</td>";
		echo "<td>".$fila[1]."</td>";
		echo "<form action='subir_imagenes.php' method='post'>
				<input type='hidden' name='id_foto' value='$fila[2]'>
				<td><button class='btn btn-default' name='cambio'>"."Eliminar"."</button></td>
				</form></tr>";
		}
		}
	mysqli_close($conexion);
}
mysqli_close($conexion);
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
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>

	<div class="col-md-6">
		<div class="container-fluid">
			<h4>Subir una imagen</h4>
			<form action="subirimg.php" method="post" enctype="multipart/form-data">
		    	<input type="file" name="foto"><br>
		    	<input class="form-control" type="text" name="nombre" placeholder="Nombre" pattern="{1,20}" required><br>
		    	<textarea type="text" name="descripcion" rows="2" cols="75" placeholder="Descripcion"></textarea><br>
		    	<br><button class="btn btn-primary" name="imagen">Subir Fotos</button>
		    </form>
		</div>
	</div>
	<div class="col-md-6">
	<div class="container-fluid">
		<h4>Eliminar una Imagen</h4>
	<div class="panel panel-default">
		<table class= "table table-striped table-bordered">
			<tr>
				<div class= "panel-heading p"><center><h2>Fotos</h2></center></div>
			</tr>

			<tr>
				<th>Nombre</th>
				<th>Descripcion</th>
				<th>Eliminar</th>
			</tr>
			<?php elimina();
			usuarios(); ?>
		</table>
	</div>
</div>
</div>

</body>
</html>