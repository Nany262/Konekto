<!doctype <!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
	<title>Konekto</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="statics/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="style.css" rel="stylesheet">
	<link href='https://fonts.googleapis.com/css?family=Orbitron:400,900' rel='stylesheet' type='text/css'>
</head>
<body>
<?php
require 'conexion.php';
session_start();

if(!isset($_SESSION["usuario"])){
	session_destroy();
	header("Location: index.php");
}

//Cabecera
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

function amigos($fila){
	require 'conexion.php';
	$usuario=$_SESSION["usuario"];
	$instruccion = "SELECT `Id_friend` FROM amigos WHERE Id_usuario='$usuario'";
	$resultado=mysqli_query($conexion,$instruccion);
	//$fila=mysqli_fetch_row($resultado);
	$tmp=0;
	while($filaf=mysqli_fetch_row($resultado)){
		if($filaf[0]==$fila[0]){
			$tmp=1;
			return ($tmp);
		}
	}
}

function cambiaid($size){
		if(isset($_GET["anterior"])){
			$i=$_GET["i"];
			if($i>0){
				$i=$i-1;
			}
		}
		if(isset($_GET["siguiente"])){
			$i=$_GET["i"];
			if($i<$size){
				$i=$i+1;
			}
		}
		if(!isset($_GET["anterior"]) and !isset($_GET["siguiente"])){
			$i=0;
		}
		return $i;
	}

$correo=$_GET["correo"];
$instruccion="SELECT `Id_usuario`,`Nombre`,`Nick` FROM `usuarios` WHERE `Correo`='$correo'";
$resultado=mysqli_query($conexion,$instruccion);
$fila=mysqli_fetch_row($resultado);
if ($fila!=NULL){
	echo "<div class='container-fluid'>
			<div class='row'>
				<div class='col-md-9 border'>
				<h6>".$fila[1]." (".$fila[2].")"."</h6><br></div>
				";		
	if(amigos($fila)==0){
		echo"<div class='col-md-3'>
			<form action='agregar.php' method='post'>
					<input type='hidden' name='usuario1' value='$usuario'>
					<input type='hidden' name='usuario2' value='$fila[0]'>
					<input type='hidden' name='correo' value='$correo'>
					<button class='btn btn-primary' name='agregar'>Agregar como amigo</button>
				</form></div>
			</div>
		</div>";
	}


$instruccion = "SELECT `Id_Foto`,`Nombre`,`Descripcion` FROM fotografias WHERE Id_usuario='$fila[0]'";
$resultado=mysqli_query($conexion,$instruccion);
$size=sizeof($fila);
$i=cambiaid($size);
mysqli_data_seek($resultado,$i);
$filafoto=mysqli_fetch_row($resultado);
echo "<div class='row'>
		<div class='col-md-9'>
			<div class='container'>
				<form action='busqueda.php' method='get'>
					<button class='btn btn-primary' name='anterior'>Anterior</button>
					<button class='btn btn-primary' name='siguiente'>Siguiente</button>
					<input type='hidden' name='correo' value='$correo'>
					<input type='hidden' name='i' value=$i>
				</form>
				<h4>".$filafoto[1]."</h4>
				<img src='imagen.php?id=$filafoto[0]' width='900' height='540'>
			</div>
		</div>";
	
}
else{
	header("Location: inicio.php");
}

/*if (isset($_GET["enviar"])){
	$correo=$_GET["correo"];
	$texto=$_GET["comentario"];

	$instruccion="SELECT `Id_usuario` FROM `usuarios` WHERE `Correo`='$correo'";
	$resultado=mysqli_query($conexion,$instruccion);
	$filaaux=mysqli_fetch_row($resultado);

	if ($filaaux!=NULL){
		$instruccion="INSERT INTO `comentarios`(`Texto`, `Id_usuario`, `Id_receptor`, `Id_Foto`) VALUES ('$texto','$usuario','$filaaux[0]','$filafoto[0]')";
			$resultado=mysqli_query($conexion,$instruccion);
	}
	else{
		echo "<div class='container'><font size=3>No se pudo enviar su comentario</font></div>";
	}	
}*/
?>
					<div class='col-md-3'>
						<h4><br>Descripción<br></h4>
						<?php
							echo $filafoto[2];
						?>
						<h4><br>Envia un comentario<br></h4>
						<form action="comentario.php" method="get">
			    			<textarea type="text" name="comentario" rows="3" cols="35" placeholder="Escribe un comentario..." required></textarea><br>
			    			<input type="hidden" name="correo" value=<?php echo $correo ?> >
			    			<input type="hidden" name="filafoto" value=<?php echo $filafoto[0] ?> >
			    			<br><button class="btn btn-primary" name="enviar">Enviar</button>
						</form>
						<h4><br>Comentarios<br></h4>
						<?php
							$instruccion="SELECT `Texto`, `Id_usuario` FROM `comentarios` WHERE `Id_Foto`='$filafoto[0]' and `Id_receptor`='$fila[0]'";
							$resultado=mysqli_query($conexion,$instruccion);
							if($resultado!=NULL){
								while($comentar=mysqli_fetch_row($resultado)){
									$instruccion="SELECT `Nombre`, `Nick` FROM `usuarios` WHERE `Id_usuario`='$comentar[1]'";
									$resultadocom=mysqli_query($conexion,$instruccion);
									$comento=mysqli_fetch_row($resultadocom);
									echo "<h5>".$comento[0]."(".$comento[1].")</h5>".$comentar[0];
								}
							}
							mysqli_close($conexion);
						?>
				</div>
			</div>
</body>
</html>