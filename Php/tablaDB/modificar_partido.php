<?php
header('Content-Type: application/json');

function registrarLog($mensaje) {
    $logFile = '/tmp/debug.log';
    $fecha = date('Y-m-d H:i:s');
    $logMessage = "[$fecha] - $mensaje" . PHP_EOL;
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

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

        $sql = "UPDATE PartidoFutbol SET descripcion = :descripcion, estadio_id = :estadio_id, 
                golesTotales = :golesTotales, fechaPartido = :fechaPartido 
                WHERE identificadorPartido = :identificadorPartido";
        registrarLog("Consulta SQL generada: UPDATE PartidoFutbol SET descripcion = '$descripcion', estadio_id = '$estadio_id', golesTotales = $golesTotales, fechaPartido = '$fechaPartido' WHERE identificadorPartido = '$identificadorPartido'");
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
        $stmt->bindParam(':estadio_id', $estadio_id, PDO::PARAM_STR);
        $stmt->bindParam(':golesTotales', $golesTotales, PDO::PARAM_INT);
        $stmt->bindParam(':fechaPartido', $fechaPartido);
        $stmt->bindParam(':identificadorPartido', $identificadorPartido, PDO::PARAM_STR);

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
