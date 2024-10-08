<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Encriptación</title>
</head>
<body>
    <?php
    // Verificar si se recibió el texto a encriptar
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['texto'])) {
        $texto = $_POST['texto']; // Obtener el texto ingresado

        // Encriptar el texto usando md5 y sha256
        $md5_encrypted = md5($texto);
        $sha256_encrypted = hash('sha256', $texto);
    ?>
        <h2>Resultados de Encriptación:</h2>
        <p>Clave original: <?php echo htmlspecialchars($texto); ?></p>
        <p>Clave encriptada en MD5 (128 bits o 16 pares hexadecimales): <?php echo $md5_encrypted; ?></p>
        <p>Clave encriptada en SHA-256 (256 bits o 32 pares hexadecimales): <?php echo $sha256_encrypted; ?></p>
    <?php
    } else {
        echo "<p>No se ha proporcionado ningún texto para encriptar.</p>";
    }
    ?>
</body>
</html>
