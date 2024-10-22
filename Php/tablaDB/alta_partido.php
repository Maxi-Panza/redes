<?php
// Configuración de la base de datos
$host = 'localhost';
$db = 'futbol';
$user = 'root';
$pass = '';

try {
    // Conectar a la base de datos usando PDO
    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {
    // Manejo de error de conexión
    die("Error de conexión: " . $e->getMessage());
}

// Verificar si se enviaron todos los campos y si se subió un archivo
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['resumen'])) {

    // Recibir los datos del formulario
    $identificadorPartido = $_POST['identificadorPartido'];
    $descripcion = $_POST['descripcion'];
    $estadio_id = $_POST['estadio_id'];
    $golesTotales = $_POST['golesTotales'];
    $fechaPartido = $_POST['fechaPartido'];

    // Manejar el archivo "resumen" (BLOB)
    $resumen = $_FILES['resumen'];
    $fileTmpName = $resumen['tmp_name'];
    $fileError = $resumen['error'];
    $fileSize = $resumen['size'];

    // Validar que el archivo no tenga errores
    if ($fileError === 0) {
        // Limitar el tamaño del archivo a 5MB
        if ($fileSize < 5000000) {
            // Convertir el archivo a formato binario (BLOB)
            $fileData = file_get_contents($fileTmpName);

            try {
                // Preparar la sentencia SQL para insertar los datos
                $sql = "INSERT INTO PartidoFutbol (identificadorPartido, descripcion, estadio_id, golesTotales, fechaPartido, resumen) 
                        VALUES (:identificadorPartido, :descripcion, :estadio_id, :golesTotales, :fechaPartido, :resumen)";

                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':identificadorPartido', $identificadorPartido);
                $stmt->bindParam(':descripcion', $descripcion);
                $stmt->bindParam(':estadio_id', $estadio_id, PDO::PARAM_INT);
                $stmt->bindParam(':golesTotales', $golesTotales, PDO::PARAM_INT);
                $stmt->bindParam(':fechaPartido', $fechaPartido);
                $stmt->bindParam(':resumen', $fileData, PDO::PARAM_LOB);

                // Ejecutar la consulta
                if ($stmt->execute()) {
                    // Si la inserción fue exitosa, registrar en el log
                    $logMessage = "Partido agregado exitosamente: ID $identificadorPartido";
                    registrarLog($logMessage);

                    echo json_encode(["status" => "success", "message" => "Partido dado de alta exitosamente."]);
                } else {
                    // Si hay un error en la inserción
                    $logMessage = "Error al agregar el partido: " . json_encode($stmt->errorInfo());
                    registrarLog($logMessage);

                    echo json_encode(["status" => "error", "message" => "Error al dar de alta el partido."]);
                }

            } catch (PDOException $e) {
                // Manejo de error en la ejecución de la consulta
                registrarLog("Error de PDO: " . $e->getMessage());
                echo json_encode(["status" => "error", "message" => "Error en la base de datos."]);
            }

        } else {
            echo json_encode(["status" => "error", "message" => "El archivo es demasiado grande."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error al subir el archivo."]);
    }
}

// Función para registrar logs
function registrarLog($mensaje) {
    $logFile = '/tmp/alta_partido.log'; // Archivo donde se guardarán los logs
    $fecha = date('Y-m-d H:i:s'); // Fecha y hora actual
    $logMessage = "[$fecha] - $mensaje" . PHP_EOL;
    
    // Guardar el mensaje en el archivo log
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

?>
