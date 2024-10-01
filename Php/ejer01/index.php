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
    </style>

    <div class="code-output">
    <?php
// Imprimir fuera de las marcas de PHP
echo "Todo lo escrito fuera de las marcas de php es entregado en la respuesta http sin pasar por el procesador php.<br>";

// Entrega de contenido con la función echo
echo "Todo el resto y/o html entregado por el procesador php usando la sentencia echo.<br>";

// Sin usar concatenador
$miVariable = "valor1";
echo "Sin usar concatenador <span class='variable'>\$miVariable</span> : <span class='variable'>$miVariable</span><br>";

// Usando concatenador
echo "Usando concatenador <span class='variable'>" . $miVariable . "</span> : <span class='variable'>" . $miVariable . "</span><br>";

// Variables booleanas
$miVariableBoolTrue = true;
$miVariableBoolFalse = false;

echo "Variable tipo booleana o lógica (verdadero) <span class='variable'>\$miVariable</span> : <span class='variable'>" . (int)$miVariableBoolTrue . "</span><br>";
echo "Variable tipo booleana o lógica (falso) <span class='variable'>\$miVariable</span> : <span class='variable'>" . (int)$miVariableBoolFalse . "</span><br>";

// Constantes
define("MICONSTANTE", "valorConstante");
echo "MICONSTANTE : <span class='variable'>" . MICONSTANTE . "</span><br>";
echo "Tipo de MICONSTANTE : " . gettype(MICONSTANTE) . "<br>";

// Arreglos
$miPalabra = ["hola", "hello"];
echo "<span class='variable'>\$miPalabra[0]</span> : " . $miPalabra[0] . "<br>";
echo "<span class='variable'>\$miPalabra[1]</span> : " . $miPalabra[1] . "<br>";
echo "Tipo de <span class='variable'>\$miPalabra</span> : " . gettype($miPalabra) . "<br>";

// Añadir elementos a un arreglo
$miPalabra[] = "ciao";
$miPalabra[] = "bonjour";

echo "Se agregan por programa dos elementos nuevos<br>";
echo "Todos los elementos originales y agregados:<br>";
foreach ($miPalabra as $palabra) {
    echo "- $palabra<br>";
}

// Arreglo de dos dimensiones (diccionario)
$diccionario = [
    "Español" => ["hola", "adiós", "casa"],
    "Inglés" => ["hello", "good bye", "house"],
    "Italiano" => ["ciao", "arrivederci", "casa"],
    "Francés" => ["bonjour", "au revoir", "maison"]
];

echo "Arreglo de dos dimensiones (diccionario)<br>";
echo "La variable <span class='variable'>\$diccionario</span> tiene el siguiente contenido:<br>";

// Imprimir la tabla de palabras
echo "<table border='1'><tr><th>Español</th><th>Inglés</th><th>Italiano</th><th>Francés</th></tr>";
for ($i = 0; $i < count($diccionario["Español"]); $i++) {
    echo "<tr>";
    foreach ($diccionario as $idioma => $palabras) {
        echo "<td>" . $palabras[$i] . "</td>";
    }
    echo "</tr>";
}
echo "</table><br>";

// Mostrar cantidad de elementos en el diccionario
echo "Cantidad de elementos de diccionario: " . count($diccionario) . "<br>";

// Variables tipo arreglo asociativo
$producto = [
    "Código de artículo" => "cp001",
    "Descripción del artículo" => "agenda",
    "Precio unitario" => 20,
    "Cantidad" => 2
];

echo "Variables tipo arreglo asociativo<br>";
foreach ($producto as $clave => $valor) {
    echo "$clave: $valor<br>";
}

echo "Cantidad de elementos: " . count($producto) . "<br>";
echo "Tipo de dato: " . gettype($producto) . "<br>";

// Expresiones aritméticas
$x = 3;
$y = 4;

echo "<br>Expresiones aritméticas<br>";
echo "La variable \$x tiene el siguiente valor: $x<br>";
echo "La variable \$y tiene el siguiente valor: $y<br>";
echo "La variable \$x tiene el siguiente tipo: " . gettype($x) . "<br>";
echo "La variable \$y tiene el siguiente tipo: " . gettype($y) . "<br>";

// Operaciones aritméticas
echo "Así se inserta una expresión aritmética por ejemplo de Suma: (\$x + \$y) = " . ($x + $y) . "<br>";
echo "Así se inserta una expresión aritmética por ejemplo de Multiplicación: \$x * \$y = " . ($x * $y) . "<br>";
echo "Así se inserta una expresión aritmética por ejemplo de División: \$x / \$y = " . ($x / $y) . "<br>";
?>

    </div>

</body>
</html>