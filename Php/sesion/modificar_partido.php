<?php
header('Content-Type: application/json');

// Función para registrar logs en /tmp/debug.log
function registrarLog($mensaje) {
    $logFile = '/tmp/debug.log';
    $fecha = date('Y-m-d H:i:s');
    $logMessage = "[$fecha] - $mensaje" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Configuración de la base de datos
$dsn = 'mysql:host=localhost;dbname=futbol;charset=utf8mb4';
$username = 'root';
$password = '';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['identificadorPartido'])) {
        $identificadorPartido = $_POST['identificadorPartido'];
        $descripcion = $_POST['descripcion'];
        $estadio_id = $_POST['estadio_id'];
        $golesTotales = $_POST['golesTotales'];
        $fechaPartido = $_POST['fechaPartido'];

        registrarLog("Modificación iniciada para identificadorPartido: $identificadorPartido");
        registrarLog("Estadio seleccionado para modificar: $estadio_id");

        // Verificar si se sube un nuevo archivo "resumen"
        if (isset($_FILES['resumen']) && $_FILES['resumen']['error'] === 0) {
            $fileTmpName = $_FILES['resumen']['tmp_name'];
            $fileData = file_get_contents($fileTmpName);

            registrarLog("Archivo recibido para resumen, tamaño: " . strlen($fileData) . " bytes");

            $sql = "UPDATE PartidoFutbol SET descripcion = :descripcion, estadio_id = :estadio_id, 
                    golesTotales = :golesTotales, fechaPartido = :fechaPartido, resumen = :resumen 
                    WHERE identificadorPartido = :identificadorPartido";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':resumen', $fileData, PDO::PARAM_LOB);
            registrarLog("Actualizando el partido con el archivo resumen.");
        } else {
            // Si no se sube un archivo nuevo, no se modifica el campo 'resumen'
            $sql = "UPDATE PartidoFutbol SET descripcion = :descripcion, estadio_id = :estadio_id, 
                    golesTotales = :golesTotales, fechaPartido = :fechaPartido 
                    WHERE identificadorPartido = :identificadorPartido";
            $stmt = $pdo->prepare($sql);

            registrarLog("Actualizando el partido sin modificar el archivo resumen.");
        }

        // Asignar los parámetros comunes
        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':estadio_id', $estadio_id, PDO::PARAM_STR);
        $stmt->bindParam(':golesTotales', $golesTotales, PDO::PARAM_INT);
        $stmt->bindParam(':fechaPartido', $fechaPartido);
        $stmt->bindParam(':identificadorPartido', $identificadorPartido, PDO::PARAM_STR);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            registrarLog("Partido modificado exitosamente para identificadorPartido: $identificadorPartido");
            echo json_encode(["status" => "success", "message" => "Partido modificado exitosamente."]);
        } else {
            registrarLog("Error al modificar el partido: " . json_encode($stmt->errorInfo()));
            echo json_encode(["status" => "error", "message" => "Error al modificar el partido."]);
        }
    } else {
        registrarLog("Solicitud no válida o falta identificadorPartido.");
        echo json_encode(["status" => "error", "message" => "Solicitud no válida."]);
    }
} catch (PDOException $e) {
    registrarLog("Error en la base de datos: " . $e->getMessage());
    echo json_encode(["status" => "error", "message" => "Error en la base de datos."]);
}
?>
