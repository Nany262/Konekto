<?php

require 'conexion.php';

session_start();

if(!isset($_SESSION["usuario"])){
    session_destroy();
    header("Location: index.php");
}

//Errores ocurridos en la subida de la imagen
if ( ! isset($_FILES["foto"]) || $_FILES["foto"]["error"] > 0 ){
		header("Location: inicio.php");// envia de nuevo a la pagina inicio
} 
else {
    $permitidos = array("image/jpg", "image/jpeg", "image/gif", "image/png"); //Tipo de imagen permitida
    $limite_kb = 16384; //16mb es el limite de medium blob mysql

    if (in_array($_FILES['foto']['type'], $permitidos) && $_FILES['foto']['size'] <= $limite_kb * 1024){

        $nom=$_POST["nombre"];
        $desc=$_POST["descripcion"];
        $usuario=$_SESSION["usuario"];
        $imagen_temporal  = $_FILES['foto']['tmp_name']; //imagen
        $tipo = $_FILES['foto']['type'];//tipo de archivo
        //leer el archivo temporal en binario
        $fp     = fopen($imagen_temporal, 'r+b');
        $data = fread($fp, filesize($imagen_temporal));
        fclose($fp);
        //escapar los caracteres
        $data = mysqli_escape_string($conexion,$data);

    $instruccion="INSERT INTO `fotografias`(`Foto`, `Nombre`, `Descripcion`,`Id_usuario`) VALUES ('$data','$nom','$desc','$usuario')";
        $resultado = mysqli_query($conexion,$instruccion);
        if ($resultado){
            header("Location: subir_imagenes.php");// envia de nuevo a la pagina opcionimagen
        } else {
            header("Location: inicio.php?error=2");
        }
    }
    else {
        header("Location: inicio.php?error=2");
    }   
}
mysqli_close($conexion);
?>
