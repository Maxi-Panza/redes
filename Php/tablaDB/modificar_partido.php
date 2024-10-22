<?php
// Conexión a la base de datos
$dsn = 'mysql:host=localhost;dbname=futbol;charset=utf8mb4';
$username = 'root'; // Cambia esto si tienes otro usuario
$password = ''; // Cambia esto si tienes contraseña
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Modo de errores como excepciones
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Modo de obtención de datos
];
try {
    // Conectar a la base de datos usando PDO
    $pdo = new PDO($dsn, $username, $password, $options);

    // Obtener el partido a modificar
    $identificadorPartido = $_GET['identificadorPartido'];
    $sql = "SELECT * FROM PartidoFutbol WHERE identificadorPartido = :identificadorPartido";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':identificadorPartido', $identificadorPartido);
    $stmt->execute();
    $partido = $stmt->fetch();

} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Partido</title>
</head>
<body>
    <h1>Modificar Partido</h1>
    <form action="guardar_modificacion.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="identificadorPartido" value="<?= htmlspecialchars($partido['identificadorPartido']); ?>">

        <label for="descripcion">Descripción:</label>
        <input type="text" name="descripcion" value="<?= htmlspecialchars($partido['descripcion']); ?>" required><br>

        <label for="estadio_id">Estadio:</label>
        <input type="text" name="estadio_id" value="<?= htmlspecialchars($partido['estadio_id']); ?>" required><br>

        <label for="golesTotales">Goles Totales:</label>
        <input type="number" name="golesTotales" value="<?= htmlspecialchars($partido['golesTotales']); ?>" required><br>

        <label for="fechaPartido">Fecha del Partido:</label>
        <input type="date" name="fechaPartido" value="<?= htmlspecialchars($partido['fechaPartido']); ?>" required><br>

        <label for="resumen">Actualizar Resumen (opcional):</label>
        <input type="file" name="resumen" accept=".pdf, .jpg, .jpeg, .png"><br>

        <button type="submit">Guardar Cambios</button>
    </form>
</body>
</html>
