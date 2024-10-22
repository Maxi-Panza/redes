<?php
// Conexión a la base de datos usando PDO
$dsn = 'mysql:host=localhost;dbname=futbol;charset=utf8mb4';
$username = 'root'; // Cambia esto si tienes otro usuario
$password = ''; // Cambia esto si tienes contraseña
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Modo de errores como excepciones
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Modo de obtención de datos
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
    
    // Crear la consulta base
    $query = "SELECT identificadorPartido, descripcion, estadio_id, golesTotales, fechaPartido FROM PartidoFutbol WHERE 1=1";
    
    // Arreglo para almacenar las condiciones
    $conditions = [];
    $params = [];
    
    // Verificar los filtros enviados desde el frontend y añadirlos a la consulta
    if (!empty($_POST['identificadorPartido'])) {
        $conditions[] = "identificadorPartido LIKE :identificadorPartido";
        $params[':identificadorPartido'] = '%' . $_POST['identificadorPartido'] . '%';
    }

    if (!empty($_POST['descripcion'])) {
        $conditions[] = "descripcion LIKE :descripcion";
        $params[':descripcion'] = '%' . $_POST['descripcion'] . '%';
    }

    if (!empty($_POST['estadio_id'])) {
        $conditions[] = "estadio_id = :estadio_id";
        $params[':estadio_id'] = $_POST['estadio_id'];
    }

    if (!empty($_POST['golesTotales'])) {
        $conditions[] = "golesTotales = :golesTotales";
        $params[':golesTotales'] = $_POST['golesTotales'];
    }

    if (!empty($_POST['fechaPartido'])) {
        $conditions[] = "fechaPartido = :fechaPartido";
        $params[':fechaPartido'] = $_POST['fechaPartido'];
    }

    // Si hay condiciones, añadirlas a la consulta
    if (count($conditions) > 0) {
        $query .= " AND " . implode(' AND ', $conditions);
    }

    // Añadir la columna de orden si está definida
    if (!empty($_POST['sort_column'])) {
        $query .= " ORDER BY " . $_POST['sort_column'];
    }

    // Preparar la consulta
    $stmt = $pdo->prepare($query);

    // Ejecutar la consulta con los parámetros vinculados
    $stmt->execute($params);

    // Obtener los resultados
    $result = $stmt->fetchAll();

    // Enviar los datos como JSON al frontend
    echo json_encode($result);

} catch (PDOException $e) {
    // Registrar el error y mostrar un mensaje de error
    file_put_contents('/tmp/debug.log', "[" . date('Y-m-d H:i:s') . "] Error en la base de datos: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['error' => 'Error en la base de datos']);
}
