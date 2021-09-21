<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Segundo Formulario</title>
</head>
<body>
<?php
$nombres = $_GET["nombres"];
$apellidos = $_GET["apellidos"];
$direccion = $_GET["direccion"];
$ciudad = $_GET["ciudad"];
?>
<h1> HOLA <?=$nombres?> <?=$apellidos?> </h1>
<h2> Ciudad: <?=$ciudad?>, Dirección: <?=$direccion?></h2>
</body>
</html>
