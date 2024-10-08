<?php
// Verifica que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoge los datos del formulario
    sleep(5);
    $data = [
        'idUsuario' => $_POST['idUsuario'],
        'login' => $_POST['login'],
        'apellido' => $_POST['apellido'],
        'nombres' => $_POST['nombres'],
        'fecha_nac' => $_POST['fecha_nac']
    ];

    // Devuelve los datos como respuesta JSON
    header('Content-Type: application/json');
    echo json_encode($data);
}
?>
