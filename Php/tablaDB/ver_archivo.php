<?php
// Configuración de la base de datos
$dsn = 'mysql:host=localhost;dbname=futbol;charset=utf8mb4';
$username = 'root'; // Cambia esto si tienes otro usuario
$password = ''; // Cambia esto si tienes contraseña
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    // Conectar a la base de datos usando PDO
    $pdo = new PDO($dsn, $username, $password, $options);

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['identificadorPartido'])) {
        $identificadorPartido = $_GET['identificadorPartido'];

        // Preparar la consulta para obtener el archivo resumen del partido
        $sql = "SELECT resumen, descripcion FROM PartidoFutbol WHERE identificadorPartido = :identificadorPartido";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':identificadorPartido', $identificadorPartido);
        $stmt->execute();

        $partido = $stmt->fetch();

        if ($partido && !empty($partido['resumen'])) {
            $resumen = $partido['resumen'];
            $descripcion = $partido['descripcion'];

            // Limpiar el búfer de salida antes de enviar el archivo
            if (ob_get_length()) {
                ob_end_clean();
            }

            // Determinar el tipo MIME del archivo
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_buffer($finfo, $resumen);
            finfo_close($finfo);

            // Establecer cabeceras para la descarga del archivo
            header('Content-Type: ' . $mimeType);
            header('Content-Disposition: attachment; filename="' . $descripcion . '"');
            header('Content-Length: ' . strlen($resumen));

            // Enviar el contenido del archivo
            echo $resumen;
            exit;
        } else {
            header('HTTP/1.0 404 Not Found');
            echo "Error: No se encontró el archivo asociado a este partido.";
        }
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo "Error: Solicitud no válida.";
    }
} catch (PDOException $e) {
    header('HTTP/1.0 500 Internal Server Error');
    echo "Error en la base de datos.";
}
?>
