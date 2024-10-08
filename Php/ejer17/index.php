<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encriptar Texto</title>
    <style>
        /* Estilos básicos */
        .container {
            display: flex;
        }
        #input-data, #result, #request-status {
            width: 30%;
            padding: 20px;
            background-color: grey;
        }
        #result, #request-status {
            width: 30%;
            padding: 20px;
            background-color: yellow;
        }
        #request-status {
            width: 30%;
            padding: 20px;
            background-color: cyan;
        }
        #encrypt-button {
            width: 30%;
            padding: 20px;
            text-align: center;
            background-color: blue;
            color: white;
        }

        /* Imagen oculta por defecto */
        #encrypt-image {
            display: none;
            width: 100px;
        }

        /* Mostrar imagen al hacer hover en el botón */
        #encrypt-button:hover #encrypt-image {
            display: block;
        }
    </style>
</head>
<body>
    <div class="container">
        <div id="input-data">
            <h2>Dato de entrada:</h2>
            <input type="text" id="text-to-encrypt" placeholder="Escribe algo...">
        </div>

        <div id="encrypt-button">
            <h2>Encriptar</h2>
            <!-- Imagen oculta que se muestra al hacer hover -->
            <img id="encrypt-image" src="Flecha.png" alt="Imagen de encriptado">
        </div>

        <div id="result">
            <h2>Resultado:</h2>
            <p id="encrypted-result"></p>
        </div>
    </div>

    <div id="request-status">
        <h3>Estado del requerimiento:</h3>
        <p id="status-text"></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#encrypt-image').click(function() {
                var text = $('#text-to-encrypt').val();

                // Mostrar que la petición está en curso
                $('#status-text').text('Enviando petición...');

                // Enviar datos al servidor vía AJAX
                $.ajax({
                    url: 'encriptar.php',
                    type: 'POST',
                    data: { text: text },
                    success: function(response) {
                        // Mostrar el resultado de la encriptación
                        $('#encrypted-result').html(response);

                        // Actualizar el estado de la petición
                        $('#status-text').text('Petición completada con éxito.');
                    },
                    error: function() {
                        // Manejar errores
                        $('#status-text').text('Error en la petición.');
                    }
                });
            });
        });
    </script>
</body>
</html>
