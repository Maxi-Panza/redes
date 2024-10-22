<?php
// Conexión a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=futbol', 'root', '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $partidoId = $_POST['partidoId'];
    
    // Verificar si se subió un archivo
    if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
        $archivoTmp = $_FILES['archivo']['tmp_name'];
        $archivoNombre = $_FILES['archivo']['name'];
        $archivoRuta = 'uploads/' . $archivoNombre; // Guardar el archivo en una carpeta 'uploads'
        
        // Mover el archivo subido a la carpeta 'uploads'
        if (move_uploaded_file($archivoTmp, $archivoRuta)) {
            // Actualizar la base de datos con la ruta del archivo
            $stmt = $pdo->prepare("UPDATE PartidoFutbol SET archivo = :archivo WHERE idPartido = :idPartido");
            $stmt->execute([':archivo' => $archivoRuta, ':idPartido' => $partidoId]);
            echo 'Archivo subido exitosamente.';
        } else {
            echo 'Error al mover el archivo.';
        }
    } else {
        echo 'No se subió ningún archivo.';
    }
}
?>
