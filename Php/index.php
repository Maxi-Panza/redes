<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Desplegable</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .menu {
            display: flex;
            background-color: #333;
            padding: 0;
            margin: 0;
            list-style: none;
            width: fit-content;
        }
        .menu > li {
            position: relative;
        }
        .menu > li > a {
            display: block;
            padding: 14px 20px;
            color: white;
            text-decoration: none;
        }
        .menu > li > a:hover {
            background-color: #575757;
        }
        .submenu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            background-color: #333;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .submenu > li > a {
            padding: 12px 20px;
            color: white;
            text-decoration: none;
            display: block;
        }
        .submenu > li > a:hover {
            background-color: #575757;
        }
        .menu > li:hover .submenu {
            display: block;
        }
    </style>
</head>
<body>

<ul class="menu">
    <li><a href="/materia/Html/">HTML</a>
        <ul class="submenu">
            <li><a href="/materia/Html/ejer01PreguntasHTTP/">Preguntas http</a></li>
            <li><a href="/materia/Html/ejer02Tablas/">Tablas</a></li>
            <li><a href="/materia/Html/ejer03Formularios/">Formularios</a></li>
            <li><a href="/materia/Html/ejer04Iframe/">IFrame</a></li>
            
        </ul>
    </li>
    <li><a href="/materia/Css/">CSS</a>
        <ul class="submenu">
            <li><a href="/materia/Css/css1/CssEjercicio8CentradoYPadding/">Centrado y padding</a></li>
            <li><a href="/materia/Css/css1/cssejer10divsenpila/">Divs en pila</a></li>
            <li><a href="/materia/Css/css1/ejer11divsenfila/">Divs en fila</a></li>
            <li><a href="/materia/Css/css2/css25menu/">Menu</a></li>
            <li><a href="/materia/Css/css2/css27formrwd/">Formulario</a></li>
            <li><a href="/materia/Css/css2/css28tablasrwd">Tablas</a></li>
            <li><a href="/materia/Css/css2/css30layout">Layout</a></li>
        </ul>
    </li>
    <li><a href="/materia/Jscript/">JS</a>
        <ul class="submenu">
        <li><a href="/materia/Jscript/ejer01/">Ejercicio 1</a></li>
            <li><a href="/materia/Jscript/ejer02/">Ejercicio 2</a></li>
            <li><a href="/materia/Jscript/ejer03/">Ejercicio 3</a></li>
            <li><a href="/materia/Jscript/ejer04/">Ejercicio 4</a></li>
            <li><a href="/materia/Jscript/ejer05/">Ejercicio 5</a></li>
            <li><a href="/materia/Jscript/ejer06/">Ejercicio 6</a></li>
        </ul>
    </li>
    <li><a href="/materia/Php/">PHP</a>
        <ul class="submenu">
            <li><a href="/materia/Php/ejer01/">Ejercicio 1</a></li>
            <li><a href="/materia/Php/ejer02/">Ejercicio 2</a></li>
            <li><a href="/materia/Php/ejer14/">Ejercicio 14</a></li>
            <li><a href="/materia/Php/ejer17/">Ejercicio 17</a></li>
            <li><a href="/materia/Php/ejer18/">Ejercicio 18</a></li>
        </ul>
    </li>
</ul>

</body>
</html>
