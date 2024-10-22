<?php

function registrarLog($mensaje) {
    $logFile = '/tmp/debug.log'; // Ruta del archivo de log en /tmp
    $fecha = date('Y-m-d H:i:s'); // Fecha y hora actual
    $logMessage = "[$fecha] - $mensaje" . PHP_EOL;
    
    // Guardar el mensaje en el archivo log
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Configuración de la base de datos
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

    // Verificar si se recibió una solicitud POST para eliminar el partido
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['identificadorPartido'])) {
        $identificadorPartido = $_POST['identificadorPartido'];

        // Preparar la consulta para eliminar el partido
        $sql = "DELETE FROM PartidoFutbol WHERE identificadorPartido = :identificadorPartido";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':identificadorPartido', $identificadorPartido);

        if ($stmt->execute()) {
            registrarLog("Partido eliminado: ID $identificadorPartido");
            // Respuesta JSON de éxito
            echo json_encode(["status" => "success", "message" => "Partido eliminado exitosamente."]);
        } else {
            registrarLog("Error al eliminar el partido: " . json_encode($stmt->errorInfo()));
            // Respuesta JSON de error
            echo json_encode(["status" => "error", "message" => "Error al eliminar el partido."]);
        }
    } else {
        // Respuesta JSON si falta el identificador
        echo json_encode(["status" => "error", "message" => "No se recibió un identificador válido."]);
    }
} catch (PDOException $e) {
    registrarLog("Error de conexión o ejecución: " . $e->getMessage());
    // Respuesta JSON de error de conexión o ejecución
    echo json_encode(["status" => "error", "message" => "Error en la base de datos."]);
}
// Cerrar la conexión
$conn = null;
?>

