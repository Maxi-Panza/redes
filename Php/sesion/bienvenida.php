<?php
session_start();

// Verificar si hay una sesión activa
if (!isset($_SESSION['ejer08idsesion'])) {
    header('Location: ./formularioDeLogin.php');
    exit();
}

// Obtener la información de la sesión
$identificacionSesion = $_SESSION['ejer08idsesion'];
$usuario = $_SESSION['login'];
$contadorSesion = $_SESSION['contador'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenida</title>
</head>
<body>
    <h1>Acceso permitido</h1>
    <p><strong>Identificación de sesión:</strong> <?php echo $identificacionSesion; ?></p>
    <p><strong>Usuario:</strong> <?php echo $usuario; ?></p>
    <p><strong>Contador de sesión para este usuario:</strong> <?php echo $contadorSesion; ?></p>

    <p><button onClick="location.href='./index.php'">Ingresar a la aplicación</button></p>
    <p><button onClick="location.href='./destruirsesion.php'">Terminar sesión</button></p>
</body>
</html>
