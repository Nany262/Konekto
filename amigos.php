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
		  
mysqli_close($conexion);
	?>

	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <!-- Collect the nav links, forms, and other content for toggling -->
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

<?php


function elimina(){
	require 'conexion.php';
	if(isset($_POST["cambio"])){
		$eliminado= $_POST["id_usuario"];
		$instruccion = "DELETE FROM `amigos` WHERE `Id_friend`='$eliminado'";
		$resultado = mysqli_query($conexion,$instruccion);
	}
		mysqli_close($conexion);
}	


function usuarios(){
	require 'conexion.php';
	$usuario=$_SESSION["usuario"];
	$instruccion="SELECT `Nombre`, `Nick`, `Correo`,`Id_usuario` FROM `usuarios` WHERE `Id_usuario` IN (SELECT `Id_friend` FROM `amigos` WHERE `Id_usuario`= '$usuario')";
	$resultado=mysqli_query($conexion,$instruccion);
	while($fila=mysqli_fetch_row($resultado)){
		if($fila!=NULL){
		echo "<tr>";
		echo "<td>".$fila[0]."</td>";
		echo "<td>".$fila[1]."</td>";
		echo "<td>".$fila[2]."</td>";
		echo "<form action='amigos.php' method='post'>
				<input type='hidden' name='id_usuario' value='$fila[3]'>
				<td><button class='btn btn-default' name='cambio'>"."Eliminar"."</button></td>
				</form></tr>";
		}
		}
	mysqli_close($conexion);
}

?>

<div class="container">
<div class="panel panel-default">
		<table class= "table table-striped table-bordered">
			<tr>
				<div class= "panel-heading p"><center><h2>Amigos</h2></center></div>
			</tr>

			<tr>
				<th>Nombre</th>
				<th>Nick</th>
				<th>Correo</th>
				<th>Estado</th>
			</tr>
			<?php elimina();
			usuarios(); ?>
		</table>
	</div>
</div>

</body>
</html>