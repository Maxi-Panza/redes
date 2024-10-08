<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Modal con AJAX (fetch)</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        header {
            background-color: #007B7F;
            height: 10%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        main {
            background-color: #C0C0C0;
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        footer {
            background-color: #007B7F;
            height: 10%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        @media (max-width: 600px) {
            header, footer {
                height: 15%;
            }
        }

        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            align-items: center;
            justify-content: center;
        }

        .modal-content {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
        }

        .close {
            float: right;
            font-size: 20px;
            cursor: pointer;
        }

        input[type="text"], input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            background-color: #007B7F;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #005f5f;
        }

        #result {
            margin-top: 10px;
            padding: 10px;
            background-color: #e0e0e0;
            border-radius: 5px;
        }

        #waiting {
            display: none;
            color: teal;
        }
    </style>
</head>
<body>

<header>
    <h1>Mi Página</h1>
</header>

<main>
    <button id="openModalBtn">Abrir Formulario</button>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <form id="userForm">
                <label for="idUsuario">idUsuario</label>
                <input type="text" id="idUsuario" name="idUsuario" value="1234" readonly><br>

                <label for="login">Login</label>
                <input type="text" id="login" name="login" placeholder="Ingrese su login" required><br>

                <label for="apellido">Apellido</label>
                <input type="text" id="apellido" name="apellido" placeholder="Ingrese su apellido" required><br>

                <label for="nombres">Nombres</label>
                <input type="text" id="nombres" name="nombres" placeholder="Ingrese su nombre" required><br>

                <label for="fecha_nac">Fecha de Nacimiento</label>
                <input type="date" id="fecha_nac" name="fecha_nac" required><br><br>

                <button type="submit">Enviar</button>
            </form>

            <p id="waiting">Esperando respuesta del servidor...</p>
            <div id="result"></div>
        </div>
    </div>
</main>

<footer>
    <p>Mi Footer</p>
</footer>

<script>
    const modal = document.getElementById('myModal');
    const btn = document.getElementById('openModalBtn');
    const span = document.getElementsByClassName('close')[0];
    const form = document.getElementById('userForm');
    const waitingText = document.getElementById('waiting');
    const resultDiv = document.getElementById('result');

    btn.onclick = function() {
        modal.style.display = 'flex';
    }

    span.onclick = function() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }

    form.onsubmit = function(event) {
        event.preventDefault();
        waitingText.style.display = 'block';

        const formData = new FormData(form);

        fetch('submit.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            waitingText.style.display = 'none';
            resultDiv.innerHTML = '<strong>Información del formulario en formato JSON:</strong><br>' + JSON.stringify(data, null, 4);
        })
        .catch(error => {
            waitingText.style.display = 'none';
            resultDiv.innerHTML = '<strong>Error:</strong> ' + error;
        });
    };
</script>

</body>
</html>
