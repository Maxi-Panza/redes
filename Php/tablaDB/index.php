<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Partidos de Fútbol</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
/* General */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    color: #333;
    margin: 0;
    padding: 0;
}

h1 {
    text-align: center;
    color: #007B7F; /* Color teal */
}

.container {
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: #ffffff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Botones */
button, input[type="submit"] {
    background-color: #007B7F;
    color: white;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 4px;
    font-size: 16px;
    transition: background-color 0.3s;
}

button:hover, input[type="submit"]:hover {
    background-color: #005f60;
}

/* Cargar datos */
#cargarDatos {
    display: inline-block;
    margin-bottom: 15px;
}

#altaDato {
    display: inline-block;
    margin-bottom: 15px;
}

/* Filtros */
.filters {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 20px;
}

.filters input, .filters select {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-right: 10px;
    margin-bottom: 10px;
}

.filters label {
    font-weight: bold;
    margin-right: 10px;
}

/* Tabla */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 12px;
    text-align: left;
    border: 1px solid #ddd;
}

table th {
    background-color: #007B7F;
    color: white;
    cursor: pointer;
    position: relative;
}

table th:hover {
    background-color: #005f60;
}

/* Indicador de orden */
table th[data-column]:after {
    content: '\25B2'; /* Triángulo para indicar que se puede ordenar */
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    opacity: 0.7;
}

/* Alternar color en filas */
table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #eaeaea;
}

/* Mensaje de carga */
#loading {
    display: none;
    font-size: 18px;
    text-align: center;
    color: #333;
}

/* Responsive Design */
@media (max-width: 768px) {
    .filters {
        flex-direction: column;
    }

    table th, table td {
        padding: 8px;
    }
}

/* Estilos para los inputs */
input[type="text"],
input[type="date"],
input[type="number"],
select {
    width: aut;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 10px;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
input[type="date"]:focus,
input[type="number"]:focus,
select:focus {
    border-color: #007B7F;
    outline: none;
}

/* Estilos adicionales para el botón de cargar */
button#cargarDatos {
    width: 10%;
    margin-top: 15px;
    background-color: #007B7F;
    color: white;
    padding: 12px;
    border-radius: 4px;
    font-size: 18px;
    transition: background-color 0.3s;
}

button#cargarDatos:hover {
    background-color: #005f60;
}

button#altaDatos {
    width: 10%;
    margin-top: 15px;
    background-color: #007B7F;
    color: white;
    padding: 12px;
    border-radius: 4px;
    font-size: 18px;
    transition: background-color 0.3s;
}

button#altaDatos:hover {
    background-color: #005f60;
}

/* Para un mejor manejo del contenedor de filtros */
.filters label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

.filters input,
.filters select {
    margin-bottom: 15px;
}

/* Estilos para los mensajes de error o feedback */
.error {
    color: red;
    font-weight: bold;
    margin-top: 10px;
}

        /* Estilos básicos para el modal */
        .modal {
            display: none; /* Oculto por defecto */
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4); /* Fondo semitransparente */
        }
        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }


    </style>
</head>
<body>
    <h1>Gestión de Partidos de Fútbol</h1>

    <!-- Filtros -->
    <div>
        <label for="identificadorFiltro">Identificador:</label>
        <input type="text" id="identificadorFiltro" name="identificadorFiltro">
        
        <label for="descripcionFiltro">Descripción:</label>
        <input type="text" id="descripcionFiltro" name="descripcionFiltro">

        <label for="estadioFiltro">Estadio:</label>
        <select id="estadioFiltro" name="estadioFiltro">
            <option value="">Todos</option>
            <!-- Las opciones se cargarán dinámicamente desde el backend -->
        </select>

        <label for="golesTotalesFiltro">Goles Totales:</label>
        <input type="number" id="golesTotalesFiltro" name="golesTotalesFiltro">

        <label for="fechaFiltro">Fecha del Partido:</label>
        <input type="date" id="fechaFiltro" name="fechaFiltro">

        <button id="cargarDatos">Cargar datos</button>
        <button id="altaDato" class="btn">Alta dato</button>
    </div>

    <!-- Tabla de partidos -->
    <table id="tablaFutbol" border="1">
        <thead>
            <tr>
                <th><button class="sort" data-column="identificadorPartido">Identificador</button></th>
                <th><button class="sort" data-column="descripcion">Descripción</button></th>
                <th><button class="sort" data-column="estadio_id">Estadio</button></th>
                <th><button class="sort" data-column="golesTotales">Goles Totales</button></th>
                <th><button class="sort" data-column="fechaPartido">Fecha</button></th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Los datos se cargarán aquí mediante AJAX -->
        </tbody>
    </table>
        <!-- Modal para el alta de estadio y subir archivo -->
    <!-- Modal para el alta de partido y subida de archivo (resumen) -->
    <div id="modalAlta" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Alta de Partido y Subida de Resumen</h2>
            <form id="altaPartidoForm">
                <label for="identificadorPartido">Identificador del partido:</label>
                <input type="text" id="identificadorPartido" name="identificadorPartido" required>

                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" required>

                <label for="estadio_id">Estadio:</label>
                <select id="estadio_id" name="estadio_id" required>
                    <option value="">Seleccione un estadio</option>
                    <!-- Opciones dinámicas de los estadios -->
                </select>

                <label for="golesTotales">Goles Totales:</label>
                <input type="number" id="golesTotales" name="golesTotales" required>

                <label for="fechaPartido">Fecha del partido:</label>
                <input type="date" id="fechaPartido" name="fechaPartido" required>

                <label for="resumen">Subir resumen (PDF, JPG, PNG):</label>
                <input type="file" id="resumen" name="resumen" accept=".pdf, .jpg, .jpeg, .png" required>

                <br><br>
                <button type="submit">Dar de alta Partido</button>
            </form>
        </div>
    </div>

    <!-- Botón para visualizar el archivo -->
    <button id="verArchivo" style="display:none;">Ver Archivo</button>

    <!-- Área donde se mostrará el archivo si es visualizable -->
    <div id="archivoVisualizacion" style="display:none;"></div>


    <!-- Botón para visualizar el archivo -->
    <button id="verArchivo" style="display:none;">Ver Archivo</button>

    <!-- Área donde se mostrará el archivo si es visualizable -->
    <div id="archivoVisualizacion" style="display:none;"></div>

    <!-- Script para manejar la ordenación, subida y visualización de archivos -->
    <script>
        $(document).ready(function() {
            let sort_column = ''; // Inicializa la columna de ordenamiento
            let sort_direction = 'ASC'; // Dirección inicial del ordenamiento

            // Cargar los estadios dinámicamente
            $.ajax({
                url: 'load_estadios.php',
                method: 'GET',
                success: function(data) {
                    const estadios = JSON.parse(data);
                    estadios.forEach(function(estadio) {
                        $('#estadioFiltro').append(`<option value="${estadio.estadio_id}">${estadio.estadio_id}</option>`);
                        $('#estadio_id').append(`<option value="${estadio.estadio_id}">${estadio.estadio_id}</option>`);

                    });
                },
                error: function() {
                    alert('Error al cargar los estadios');
                }
            });

            // Función para cargar datos
// Cargar datos al hacer clic en 'Cargar datos'
$('#cargarDatos').on('click', function() {
    const sort_column = $('#ordenInput').val();
    const identificadorFiltro = $('#identificadorFiltro').val();
    const descripcionFiltro = $('#descripcionFiltro').val();
    const estadioFiltro = $('#estadioFiltro').val();
    const golesTotalesFiltro = $('#golesTotalesFiltro').val();
    const fechaFiltro = $('#fechaFiltro').val();
    
    $('#loading').show();
    $('#tablaFutbol tbody').html(''); // Borrar datos mientras esperamos

    $.ajax({
        url: 'load_data.php',
        method: 'POST',
        data: {
            sort_column: sort_column,
            identificadorPartido: identificadorFiltro,
            descripcion: descripcionFiltro,
            estadio_id: estadioFiltro,
            golesTotales: golesTotalesFiltro,
            fechaPartido: fechaFiltro
        },
        success: function(data) {
            $('#loading').hide();
            const partidos = JSON.parse(data);
            let html = '';
            partidos.forEach(function(partido) {
                html += `<tr data-id="${partido.identificadorPartido}">
                            <td>${partido.identificadorPartido}</td>
                            <td>${partido.descripcion}</td>
                            <td>${partido.estadio_id}</td>
                            <td>${partido.golesTotales}</td>
                            <td>${partido.fechaPartido}</td>
                            <td>
                                <button class="btn btn-primary ver-archivo" data-id="${partido.identificadorPartido}">
                                    Ver Archivo
                                </button>
                                <button class="btn btn-warning modificar-partido" data-id="${partido.identificadorPartido}">
                                    Modificar
                                </button>
                                <button class="btn btn-danger eliminar-partido" data-id="${partido.identificadorPartido}">
                                    Eliminar
                                </button>
                            </td>
                         </tr>`;
            });
            $('#tablaFutbol tbody').html(html);

            // Llamamos a la función para enlazar eventos después de que se carguen los nuevos datos
            bindActionsToButtons();
        },
        error: function() {
            $('#loading').hide();
            alert('Error al cargar los datos');
        }
    });
});

// Función para enlazar los botones con las acciones
function bindActionsToButtons() {
    // Manejo del botón para ver el archivo asociado
    $('.ver-archivo').on('click', function() {
    const identificadorPartido = $(this).data('id');
    // Redirigir a ver_archivo.php con el identificador del partido como parámetro
    window.location.href = 'ver_archivo.php?identificadorPartido=' + identificadorPartido;
});

    // Manejo del botón para modificar el partido
    $('.modificar-partido').on('click', function() {
        const identificadorPartido = $(this).data('id');
        window.location.href = 'modificar_partido.php?identificadorPartido=' + identificadorPartido;
    });

    // Manejo del botón para eliminar el partido
    $('.eliminar-partido').on('click', function() {
    const identificadorPartido = $(this).data('id');
    if (confirm('¿Estás seguro de que deseas eliminar este partido?')) {
        $.ajax({
            url: 'eliminar_partido.php',
            method: 'POST',
            data: { identificadorPartido: identificadorPartido },
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    // Eliminar la fila correspondiente de la tabla
                    $('tr[data-id="' + identificadorPartido + '"]').remove();
                    alert(res.message);
                } else {
                    alert('Error: ' + res.message);
                }
            },
            error: function() {
                alert('Error al conectar con el servidor.');
            }
        });
    }
});
}

// Llamamos a bindActionsToButtons inmediatamente al cargar la página
$(document).ready(function() {
    bindActionsToButtons();
});


            // Ordenar columnas al hacer clic en el botón de ordenación
            $('.sort').on('click', function() {
                sort_column = $(this).data('column');
                sort_direction = sort_direction === 'ASC' ? 'DESC' : 'ASC'; // Alternar dirección
                loadData();
            });


            // Manejo del botón para ver el archivo
            $('#verArchivo').on('click', function() {
                const partidoId = $('#partidoId').val();
                
                $.ajax({
                    url: 'visualizar_archivo.php',
                    type: 'GET',
                    data: { partidoId: partidoId },
                    success: function(response) {
                        $('#archivoVisualizacion').html(response); // Mostrar el archivo
                        $('#archivoVisualizacion').show();
                    },
                    error: function() {
                        alert('Error al cargar el archivo');
                    }
                });
            });

            // Manejo del botón "Seleccionar" de cada partido
            $(document).on('click', '.seleccionarPartido', function() {
                const partidoId = $(this).data('id');
                $('#partidoId').val(partidoId); // Asignar el ID del partido al campo oculto
                $('#verArchivo').hide(); // Ocultar el botón de ver archivo hasta que se suba uno nuevo
                $('#archivoVisualizacion').hide(); // Ocultar cualquier vista previa de archivo anterior
            });
        });


            // Cargar datos al hacer clic en "Alta dato"
            $('#altaDato').on('click', function() {
                $('#modalAlta').show(); // Mostrar el modal
            });

            // Cerrar el modal al hacer clic en la X
            $('.close').on('click', function() {
                $('#modalAlta').hide(); // Ocultar el modal
            });

            $('#altaPartidoForm').on('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(this); // Para manejar archivos
                
                $.ajax({
                    url: 'alta_partido.php',
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert('Partido dado de alta exitosamente');
                        $('#altaPartidoForm')[0].reset(); // Limpiar el formulario
                        $('#modalAlta').hide(); // Ocultar el modal después de guardar
                        loadData(); // Recargar los datos
                    },
                    error: function() {
                        alert('Error al dar de alta el partido');
                    }
                });
            });
            // Mostrar el archivo al hacer clic en el botón "Ver Archivo"
            $('#verArchivo').on('click', function() {
                const partidoId = $('#partidoId').val();
                $.ajax({
                    url: 'ver_archivo.php', // Archivo PHP que servirá el archivo
                    method: 'GET',
                    data: { idPartido: partidoId },
                    success: function(response) {
                        // Aquí puedes manejar cómo se mostrará el archivo
                        // Ejemplo: si es imagen mostrar en un <img>, si es PDF usar un <embed>
                        $('#archivoVisualizacion').html(response);
                        $('#archivoVisualizacion').show(); // Mostrar la vista previa
                    },
                    error: function() {
                        alert('Error al cargar el archivo');
                    }
                });
            });

    </script>
</body>
</html>
