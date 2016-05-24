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
$instruccion="SELECT `Nombre`,`Nick`,`Activo/Inactivo`,`Entradas` FROM `usuarios` WHERE `Id_usuario`='$usuario'";
$resultado=mysqli_query($conexion,$instruccion);
$fila=mysqli_fetch_row($resultado);

if($usuario==7){
	header("Location: administrador.php");
}
if($fila[2]==1){
	echo "<div class='container-fluid title'>
		  <h3>".$fila[0]." (".$fila[1].")"."</h3>
		  <h4><font color='#FFF'>Cantidad de entradas a tu perfil: ".$fila[3]."</font></h4>
		  </div>";

	$instruccion = "SELECT `Id_Foto`, `Nombre` FROM fotografias WHERE Id_usuario='$usuario'";
	$resultado=mysqli_query($conexion,$instruccion);
	$size=sizeof($fila);
	$i=cambiaid($size);
	mysqli_data_seek($resultado,$i);
	$fila=mysqli_fetch_row($resultado);

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

	<div class="row">
		<div class="col-md-3">
			<div class="container-fluid">
			<h4>Etiquetar en esta foto</h4>
				<form action="etiquetas.php" method="post">
					<div class="form group">
						<input class= "form-control" type="email" name="persona" placeholder="Persona" required>
						<input type='hidden' name='foto' value=<?php echo $fila[0] ?>>
			    		<br><button class="btn btn-primary" name="etiqueta">Etiquetar</button>
			    	</div>
			    </form>
			</div>
			<div class="container-fluid">
				<h4>Etiquetados</h4>
				<?php
					$instruccion="SELECT `Id_etiquetado` FROM `aparece` WHERE `Id_Foto`='$fila[0]'";
					$resultado=mysqli_query($conexion,$instruccion);
					if($resultado!=NULL){
						while ($etiquetados=mysqli_fetch_row($resultado)) {
							$instruccion="SELECT `Nombre`, `Nick` FROM `usuarios` WHERE `Id_usuario`='$etiquetados[0]'";
							$resultadoet=mysqli_query($conexion,$instruccion);
							$aparece=mysqli_fetch_row($resultadoet);
							echo "<h5>".$aparece[0]."(".$aparece[1].")</h5>";
						}
					}
				?>
			</div>
			<div class="container-fluid">
				<h4>Comentarios</h4>
				<?php
						$instruccion="SELECT `Texto`, `Id_usuario` FROM `comentarios` WHERE `Id_Foto`='$fila[0]' and `Id_receptor`='$usuario'";
						$resultado=mysqli_query($conexion,$instruccion);
						if($resultado!=NULL){
							while($comentar=mysqli_fetch_row($resultado)){
								$instruccion="SELECT `Nombre`, `Nick` FROM `usuarios` WHERE `Id_usuario`='$comentar[1]'";
								$resultadocom=mysqli_query($conexion,$instruccion);
								$comento=mysqli_fetch_row($resultadocom);
								echo "<h5>".$comento[0]."(".$comento[1].")</h5>".$comentar[0];
							}
						}
				?>
			</div>
		</div>

	<div class='col-md-9'>
			<div class='container-fluid'>
				<form action='inicio.php' method='post'>
					<button class='btn btn-primary' name='anterior'>Anterior</button>
	    			<button class='btn btn-primary' name='siguiente'>Siguiente</button>
	    			<input type='hidden' name='i' value=<?php echo $i ?>>
	    		</form>
<?php
	
	if($fila!=NULL){
	echo "<center><h4>".$fila[1]."</h4></center>".
		  "<center><img src='imagen.php?id=$fila[0] width='900' height='540'></center>
			</div>
		</div>
	</div>";
	}
	else
	{
		echo "<br><center><h4>No has subido ninguna foto</h4></center></div>";
	}
}
else
	{echo "<div class='container-fluid title'>
		  <h3><font color=''>".$fila[0]." (".$fila[1].")"."</font></h3><br>
		  </div><br>";
	echo "<div class='container'>
			<div class='panel panel-default'>
				<table class= 'table table-striped table-bordered'>
				<tr>
					<div class= 'panel-heading p'><center><h2>Error de Login</h2></center></div>
				</tr>";
	echo"<tr><p><br>Querido usuario:<br>Esta notificacion le informa que su cuenta ha sido inhabilitada en Konekto, para quejas o reclamos porfavor contactarse con el equipo de desarrollo</p></tr>";
	echo"<tr><br><center><a href='index.php'>Volver</center><br></tr>";}

mysqli_close($conexion);
?>
</body>
</html>