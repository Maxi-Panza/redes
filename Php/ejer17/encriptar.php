<?php
if (isset($_POST['text'])) {
    sleep(5);
    $text = $_POST['text'];

    // Encriptar en MD5
    $md5 = md5($text);

    // Encriptar en SHA1
    $sha1 = sha1($text);

    // Devolver la respuesta en formato HTML
    echo "
    <p>Clave original: $text</p>
    <p>Clave en MD5 (128 bits o 16 pares hexadecimales): $md5</p>
    <p>Clave en SHA1 (160 bits o 20 pares hexadecimales): $sha1</p>
    ";
} else {
    echo "No se recibió ningún texto.";
}
?>
