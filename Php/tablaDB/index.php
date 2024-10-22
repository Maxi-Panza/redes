<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Partidos de Fútbol</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            color: #007B7F;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        button,
        input[type="submit"] {
            background-color: #007B7F;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover,
        input[type="submit"]:hover {
            background-color: #005f60;
        }

        #cargarDatos {
            display: inline-block;
            margin-bottom: 15px;
        }

        #altaDato {
            display: inline-block;
            margin-bottom: 15px;
        }

        .filters {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 20px;
        }

        .filters input,
        .filters select {
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
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

        table th[data-column]:after {
            content: '\25B2';
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0.7;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #eaeaea;
        }

        #loading {
            display: none;
            font-size: 18px;
            text-align: center;
            color: #333;
        }

        @media (max-width: 768px) {
            .filters {
                flex-direction: column;
            }

            table th,
            table td {
                padding: 8px;
            }
        }

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

        .filters label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .filters input,
        .filters select {
            margin-bottom: 15px;
        }

        .error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            padding-top: 100px;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
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

    <div>
        <label for="identificadorFiltro">Identificador:</label>
        <input type="text" id="identificadorFiltro" name="identificadorFiltro">

        <label for="descripcionFiltro">Descripción:</label>
        <input type="text" id="descripcionFiltro" name="descripcionFiltro">

        <label for="estadioFiltro">Estadio:</label>
        <select id="estadioFiltro" name="estadioFiltro">
            <option value="">Todos</option>
        </select>

        <label for="golesTotalesFiltro">Goles Totales:</label>
        <input type="number" id="golesTotalesFiltro" name="golesTotalesFiltro">

        <label for="fechaFiltro">Fecha del Partido:</label>
        <input type="date" id="fechaFiltro" name="fechaFiltro">

        <button id="cargarDatos">Cargar datos</button>
        <button id="altaDato" class="btn">Alta dato</button>
    </div>

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
        </tbody>
    </table>
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
                </select>

                <label for="golesTotales">Goles Totales:</label>
                <input type="number" id="golesTotales" name="golesTotales" required>

                <label for="fechaPartido">Fecha del partido:</label>
                <input type="date" id="fechaPartido" name="fechaPartido" required>

                <label for="resumen">Subir resumen (PDF, JPG, PNG):</label>
                <input type="file" id="resumen" name="resumen" accept=".pdf, .jpg, .jpeg, .png">

                <br><br>
                <button type="submit">Dar de alta Partido</button>
            </form>
        </div>
    </div>

    <div id="modalModificar" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Modificar Partido</h2>
            <form id="modificarPartidoForm">
                <input type="hidden" id="modificarIdentificadorPartido" name="identificadorPartido">

                <label for="modificarDescripcion">Descripción:</label>
                <input type="text" id="modificarDescripcion" name="descripcion" required>

                <label for="modificarEstadio">Estadio:</label>
                <select id="modificarEstadio" name="estadio_id" required>
                </select>

                <label for="modificarGolesTotales">Goles Totales:</label>
                <input type="number" id="modificarGolesTotales" name="golesTotales" required>

                <label for="modificarFechaPartido">Fecha del Partido:</label>
                <input type="date" id="modificarFechaPartido" name="fechaPartido" required>

                <label for="modificarResumen">Actualizar Resumen (opcional):</label>
                <input type="file" id="modificarResumen" name="resumen" accept=".pdf, .jpg, .jpeg, .png">

                <br><br>
                <button type="submit">Guardar Cambios</button>
            </form>
        </div>
    </div>


    <button id="verArchivo" style="display:none;">Ver Archivo</button>

    <div id="archivoVisualizacion" style="display:none;"></div>


    <button id="verArchivo" style="display:none;">Ver Archivo</button>

    <div id="archivoVisualizacion" style="display:none;"></div>

    <script>
        $(document).ready(function () {
            let sort_column = ''; 
            let sort_direction = 'ASC'; 

            $.ajax({
                url: 'load_estadios.php',
                method: 'GET',
                success: function (data) {
                    const estadios = JSON.parse(data);
                    estadios.forEach(function (estadio) {
                        $('#estadioFiltro').append(`<option value="${estadio.estadio_id}">${estadio.estadio_id}</option>`);
                        $('#estadio_id').append(`<option value="${estadio.estadio_id}">${estadio.estadio_id}</option>`);

                    });
                },
                error: function () {
                    alert('Error al cargar los estadios');
                }
            });

            $('#cargarDatos').on('click', function () {
                const sort_column = $('#ordenInput').val();
                const identificadorFiltro = $('#identificadorFiltro').val();
                const descripcionFiltro = $('#descripcionFiltro').val();
                const estadioFiltro = $('#estadioFiltro').val();
                const golesTotalesFiltro = $('#golesTotalesFiltro').val();
                const fechaFiltro = $('#fechaFiltro').val();

                $('#loading').show();
                $('#tablaFutbol tbody').html(''); 
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
                    success: function (data) {
                        $('#loading').hide();
                        const partidos = JSON.parse(data);
                        let html = '';
                        partidos.forEach(function (partido) {
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

                        bindActionsToButtons();
                    },
                    error: function () {
                        $('#loading').hide();
                        alert('Error al cargar los datos');
                    }
                });
            });

            function bindActionsToButtons() {
                $('.ver-archivo').on('click', function () {
                    const identificadorPartido = $(this).data('id');
                    window.location.href = 'ver_archivo.php?identificadorPartido=' + identificadorPartido;
                });

                $('.modificar-partido').on('click', function() {
                    const fila = $(this).closest('tr');

                    const identificadorPartido = fila.find('td').eq(0).text();
                    const descripcion = fila.find('td').eq(1).text();
                    const estadio_id = fila.find('td').eq(2).text();
                    const golesTotales = fila.find('td').eq(3).text();
                    const fechaPartido = fila.find('td').eq(4).text();

                    $('#modificarIdentificadorPartido').val(identificadorPartido);
                    $('#modificarDescripcion').val(descripcion);
                    $('#modificarGolesTotales').val(golesTotales);
                    $('#modificarFechaPartido').val(fechaPartido);

                    $('#modificarEstadio').empty();

                    $.ajax({
                        url: 'load_estadios.php',
                        method: 'GET',
                        success: function(data) {
                            const estadios = JSON.parse(data); 

                            $('#modificarEstadio').append('<option value="">Seleccione un estadio</option>');

                            estadios.forEach(function(estadio) {
                                const selected = estadio.estadio_id === estadio_id ? 'selected' : '';
                                $('#modificarEstadio').append(`<option value="${estadio.estadio_id}" ${selected}>${estadio.estadio_id}</option>`);
                            });

                            $('#modalModificar').show();
                        },
                        error: function() {
                            alert('Error al cargar los estadios.');
                        }
                    });
                });



                $('.close').on('click', function () {
                    $('#modalModificar').hide();
                });

                $('#modificarPartidoForm').on('submit', function (event) {
                    event.preventDefault();
                    const formData = new FormData(this);

                    $.ajax({
                        url: 'modificar_partido.php',
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            alert('Partido modificado exitosamente');
                            $('#modalModificar').hide();
                            location.reload(); 
                        },
                        error: function () {
                            alert('Error al modificar el partido.');
                        }
                    });
                });


                $('.eliminar-partido').on('click', function () {
                    const identificadorPartido = $(this).data('id');
                    if (confirm('¿Estás seguro de que deseas eliminar este partido?')) {
                        $.ajax({
                            url: 'eliminar_partido.php',
                            method: 'POST',
                            data: { identificadorPartido: identificadorPartido },
                            success: function (response) {
                                const res = JSON.parse(response);
                                if (res.status === 'success') {
                                    $('tr[data-id="' + identificadorPartido + '"]').remove();
                                    alert(res.message);
                                } else {
                                    alert('Error: ' + res.message);
                                }
                            },
                            error: function () {
                                alert('Error al conectar con el servidor.');
                            }
                        });
                    }
                });
            }

            $(document).ready(function () {
                bindActionsToButtons();
            });


            $('.sort').on('click', function () {
                sort_column = $(this).data('column');
                sort_direction = sort_direction === 'ASC' ? 'DESC' : 'ASC'; // Alternar dirección
                loadData();
            });


            $('#verArchivo').on('click', function () {
                const partidoId = $('#partidoId').val();

                $.ajax({
                    url: 'visualizar_archivo.php',
                    type: 'GET',
                    data: { partidoId: partidoId },
                    success: function (response) {
                        $('#archivoVisualizacion').html(response); 
                        $('#archivoVisualizacion').show();
                    },
                    error: function () {
                        alert('Error al cargar el archivo');
                    }
                });
            });

            $(document).on('click', '.seleccionarPartido', function () {
                const partidoId = $(this).data('id');
                $('#partidoId').val(partidoId);
                $('#verArchivo').hide();
                $('#archivoVisualizacion').hide();
            });
        });


        $('#altaDato').on('click', function () {
            $('#modalAlta').show(); 
        });

        $('.close').on('click', function () {
            $('#modalAlta').hide(); 
        });

        $('#altaPartidoForm').on('submit', function (event) {
            event.preventDefault();
            const formData = new FormData(this); 

            $.ajax({
                url: 'alta_partido.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert('Partido dado de alta exitosamente');
                    $('#altaPartidoForm')[0].reset();
                    $('#modalAlta').hide();
                    loadData();
                },
                error: function () {
                    alert('Error al dar de alta el partido');
                }
            });
        });
        $('#verArchivo').on('click', function () {
            const partidoId = $('#partidoId').val();
            $.ajax({
                url: 'ver_archivo.php',
                method: 'GET',
                data: { idPartido: partidoId },
                success: function (response) {
                    $('#archivoVisualizacion').html(response);
                    $('#archivoVisualizacion').show();
                },
                error: function () {
                    alert('Error al cargar el archivo');
                }
            });
        });

    </script>
</body>

</html>