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
<body background="fondo.png">

<?php
//Datos necesarios para conectar la base de datos con php
	$db_host="localhost";
	$db_nombre="konekto";
	$db_usuario="root";
	$db_password="";

//Funcion que realiza la conexion y su respectivo error si no se logra la conexion 
	$conexion=mysqli_connect($db_host,$db_usuario,$db_password,$db_nombre);
	if (mysqli_connect_errno()){
		echo "No se puede conectar";
		exit();
	}
?>

<div class="container-fluid title">
<h1><font color="">Konekto</font></h1><br>
</div>

<div class="container"> 
<h2>Iniciar sesión</h2>
<form action="inicio.php" method="post">
	<label><input class= "form-control" type="email" name="correo" placeholder="Correo Electronico"></label><br>
	<label><input class= "form-control" type="password" name="pass" placeholder="Contraseña"></label><br>
	<br><button class="btn btn-primary" name="datos">Entrar</button>
	</form>
</div>

<!--Formulario Registro de usuario-->
<div class="container">
<h2>Registrarse</h2>
<form action ="index.php" method="post">
	<label><input class="form-control" type="email" name="correoreg" placeholder="Correo Electronico"></label><br>
	<label><input class="form-control" type="text" name="nombre" placeholder="Nombre"></label><br>
	<label><input class="form-control" type="text" name="nick" placeholder="Nick"></label><br>
	<label><input class="form-control" type="password" name="passreg" placeholder="Contraseña"></label><br>
	<br><button class="btn btn-primary" name="registro">Registrarse</button>
</div>
<?php

if (isset($_POST["registro"])){
//Toma los datos del formulario registro creado en html y los guarda en variables para manejarlos en php
	$correo=isset($_POST["correoreg"]);
	$nom=$_POST["nombre"];
	$nick=$_POST["nick"];
	$pass=$_POST["passreg"];
//Instruccion de verificacion y consulta
	if ($correo!=" "){
		if($nom!=" "){
			if($nick!=" "){
				if($pass!=" "){
					$instruccion="INSERT INTO `usuarios`(`Activo/Inactivo`, `Correo`, `Nombre`, `Nick`, `Clave`) VALUES (1,'$correo','$nom','$nick','$pass')";
					$resultado=mysqli_query($conexion,$instruccion);
				}
			}
		}
	}
}

?>

</body>
</html>