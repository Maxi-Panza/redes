<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo PHP</title>
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .code-output {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .code-output p {
            margin-bottom: 15px;
        }
        .variable {
            color: blue;
        }
        .array-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .array-table th, .array-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .array-table th {
            background-color: #f2f2f2;
        }
        .array-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .array-table tr:hover {
            background-color: #f1f1f1;
        }
    </style>

    <div class="code-output">
    <?php
        // Mensajes iniciales
        echo "En este ejemplo se utiliza la funcion include() que ubica código PHP definido en el archivo ejemplo2.inc:<br>";
        echo "Antes de insertar el include las variables declaradas en el mismo no existen.<br>";

        // Intentar usar variables antes del include
        echo "Las variables son:<br>";

        if (!isset($arreglo1)) {
            echo "Notice: Undefined variable: arreglo1<br>";
        }
        if (!isset($arreglo2)) {
            echo "Notice: Undefined variable: arreglo2<br>";
        }

        echo "La longitud de los arreglos es: 0<br><br>";

        // Intentar incluir el archivo
        $include_file = 'ejemplo2.inc';

        if (file_exists($include_file)) {
            include($include_file);  // Incluir el archivo si existe
            echo "Aquí ya se ejecutó la función include().<br>";
        } else {
            echo "Error: El archivo $include_file no existe.<br>";
            // Detener la ejecución si el archivo no existe
            die("El archivo $include_file no existe.");
        }

        // Variables después del include
        if (isset($arreglo1) && isset($arreglo2)) {
            echo "Las 2 variables de tipo array asociativo en el include son:<br>";
            echo "<table class='array-table'>";
            echo "<tr><th>Nombre</th><th>Año</th></tr>";
            foreach ($arreglo1 as $nombre => $year) {
                echo "<tr><td>$nombre</td><td>$year</td></tr>";
            }
            foreach ($arreglo2 as $nombre => $year) {
                echo "<tr><td>$nombre</td><td>$year</td></tr>";
            }
            echo "</table>";
            echo "La longitud de los arreglos es: " . count($arreglo1) . "<br>";
        } else {
            echo "No se pudieron incluir las variables del archivo $include_file.<br>";
        }
        ?>
    </div>

</body>
</html>